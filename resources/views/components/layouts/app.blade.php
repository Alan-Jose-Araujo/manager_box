<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
    body {
            background-color: #f8f7f5;
            font-family: 'Inter', sans-serif;
        }

        .sidebar {
            width: 4rem;
            transition: width 0.3s ease-in-out;
            background-color: #f8f7f5;
        }
        .sidebar:hover {
            width: 14rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .sidebar-text, .submenu-item {
            display: none;
            opacity: 0;
            transition: opacity 0.15s ease-in-out;
        }
        .sidebar:hover .sidebar-text, .sidebar:hover .submenu-item {
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
        .profile-menu:hover .profile-dropdown {
            display: block;
        }

        .sidebar-icon {
            color: rgba(0, 0, 0, 0.5);
            transition: color 0.2s;
        }
        .sidebar:hover .nav-item:hover .sidebar-icon {
            color: rgba(0, 0, 0, 0.7);
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden">

<aside id="sidebar" class="sidebar ...">
    <div class="flex items-center justify-start h-16 border-b border-gray-200 mb-4 px-2">
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
    @endphp
    @foreach($menu as $title => $item)
        <div class="nav-item">
            <div data-toggle="submenu" class="flex items-center justify-start gap-3 p-2 rounded-xl text-gray-700 hover:bg-stone-200 hover:text-gray-900 cursor-pointer transition-colors duration-200" @if($title === 'Relatórios') aria-expanded="true" @endif>
                {!! $item['icon'] !!} <span class="sidebar-text font-medium whitespace-nowrap flex-grow">{{ $title }}</span>
                <svg class="sidebar-text w-4 h-4 ml-auto text-gray-500 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </div>
            <div class="submenu @if($title === 'Relatórios') expanded @endif ml-2" id="submenu-{{ Str::slug($title) }}">
                <ul class="pt-1 space-y-1 text-base text-gray-700">
                    @foreach($item['sub'] as $subItem)
                        <li class="submenu-item flex items-center justify-between p-1 pl-4 rounded-lg hover:bg-stone-200">
                            <span class="flex items-center">
                                <span class="w-2 h-2 bg-gray-600 rounded-full mr-3"></span>
                                <span class="font-medium">{{ $subItem }}</span>
                            </span>
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach
</nav>
    </aside>

    <div class="flex flex-col flex-1 overflow-x-hidden overflow-y-auto">

        <header class="h-16 flex items-center justify-between bg-white border-b border-gray-100/50 shadow-sm px-6 sticky top-0 z-10">

            <div class="flex items-center space-x-4">
                <div class="p-2 text-gray-500 hover:text-gray-700 cursor-pointer rounded-lg hover:bg-stone-200">
                    <svg class="w-6 h-6" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.66675 11.6667H33.3334M6.66675 28.3334H33.3334M6.66675 20.0001H33.3334" stroke="currentColor" stroke-opacity="0.5" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>

            <div class="flex items-center space-x-4">

                <div class="p-2 text-gray-500 hover:text-gray-700 cursor-pointer rounded-lg hover:bg-stone-200">
                    <svg class="w-5 h-5 nav-icon" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.33333 13.5416H10.9375M8.33333 9.37492H15.1042M8.33333 17.7083H9.89583M3.125 14.5833V10.4166C3.125 6.48846 3.125 4.52388 4.34583 3.30409C5.56667 2.08429 7.53021 2.08325 11.4583 2.08325H13.5417C17.4698 2.08325 19.4344 2.08325 20.6542 3.30409M21.875 14.5833C21.875 18.5114 21.875 20.476 20.6542 21.6958M20.6542 21.6958C19.4344 22.9166 17.4698 22.9166 13.5417 22.9166H11.4583C7.53021 22.9166 5.56562 22.9166 4.34583 21.6958M20.6542 21.6958C21.6375 20.7135 21.8281 19.2499 21.8656 16.6666" stroke="currentColor" stroke-opacity="0.5" stroke-width="2" stroke-linecap="round"/>
                        <path d="M18.9374 8.37495L14.4999 12.8125C13.2374 14.8541L12.6676 16.5635L13.6447 17.5406M21.8343 11.2708L17.3968 15.7083C15.3541 16.9708 13.6666 17.5406 13.6447 17.5406" stroke="currentColor" stroke-opacity="0.5" stroke-width="2"/>
                        <path d="M18.7083 7.25C21.8333 4.125C15.5833 7.25 20.4341 7.25 18.7083 7.25Z" stroke="currentColor" stroke-opacity="0.5" stroke-width="2"/>
                    </svg>
                </div>

                <div class="p-2 text-gray-500 hover:text-gray-700 cursor-pointer rounded-lg hover:bg-stone-200">
                    <svg class="w-5 h-5 nav-icon" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.7083 7.25C20.4341 7.25 21.8333 5.85089 21.8333 4.125C21.8333 2.39911 20.4341 1 18.7083 1C16.9824 1 15.5833 2.39911 15.5833 4.125C15.5833 5.85089 16.9824 7.25 18.7083 7.25Z" stroke="currentColor" stroke-opacity="0.5" stroke-width="2"/>
                        <path d="M6.20833 13.5H15.5833M6.20833 17.1458H12.4583M1 11.4167C1 16.3271 1 18.7823 2.525 20.3073C4.05208 21.8333 6.50625 21.8333 11.4167 21.8333C16.3271 21.8333 18.7823 21.8333 20.3073 20.3073C21.8333 18.7833 21.8333 16.3271 21.8333 11.4167V9.85417M12.9792 1H11.4167C6.50625 1 4.05104 1 2.525 2.525C1.51146 3.53958 1.17083 4.96563 1.05729 7.25" stroke="currentColor" stroke-opacity="0.5" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>

                <div class="relative profile-menu group">
                    <div class="flex items-center cursor-pointer rounded-full p-1 transition-colors duration-200 hover:bg-stone-200">
                        <img src="https://placehold.co/32x32/FFD1DC/660022?text=AC" alt="Ana C." class="w-8 h-8 rounded-full object-cover border-2 border-yellow-300">
                        <div class="absolute right-0 bottom-0 w-2 h-2 bg-yellow-400 rounded-full border border-white"></div>
                    </div>

                    <div class="profile-dropdown absolute right-0 mt-3 w-72 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 transform origin-top-right transition-all duration-300">
                        <div class="p-4 flex items-center border-b border-gray-100">
                            <img src="https://placehold.co/40x40/FFD1DC/660022?text=AC" alt="Ana C." class="w-10 h-10 rounded-full object-cover mr-3 shrink-0">
                            <div>
                                <div class="font-semibold text-gray-800 flex items-center whitespace-nowrap">
                                    Ana Carolina
                                    <span class="ml-2 px-2 py-0.5 text-xs font-medium bg-green-100 text-green-700 rounded-full">Admin</span>
                                </div>
                                <p class="text-sm text-gray-500 truncate">ana.carolina@example.com</p>
                            </div>
                        </div>

                        <div class="p-2 space-y-1 text-gray-700">
                            <a href="#" class="block px-3 py-2 rounded-lg hover:bg-stone-100">Meu perfil</a>
                            <a href="#" class="block px-3 py-2 rounded-lg hover:bg-stone-100">Painel da empresa</a>
                            <a href="#" class="flex justify-between items-center px-3 py-2 rounded-lg hover:bg-stone-100">
                                Assinaturas
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </div>

                        <div class="border-t border-b border-gray-100 p-2 space-y-1 text-gray-700">
                            <div class="px-3 py-2 text-sm font-semibold text-gray-500">Ajustes de interface</div>
                            <div class="flex justify-between items-center px-3 py-2 rounded-lg hover:bg-stone-100 cursor-pointer">
                                <span>Modo</span>
                                <span class="flex items-center text-sm font-medium">Claro <svg class="w-5 h-5 ml-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg></span>
                            </div>
                            <div class="flex justify-between items-center px-3 py-2 rounded-lg hover:bg-stone-100 cursor-pointer">
                                <span>Idioma</span>
                                <span class="flex items-center text-sm font-medium bg-stone-200 px-2 py-1 rounded-lg">Português <span class="ml-2 text-lg">🇧🇷</span></span>
                            </div>
                        </div>

                        <div class="p-2 space-y-1 text-gray-700">
                            <a href="#" class="block px-3 py-2 rounded-lg hover:bg-stone-100">Configurações de conta</a>
                            <a href="#" class="block px-3 py-2 rounded-lg hover:bg-red-50 text-red-600">Sair</a>
                        </div>
                    </div>
                </div>

                <div class="p-2 text-gray-500 hover:text-gray-700 cursor-pointer rounded-lg hover:bg-stone-200">
                     <svg class="w-5 h-5 nav-icon" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.16979 21.0395C10.2833 22.2905 11.3396 22.9166 12.5 22.9166C13.6604 22.9166 14.7167 22.2916 16.8302 21.0395L17.5448 20.6155C19.6583 19.3655 20.7146 18.7385 21.2948 17.7083C21.875 16.677 21.875 15.427 21.875 12.9228M21.6823 8.33325C21.6056 7.96871 21.475 7.61763 21.2948 7.29159C20.7146 6.26034 19.6583 5.63534 17.5448 4.38325L16.8302 3.96034C14.7167 2.70929 13.6604 2.08325 12.5 2.08325C11.3396 2.08325 10.2833 2.70825 8.16979 3.96034L7.45521 4.38325C5.34167 5.63534 4.28542 6.26138 3.70521 7.29159C3.125 8.32284 3.125 9.57284 3.125 12.077V12.9228C3.125 15.426 3.125 16.678 3.70521 17.7083C3.94062 18.127 4.25521 18.4791 4.6875 18.8333" stroke="currentColor" stroke-opacity="0.5" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M12.5 15.625C14.2259 15.625 15.625 14.2259 15.625 12.5C15.625 10.7741 14.2259 9.375 12.5 9.375C10.7741 9.375 9.375 10.7741 9.375 12.5C9.375 14.2259 10.7741 15.625 12.5 15.625Z" stroke="currentColor" stroke-opacity="0.5" stroke-width="1.5"/>
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

            const toggleArrow = (svg, isExpanded) => {
                const path = isExpanded ? 'M19 9l-7 7-7-7' : 'M9 5l7 7-7 7';
                svg.querySelector('path').setAttribute('d', path);
            };

            navItems.forEach(item => {
                const parentDiv = item.querySelector('[data-toggle="submenu"]');
                const submenu = item.querySelector('.submenu');
                const arrow = parentDiv.querySelector('svg:last-child');

                if (parentDiv && submenu) {

                    let isExpanded = submenu.classList.contains('expanded');
                    if (isExpanded) {
                        toggleArrow(arrow, true);
                    }

                    parentDiv.addEventListener('click', (e) => {

                        if (sidebar.clientWidth > 100) {
                            e.stopPropagation();
                            isExpanded = !isExpanded;
                            submenu.classList.toggle('expanded', isExpanded);
                            toggleArrow(arrow, isExpanded);
                        }
                    });
                }
            });

            sidebar.addEventListener('transitionend', () => {
                const isSidebarExpanded = sidebar.clientWidth > 100;
                navItems.forEach(item => {
                    const parentDiv = item.querySelector('[data-toggle="submenu"]');
                    const arrow = parentDiv.querySelector('svg:last-child');
                    const submenu = item.querySelector('.submenu');

                    if (!isSidebarExpanded) {
                        submenu.classList.remove('expanded');
                        toggleArrow(arrow, false);
                    }
                });
            });
        });
    </script>
</body>
</html>
