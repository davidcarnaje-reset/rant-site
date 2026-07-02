<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $story->title }} - SINO ANG MALI?</title>

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
            .font-heading, h1, h2, h3 {
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
    <body class="min-h-screen relative overflow-x-hidden selection:bg-[#111111] selection:text-[#F9F9F7] antialiased">
        <div class="min-h-screen flex flex-col justify-between relative z-10">
            <!-- Header/Navbar -->
            <header class="w-full max-w-4xl mx-auto px-4 py-6 flex items-center justify-between border-b-4 border-[#111111] bg-[#F9F9F7]">
                <a href="/" class="flex items-center gap-3 transition-transform duration-200 hover:scale-[1.01]">
                    <span class="text-3xl">⚖️</span>
                    <div>
                        <h1 class="text-2xl font-black font-heading tracking-tight text-[#111111] uppercase leading-none">
                            SINO ANG MALI?
                        </h1>
                        <p class="text-[9px] uppercase tracking-widest text-[#CC0000] font-mono font-bold mt-1">
                            Ang Hatol ng Bayan &bull; Broadsheet Ledger
                        </p>
                    </div>
                </a>

                <!-- Navigation Links Removed for Pure Editorial Aesthetics -->
            </header>

            <!-- Main Content Container -->
            <main class="w-full max-w-4xl mx-auto flex-grow py-10 px-4">
                <div class="w-full">
                    <!-- Navigation / Breadcrumbs -->
                    <div class="mb-6 flex items-center gap-2 font-mono text-[10px] uppercase text-[#111111]/70 font-bold border-b border-[#111111]/20 pb-2">
                        <a href="/" class="hover:underline">Home</a>
                        <span>/</span>
                        <span>Kwento</span>
                        <span>/</span>
                        <span class="truncate max-w-[200px] text-[#111111]" title="{{ $story->title }}">{{ $story->title }}</span>
                    </div>

                    <!-- Livewire Component -->
                    <livewire:story-voter :story="$story" />
                </div>
            </main>

            <!-- Footer -->
            <footer class="w-full text-center py-8 text-[10px] font-mono uppercase tracking-wider text-slate-500 border-t-4 border-[#111111] bg-[#F9F9F7]">
                <p>&copy; {{ date('Y') }} SINO ANG MALI? &bull; ALL RIGHTS RESERVED ON CORRESPONDENCE LEDGER.</p>
            </footer>
        </div>
    </body>
</html>
