@extends('layouts.app')

@section('title', 'Dashboard - Administrador')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 py-10 px-6">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-10 text-center">
            Panel de Administración
        </h1>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="bg-white rounded-2xl shadow-lg p-6 flex items-center hover:shadow-2xl transition">
                <div class="p-4 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-box text-3xl"></i>
                </div>
                <div class="ml-5">
                    <h3 class="text-3xl font-bold text-gray-900">{{ $stats['products'] }}</h3>
                    <p class="text-gray-600">Productos</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 flex items-center hover:shadow-2xl transition">
                <div class="p-4 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-shopping-cart text-3xl"></i>
                </div>
                <div class="ml-5">
                    <h3 class="text-3xl font-bold text-gray-900">{{ $stats['sales_today'] }}</h3>
                    <p class="text-gray-600">Ventas Hoy</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 flex items-center hover:shadow-2xl transition">
                <div class="p-4 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-users text-3xl"></i>
                </div>
                <div class="ml-5">
                    <h3 class="text-3xl font-bold text-gray-900">{{ $stats['clients'] }}</h3>
                    <p class="text-gray-600">Clientes</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 flex items-center hover:shadow-2xl transition">
                <div class="p-4 rounded-full bg-orange-100 text-orange-600">
                    <i class="fas fa-truck text-3xl"></i>
                </div>
                <div class="ml-5">
                    <h3 class="text-3xl font-bold text-gray-900">{{ $stats['suppliers'] }}</h3>
                    <p class="text-gray-600">Proveedores</p>
                </div>
            </div>
        </div>

        <!-- Navegación Rápida -->
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Navegación Rápida</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <a href="{{ route('admin.products') }}" 
               class="bg-white rounded-2xl shadow-md p-8 text-center hover:shadow-2xl transform hover:-translate-y-1 transition">
                <i class="fas fa-box text-5xl text-blue-600 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Productos</h3>
                <p class="text-gray-600">Gestionar inventario</p>
            </a>

            <a href="{{ route('admin.sales') }}" 
               class="bg-white rounded-2xl shadow-md p-8 text-center hover:shadow-2xl transform hover:-translate-y-1 transition">
                <i class="fas fa-shopping-cart text-5xl text-green-600 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Ventas</h3>
                <p class="text-gray-600">Ver historial de ventas</p>
            </a>

            <a href="{{ route('admin.suppliers') }}" 
               class="bg-white rounded-2xl shadow-md p-8 text-center hover:shadow-2xl transform hover:-translate-y-1 transition">
                <i class="fas fa-truck text-5xl text-orange-600 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Proveedores</h3>
                <p class="text-gray-600">Administrar proveedores</p>
            </a>

            <a href="{{ route('admin.categories') }}" 
               class="bg-white rounded-2xl shadow-md p-8 text-center hover:shadow-2xl transform hover:-translate-y-1 transition">
                <i class="fas fa-tags text-5xl text-purple-600 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Categorías</h3>
                <p class="text-gray-600">Gestionar categorías</p>
            </a>
        </div>

        <!-- Pie -->
        <footer class="text-center text-gray-500 text-sm mt-12">
            © {{ date('Y') }} Sistema de Inventarios — Panel de Administración.
        </footer>
    </div>
</div>
@endsection
