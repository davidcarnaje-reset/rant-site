<x-app-layout>
    <div class="py-12 bg-[#F9F9F7] min-h-screen font-sans selection:bg-[#CC0000] selection:text-white text-[#111111]">
        <div class="max-w-4xl mx-auto px-4">
            
            <div class="border-b-4 border-[#111111] pb-4 mb-8 text-center md:text-left flex flex-col md:flex-row justify-between items-center md:items-end">
                <div>
                    <span class="font-mono text-xs uppercase tracking-widest text-[#737373]">EDITORIAL CONTROL DESK // VOL. 1.0</span>
                    <h2 class="font-serif text-4xl font-black uppercase tracking-tight mt-1">Magpalathala ng Bagong Usapin</h2>
                </div>
                <div class="font-mono text-xs uppercase text-[#737373] mt-2 md:mt-0 border border-[#111111] px-3 py-1 bg-white">
                    MANILA EDITION • {{ date('Y-m-d') }}
                </div>
            </div>

            @if(session('success'))
                <div class="bg-[#CC0000] text-white p-4 mb-6 font-mono text-sm tracking-wider uppercase flex justify-between items-center animate-pulse">
                    <span>📢 {{ session('success') }}</span>
                    <span class="font-sans cursor-pointer font-bold" onclick="this.parentElement.remove()">✕</span>
                </div>
            @endif

            <form action="{{ route('admin.stories.store') }}" method="POST" enctype="multipart/form-data" class="bg-white border-2 border-[#111111] p-8 space-y-6 shadow-none">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <div class="md:col-span-2 space-y-6">
                        <div class="space-y-1">
                            <label class="block font-mono text-xs uppercase tracking-wider font-bold text-[#404040]">Pamagat ng Kwento / Headline *</label>
                            <input type="text" name="title" required value="{{ old('title') }}" placeholder="Hal. Isang Panganay na Nais Mag-aral vs. Bunsong Sakitin"
                                class="w-full bg-transparent border-t-0 border-x-0 border-b-2 border-[#111111] px-0 py-2 font-serif text-xl focus:outline-none focus:bg-[#F5F5F5] focus:border-[#CC0000] transition-colors" />
                            @error('title') <span class="text-xs text-[#CC0000] font-mono block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-1">
                            <label class="block font-mono text-xs uppercase tracking-wider font-bold text-[#404040]">Nilalaman ng Dilemma / Article Body *</label>
                            <textarea name="content" required rows="10" placeholder="Isulat dito ang buong ragebait o dilemma story nang may sapat na detalye at matinding emosyon..."
                                class="w-full bg-transparent border-2 border-[#111111] p-4 font-body text-base leading-relaxed text-justify focus:outline-none focus:bg-[#F5F5F5] transition-colors">{{ old('content') }}</textarea>
                            @error('content') <span class="text-xs text-[#CC0000] font-mono block mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="space-y-6 md:border-l md:border-[#111111] md:pl-6">
                        
                        <div class="space-y-1">
                            <label class="block font-mono text-xs uppercase tracking-wider font-bold text-[#404040]">Alternatibo A (Button Text) *</label>
                            <input type="text" name="option_a" required value="{{ old('option_a') }}" placeholder="Hal. Ipaglaban ang Pangarap"
                                class="w-full bg-transparent border-t-0 border-x-0 border-b-2 border-[#111111] px-0 py-2 font-sans text-sm font-bold focus:outline-none focus:bg-[#F5F5F5]" />
                            @error('option_a') <span class="text-xs text-[#CC0000] font-mono block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-1">
                            <label class="block font-mono text-xs uppercase tracking-wider font-bold text-[#404040]">Alternatibo B (Button Text) *</label>
                            <input type="text" name="option_b" required value="{{ old('option_b') }}" placeholder="Hal. Magparaya sa Kapatid"
                                class="w-full bg-transparent border-t-0 border-x-0 border-b-2 border-[#111111] px-0 py-2 font-sans text-sm font-bold focus:outline-none focus:bg-[#F5F5F5]" />
                            @error('option_b') <span class="text-xs text-[#CC0000] font-mono block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-2 pt-2">
                            <label class="block font-mono text-xs uppercase tracking-wider font-bold text-[#404040]">Litrato ng Editoryal (Opsyonal)</label>
                            <div class="border-2 border-dashed border-[#111111] p-4 bg-[#F5F5F5] text-center relative hover:bg-[#E5E5E0] transition-colors">
                                <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full" onchange="this.nextElementSibling.innerText = this.files[0].name" />
                                <span class="text-xs font-mono text-[#525252] block">📁 Pumili ng Larawan (JPEG, PNG)</span>
                            </div>
                            <span class="text-[10px] font-mono text-[#737373] block italic">Fig 1.2 — Awtomatikong magkakaroon ng grayscale texture filter sa balita.</span>
                            @error('image') <span class="text-xs text-[#CC0000] font-mono block mt-1">{{ $message }}</span> @enderror
                        </div>

                    </div>
                </div>

                <div class="border-t-2 border-[#111111] pt-6 flex justify-end">
                    <button type="submit" class="w-full md:w-auto px-8 py-4 bg-[#111111] text-[#F9F9F7] font-sans font-black uppercase tracking-widest text-sm border-2 border-transparent hover:bg-white hover:text-[#111111] hover:border-[#111111] transition-all duration-200 active:scale-95 shadow-none">
                        IPAPUBLIKA ANG BAGONG HATOL ➔
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>