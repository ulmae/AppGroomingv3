<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Veterinaria - Grooming y Baños para Mascotas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'raleway': ['Raleway', 'sans-serif'],
                        'poppins': ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="font-raleway">
    <nav class="bg-[#D1FAFF] py-3 px-6 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center space-x-2">
            <img src="/logo.png" alt="Logo" class="h-8">
        </div>
        <div class="space-x-4 text-sm text-[#4BB5E7] hidden md:flex">
            <a href="#" class="px-3 py-1 rounded font-medium transition-colors hover:bg-[#4EB5E6] hover:text-white">
                Inicio
            </a>
            <a href="#testimonios" class="px-3 py-1 rounded font-medium transition-colors hover:bg-[#4EB5E6] hover:text-white">
                Testimonios
            </a>
            <a href="#servicios" class="px-3 py-1 rounded font-medium transition-colors hover:bg-[#4EB5E6] hover:text-white">
                Servicios
            </a>
            <a href="#quienes-somos" class="px-3 py-1 rounded font-medium transition-colors hover:bg-[#4EB5E6] hover:text-white">
                ¿Quiénes somos?
            </a>
            <a href="#contacto" class="px-3 py-1 rounded font-medium transition-colors hover:bg-[#4EB5E6] hover:text-white">
                Contáctanos
            </a>
        </div>
        <button id="mobileMenuToggle" class="md:hidden text-sky-900 focus:outline-none">☰</button>
    </nav>

    <section class="relative h-[500px] flex items-center justify-start px-6 text-white bg-cover bg-center" style="background-image: url('./perro-bg.jpg')">
        <div class="absolute inset-0" style="background: linear-gradient(90deg, #4BB5E7cc 40%, transparent 100%); z-index: 1;"></div>
        
        <div class="relative z-10 max-w-lg font-raleway">
            <h1 class="text-3xl md:text-5xl font-bold leading-tight mb-4 font-raleway">
                Más que estilo, es bienestar: tu mascota merece lo mejor.
            </h1>
            <p class="mb-6 text-md md:text-lg font-light font-raleway">
                Somos los expertos en grooming y baños para consentir, cuidar y embellecer a tu mascota.
            </p>
            <a href="{{ route('login') }}" class="bg-[#00ffa3] text-black font-semibold py-2 px-5 rounded shadow border border-black hover:bg-[#00e693] hover:brightness-105 transition-colors font-raleway inline-block">
                ¡Agenda tu baño hoy!
            </a>
        </div>
    </section>

    <section id="testimonios" class="bg-white py-12 px-4 text-center">
        <h2 class="text-3xl font-bold text-sky-900 mb-8">Testimonios de nuestros clientes</h2>
        <div class="grid md:grid-cols-3 gap-6 max-w-6xl mx-auto">
            <div class="bg-sky-50 p-6 rounded-lg shadow flex flex-row items-center text-left">
                <div class="flex flex-col items-center mr-6">
                    <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Nancy Zavalaga" class="w-20 h-20 object-cover mb-3 rounded-lg shadow">
                    <div class="text-sky-900 text-xl mb-2">
                        ★★★★★
                    </div>
                </div>
                <div>
                    <p class="text-sky-900 mb-4">"¡A mi perrita la dejaron hermosa! Muy amables y profesionales."</p>
                    <p class="mt-2 font-semibold text-sky-900">Nancy Zavalaga</p>
                </div>
            </div>
            
            <div class="bg-sky-50 p-6 rounded-lg shadow flex flex-row items-center text-left">
                <div class="flex flex-col items-center mr-6">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Gerhard Romero" class="w-20 h-20 object-cover mb-3 rounded-lg shadow">
                    <div class="text-sky-900 text-xl mb-2">
                        ★★★★★
                    </div>
                </div>
                <div>
                    <p class="text-sky-900 mb-4">"Muy buena atención y resultados, recomendado."</p>
                    <p class="mt-2 font-semibold text-sky-900">Gerhard Romero</p>
                </div>
            </div>
            
            <div class="bg-sky-50 p-6 rounded-lg shadow flex flex-row items-center text-left">
                <div class="flex flex-col items-center mr-6">
                    <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="María Pérez" class="w-20 h-20 object-cover mb-3 rounded-lg shadow">
                    <div class="text-sky-900 text-xl mb-2">
                        ★★★★★
                    </div>
                </div>
                <div>
                    <p class="text-sky-900 mb-4">"El lugar está súper limpio y mi gato salió feliz."</p>
                    <p class="mt-2 font-semibold text-sky-900">María Pérez</p>
                </div>
            </div>
        </div>
    </section>

    <section id="servicios" class="bg-[#d4f4fa] py-12 px-4">
        <div class="max-w-5xl mx-auto flex flex-col md:flex-row items-center md:items-stretch gap-10">
            <div class="flex-1 relative h-72 md:h-auto md:min-h-[350px] mb-8 md:mb-0 overflow-hidden rounded-none">
                <img src="https://images.unsplash.com/photo-1518717758536-85ae29035b6d?auto=format&fit=crop&w=800&q=80" alt="Perro en grooming" class="absolute inset-0 w-full h-full object-cover rounded-none shadow-none">
            </div>
            <div class="flex-1 flex flex-col justify-center items-center md:items-start text-center md:text-left">
                <h2 class="font-bold mb-4" style="color: #46ABDF; font-size: 33.98px; text-align: center;">
                    ¡Tú manejas tu tiempo!
                </h2>
                <p class="mb-6" style="color: #023E8A; font-family: 'Poppins', sans-serif; font-size: 18.77px; line-height: 1.5; max-width: 400px;">
                    Cuando eliges tu corte o baño, podrás ver la hora en la que tu mascota estará lista para regresar a casa.
                    <br><br>
                    ¡Siempre exactos!
                </p>
                <a href="{{ route('login') }}" class="bg-white text-black font-semibold py-3 px-8 rounded border border-black shadow hover:bg-gray-100 self-center md:self-start">
                    ¡Agenda tu cita hoy!
                </a>
            </div>
        </div>
    </section>

    <section id="quienes-somos" class="py-12 px-4 flex flex-col md:flex-row items-center" style="background-color: #4EB5E6;">
        <div class="flex-1 flex flex-col justify-center items-center md:items-start text-center md:text-left">
            <h2 class="font-bold mb-4" style="color: #D1FAFF; font-size: 33.98px; font-family: 'Raleway', sans-serif; text-align: center;">
                Profesionales certificados
            </h2>
            <p class="mb-6" style="color: #023E8A; font-size: 18.77px; font-family: 'Poppins', sans-serif; line-height: 1.5; max-width: 500px;">
                Tus mascotas están bajo el cuidado de nuestro personal, 100% certificados por la JNMV de El Salvador.
                <br><br>
                ¡Los cuidamos porque son familia!
            </p>
            <a href="{{ route('login') }}" class="bg-white text-[#023E8A] font-semibold py-2 px-6 rounded-sm shadow hover:bg-gray-100 border border-[#023E8A]">
                ¿Corte, baño o ambos?
            </a>
        </div>
        <div class="flex-1 h-64 md:h-80 w-full mt-8 md:mt-0 md:ml-8 rounded-none overflow-hidden">
            <img alt="Perro feliz" src="https://images.unsplash.com/photo-1558788353-f76d92427f16?auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover rounded-none shadow-none">
        </div>
    </section>

    <section class="bg-white py-12 px-4 text-center">
        <blockquote class="text-sky-900 text-lg italic max-w-2xl mx-auto">
            "El perro es el único ser que te amará, mucho más que a sí mismo."
            <footer class="mt-2 text-sm not-italic">— Sócrates</footer>
        </blockquote>
    </section>

    <footer id="contacto" class="bg-[#00204A] text-white py-12 px-6">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-10 text-sm">
            <div class="space-y-4">
                <img src="/logo.png" alt="Logo" class="h-10">
            </div>
            <div>
                <h3 class="font-semibold mb-2 underline">Útil</h3>
                <ul class="space-y-1 text-[#D1FAFF]">
                    <li><a href="#" class="hover:underline">Inicio</a></li>
                    <li><a href="{{ route('login') }}" class="hover:underline">Agenda tu cita</a></li>
                    <li><a href="#" class="hover:underline">Historia</a></li>
                    <li><a href="#testimonios" class="hover:underline">Testimonios</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-semibold mb-2 underline">Help</h3>
                <ul class="space-y-1 text-[#D1FAFF]">
                    <li><a href="#" class="hover:underline">Contáctanos</a></li>
                    <li><a href="#" class="hover:underline">Preguntas frecuentes</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-semibold mb-2 underline">Privacy</h3>
                <ul class="space-y-1 text-[#D1FAFF]">
                    <li><a href="#" class="hover:underline">Privacidad</a></li>
                    <li><a href="#" class="hover:underline">Información de dominio</a></li>
                    <li><a href="#" class="hover:underline">Información de salud</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('mobileMenuToggle').addEventListener('click', function() {
            alert('Menú móvil - Implementar según necesidades');
        });
    </script>
</body>
</html>