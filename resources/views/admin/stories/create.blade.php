<x-app-layout>
    <div class="py-12 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Newsprint Header Block inside layout -->
        <header class="border-t-4 border-b-2 border-double border-[#111111] py-6 mb-8 text-center bg-[#F9F9F7]">
            <p class="font-mono text-xs uppercase tracking-widest text-[#111111]/70 mb-2 font-bold">
                System Control Panel / Authorized Personnel Only
            </p>
            <h1 class="text-4xl md:text-5xl font-black font-heading tracking-tight uppercase mb-3 text-[#111111]">
                Sino Ang Mali?
            </h1>
            <div class="border-t border-[#111111]/20 pt-3 mt-1 flex flex-col sm:flex-row items-center justify-between font-mono text-[10px] uppercase tracking-wider text-[#111111]/80 font-bold">
                <span>VOL. 1.0</span>
                <span class="my-1 sm:my-0">PRINTED IN LOCALHOST</span>
                <span>EDITION 2026</span>
            </div>
        </header>

        <!-- Alerts Section -->
        @if (session('success'))
            <div class="border-2 border-[#111111] bg-[#F2F2EC] p-5 mb-8">
                <p class="font-mono text-sm font-bold uppercase mb-2">
                    [SUCCESS REPORT]
                </p>
                <p class="text-sm font-semibold mb-3">
                    {{ session('success') }}
                </p>
                @if (session('story_url'))
                    <div class="border-t border-[#111111]/30 pt-3">
                        <span class="font-mono text-[10px] uppercase font-bold text-[#111111]/60">Link ng Kwento:</span>
                        <a href="{{ session('story_url') }}" target="_blank" class="font-mono text-xs underline font-bold ml-1 break-all hover:bg-[#111111] hover:text-[#F9F9F7] px-1 py-0.5 transition-colors">
                            {{ session('story_url') }}
                        </a>
                    </div>
                @endif
            </div>
        @endif

        <!-- Newsprint Layout Grid -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
            
            <!-- Left Editorial Pane (Desktop Meta Description) -->
            <div class="md:col-span-4 border-2 border-[#111111] p-5 bg-[#F9F9F7]">
                <h3 class="font-mono text-xs uppercase font-bold border-b border-[#111111] pb-2 mb-4">
                    [INSTRUCTIONS]
                </h3>
                <p class="text-xs leading-relaxed text-[#111111]/90 mb-4 text-justify font-body">
                    Ang module na ito ay nagsisilbing tagapamahala ng mga bagong dilemang ilalathala sa publiko. Tiyaking ang bawat opsyon ay may malinaw at nakakapukaw na panig upang hikayatin ang pagpapasya ng mga hukom ng bayan.
                </p>
                <div class="border-t border-dashed border-[#111111] pt-4 font-mono text-[10px] text-[#111111]/60 space-y-1 font-bold">
                    <p>&bull; REQUIRED FIELDS ON ALL BLOCK ITEMS</p>
                    <p>&bull; AUTO-SLUG GENERATOR DETECTS TITLES</p>
                    <p>&bull; PRESS POST TO UPDATE THE LEDGER</p>
                </div>
            </div>

            <!-- Right Form Pane -->
            <div class="md:col-span-8 border-2 border-[#111111] p-6 md:p-8 bg-[#F9F9F7]">
                <div class="border-b border-[#111111] pb-4 mb-6">
                    <h2 class="font-heading text-2xl font-bold uppercase tracking-tight">CORRESPONDENCE SUBMISSION Form</h2>
                    <span class="font-mono text-[10px] uppercase text-[#111111]/60 font-bold">Document Ref: DEC-2026-STORY</span>
                </div>

                <form action="{{ route('admin.stories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Title Field -->
                    <div>
                        <label for="title" class="block font-mono text-xs font-extrabold uppercase tracking-wider mb-2">01. Pamagat ng Dilemma / Dilemma Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                            class="w-full px-3 py-2 bg-transparent border-b-2 border-[#111111] text-[#111111] font-mono text-sm focus:bg-[#F0F0F0] focus:outline-none transition-all placeholder:text-[#111111]/30 shadow-none"
                            placeholder="Pamagat (e.g. Panganay vs. Bunso)">
                        @error('title')
                            <span class="font-mono text-xs text-red-600 mt-1 block">Error: {{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Slug Field -->
                    <div>
                        <label for="slug" class="block font-mono text-xs font-extrabold uppercase tracking-wider mb-2">02. Pasadyang URL Slug / Custom Slug (Optional)</label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                            class="w-full px-3 py-2 bg-transparent border-b-2 border-[#111111] text-[#111111] font-mono text-sm focus:bg-[#F0F0F0] focus:outline-none transition-all placeholder:text-[#111111]/30 shadow-none"
                            placeholder="Iwanang blangko para sa auto-generation (e.g. panganay-vs-bunso)">
                        @error('slug')
                            <span class="font-mono text-xs text-red-600 mt-1 block">Error: {{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Content Field -->
                    <div>
                        <label for="content" class="block font-mono text-xs font-extrabold uppercase tracking-wider mb-2">03. Ang Kwento / Case Statement Body</label>
                        <textarea name="content" id="content" rows="6" required
                            class="w-full px-3 py-2 bg-transparent border-2 border-[#111111] text-[#111111] text-sm focus:bg-[#F0F0F0] focus:outline-none transition-all placeholder:text-[#111111]/30 leading-relaxed font-body text-justify shadow-none"
                            placeholder="Isulat dito ang kwento o sitwasyon... (Lora type spacing enabled)">{{ old('content') }}</textarea>
                        @error('content')
                            <span class="font-mono text-xs text-red-600 mt-1 block">Error: {{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Options Section Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Option A -->
                        <div>
                            <label for="option_a" class="block font-mono text-xs font-extrabold uppercase tracking-wider mb-2">04. Unang Hatol / Option A</label>
                            <input type="text" name="option_a" id="option_a" value="{{ old('option_a') }}" required
                                class="w-full px-3 py-2 bg-transparent border-b-2 border-[#111111] text-[#111111] font-mono text-sm focus:bg-[#F0F0F0] focus:outline-none transition-all placeholder:text-[#111111]/30 shadow-none"
                                placeholder="Hal. Ipaglaban ang Pangarap">
                            @error('option_a')
                                <span class="font-mono text-xs text-red-600 mt-1 block">Error: {{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Option B -->
                        <div>
                            <label for="option_b" class="block font-mono text-xs font-extrabold uppercase tracking-wider mb-2">05. Pangalawang Hatol / Option B</label>
                            <input type="text" name="option_b" id="option_b" value="{{ old('option_b') }}" required
                                class="w-full px-3 py-2 bg-transparent border-b-2 border-[#111111] text-[#111111] font-mono text-sm focus:bg-[#F0F0F0] focus:outline-none transition-all placeholder:text-[#111111]/30 shadow-none"
                                placeholder="Hal. Magparaya sa Kapatid">
                            @error('option_b')
                                <span class="font-mono text-xs text-red-600 mt-1 block">Error: {{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Image Field -->
                    <div>
                        <label for="image" class="block font-mono text-xs font-extrabold uppercase tracking-wider mb-2">06. Larawan ng Dilemma / Dilemma Image (Optional, max 2MB)</label>
                        <input type="file" name="image" id="image"
                            class="w-full px-3 py-2 bg-transparent border-2 border-dashed border-[#111111] text-[#111111] font-mono text-xs focus:bg-[#F0F0F0] focus:outline-none transition-all cursor-pointer file:bg-[#111111] file:text-[#F9F9F7] file:border-none file:font-mono file:text-[10px] file:uppercase file:px-3 file:py-1 file:mr-3 hover:file:bg-[#F9F9F7] hover:file:text-[#111111] hover:file:border hover:file:border-[#111111] shadow-none" />
                        @error('image')
                            <span class="font-mono text-xs text-red-600 mt-1 block">Error: {{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Actions block -->
                    <div class="pt-6 border-t border-[#111111]/25">
                        <button type="submit"
                            class="w-full py-4 bg-[#111111] text-[#F9F9F7] border-2 border-[#111111] font-mono uppercase tracking-widest text-xs font-black hover:bg-[#F9F9F7] hover:text-[#111111] transition-all duration-200 cursor-pointer shadow-none">
                            IPAPALATHALA ANG BAGONG EDISYON ➔
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
