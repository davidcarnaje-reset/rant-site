<?php

use Livewire\Component;
use App\Models\Story;
use App\Models\Vote;
use App\Models\Comment;
use Illuminate\Support\Facades\Request;

new class extends Component {
    public $story;
    public $hasVoted = false;
    public $percentA = 0;
    public $percentB = 0;
    public $totalVotes = 0;
    
    // Form Properties
    public $username = 'Anonymous';
    public $comment_text = '';

    public function mount(Story $story)
    {
        $this->story = $story;
        $this->checkVoteStatus();
    }

    public function checkVoteStatus()
    {
        $this->totalVotes = Vote::where('story_id', $this->story->id)->count();
        $this->hasVoted = Vote::where('story_id', $this->story->id)
            ->where('ip_address', Request::ip())
            ->where('created_at', '>=', now()->subDay())
            ->exists();

        if ($this->totalVotes > 0) {
            $votesA = Vote::where('story_id', $this->story->id)->where('choice', 'A')->count();
            $votesB = Vote::where('story_id', $this->story->id)->where('choice', 'B')->count();

            $this->percentA = round(($votesA / $this->totalVotes) * 100);
            $this->percentB = round(($votesB / $this->totalVotes) * 100);
        }
    }

    public function vote($choice)
    {
        // Double check 24-hour cooldown to prevent duplicate submissions
        $recentVoteExists = Vote::where('story_id', $this->story->id)
            ->where('ip_address', Request::ip())
            ->where('created_at', '>=', now()->subDay())
            ->exists();

        if ($recentVoteExists) {
            $this->hasVoted = true;
            return;
        }

        Vote::create([
            'story_id' => $this->story->id,
            'choice' => $choice,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);

        $this->checkVoteStatus();
    }

    public function saveComment()
    {
        $this->validate([
            'comment_text' => 'required|min:3',
        ]);

        // Spam protection: check if comment from same IP exists within the last 5 minutes
        $spamCheck = Comment::where('story_id', $this->story->id)
            ->where('ip_address', Request::ip())
            ->where('created_at', '>=', now()->subMinutes(5))
            ->exists();

        if ($spamCheck) {
            $this->addError('comment_text', 'Bawal ang sunod-sunod na hatol. Mangyaring maghintay ng 5 minuto bago mag-post muli.');
            return;
        }

        // Profanity Filter
        $badWords = ['gago', 'bobo', 'tanga', 'puta', 'leche', 'pakyu', 'fuck', 'shit'];
        $cleanText = $this->comment_text;
        foreach ($badWords as $word) {
            $cleanText = str_ireplace($word, str_repeat('*', strlen($word)), $cleanText);
        }

        Comment::create([
            'story_id' => $this->story->id,
            'username' => $this->username ?: 'Anonymous',
            'comment_text' => $cleanText,
            'is_approved' => true,
            'ip_address' => Request::ip(),
        ]);

        $this->comment_text = '';
        $this->story->refresh();
    }
}; ?>

<div class="w-full max-w-xl mx-auto space-y-8">
    <!-- Story & Voting Card (Newsprint Broadsheet Column Card) -->
    <div class="p-8 bg-[#F9F9F7] text-[#111111] border-4 border-[#111111] relative overflow-hidden transition-all duration-300">
        
        <!-- Badges section -->
        <div class="flex items-center gap-2 mb-6">
            <span class="px-3 py-1 bg-transparent text-[#CC0000] text-[10px] font-mono font-black uppercase tracking-widest border border-[#111111]">
                ⚖️ DILEMMA POLL
            </span>
            <span class="px-3 py-1 bg-[#111111] text-[#F9F9F7] text-[10px] font-mono font-black uppercase tracking-widest border border-[#111111]">
                🔥 ACTIVE
            </span>
        </div>

        <!-- Title Header (Playfair Display) -->
        <h2 class="text-3xl font-black font-heading text-[#111111] mb-6 tracking-tight leading-none uppercase border-b border-[#111111]/35 pb-4">
            {{ $story->title }}
        </h2>

        <!-- Story Image (Halftone Newsprint Style) -->
        @if($story->image_path)
            <div class="mb-6 border-4 border-[#111111] bg-white overflow-hidden">
                <img src="{{ asset('storage/' . $story->image_path) }}" alt="{{ $story->title }}" class="w-full h-auto object-cover filter grayscale contrast-125" />
            </div>
        @endif
        
        <!-- Story content (Lora, justified, large Drop Cap) -->
        @php
            $firstLetter = mb_substr($story->content, 0, 1);
            $restOfContent = mb_substr($story->content, 1);
        @endphp
        <div class="my-6">
            <p class="text-justify font-body text-[#111111] leading-relaxed text-sm md:text-base">
                <span class="text-7xl font-heading font-black float-left mr-3 line-none leading-[0.8] mt-1 text-[#CC0000]">{{ $firstLetter }}</span>{{ $restOfContent }}
            </p>
        </div>

        <!-- Voting Options / Buttons -->
        @if(!$hasVoted)
            <div class="grid grid-cols-1 gap-4 mt-8 border-t-2 border-[#111111] pt-6">
                <button wire:click="vote('A')" class="w-full py-4 bg-[#111111] text-[#F9F9F7] border-2 border-[#111111] font-mono uppercase tracking-widest text-xs font-black hover:bg-[#F9F9F7] hover:text-[#111111] transition-all duration-200 cursor-pointer shadow-none">
                    {{ $story->option_a }} ➔
                </button>
                <button wire:click="vote('B')" class="w-full py-4 bg-[#111111] text-[#F9F9F7] border-2 border-[#111111] font-mono uppercase tracking-widest text-xs font-black hover:bg-[#F9F9F7] hover:text-[#111111] transition-all duration-200 cursor-pointer shadow-none">
                    {{ $story->option_b }} ➔
                </button>
            </div>
        @else
            <!-- Results Ledger (Sharp cells, solid fills) -->
            <div class="space-y-6 bg-[#E5E5E0]/20 p-6 border-2 border-[#111111] mt-8">
                <h3 class="font-heading font-black text-xl uppercase tracking-tight text-[#111111] border-b border-[#111111] pb-2">
                    📊 LEDGER FOR DECISION RECORD
                </h3>
                
                <div class="space-y-6">
                    <!-- Option A Result -->
                    <div class="space-y-2">
                        <div class="flex justify-between font-mono text-xs uppercase font-black tracking-wider text-[#111111]">
                            <span>{{ $story->option_a }}</span>
                            <span class="text-sm font-extrabold">{{ $percentA }}%</span>
                        </div>
                        <div class="w-full bg-[#F9F9F7] border-2 border-[#111111] h-6 overflow-hidden">
                            <div class="bg-[#111111] h-full transition-all duration-1000 ease-out" style="width: {{ $percentA }}%"></div>
                        </div>
                    </div>

                    <!-- Option B Result -->
                    <div class="space-y-2">
                        <div class="flex justify-between font-mono text-xs uppercase font-black tracking-wider text-[#111111]">
                            <span>{{ $story->option_b }}</span>
                            <span class="text-sm font-extrabold">{{ $percentB }}%</span>
                        </div>
                        <div class="w-full bg-[#F9F9F7] border-2 border-[#111111] h-6 overflow-hidden">
                            <div class="bg-[#CC0000] h-full transition-all duration-1000 ease-out" style="width: {{ $percentB }}%"></div>
                        </div>
                    </div>
                </div>
                
                <p class="text-[9px] text-center text-slate-500 font-mono uppercase tracking-wider font-bold">DECISION LEDGER UPDATE COMPLETE / VOTED SECURE</p>
            </div>
        @endif

        <!-- Stats Section (Newspaper Column Grid Lines) -->
        <div class="grid grid-cols-2 gap-0 mt-8 border-t-2 border-b-2 border-double border-[#111111] divide-x-2 divide-[#111111]">
            <!-- Metric 1 -->
            <div class="py-4 flex flex-col items-center justify-center">
                <span class="text-[9px] font-black tracking-widest text-[#111111]/70 font-mono uppercase">KABUUANG BOTO</span>
                <span class="text-3xl font-black text-[#111111] mt-1 tracking-tight font-mono">{{ $totalVotes }}</span>
            </div>
            
            <!-- Metric 2 -->
            <div class="py-4 flex flex-col items-center justify-center">
                <span class="text-[9px] font-black tracking-widest text-[#111111]/70 font-mono uppercase">SENTIMYENTO</span>
                <span class="text-xs font-black px-3.5 py-1 bg-transparent text-[#111111] border border-[#111111] mt-2 font-mono tracking-wider uppercase">
                    {{ $totalVotes > 5 ? ($percentA > 60 || $percentB > 60 ? 'Unilateral' : 'Mainit') : 'Bagong Poll' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Comments Section (Classified Ads Block) -->
    <div class="p-8 bg-[#F9F9F7] text-[#111111] border-4 border-[#111111]">
        <div class="flex items-center justify-between mb-6 pb-4 border-b-4 border-double border-[#111111]">
            <h3 class="text-lg font-bold font-heading uppercase tracking-tight">
                <span>💬</span> Correspondence Ledger
            </h3>
            <span class="px-3 py-1 bg-[#111111] text-[#F9F9F7] text-[10px] font-mono font-black uppercase border border-[#111111]">
                {{ $story->comments()->where('is_approved', true)->count() }} Items
            </span>
        </div>

        <!-- Comment Form -->
        <form wire:submit.prevent="saveComment" class="space-y-4 mb-8">
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label for="username" class="block text-[9px] font-black text-slate-500 font-mono uppercase tracking-widest mb-1.5">NAME / CORRESPONDENT</label>
                    <input type="text" id="username" wire:model.defer="username" 
                        class="w-full px-3 py-2 text-xs bg-transparent border-b-2 border-[#111111] text-[#111111] font-mono focus:bg-[#F0F0F0] focus:outline-none transition-all placeholder:text-[#111111]/30 shadow-none"
                        placeholder="Anonymous">
                    @error('username') <span class="font-mono text-xs text-red-600 mt-1 block">Error: {{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label for="comment_text" class="block text-[9px] font-black text-slate-500 font-mono uppercase tracking-widest mb-1.5">STATEMENT LOG / PUBLIC COMMENT</label>
                    <textarea id="comment_text" wire:model.defer="comment_text" rows="3"
                        class="w-full px-3 py-2.5 text-xs bg-transparent border-2 border-[#111111] text-[#111111] font-mono focus:bg-[#F0F0F0] focus:outline-none transition-all placeholder:text-[#111111]/30 shadow-none leading-relaxed"
                        placeholder="Ibahagi ang iyong opinyon..."></textarea>
                    @error('comment_text') <span class="font-mono text-xs text-red-600 mt-1 block">Error: {{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" wire:loading.attr="disabled"
                    class="px-6 py-3.5 bg-[#111111] text-[#F9F9F7] border-2 border-[#111111] font-mono font-black text-xs hover:bg-[#F9F9F7] hover:text-[#111111] transition-all duration-200 flex items-center gap-2 cursor-pointer uppercase tracking-widest shadow-none">
                    <span wire:loading.remove wire:target="saveComment">SUBMIT STATEMENT</span>
                    <span wire:loading wire:target="saveComment" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-[#F9F9F7]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        POSTING...
                    </span>
                </button>
            </div>
        </form>

        <!-- Comments List (Classified Ads Style) -->
        <div class="space-y-0 border-t border-[#111111]">
            @forelse($story->comments()->where('is_approved', true)->latest()->get() as $comment)
                <div class="py-5 border-b border-[#111111] flex flex-col md:flex-row gap-4 items-start">
                    <!-- Square Avatar -->
                    <div class="w-8 h-8 border border-[#111111] bg-[#111111] text-[#F9F9F7] flex items-center justify-center text-[10px] font-mono font-bold uppercase shrink-0">
                        {{ substr($comment->username, 0, 2) }}
                    </div>
                    <div class="flex-grow">
                        <div class="flex items-center justify-between mb-2 font-mono text-[9px] font-bold text-[#111111]/70 tracking-wide uppercase">
                            <div>
                                <span>{{ $comment->username }}</span>
                                <span class="bg-[#111111]/10 text-[#111111] px-1 py-0.5 ml-1">CORRESPONDENT</span>
                            </div>
                            <span>{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-[#111111] text-sm leading-relaxed font-body text-justify">
                            {{ $comment->comment_text }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 text-slate-550 border-b border-[#111111]">
                    <p class="text-3xl mb-2">💬</p>
                    <p class="text-xs font-bold font-mono uppercase tracking-widest">NO STATEMENTS FOUND IN LEDGER</p>
                    <p class="text-xs text-slate-500 font-body mt-1">Maging unang magsulat ng hatol.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>