<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Google Fonts: Playfair Display, Lora, Inter, JetBrains Mono -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Lora:ital,wght@0,400..700;1,400..700&family=Inter:wght@300;400;550;600;700&family=JetBrains+Mono:wght@300;400;500;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Newsprint Global CSS Injection -->
        <style>
            * {
                border-radius: 0px !important;
                box-shadow: none !important;
            }
            body {
                background-color: #F9F9F7 !important;
                color: #111111 !important;
                font-family: 'Inter', sans-serif;
                background-image: radial-gradient(#111111 0.7px, transparent 0.7px);
                background-size: 24px 24px;
            }
            .bg-white, .bg-gray-100, .bg-slate-50, .bg-zinc-900, .bg-zinc-950\/60, .bg-indigo-950\/40, .bg-indigo-950\/60, .bg-\[\#13141C\], .bg-\[\#121216\] {
                background-color: #F9F9F7 !important;
            }
            .border, .border-gray-100, .border-gray-200, .border-zinc-800, .border-white\/5, .border-indigo-500\/10, .border-indigo-500\/20, .border-indigo-500\/30 {
                border-color: #111111 !important;
            }
            .text-white, .text-slate-100, .text-slate-200, .text-slate-300, .text-slate-350, .text-indigo-200, .text-gray-250, .text-gray-300 {
                color: #111111 !important;
            }
            .text-slate-400, .text-slate-500, .text-slate-600, .text-gray-400, .text-gray-500, .text-indigo-400 {
                color: #666666 !important;
            }
            header, nav {
                background-color: #F9F9F7 !important;
                border-bottom: 4px solid #111111 !important;
            }
            .font-heading, h1, h2, h3 {
                font-family: 'Playfair Display', Georgia, serif !important;
            }
            .font-mono {
                font-family: 'JetBrains Mono', monospace !important;
            }
            .font-body {
                font-family: 'Lora', Georgia, serif !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-[#F9F9F7]">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-[#F9F9F7] border-b-4 border-[#111111]">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
