@extends('layouts.app')

@section('title', $product->name . ' - Cliente')

@section('content')
<div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-2xl overflow-hidden transition transform hover:scale-[1.01] border border-gray-100">
    <div class="md:flex">

        {{-- 🖼️ Imagen --}}
        <div class="md:w-1/2 relative bg-gray-50">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                    class="h-96 w-full object-cover md:h-full">
            @else
                <div class="h-96 flex items-center justify-center bg-gray-200">
                    <i class="fas fa-box text-7xl text-gray-400"></i>
                </div>
            @endif

            @if($product->stock == 0)
                <div class="absolute top-0 left-0 bg-red-600 text-white px-3 py-1 text-sm font-semibold">
                    Agotado
                </div>
            @endif
        </div>

        {{-- 📋 Detalles --}}
        <div class="p-8 md:w-1/2 flex flex-col justify-between">
            <div>
                <span class="text-sm font-semibold text-blue-600 uppercase tracking-wide">{{ $product->category->name }}</span>
                <h1 class="mt-2 text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
                <p class="mt-4 text-gray-600 leading-relaxed">{{ $product->description }}</p>
            </div>

            <div class="mt-6 flex items-center justify-between">
                <span class="text-4xl font-bold text-green-600">S/ {{ number_format($product->price, 2) }}</span>
                <span class="text-sm font-semibold {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $product->stock > 0 ? 'En stock' : 'Sin stock' }}
                </span>
            </div>

            {{-- 🛒 Botón de compra --}}
            @if($product->stock > 0)
                <div class="mt-8">
                    <a href="{{ route('client.showCheckout', $product->id) }}" 
                        class="block w-full bg-gradient-to-r from-indigo-600 to-blue-500 hover:from-indigo-700 hover:to-blue-600 text-white py-3 px-6 rounded-lg font-semibold text-lg text-center shadow-md transition duration-200">
                        <i class="fas fa-shopping-cart mr-2"></i> Comprar Ahora
                    </a>
                </div>
            @else
                <div class="mt-8 bg-red-100 border border-red-300 rounded-lg p-3 text-center text-red-700 font-medium">
                    Este producto no está disponible actualmente.
                </div>
            @endif
        </div>
    </div>
</div>

{{-- 🔙 Botón volver --}}
<div class="max-w-5xl mx-auto mt-8">
    <a href="{{ url()->previous() }}" 
        class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition">
        <i class="fas fa-arrow-left mr-2"></i> Volver
    </a>
</div>
@endsection
