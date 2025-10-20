<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' - '.config('app.name', 'ManagerBox') : config('app.name', 'ManagerBox') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-background text-gray-800 flex">

    {{-- SIDEBAR --}}
    <aside class="w-20 md:w-64 bg-[#f3eee9] border-r border-gray-200 min-h-screen p-4 flex flex-col">
        <div class="flex items-center justify-center md:justify-start mb-10">
            <span class="text-xl font-semibold text-gray-700 hidden md:block">ManagerBox</span>
            <span class="text-xl md:hidden">📦</span>
        </div>

        <nav class="flex flex-col gap-4 text-sm font-medium">
            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-[#e7dfd7] transition">
                <x-icon name="o-home" class="w-5 h-5" />
                <span class="hidden md:block">Início</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg bg-[#e7dfd7] text-[#1b1b1b] font-semibold transition">
                <x-icon name="o-chart-bar" class="w-5 h-5" />
                <span class="hidden md:block">Relatórios</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-[#e7dfd7] transition">
                <x-icon name="o-cog-6-tooth" class="w-5 h-5" />
                <span class="hidden md:block">Configurações</span>
            </a>
        </nav>

        <div class="mt-auto pt-6 text-center text-xs text-gray-500">
            v0.1.0
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="flex-1 p-8 overflow-y-auto bg-white">
        {{ $slot }}
    </main>

</body>
</html>
