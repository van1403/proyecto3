<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Terrastep')</title>

    {{-- Tailwind + FontAwesome --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    {{-- Fuente moderna --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; scroll-behavior: smooth; }
    </style>

    {{-- Animaciones AOS --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body class="flex flex-col min-h-screen bg-gradient-to-br from-indigo-50 via-white to-blue-50 text-gray-800">

    {{-- 🌟 NAVBAR --}}
    @auth
    <nav class="bg-gradient-to-r from-indigo-600 via-blue-600 to-cyan-500 text-white shadow-md sticky top-0 z-50 backdrop-blur-lg bg-opacity-95">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                {{-- Logo --}}
                <div class="flex items-center space-x-3">
                    <i class="fas fa-cubes text-2xl text-yellow-300"></i>
                    <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('client.dashboard') }}" 
                       class="text-xl font-bold tracking-wide hover:text-yellow-200 transition">
                       Terrastep
                    </a>
                </div>

                {{-- Menú --}}
                @if(Auth::user()->isAdmin())
                    <div class="hidden md:flex space-x-6 text-sm font-medium">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-yellow-300 transition">Dashboard</a>
                        <a href="{{ route('admin.products') }}" class="hover:text-yellow-300 transition">Productos</a>
                        <a href="{{ route('admin.sales') }}" class="hover:text-yellow-300 transition">Ventas</a>
                        <a href="{{ route('admin.suppliers') }}" class="hover:text-yellow-300 transition">Proveedores</a>
                        <a href="{{ route('admin.categories') }}" class="hover:text-yellow-300 transition">Categorías</a>
                    </div>
                @else
                    <div class="hidden md:flex space-x-6 text-sm font-medium">
                        <a href="{{ route('client.dashboard') }}" class="hover:text-yellow-300 transition">Tienda</a>
                        <a href="{{ route('client.purchase-history') }}" class="hover:text-yellow-300 transition">Mis Compras</a>
                    </div>
                @endif

                {{-- Usuario --}}
                <div class="flex items-center space-x-4">
                    <span class="text-sm font-semibold">👋 {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-black px-3 py-2 rounded-lg text-sm font-semibold shadow-md transition">
                            <i class="fas fa-sign-out-alt mr-1"></i> Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    @endauth

    {{-- 🌈 CONTENIDO PRINCIPAL --}}
    <main class="flex-grow px-4 py-10 sm:px-6 lg:px-8" data-aos="fade-up" data-aos-duration="700">
        @yield('content')
    </main>

    {{-- ✅ MENSAJES FLASH --}}
    @if(session('success'))
    <div class="fixed top-6 right-6 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center animate-bounce">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="fixed top-6 right-6 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center animate-bounce">
        <i class="fas fa-exclamation-triangle mr-2"></i>{{ session('error') }}
    </div>
    @endif

    {{-- ⚡ FOOTER --}}
    <footer class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 text-gray-300 py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-lg font-semibold text-white">Somos <span class="text-yellow-300">Terrastep</span></p>
            <p class="text-sm mt-2 text-gray-400">
                © {{ date('Y') }} — Desarrollado con ❤️ por <span class="text-yellow-300 font-medium">Terrastep Team</span>
            </p>
        </div>
    </footer>

    {{-- Scripts --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
        setTimeout(() => document.querySelectorAll('.fixed').forEach(msg => msg.remove()), 5000);
    </script>
</body>
</html>
