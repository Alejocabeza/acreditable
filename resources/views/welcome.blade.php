<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased font-sans">
    <div class="min-h-screen bg-gradient-to-b from-blue-50 to-white">
        {{-- Header/Navigation --}}
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        @svg('tabler-wallet', 'h-12 w-12')
                        <span class="ml-2 text-xl font-bold text-gray-900">FinanzApp</span>
                    </div>
                    <div class="hidden md:flex space-x-8">
                        <a href="#caracteristicas" class="text-gray-600 hover:text-blue-600">Características</a>
                        <a href="#beneficios" class="text-gray-600 hover:text-blue-600">Beneficios</a>
                        {{-- <a href="#precios" class="text-gray-600 hover:text-blue-600">Precios</a> --}}
                    </div>
                    <div class="flex space-x-4">
                        <a href="{{ route('login') }}" class="px-4 py-2 text-blue-600 hover:text-blue-700">Iniciar
                            Sesión</a>
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Registrarse
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        {{-- Hero Section --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-5xl font-bold text-gray-900 mb-6">
                        Controla tus finanzas de manera inteligente
                    </h1>
                    <p class="text-xl text-gray-600 mb-8">
                        Gestiona tus gastos, ahorra más y alcanza tus metas financieras con la aplicación más completa
                        del mercado.
                    </p>
                    <a href="{{ route('register') }}"
                        class="px-8 py-4 bg-blue-600 text-white rounded-lg text-lg hover:bg-blue-700 inline-flex items-center">
                        Comienza Gratis
                        <i data-lucide="chevron-right" class="ml-2"></i>
                    </a>
                </div>
                <div class="relative">
                    <img src="/images/image-home.avif" alt="Dashboard Financiero" class="rounded-lg shadow-2xl">
                </div>
            </div>
        </div>

        {{-- Features Section --}}
        <div id="caracteristicas" class="bg-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">
                    Todo lo que necesitas para tu salud financiera
                </h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="p-6 bg-blue-50 rounded-lg">
                        @svg('tabler-credit-card', 'h-16 w-16 text-blue-600 mb-4')
                        <h3 class="text-xl font-semibold mb-2">Control de Gastos</h3>
                        <p class="text-gray-600">
                            Registra y categoriza automáticamente todos tus gastos e ingresos.
                        </p>
                    </div>
                    <div class="p-6 bg-blue-50 rounded-lg">
                        @svg('tabler-cash-banknote', 'h-16 w-16 text-blue-600 mb-4')
                        <h3 class="text-xl font-semibold mb-2">Presupuestos</h3>
                        <p class="text-gray-600">
                            Crea presupuestos personalizados y recibe alertas inteligentes.
                        </p>
                    </div>
                    <div class="p-6 bg-blue-50 rounded-lg">
                        @svg('tabler-target', 'h-16 w-16 text-blue-600 mb-4')
                        <h3 class="text-xl font-semibold mb-2">Metas de Ahorro</h3>
                        <p class="text-gray-600">
                            Establece objetivos y visualiza tu progreso en tiempo real.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Benefits Section --}}
        <div id="beneficios" class="py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900">
                        ¿Por qué elegir FinanzApp?
                    </h2>
                </div>
                <div class="grid md:grid-cols-4 gap-8">
                    <div class="flex justify-center items-center gap-1 flex-col">
                        @svg('tabler-chart-pie-filled', 'h-16 w-16 text-blue-600 mb-4')
                        <h3 class="text-lg font-semibold mb-2">Análisis Detallado</h3>
                        <p class="text-gray-600">Reportes y gráficos intuitivos</p>
                    </div>
                    <div class="flex justify-center items-center gap-1 flex-col">
                        @svg('tabler-trending-up', 'h-16 w-16 text-blue-600 mb-4')
                        <h3 class="text-lg font-semibold mb-2">Inversiones</h3>
                        <p class="text-gray-600">Seguimiento de tu portafolio</p>
                    </div>
                    <div class="flex justify-center items-center gap-1 flex-col">
                        @svg('tabler-shield', 'h-16 w-16 text-blue-600 mb-4')
                        <h3 class="text-lg font-semibold mb-2">Seguridad</h3>
                        <p class="text-gray-600">Datos encriptados y protegidos</p>
                    </div>
                    <div class="flex justify-center items-center gap-1 flex-col">
                        @svg('tabler-phone-incoming', 'h-16 w-16 text-blue-600 mb-4')
                        <h3 class="text-lg font-semibold mb-2">Multiplataforma</h3>
                        <p class="text-gray-600">Accede desde cualquier dispositivo</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- CTA Section --}}
        <div class="bg-blue-600 py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-bold text-white mb-8">
                    Comienza a controlar tus finanzas hoy mismo
                </h2>
                <a href="{{ route('register') }}"
                    class="px-8 py-4 bg-white text-blue-600 rounded-lg text-lg hover:bg-gray-100 inline-block">
                    Crear cuenta gratuita
                </a>
            </div>
        </div>

        {{-- Footer --}}
        <footer class="bg-gray-900 text-white py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-1 gap-8">
                    <div>
                        <div class="flex items-center mb-4">
                            @svg('tabler-wallet', 'h-12 w-12')
                            <span class="ml-2 text-xl font-bold">FinanzApp</span>
                        </div>
                        <p class="text-gray-400">
                            Tu mejor aliado para la gestión financiera personal
                        </p>
                    </div>
                    {{-- <div>
                        <h3 class="text-lg font-semibold mb-4">Producto</h3>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#caracteristicas">Características</a></li> <li><a href="#precios">Precios</a></li>
                            <li><a href="#">Tutoriales</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Compañía</h3>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="">Sobre nosotros</a></li>
                            <li><a href="">Blog</a></li>
                            <li><a href="">Contacto</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Legal</h3>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="">Privacidad</a></li>
                            <li><a href="">Términos</a></li>
                            <li><a href="">Seguridad</a></li>
                        </ul>
                    </div> --}}
                </div>
                <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-400">
                    <p>&copy; {{ date('Y') }} FinanzApp. Todos los derechos reservados.</p>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>
