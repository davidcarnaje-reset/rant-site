<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>SINO ANG MALI? - Broadside Ledger</title>

        <!-- Google Fonts: Playfair Display, Lora, Inter, JetBrains Mono -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Lora:ital,wght@0,400..700;1,400..700&family=Inter:wght@300;400;550;600;700&family=JetBrains+Mono:wght@300;400;500;700;800&display=swap" rel="stylesheet">

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                background-color: #F9F9F7;
                color: #111111;
                font-family: 'Inter', sans-serif;
                background-image: radial-gradient(#111111 0.7px, transparent 0.7px);
                background-size: 24px 24px;
            }
            .font-heading {
                font-family: 'Playfair Display', Georgia, serif;
            }
            .font-mono {
                font-family: 'JetBrains Mono', monospace;
            }
            .font-body {
                font-family: 'Lora', Georgia, serif;
            }
            * {
                border-radius: 0px !important;
                box-shadow: none !important;
            }
        </style>
    </head>
    <body class="min-h-screen py-12 px-4 md:px-8 selection:bg-[#111111] selection:text-[#F9F9F7] antialiased">
        <div class="max-w-6xl mx-auto">
            
            <!-- Broadsheet Masthead Block -->
            <header class="border-t-4 border-b-4 border-double border-[#111111] py-8 mb-10 text-center">
                <p class="font-mono text-xs uppercase tracking-widest text-[#111111]/70 mb-2 font-bold">
                    The Voice of Local Dilemmas and Public Judgement
                </p>
                <h1 class="text-5xl md:text-7xl font-black font-heading tracking-tighter uppercase mb-4">
                    Sino Ang Mali?
                </h1>
                <div class="border-t border-[#111111]/30 pt-4 mt-2 flex flex-col sm:flex-row items-center justify-between font-mono text-xs uppercase tracking-widest text-[#111111]/90 font-bold">
                    <span>VOL. 1.0 &bull; ISSUE NO. 1</span>
                    <span class="my-2 sm:my-0">MANILA, PHILIPPINES</span>
                    <span>{{ date('F d, Y') }}</span>
                </div>
            </header>

            <!-- Headline/Hero Section (Only shown if stories exist) -->
            @if($stories->isNotEmpty())
                @php $headline = $stories->first(); @endphp
                <section class="border-4 border-[#111111] p-6 md:p-8 bg-[#F9F9F7] mb-10">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
                        <div class="md:col-span-8 space-y-4">
                            <!-- Monospace badge -->
                            <span class="px-2 py-0.5 border border-[#111111] text-[#CC0000] font-mono text-[10px] font-black uppercase tracking-widest">
                                📢 HEADLINE CORRESPONDENCE
                            </span>

                            @if($headline->image_path)
                                <div class="mb-4 border-2 border-[#111111] bg-white overflow-hidden group">
                                    <img src="{{ asset('storage/' . $headline->image_path) }}" alt="{{ $headline->title }}" class="w-full max-h-[320px] object-cover grayscale hover:grayscale-0 transition-all duration-300" />
                                </div>
                            @endif
                            
                            <!-- Title -->
                            <h2 class="text-3xl md:text-5xl font-heading font-black uppercase leading-tight tracking-tight">
                                <a href="{{ route('story.show', $headline->slug) }}" class="hover:underline decoration-4 decoration-[#CC0000] hover:text-[#CC0000] transition-colors">
                                    {{ $headline->title }}
                                </a>
                            </h2>
                            
                            <!-- Content preview -->
                            <p class="text-justify font-body text-slate-800 leading-relaxed text-sm md:text-base">
                                {{ Str::limit($headline->content, 260) }}
                            </p>
                            
                            <!-- Read action -->
                            <div class="pt-2">
                                <a href="{{ route('story.show', $headline->slug) }}" class="inline-block font-mono text-xs font-black uppercase tracking-widest text-[#111111] hover:text-[#CC0000] border-b-2 border-[#111111] pb-1 hover:border-[#CC0000] transition-all">
                                    BASAHIN ANG BUONG HATOL ➔
                                </a>
                            </div>
                        </div>
                        
                        <!-- Sidebar stats column within headline -->
                        <div class="md:col-span-4 border-l-2 border-[#111111] pl-0 md:pl-8 space-y-4 pt-6 md:pt-0 border-t-2 md:border-t-0 border-dashed border-[#111111]">
                            <h3 class="font-mono text-xs uppercase font-black tracking-wider text-[#111111]/70">[LEDGER SUMMARY]</h3>
                            <div class="space-y-3 font-mono text-xs">
                                <div class="flex justify-between border-b border-[#111111]/10 pb-1">
                                    <span class="text-slate-600">MGA BOTO RECORDED:</span>
                                    <span class="font-bold">{{ $headline->votes()->count() }}</span>
                                </div>
                                <div class="flex justify-between border-b border-[#111111]/10 pb-1">
                                    <span class="text-slate-600">MGA HUKOM SUMMARY:</span>
                                    <span class="font-bold">{{ $headline->comments()->count() }} statements</span>
                                </div>
                                <div class="flex justify-between border-b border-[#111111]/10 pb-1">
                                    <span class="text-slate-600">LEDGER STATUS:</span>
                                    <span class="text-[#CC0000] font-black uppercase">ACTIVE</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif

            <!-- Broadsheet Grid Title -->
            <div class="border-b-4 border-[#111111] pb-2 mb-6 flex justify-between items-end">
                <h3 class="font-heading text-2xl font-black uppercase tracking-tight">Public Case Ledger</h3>
                <span class="font-mono text-xs font-bold text-slate-500 uppercase tracking-widest">Page 2 &bull; Archives</span>
            </div>

            <!-- Broadsheet Main Stories Grid -->
            <div class="border-l border-t border-[#111111] bg-[#F9F9F7]">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-0">
                    
                    @forelse($stories as $story)
                        <!-- Grid cell with collapsed borders -->
                        <article class="p-6 border-r border-b border-[#111111] flex flex-col justify-between space-y-4 hover:bg-[#F2F2EC]/40 transition-colors duration-200">
                            <div class="space-y-3">
                                <!-- Monospace Category Badge -->
                                <span class="px-2 py-0.5 border border-[#111111] text-[#111111] font-mono text-[9px] font-bold uppercase tracking-wider">
                                    ⚖️ CASE #{{ $story->id }}
                                </span>

                                @if($story->image_path)
                                    <div class="my-3 border border-[#111111] bg-white overflow-hidden">
                                        <img src="{{ asset('storage/' . $story->image_path) }}" alt="{{ $story->title }}" class="w-full h-36 object-cover grayscale hover:grayscale-0 transition-all duration-300" />
                                    </div>
                                @endif
                                
                                <!-- Story Title -->
                                <h4 class="text-xl font-heading font-bold uppercase leading-tight tracking-tight">
                                    <a href="{{ route('story.show', $story->slug) }}" class="hover:underline decoration-2 decoration-[#CC0000] hover:text-[#CC0000] transition-colors">
                                        {{ $story->title }}
                                    </a>
                                </h4>
                                
                                <!-- Content justified preview snippet -->
                                <p class="text-justify font-body text-xs text-slate-800 leading-relaxed">
                                    {{ Str::limit($story->content, 150) }}
                                </p>
                            </div>

                            <!-- Read Button -->
                            <div class="pt-4 border-t border-[#111111]/10">
                                <a href="{{ route('story.show', $story->slug) }}" class="inline-block font-mono text-[10px] font-black uppercase tracking-widest text-[#111111] hover:text-[#CC0000] transition-colors">
                                    BASAHIN ANG BUONG HATOL ➔
                                </a>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-3 p-12 text-center border-r border-b border-[#111111]">
                            <p class="font-mono text-sm uppercase tracking-widest text-slate-500 font-bold mb-1">
                                [SYSTEM REPORT: THE LEDGER IS VACANT]
                            </p>
                            <p class="text-xs font-body text-slate-400">Walang mga kwento na natagpuan sa database.</p>
                        </div>
                    @endforelse

                </div>
            </div>

            <!-- Footer Block -->
            <footer class="w-full text-center py-10 mt-12 border-t-4 border-b border-[#111111] border-double bg-[#F9F9F7] font-mono text-xs uppercase tracking-widest text-[#111111]/70 font-bold">
                <p>&copy; {{ date('Y') }} SINO ANG MALI? &bull; PUBLIC BROADCASTING & PUBLIC LEDGER OF GENERAL TRUTHS.</p>
            </footer>
        </div>
    </body>
</html>
