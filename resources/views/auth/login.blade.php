<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Sistema de Inventarios</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-blue-100 to-blue-300 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-lg bg-white rounded-2xl shadow-2xl p-10 transform transition-all">
        <div class="text-center">
            <h2 class="text-4xl font-extrabold text-gray-900 mb-2">Iniciar Sesión</h2>
            <p class="text-gray-600">Accede a tu cuenta</p>
        </div>

        <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="space-y-5">
                {{-- 📧 Correo --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                    <input id="email" name="email" type="email" required 
                           class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="tu@email.com" value="{{ old('email') }}">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 🔒 Contraseña --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input id="password" name="password" type="password" required 
                           class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Tu contraseña">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- 🔗 Enlace "Olvidaste tu contraseña" --}}
            <div class="text-right mt-2">
                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    ¿Olvidaste tu contraseña?
                </a>
            </div>

            {{-- 🚪 Botón de inicio de sesión --}}
            <div class="pt-4">
                <button type="submit" 
                        class="w-full py-3 bg-blue-600 text-white rounded-lg font-semibold text-lg hover:bg-blue-700 transition duration-200">
                    Iniciar Sesión
                </button>
            </div>

            {{-- 📝 Enlace para registrarse --}}
            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">
                    ¿No tienes cuenta? 
                    <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-800">
                        Regístrate aquí
                    </a>
                </p>
            </div>
        </form>
    </div>
</body>
</html>
