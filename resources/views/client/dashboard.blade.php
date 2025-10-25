@extends('layouts.app')

@section('title', 'Tienda - Cliente')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Nuestros Productos</h1>

    <!-- Filtros por Categoría -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Categorías</h2>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('client.dashboard') }}" 
               class="px-4 py-2 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition duration-200">
                Todos
            </a>
            @foreach($categories as $category)
            <a href="{{ route('client.products.by-category', $category) }}" 
               class="px-4 py-2 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 transition duration-200">
                {{ $category->name }}
            </a>
            @endforeach
        </div>
    </div>

    <!-- Grid de Productos -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($products as $product)
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
            @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
            @else
            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                <i class="fas fa-box text-4xl text-gray-400"></i>
            </div>
            @endif
            
            <div class="p-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $product->name }}</h3>
                <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $product->description }}</p>
                
                <div class="flex justify-between items-center mb-3">
                    <span class="text-2xl font-bold text-green-600">${{ number_format($product->price, 2) }}</span>
                    <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded">
                        Stock: {{ $product->stock }}
                    </span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">{{ $product->category->name }}</span>
                    <a href="{{ route('client.product.show', $product) }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm transition duration-200">
                        Comprar
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($products->isEmpty())
    <div class="text-center py-12">
        <i class="fas fa-box-open text-6xl text-gray-400 mb-4"></i>
        <h3 class="text-xl font-semibold text-gray-600">No hay productos disponibles</h3>
        <p class="text-gray-500">Vuelve más tarde para ver nuevos productos.</p>
    </div>
    @endif
</div>
@endsection