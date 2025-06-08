<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tu Veterinaria')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('android-chrome-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('android-chrome-512x512.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'montserrat': ['Montserrat', 'sans-serif'],
                    },
                    colors: {
                        'vet-blue': '#2A588A',
                    }
                }
            }
        }
    </script>
    @stack('styles')
</head>
<body class="bg-gray-50 font-montserrat">

    <nav class="bg-vet-blue shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="hidden flex-shrink-0 md:flex items-center">
                        <img src="/logo.png" alt="TuVeterinaria">
                    </div>
                    <div class="md:hidden flex-shrink-0 flex items-center">
                        <img src="/logo-mobile.png" alt="TuVeterinaria">
                    </div>
                    
                    <div class="hidden md:ml-10 md:flex md:space-x-8">
                        @if(Auth::user()->role === 'receptionist')
                            <a href="{{ route('receptionist.dashboard') }}" 
                               class="text-white hover:text-gray-300 px-3 py-2 text-sm font-medium {{ request()->routeIs('receptionist.dashboard') ? 'border-b-2 border-white' : '' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('customers.index') }}" 
                               class="text-white hover:text-gray-300 px-3 py-2 text-sm font-medium {{ request()->routeIs('customers.*') ? 'border-b-2 border-white' : '' }}">
                                Clientes
                            </a>
                             <a href="{{ route('pets.index') }}" 
                               class="text-white hover:text-gray-300 px-3 py-2 text-sm font-medium {{ request()->routeIs('pets.*') ? 'border-b-2 border-white' : '' }}">
                                Mascotas
                            </a>
                        @elseif(Auth::user()->role === 'groomer')
                            <a href="{{ route('groomer.dashboard') }}" 
                               class="text-white hover:text-gray-300 px-3 py-2 text-sm font-medium {{ request()->routeIs('groomer.*') ? 'border-b-2 border-white' : '' }}">
                                Cola de Espera
                            </a>
                        @elseif(Auth::user()->role === 'admin')
                            <a href="#" class="text-white hover:text-gray-300 px-3 py-2 text-sm font-medium">
                                Dashboard
                            </a>
                            <a href="#" class="text-white hover:text-gray-300 px-3 py-2 text-sm font-medium">
                                Usuarios
                            </a>
                            <a href="#" class="text-white hover:text-gray-300 px-3 py-2 text-sm font-medium">
                                Reportes
                            </a>
                        @endif
                    </div>
                </div>

                <div class="flex items-center">
                    <div class="md:hidden">
                        <button id="mobileMenuButton" class="text-white hover:text-gray-300 focus:outline-none focus:text-white">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                    </div>

                    <div class="hidden md:block relative">
                        <button id="userDropdown" class="bg-vet-blue text-white flex items-center space-x-2 px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-white">
                            <i class="fas fa-user-circle text-lg"></i>
                            <span>{{ Auth::user()->full_name }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div id="userDropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                            <div class="px-4 py-2 text-sm text-gray-700 border-b">
                                <div class="font-medium">{{ Auth::user()->full_name }}</div>
                                <div class="text-gray-500 capitalize">{{ Auth::user()->role }}</div>
                            </div>
                            <!--<a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i>Perfil
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-cog mr-2"></i>Configuración
                            </a>-->
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Cerrar Sesión
                                </button>
                            </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:hidden" id="mobileMenu" style="display: none;">
            <div class="px-2 pt-2 pb-3 space-y-1 bg-vet-blue border-t border-blue-700">
                <div class="px-3 py-3 border-b border-blue-700 mb-2">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-user-circle text-white text-2xl"></i>
                        <div>
                            <div class="text-white font-medium">{{ Auth::user()->full_name }}</div>
                            <div class="text-blue-200 text-sm capitalize">{{ Auth::user()->role }}</div>
                        </div>
                    </div>
                </div>
                @if(Auth::user()->role === 'receptionist')
                    <a href="{{ route('receptionist.dashboard') }}" 
                       class="text-white hover:bg-blue-700 hover:text-gray-100 flex items-center px-3 py-3 text-base font-medium rounded-md {{ request()->routeIs('receptionist.dashboard') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('customers.index') }}" 
                       class="text-white hover:bg-blue-700 hover:text-gray-100 flex items-center px-3 py-3 text-base font-medium rounded-md {{ request()->routeIs('customers.*') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-users mr-3"></i>
                        Clientes
                    </a>
                    <a href="{{ route('pets.index') }}" 
                       class="text-white hover:bg-blue-700 hover:text-gray-100 flex items-center px-3 py-3 text-base font-medium rounded-md {{ request()->routeIs('pets.*') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-paw mr-3"></i>
                        Mascotas
                    </a>
                @elseif(Auth::user()->role === 'groomer')
                    <a href="{{ route('groomer.dashboard') }}" class="text-white hover:bg-blue-700 hover:text-gray-100 flex items-center px-3 py-3 text-base font-medium rounded-md {{ request()->routeIs('pets.*') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-paw mr-3"></i>
                        Cola de Espera
                    </a>
                @elseif(Auth::user()->role === 'admin')
                    <a href="#" class="text-white hover:bg-blue-700 hover:text-gray-100 flex items-center px-3 py-3 text-base font-medium rounded-md">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        Dashboard
                    </a>
                    <a href="#" class="text-white hover:bg-blue-700 hover:text-gray-100 flex items-center px-3 py-3 text-base font-medium rounded-md">
                        <i class="fas fa-users-cog mr-3"></i>
                        Usuarios
                    </a>
                    <a href="#" class="text-white hover:bg-blue-700 hover:text-gray-100 flex items-center px-3 py-3 text-base font-medium rounded-md">
                        <i class="fas fa-chart-bar mr-3"></i>
                        Reportes
                    </a>
                @endif

                <div class="border-t border-blue-700 pt-2 mt-2">
                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left text-white hover:bg-blue-700 hover:text-gray-100 flex items-center px-3 py-3 text-base font-medium rounded-md">
                            <i class="fas fa-sign-out-alt mr-3"></i>
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    @stack('scripts')
    
    <script>
        document.getElementById('mobileMenuButton').addEventListener('click', function() {
            const menu = document.getElementById('mobileMenu');
            const isHidden = menu.style.display === 'none';
            menu.style.display = isHidden ? 'block' : 'none';
        });

        const userDropdown = document.getElementById('userDropdown');
        if (userDropdown) {
            userDropdown.addEventListener('click', function() {
                const menu = document.getElementById('userDropdownMenu');
                if (menu) {
                    menu.classList.toggle('hidden');
                }
            });

            document.addEventListener('click', function(event) {
                const menu = document.getElementById('userDropdownMenu');
                if (menu && !userDropdown.contains(event.target)) {
                    menu.classList.add('hidden');
                }
            });
        }
    </script>
</body>
</html>