<!DOCTYPE html>
<html lang="pt-BR" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' - '.config('app.name', 'ManagerBox') : config('app.name', 'ManagerBox') }}</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="min-h-screen font-sans antialiased bg-base-100 flex" x-data="{ sidebarOpened: true }">

    {{-- 1. SIDEBAR  --}}
    <aside class="w-20 bg-white border-r border-gray-200 min-h-screen p-4 flex flex-col shadow-lg z-20">
        <div class="mb-8 flex flex-col items-center gap-6">
            {{-- Icon - App --}}
            <x-icon name="o-square-3-stack-3d" class="w-8 h-8 text-gray-700 cursor-pointer" @click="sidebarOpened = !sidebarOpened" />
        </div>

        <nav class="flex flex-col items-center gap-6 text-sm font-medium">
            <x-icon name="o-home" class="w-6 h-6 text-gray-700 hover:text-primary transition cursor-pointer" tooltip="Início" />
            <x-icon name="o-cube" class="w-6 h-6 text-primary transition cursor-pointer" tooltip="Estoque" />
            <x-icon name="o-users" class="w-6 h-6 text-gray-700 hover:text-primary transition cursor-pointer" tooltip="Usuários" />
        </nav>
    </aside>

    {{-- 2. SIDEBAR NAVEGATOR --}}
    <aside
        class="bg-gray-50 border-r border-gray-200 min-h-screen p-4 flex flex-col transition-all duration-300 z-10"
        :class="sidebarOpened ? 'w-64' : 'w-0 overflow-hidden p-0'"
    >
        {{-- Títle --}}
        <div class="flex items-center justify-between h-10 mb-6">
            <span class="text-xl font-bold text-gray-700">DashB.</span>
        </div>

        {{-- Mary UI --}}
        <x-menu>

            <x-menu-sub title="Relatórios" icon="o-chart-bar-square" open-on-load class="bg-primary/10">
                <x-menu-item title="Visão geral" link="/dashboard" icon="o-eye" class="text-primary" />
                <x-menu-item title="Itens em estoque" link="#" icon="o-truck" />
            </x-menu-sub>

            <x-menu-sub title="Usuários" icon="o-user-group">
                <x-menu-item title="Listar" link="#" icon="o-list-bullet" />
                <x-menu-item title="Adicionar novo" link="#" icon="o-plus" />
            </x-menu-sub>

            <x-menu-sub title="Estoque" icon="o-archive-box">
                <x-menu-item title="Listar" link="#" icon="o-list-bullet" />
                <x-menu-item title="Adicionar novo" link="#" icon="o-plus" />
                <x-menu-item title="Movimentações" link="#" icon="o-arrows-up-down" />
            </x-menu-sub>

             <x-menu-sub title="Funcionários" icon="o-briefcase">
                <x-menu-item title="Listar" link="#" icon="o-list-bullet" />
                <x-menu-item title="Adicionar novo" link="#" icon="o-plus" />
            </x-menu-sub>
        </x-menu>
    </aside>

    {{-- 3. MAIN CONTENT --}}
    <main class="flex-1 overflow-y-auto bg-gray-50">

        {{-- NAVBAR/HEADER --}}
        <header class="p-4 bg-white border-b border-gray-200 flex items-center justify-between shadow-sm sticky top-0 z-10">

            {{-- Breadcrumbs --}}
            <div class="flex items-center space-x-2 text-sm">
                <x-icon name="o-home" class="w-4 h-4 text-gray-400" />
                <a href="#" class="hover:text-primary transition">Relatórios</a>
                <x-icon name="o-chevron-right" class="w-4 h-4 text-gray-400" />
                <span class="font-semibold text-gray-700">Visão geral</span>
            </div>

            <div class="flex items-center space-x-4">
                <x-button icon="o-magnifying-glass" class="btn-ghost btn-sm" link="#" />
                <x-button icon="o-bell" class="btn-ghost btn-sm" link="#" />

                {{-- Dropdown ) --}}
                <x-dropdown>
                    <x-slot:trigger>
                        <div class="w-10 h-10 rounded-full bg-yellow-300 flex items-center justify-center text-lg font-bold cursor-pointer">AC</div>
                    </x-slot:trigger>

                    <x-menu-item title="Meu perfil" link="#" />
                    <x-menu-item title="Painel da empresa" link="#" />
                    <x-menu-item title="Assinatura" link="#" />
                    <x-menu-separator />
                    <x-menu-item title="Ajustes de interface" link="#" />
                    <x-menu-item title="Modo" link="#">
                         <x-slot:actions>
                            <x-icon name="o-sun" class="w-5 h-5" />
                        </x-slot:actions>
                    </x-menu-item>
                    <x-menu-item title="Idioma" link="#">
                         <x-slot:actions>
                            Português 🇵🇹
                        </x-slot:actions>
                    </x-menu-item>
                    <x-menu-item title="Configurações da conta" link="#" />
                    <x-menu-separator />
                    <x-menu-item title="Sair" icon="o-arrow-left-start-on-rectangle" link="#" class="text-red-500" />
                </x-dropdown>
            </div>
        </header>

        {{-- SLOT --}}
        <div class="p-4 md:p-6 lg:p-8">
            {{ $slot }}
        </div>

    </main>

    <x-toast />
    @livewireScripts
</body>
</html>
