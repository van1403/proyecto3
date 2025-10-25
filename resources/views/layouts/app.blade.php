<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Inventarios')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="flex flex-col min-h-screen bg-gray-100">
    @auth
        <nav class="bg-blue-600 text-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center space-x-4">
                        <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('client.dashboard') }}" 
                           class="text-xl font-bold">
                            Sistema de Inventarios
                        </a>
                        
                        @if(Auth::user()->isAdmin())
                        <div class="hidden md:flex space-x-4">
                            <a href="{{ route('admin.dashboard') }}" class="hover:bg-blue-700 px-3 py-2 rounded">Dashboard</a>
                            <a href="{{ route('admin.products') }}" class="hover:bg-blue-700 px-3 py-2 rounded">Productos</a>
                            <a href="{{ route('admin.sales') }}" class="hover:bg-blue-700 px-3 py-2 rounded">Ventas</a>
                            <a href="{{ route('admin.suppliers') }}" class="hover:bg-blue-700 px-3 py-2 rounded">Proveedores</a>
                            <a href="{{ route('admin.categories') }}" class="hover:bg-blue-700 px-3 py-2 rounded">Categorías</a>
                        </div>
                        @else
                        <div class="hidden md:flex space-x-4">
                            <a href="{{ route('client.dashboard') }}" class="hover:bg-blue-700 px-3 py-2 rounded">Tienda</a>
                            <a href="{{ route('client.purchase-history') }}" class="hover:bg-blue-700 px-3 py-2 rounded">Mis Compras</a>
                        </div>
                        @endif
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <span class="text-sm">
                            Hola, {{ Auth::user()->name }}
                        </span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-blue-700 hover:bg-blue-800 px-3 py-2 rounded text-sm">
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    @endauth

    <main class="flex-grow">
        @yield('content')
    </main>
   
    @if(session('success'))
    <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        {{ session('error') }}
    </div>
    @endif

    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>Sistema de Inventarios © 2023 - Desarrollado con Laravel y Laragon</p>
        </div>
    </footer>

    <script>
        // Auto-hide flash messages
        setTimeout(() => {
            const flashMessages = document.querySelectorAll('.fixed');
            flashMessages.forEach(msg => {
                msg.style.display = 'none';
            });
        }, 5000);
    </script>
</body>
</html>