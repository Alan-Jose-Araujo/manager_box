<!DOCTYPE html>
<html lang="pt-br" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/manager_box_icon.ico') }}">
    <title>{{ $title ?? 'Page Title' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --beige-color: #F8F2EC;
        }

        body {
            background-color: var(--beige-color);
            font-family: 'Inter', sans-serif;
        }

        .sidebar {
            /* width: 4rem; */
            transition: width 0.3s ease-in-out;
            background-color: var(--beige-color);
        }

        .sidebar:hover,
        .sidebar.sidebar-fixed {
            width: 14rem;
        }

        .sidebar-text,
        .submenu-item {
            display: none;
            opacity: 0;
            transition: opacity 0.15s ease-in-out;
        }

        .sidebar:hover .sidebar-text,
        .sidebar:hover .submenu-item,
        .sidebar.sidebar-fixed .sidebar-text,
        .sidebar.sidebar-fixed .submenu-item {
            display: inline-block;
            opacity: 1;
        }

        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-in-out;
            padding-top: 0;
            padding-bottom: 0;
        }

        .submenu.expanded {
            max-height: 200px;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        .profile-dropdown {
            display: none;
        }

        .profile-menu.profile-menu-open .profile-dropdown {
            display: block;
        }

        .nav-item [data-toggle="submenu"] svg:last-child {
            transition: transform 0.2s;
        }

        .rotate-180 {
            transform: rotate(180deg);
        }

        .sidebar-icon {
            color: rgba(0, 0, 0, 0.5);
            transition: color 0.2s;
        }

        .sidebar:hover .nav-item:hover .sidebar-icon {
            color: rgba(0, 0, 0, 0.7);
        }

        .navbar-icon path {
            stroke: currentColor;
        }

        main {
            background-color: #FFF;
            border-radius: 1em;
        }
    </style>
</head>

<body class="flex h-screen overflow-hidden">

    <aside id="sidebar" class="sidebar flex flex-col p-4 z-20">
        <div class="flex items-center justify-start h-16 mb-4">
            <img src="{{ asset('images/manager_box_logo.svg') }}" alt="Logo" class="w-12 h-12 shrink-0">
        </div>

        <nav class="flex-1 space-y-2">
            @php
                $menu = [
                    'Relatórios' => [
                        'icon' => '<svg class="sidebar-icon w-7 h-7 shrink-0" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M2.14286 0C1.57454 0 1.02949 0.225765 0.627628 0.627628C0.225765 1.02949 0 1.57454 0 2.14286L0 15C0 15.5683 0.225765 16.1134 0.627628 16.5152C1.02949 16.9171 1.57454 17.1429 2.14286 17.1429H10.7143C11.2826 17.1429 11.8277 16.9171 12.2295 16.5152C12.6314 16.1134 12.8571 15.5683 12.8571 15V2.14286C12.8571 1.57454 12.6314 1.02949 12.2295 0.627628C11.8277 0.225765 11.2826 0 10.7143 0L2.14286 0ZM17.1429 2.14286C17.1429 1.57454 17.3686 1.02949 17.7705 0.627628C18.1723 0.225765 18.7174 0 19.2857 0L27.8571 0C28.4255 0 28.9705 0.225765 29.3724 0.627628C29.7742 1.02949 30 1.57454 30 2.14286V6.45C30 7.01832 29.7742 7.56336 29.3724 7.96523C28.9705 8.36709 28.4255 8.59286 27.8571 8.59286H19.2857C18.7174 8.59286 18.1723 8.36709 17.7705 7.96523C17.3686 7.56336 17.1429 7.01832 17.1429 6.45V2.14286ZM17.1429 15C17.1429 14.4317 17.3686 13.8866 17.7705 13.4848C18.1723 13.0829 18.7174 12.8571 19.2857 12.8571H27.8571C28.4255 12.8571 28.9705 13.0829 29.3724 13.4848C29.7742 13.8866 30 14.4317 30 15V27.8571C30 28.4255 29.7742 28.9705 29.3724 29.3724C28.9705 29.7742 28.4255 30 27.8571 30H19.2857C18.7174 30 18.1723 29.7742 17.7705 29.3724C17.3686 28.9705 17.1429 28.4255 17.1429 27.8571V15ZM0 23.55C0 22.9817 0.225765 22.4366 0.627628 22.0348C1.02949 21.6329 1.57454 21.4071 2.14286 21.4071H10.7143C11.2826 21.4071 11.8277 21.6329 12.2295 22.0348C12.6314 22.4366 12.8571 22.9817 12.8571 23.55V27.8571C12.8571 28.4255 12.6314 28.9705 12.2295 29.3724C11.8277 29.7742 11.2826 30 10.7143 30H2.14286C1.57454 30 1.02949 29.7742 0.627628 29.3724C0.225765 28.9705 0 28.4255 0 27.8571V23.55Z" fill="currentColor" /></svg>',
                        'sub' => ['Visão geral', 'Itens em estoque', 'Usuários']
                    ],
                    'Estoque' => [
                        'icon' => '<svg class="sidebar-icon w-8 h-8 shrink-0" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M34.3067 14.3333C34.245 12.1483 34.0383 10.755 33.3383 9.56667C32.3417 7.875 30.5483 6.93333 26.9633 5.05333L23.63 3.30333C20.7033 1.76833 19.24 1 17.6667 1C16.0933 1 14.63 1.76667 11.7033 3.30333L8.37 5.05333C4.785 6.93333 2.99167 7.875 1.995 9.56667C1 11.2567 1 13.3617 1 17.57V17.765C1 21.9717 1 24.0767 1.995 25.7667C2.99167 27.4583 4.785 28.4 8.37 30.2817L11.7033 32.03C14.63 33.565 16.0933 34.3333 17.6667 34.3333C19.24 34.3333 20.7033 33.5667 23.63 32.03L26.9633 30.28C30.5483 28.3983 32.3417 27.4583 33.3383 25.7667C34.0383 24.5783 34.245 23.185 34.3067 21M32.6667 10.1667L26 13.5M26 13.5L25.1667 13.9167L17.6667 17.6667M26 13.5V19.3333M26 13.5L10.1667 5.16667M17.6667 17.6667L2.66667 10.1667M17.6667 17.6667V33.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
                        'sub' => ['Listar', 'Adicionar novo', 'Movimentações']
                    ],
                    'Funcionários' => [
                        'icon' => '<svg class="sidebar-icon w-10 h-10 shrink-0" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.9999 16.6667C18.6818 16.6667 21.6666 13.6819 21.6666 10C21.6666 6.31814 18.6818 3.33337 14.9999 3.33337C11.318 3.33337 8.33325 6.31814 8.33325 10C8.33325 13.6819 11.318 16.6667 14.9999 16.6667Z" stroke="currentColor" stroke-width="2"/><path d="M24.9999 15C26.326 15 27.5978 14.4732 28.5355 13.5355C29.4731 12.5979 29.9999 11.3261 29.9999 10C29.9999 8.67392 29.4731 7.40215 28.5355 6.46447C27.5978 5.52678 26.326 5 24.9999 5M9.81658 34.3067C11.3749 34.75 13.1366 35 14.9999 35C21.4433 35 26.6666 32.0167 26.6666 28.3333C26.6666 24.65 21.4433 21.6667 14.9999 21.6667C8.55659 21.6667 3.33325 24.65 3.33325 28.3333C3.33325 28.9083 3.46159 29.4667 3.69992 30M29.9999 23.3333C32.9233 23.975 34.9999 25.5983 34.9999 27.5C34.9999 29.2167 33.3099 30.705 30.8333 31.45" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
                        'sub' => ['Listar', 'Adicionar novo']
                    ],
                ];

                $authUser = auth()->user();
            @endphp
            @foreach($menu as $title => $item)
                <div class="nav-item">
                    <div data-toggle="submenu"
                        class="flex items-center justify-start gap-3 p-2 rounded-xl text-gray-700 hover:bg-stone-200 hover:text-gray-900 cursor-pointer transition-colors duration-200"
                        @if($title === 'Relatórios') aria-expanded="true" @endif>
                        {!! $item['icon'] !!} <span
                            class="sidebar-text font-medium whitespace-nowrap flex-grow">{{ $title }}</span>
                        <svg class="sidebar-text w-4 h-4 ml-auto text-gray-500 transition-transform duration-200"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                    <div class="submenu @if($title === 'Relatórios') expanded @endif ml-2"
                        id="submenu-{{ Str::slug($title) }}">
                        <ul class="pt-1 space-y-1 text-base text-gray-700">
                            @foreach($item['sub'] as $subItem)
                                <li class="submenu-item flex items-center p-1 pl-4 rounded-lg hover:bg-stone-200">
                                    <a href="#">
                                        <span class="flex items-center">
                                            <span class="w-2 h-2 bg-gray-600 rounded-full mr-3"></span>
                                            <span class="font-medium whitespace-nowrap">{{ $subItem }}</span>
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </nav>

        <div class="relative">
            <a href="#">
                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M15 20C17.7614 20 20 17.7614 20 15C20 12.2386 17.7614 10 15 10C12.2386 10 10 12.2386 10 15C10 17.7614 12.2386 20 15 20Z"
                        stroke="black" stroke-opacity="0.5" stroke-width="1.5" />
                    <path
                        d="M18.75 11.25L23.75 6.25M6.25 23.75L11.25 18.75M11.25 11.25L6.25 6.25M23.75 23.75L18.75 18.75"
                        stroke="black" stroke-opacity="0.5" stroke-width="1.5" />
                    <path
                        d="M11.765 2.92366C13.8841 2.3537 16.1163 2.35457 18.235 2.92616C24.9037 4.71366 28.86 11.5674 27.0737 18.2349C25.2862 24.9037 18.4337 28.8599 11.765 27.0737C5.0962 25.2874 1.13995 18.4337 2.92495 11.7649C3.48909 9.64411 4.60433 7.71034 6.15745 6.15991"
                        stroke="black" stroke-opacity="0.5" stroke-width="1.5" stroke-linecap="round" />
                </svg>
            </a>
        </div>
    </aside>

    <div class="flex flex-col flex-1 overflow-x-hidden overflow-y-auto">

        <header
            class="h-16 flex items-center justify-between border-b border-gray-100/50 px-6 sticky top-0 z-10"
            style="background-color: #F8F2EC;">

            <div class="flex items-center space-x-4">
                <div id="navbarMenuToggle"
                    class="p-2 text-black hover:text-gray-800 cursor-pointer rounded-lg hover:bg-stone-200">
                    <svg class="w-6 h-6 navbar-icon" width="40" height="40" viewBox="0 0 40 40" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M6.66675 11.6667H11.6667M33.3334 11.6667H18.3334M33.3334 28.3334H28.3334M6.66675 28.3334H21.6667M6.66675 20.0001H33.3334"
                            stroke="currentColor" stroke-opacity="0.5" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </div>
            </div>

            <div class="flex items-center space-x-4">

                <div
                    class="p-2 text-gray-500 hover:text-gray-700 cursor-pointer rounded-lg hover:bg-stone-200 relative">
                    <svg class="w-6 h-6 navbar-icon" width="23" height="23" viewBox="0 0 23 23" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M18.7083 7.25C20.4341 7.25 21.8333 5.85089 21.8333 4.125C21.8333 2.39911 20.4341 1 18.7083 1C16.9824 1 15.5833 2.39911 15.5833 4.125C15.5833 5.85089 16.9824 7.25 18.7083 7.25Z"
                            stroke="currentColor" stroke-opacity="0.5" stroke-width="2" />
                        <path
                            d="M6.20833 13.5H15.5833M6.20833 17.1458H12.4583M1 11.4167C1 16.3271 1 18.7823 2.525 20.3073C4.05208 21.8333 6.50625 21.8333 11.4167 21.8333C16.3271 21.8333 18.7823 21.8333 20.3073 20.3073C21.8333 18.7833 21.8333 16.3271 21.8333 11.4167V9.85417M12.9792 1H11.4167C6.50625 1 4.05104 1 2.525 2.525C1.51146 3.53958 1.17083 4.96563 1.05729 7.25"
                            stroke="currentColor" stroke-opacity="0.5" stroke-width="2" stroke-linecap="round" />
                    </svg>
                    <span
                        class="absolute top-1 right-1 block w-2 h-2 rounded-full bg-red-500 border border-white"></span>
                </div>

                <div class="p-2 text-gray-500 hover:text-gray-700 cursor-pointer rounded-lg hover:bg-stone-200">
                    <svg class="w-6 h-6 navbar-icon" width="25" height="25" viewBox="0 0 25 25" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M18.9374 8.37495L19.4197 7.89162C19.8037 7.50747 20.3246 7.2916 20.8678 7.2915C21.411 7.29141 21.9319 7.50709 22.3161 7.8911C22.7002 8.27511 22.9161 8.796 22.9162 9.33917C22.9163 9.88234 22.7006 10.4033 22.3166 10.7875L21.8343 11.2708M18.9374 8.37495C18.9374 8.37495 18.9978 9.39995 19.9031 10.3052C20.8083 11.2104 21.8343 11.2708 21.8343 11.2708M18.9374 8.37495L14.4999 12.8125C14.1978 13.1125 14.0478 13.2635 13.9187 13.4291C13.7659 13.625 13.636 13.8354 13.5291 14.0604C13.4385 14.25 13.3718 14.451 13.2374 14.8541L12.8072 16.1458L12.6676 16.5635M21.8343 11.2708L17.3968 15.7083C17.0947 16.0104 16.9447 16.1604 16.7791 16.2895C16.5833 16.4423 16.3728 16.5722 16.1478 16.6791C15.9583 16.7697 15.7572 16.8364 15.3541 16.9708L14.0624 17.401L13.6447 17.5406M12.6676 16.5635L12.5291 16.9822C12.4968 17.0794 12.4922 17.1837 12.5158 17.2834C12.5394 17.383 12.5903 17.4742 12.6627 17.5466C12.7351 17.619 12.8262 17.6698 12.9259 17.6934C13.0256 17.717 13.1298 17.7124 13.227 17.6802L13.6447 17.5406M12.6676 16.5635L13.6447 17.5406"
                            stroke="currentColor" stroke-opacity="0.5" stroke-width="2" />
                        <path
                            d="M8.33333 13.5416H10.9375M8.33333 9.37492H15.1042M8.33333 17.7083H9.89583M3.125 14.5833V10.4166C3.125 6.48846 3.125 4.52388 4.34583 3.30409C5.56667 2.08429 7.53021 2.08325 11.4583 2.08325H13.5417C17.4698 2.08325 19.4344 2.08325 20.6542 3.30409M21.875 14.5833C21.875 18.5114 21.875 20.476 20.6542 21.6958M20.6542 21.6958C19.4344 22.9166 17.4698 22.9166 13.5417 22.9166H11.4583C7.53021 22.9166 5.56562 22.9166 4.34583 21.6958M20.6542 21.6958C21.6375 20.7135 21.8281 19.2499 21.8656 16.6666"
                            stroke="currentColor" stroke-opacity="0.5" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </div>

                <div id="profileMenu" class="profile-menu relative cursor-pointer">
                    <div
                        class="w-10 h-10 rounded-full overflow-hidden shrink-0 border-2 border-transparent hover:border-gray-500 transition-colors duration-200">
                        <img src="{{ asset('storage/' . $authUser->profile_picture_path ) ?? asset('images/default_user_icon.png') }}" alt="{{ $authUser->name }}"
                            class="w-full h-full object-cover">
                    </div>

                    <div id="profileDropdown"
                        class="profile-dropdown absolute right-0 mt-3 w-72 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 transform origin-top-right">
                        <div class="p-4 border-b border-gray-200">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 rounded-full overflow-hidden shrink-0">
                                    <img src="{{ asset('storage/' . $authUser->profile_picture_path ) ?? asset('images/default_user_icon.png') }}" alt="{{ $authUser->name }}"
                                        class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <p class="text-lg font-semibold text-gray-800">{{ $authUser->name }}</p>
                                        {{-- TODO: Translate roles names and get here. --}}
                                        <span
                                            class="text-xs font-medium bg-green-500 text-white px-2 py-0.5 rounded-full">{{ $authUser->roles()->first(['name'])->name }}</span>
                                    </div>
                                    <p class="text-sm text-gray-500">{{ $authUser->email }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="py-2 border-b border-gray-200">
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-stone-100">Meu perfil</a>
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-stone-100">Painel da empresa</a>

                            <a href="#"
                                class="flex justify-between items-center px-4 py-2 text-gray-700 hover:bg-stone-100">
                                Assinatura
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" fill-rule="evenodd"></path>
                                </svg>
                            </a>
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-stone-100">Ajustes de
                                interface</a>
                        </div>

                        <div class="py-2">
                            <div class="flex justify-between items-center px-4 py-2 text-gray-700">
                                Modo
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                                    </path>
                                </svg>
                            </div>

                            {{-- Disabled for now. --}}
                            {{-- <div class="flex justify-between items-center px-4 py-2 text-gray-700">
                                Idioma
                                <span
                                    class="text-sm font-medium bg-stone-100 text-gray-700 px-2 py-1 rounded-full flex items-center space-x-2">
                                    Português <img src="https://flagcdn.com/16x12/br.png" width="16" height="12"
                                        alt="Bandeira do Brasil">
                                </span>
                            </div> --}}

                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-stone-100">Configurações da
                                conta</a>

                            <div class="pt-2 mt-2 border-t border-gray-100">
                                <a href="#" class="block px-4 py-2 text-red-600 hover:bg-red-50 rounded-b-xl">Sair</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="p-2 text-gray-500 hover:text-gray-700 cursor-pointer rounded-lg hover:bg-stone-200 hidden md:block">
                    <svg class="w-6 h-6 navbar-icon" width="25" height="25" viewBox="0 0 25 25" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M8.16979 21.0395C10.2833 22.2905 11.3396 22.9166 12.5 22.9166C13.6604 22.9166 14.7167 22.2916 16.8302 21.0395L17.5448 20.6155C19.6583 19.3655 20.7146 18.7385 21.2948 17.7083C21.875 16.677 21.875 15.427 21.875 12.9228M21.6823 8.33325C21.6056 7.96871 21.475 7.61763 21.2948 7.29159C20.7146 6.26034 19.6583 5.63534 17.5448 4.38325L16.8302 3.96034C14.7167 2.70929 13.6604 2.08325 12.5 2.08325C11.3396 2.08325 10.2833 2.70825 8.16979 3.96034L7.45521 4.38325C5.34167 5.63534 4.28542 6.26138 3.70521 7.29159C3.125 8.32284 3.125 9.57284 3.125 12.077V12.9228C3.125 15.426 3.125 16.678 3.70521 17.7083C3.94062 18.127 4.25521 18.4791 4.6875 18.8333"
                            stroke="currentColor" stroke-opacity="0.5" stroke-width="1.5" stroke-linecap="round" />
                        <path
                            d="M12.5 15.625C14.2259 15.625 15.625 14.2259 15.625 12.5C15.625 10.7741 14.2259 9.375 12.5 9.375C10.7741 9.375 9.375 10.7741 9.375 12.5C9.375 14.2259 10.7741 15.625 12.5 15.625Z"
                            stroke="currentColor" stroke-opacity="0.5" stroke-width="1.5" />
                    </svg>
                </div>
            </div>
        </header>

        <main class="flex-1 p-6 overflow-y-auto">
            {{ $slot }}
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const navItems = document.querySelectorAll('.nav-item');
            const navbarToggle = document.getElementById('navbarMenuToggle');

            const profileMenu = document.getElementById('profileMenu');
            const profileDropdown = document.getElementById('profileDropdown');

            if (profileMenu && profileDropdown) {
                profileMenu.addEventListener('click', (e) => {
                    e.stopPropagation();
                    profileMenu.classList.toggle('profile-menu-open');
                });
                document.addEventListener('click', (e) => {
                    if (!profileMenu.contains(e.target) && profileMenu.classList.contains('profile-menu-open')) {
                        profileMenu.classList.remove('profile-menu-open');
                    }
                });
            }


            if (navbarToggle && sidebar) {
                navbarToggle.addEventListener('click', () => {
                    sidebar.classList.toggle('sidebar-fixed');
                });
            }

            navItems.forEach(item => {
                const parentDiv = item.querySelector('[data-toggle="submenu"]');
                const submenu = item.querySelector('.submenu');
                const arrow = parentDiv.querySelector('svg:last-child');

                if (parentDiv && submenu) {
                    let isExpanded = submenu.classList.contains('expanded');

                    parentDiv.addEventListener('click', (e) => {
                        if (sidebar.clientWidth > 100 || sidebar.classList.contains('sidebar-fixed')) {
                            e.stopPropagation();
                            isExpanded = !isExpanded;
                            submenu.classList.toggle('expanded', isExpanded);

                            if (arrow) {
                                arrow.classList.toggle('rotate-180', isExpanded);
                            }
                        }
                    });
                }
            });

            sidebar.addEventListener('transitionend', () => {
                const isSidebarExpanded = sidebar.clientWidth > 100 || sidebar.classList.contains('sidebar-fixed');

                navItems.forEach(item => {
                    const submenu = item.querySelector('.submenu');
                    const arrow = item.querySelector('.submenu').previousElementSibling.querySelector('svg:last-child');

                    if (!isSidebarExpanded) {
                        submenu.classList.remove('expanded');
                        if (arrow) {
                            arrow.classList.remove('rotate-180');
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>
