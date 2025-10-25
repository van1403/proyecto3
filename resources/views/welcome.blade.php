```html
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Inventarios</title>
    <script src="https://cdn.tailwindcss.com  "></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css  " rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-100 via-indigo-100 to-purple-100 min-h-screen">
    <div class="max-w-4xl mx-auto bg-white/90 backdrop-blur-md rounded-2xl shadow-xl p-8 space-y-8 mt-8 mb-8">
        
        <!-- Título principal -->
        <div class="text-center">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-3">
                Bienvenido al Sistema de Inventarios
            </h1>
            <p class="text-base text-gray-600">
                Gestiona productos, ventas, clientes y proveedores de manera eficiente con nuestra plataforma integral.
            </p>
        </div>

        <!-- Sección de acceso -->
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Tarjeta de administrador -->
            <div class="bg-blue-50 hover:scale-105 transition transform p-6 rounded-xl border border-blue-200 shadow-sm">
                <div class="text-center">
                    <i class="fas fa-user-shield text-4xl text-blue-600 mb-3"></i>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Administrador</h3>
                    <p class="text-gray-600 mb-4">Gestiona todo el sistema, productos, proveedores y ventas.</p>
                    <a href="{{ route('login') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium text-base transition duration-200">
                        Iniciar Sesión
                    </a>
                </div>
            </div>

            <!-- Tarjeta de cliente -->
            <div class="bg-green-50 hover:scale-105 transition transform p-6 rounded-xl border border-green-200 shadow-sm">
                <div class="text-center">
                    <i class="fas fa-user text-4xl text-green-600 mb-3"></i>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Cliente</h3>
                    <p class="text-gray-600 mb-4">Explora productos y realiza compras de manera sencilla.</p>
                    <div class="space-y-2">
                        <a href="{{ route('login') }}" 
                           class="block w-full bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium text-base transition duration-200">
                            Iniciar Sesión
                        </a>
                        <a href="{{ route('register') }}" 
                           class="block w-full bg-gray-700 hover:bg-gray-800 text-white px-6 py-2 rounded-lg font-medium text-base transition duration-200">
                            Registrarse
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de características -->
        <div class="grid sm:grid-cols-2 gap-4 pt-4">
            <div class="bg-white hover:shadow-lg transition rounded-lg border border-gray-200 p-4 text-center">
                <i class="fas fa-box text-2xl text-blue-600 mb-2"></i>
                <h4 class="font-semibold text-gray-800 mb-1">Gestión de Productos</h4>
                <p class="text-xs text-gray-600">Administra tu inventario de productos, precios y existencias.</p>
            </div>

            <div class="bg-white hover:shadow-lg transition rounded-lg border border-gray-200 p-4 text-center">
                <i class="fas fa-shopping-cart text-2xl text-green-600 mb-2"></i>
                <h4 class="font-semibold text-gray-800 mb-1">Control de Ventas</h4>
                <p class="text-xs text-gray-600">Registra y gestiona todas tus ventas y transacciones.</p>
            </div>

            <div class="bg-white hover:shadow-lg transition rounded-lg border border-gray-200 p-4 text-center">
                <i class="fas fa-users text-2xl text-purple-600 mb-2"></i>
                <h4 class="font-semibold text-gray-800 mb-1">Administración de Clientes</h4>
                <p class="text-xs text-gray-600">Mantén un registro completo de todos tus clientes.</p>
            </div>

            <div class="bg-white hover:shadow-lg transition rounded-lg border border-gray-200 p-4 text-center">
                <i class="fas fa-truck text-2xl text-orange-600 mb-2"></i>
                <h4 class="font-semibold text-gray-800 mb-1">Gestión de Proveedores</h4>
                <p class="text-xs text-gray-600">Administra la información de tus proveedores y compras.</p>
            </div>
        </div>

        <!-- Footer -->
        <footer class="text-center text-gray-500 text-xs pt-6 border-t border-gray-200">
            © {{ date('Y') }} Sistema de Inventarios. Todos los derechos reservados.
        </footer>
    </div>
</body>
</html>
```