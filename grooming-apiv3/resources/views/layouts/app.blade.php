<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tu Veterinaria')</title>
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
                    <div class="flex-shrink-0 flex items-center">
                        <h1 class="text-white text-xl font-bold font-montserrat">TU VETERINARIA</h1>
                    </div>
                    
                    <div class="hidden md:ml-10 md:flex md:space-x-8">
                        @if(Auth::user()->role === 'receptionist')
                            <a href="{{ route('receptionist.dashboard') }}" 
                               class="text-white hover:text-gray-300 px-3 py-2 text-sm font-medium {{ request()->routeIs('receptionist.dashboard') ? 'border-b-2 border-white' : '' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('pets.index') }}" 
                               class="text-white hover:text-gray-300 px-3 py-2 text-sm font-medium {{ request()->routeIs('pets.*') ? 'border-b-2 border-white' : '' }}">
                                Clientes
                            </a>
                            <a href="{{ route('pets.index') }}" class="text-white hover:text-gray-300 block px-3 py-2 text-base font-medium">
                                Mascotas
                            </a>
                        @elseif(Auth::user()->role === 'groomer')
                            <a href="#" class="text-white hover:text-gray-300 px-3 py-2 text-sm font-medium">
                                Mis Órdenes
                            </a>
                            <a href="#" class="text-white hover:text-gray-300 px-3 py-2 text-sm font-medium">
                                Servicios
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
                    <div class="relative">
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
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i>Perfil
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-cog mr-2"></i>Configuración
                            </a>
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
        </div>

        <div class="md:hidden" id="mobileMenu" style="display: none;">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                @if(Auth::user()->role === 'receptionist')
                    <a href="{{ route('receptionist.dashboard') }}" class="text-white hover:text-gray-300 block px-3 py-2 text-base font-medium">Dashboard</a>
                    <a href="#" class="text-white hover:text-gray-300 block px-3 py-2 text-base font-medium">Clientes</a>
                    <a href="{{ route('pets.index') }}" class="text-white hover:text-gray-300 block px-3 py-2 text-base font-medium">Mascotas</a>
                @elseif(Auth::user()->role === 'groomer')
                    <a href="#" class="text-white hover:text-gray-300 block px-3 py-2 text-base font-medium">Mis Órdenes</a>
                    <a href="#" class="text-white hover:text-gray-300 block px-3 py-2 text-base font-medium">Servicios</a>
                @elseif(Auth::user()->role === 'admin')
                    <a href="#" class="text-white hover:text-gray-300 block px-3 py-2 text-base font-medium">Dashboard</a>
                    <a href="#" class="text-white hover:text-gray-300 block px-3 py-2 text-base font-medium">Usuarios</a>
                    <a href="#" class="text-white hover:text-gray-300 block px-3 py-2 text-base font-medium">Reportes</a>
                @endif
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
        // Toggle user dropdown
        document.getElementById('userDropdown').addEventListener('click', function() {
            const menu = document.getElementById('userDropdownMenu');
            menu.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const menu = document.getElementById('userDropdownMenu');
            
            if (!dropdown.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>