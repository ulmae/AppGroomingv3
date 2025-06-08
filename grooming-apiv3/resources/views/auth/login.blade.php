<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tu Veterinaria</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('android-chrome-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('android-chrome-512x512.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'montserrat': ['Montserrat', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body>
    <div class="flex min-h-screen h-screen w-full">
        <div class="relative w-1/2 h-full hidden md:block">
            <img
                src="/perro.jpeg"
                alt="Perro con toalla"
                class="object-cover w-full h-full"
                style="object-position: center; z-index: 0;"
            />
            <div class="absolute inset-0 bg-blue-900 bg-opacity-20"></div>
        </div>
        
        <div class="flex w-full md:w-1/2 items-center justify-center bg-white">
            <div class="bg-blue-100 bg-opacity-90 p-8 rounded-lg shadow-lg max-w-md w-full">
                <div class="flex justify-center mb-6">
                    <img src="/logo.png" alt="Logo Veterinaria" class="h-16 w-auto">
                </div>
                <h2 class="text-center mb-6 font-bold font-montserrat" style="color: #2A588A; font-size: 32px;">
                    BIENVENIDO
                </h2>
                
                <form method="POST" action="{{ route('login') }}" class="flex flex-col space-y-4">
                    @csrf
                    
                    @if ($errors->has('email'))
                        <div class="text-red-500 text-sm mb-2 text-center">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                    
                    <div>
                        <label class="block text-sm font-medium">Usuario</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            placeholder="Ingresa tu usuario"
                            required 
                            class="w-full p-2 rounded bg-white border"
                        />
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium">Contraseña</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Ingresa tu contraseña"
                            required 
                            class="w-full p-2 rounded bg-white border"
                        />
                        <a href="#" class="text-xs text-blue-700 float-right mt-1 hover:underline">
                            ¿Has olvidado tu contraseña?
                        </a>
                    </div>
                    
                    <button 
                        type="submit"
                        class="bg-sky-500 text-white py-2 rounded hover:bg-sky-600"
                    >
                        Iniciar sesión
                    </button>
                    
                    <button 
                        type="button"
                        class="bg-sky-300 text-white py-2 rounded hover:bg-sky-400"
                    >
                        Registrarse
                    </button>
                </form>
                
                <div class="mt-4 text-xs text-gray-500 text-center">
                    <details>
                        <summary class="cursor-pointer">Usuarios de prueba</summary>
                        <div class="mt-2">
                            <p>laura.vasquez@grooming.com / password123</p>
                            <p>pedro.morales@grooming.com / password123</p>
                            <p>carlos.ramirez@grooming.com / password123</p>
                        </div>
                    </details>
                </div>
            </div>
        </div>
    </div>
</body>
</html>