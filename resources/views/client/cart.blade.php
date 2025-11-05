@extends('layouts.app')

@section('title', 'Mi Carrito')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow-2xl rounded-2xl p-8 mt-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 flex items-center">
        <i class="fas fa-shopping-cart text-blue-600 mr-3"></i> Mi Carrito de Compras
    </h1>

    @if(count($cart) > 0)
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm uppercase tracking-wide">
                    <tr>
                        <th class="p-3 text-left">Producto</th>
                        <th class="p-3 text-center">Precio</th>
                        <th class="p-3 text-center">Cantidad</th>
                        <th class="p-3 text-center">Subtotal</th>
                        <th class="p-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $id => $item)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="p-4 flex items-center space-x-4">
                            @if($item['image'])
                                <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover rounded-lg shadow">
                            @else
                                <div class="w-16 h-16 bg-gray-200 flex items-center justify-center rounded-lg">
                                    <i class="fas fa-box text-gray-400 text-2xl"></i>
                                </div>
                            @endif
                            <span class="font-medium text-gray-800">{{ $item['name'] }}</span>
                        </td>
                        <td class="text-center text-gray-700 font-semibold">S/ {{ number_format($item['price'], 2) }}</td>
                        <td class="text-center">
                            <form action="{{ route('cart.update', $id) }}" method="POST" class="flex justify-center items-center space-x-2">
                                @csrf
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                       class="w-16 text-center border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none">
                                <button type="submit" class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </form>
                        </td>
                        <td class="text-center text-green-600 font-bold">
                            S/ {{ number_format($item['price'] * $item['quantity'], 2) }}
                        </td>
                        <td class="text-center">
                            <a href="{{ route('cart.remove', $id) }}" class="text-red-600 hover:text-red-800 text-lg">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Total y acciones --}}
        <div class="flex flex-col sm:flex-row justify-between items-center mt-8 gap-4">
            <div class="text-xl font-semibold text-gray-800">
                Total: <span class="text-green-600 font-bold">S/ {{ number_format($total, 2) }}</span>
            </div>

            <div class="flex space-x-4">
                <a href="{{ route('cart.clear') }}" 
                   class="bg-red-500 hover:bg-red-600 text-white px-5 py-3 rounded-lg shadow font-semibold transition">
                    <i class="fas fa-trash mr-2"></i> Vaciar Carrito
                </a>

                <a href="{{ route('cart.checkout') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg shadow-lg font-semibold transition">
                    <i class="fas fa-credit-card mr-2"></i> Proceder al Pago
                </a>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-shopping-basket text-5xl text-gray-400 mb-4"></i>
            <p class="text-gray-500 text-lg mb-6">Tu carrito está vacío.</p>
            <a href="{{ route('client.dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold shadow transition">
                <i class="fas fa-store mr-2"></i> Ir a la Tienda
            </a>
        </div>
    @endif
</div>
@endsection
