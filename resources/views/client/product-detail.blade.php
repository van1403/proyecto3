@extends('layouts.app')

@section('title', $product->name . ' - Cliente')

@section('content')
<div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="flex items-center mb-6">
        <a href="{{ url()->previous() }}" class="text-blue-600 hover:text-blue-800 mr-2">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="md:flex">
            <div class="md:flex-shrink-0 md:w-1/2">
                @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                     class="h-96 w-full object-cover md:h-full">
                @else
                <div class="h-96 w-full bg-gray-200 flex items-center justify-center md:h-full">
                    <i class="fas fa-box text-8xl text-gray-400"></i>
                </div>
                @endif
            </div>

            <div class="p-8 md:w-1/2">
                <div class="uppercase tracking-wide text-sm text-blue-600 font-semibold">
                    {{ $product->category->name }}
                </div>
                <h1 class="mt-2 text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
                <p class="mt-4 text-gray-600">{{ $product->description }}</p>
                
                <div class="mt-6">
                    <div class="flex items-center justify-between">
                        <span class="text-4xl font-bold text-green-600">${{ number_format($product->price, 2) }}</span>
                        <span class="text-lg {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }} font-semibold">
                            {{ $product->stock > 0 ? 'En stock' : 'Sin stock' }}
                        </span>
                    </div>
                    
                    @if($product->stock > 0)
                    {{-- 🔹 Botón actualizado para ir a la vista de selección de método de pago --}}
                    <div class="mt-6">
                        <a href="{{ route('client.showPayment', $product->id) }}" 
                           class="block w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-lg font-semibold text-lg text-center transition duration-200">
                            Comprar Ahora
                        </a>
                    </div>
                    @else
                    <div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-red-800">Este producto no está disponible actualmente.</p>
                    </div>
                    @endif
                </div>

                <div class="mt-8 border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Información del Producto</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium text-gray-500">Categoría:</span>
                            <p class="text-gray-900">{{ $product->category->name }}</p>
                        </div>
                        <div>
                            <span class="font-medium text-gray-500">Stock disponible:</span>
                            <p class="text-gray-900">{{ $product->stock }} unidades</p>
                        </div>
                        <div>
                            <span class="font-medium text-gray-500">Proveedor:</span>
                            <p class="text-gray-900">{{ $product->supplier->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
