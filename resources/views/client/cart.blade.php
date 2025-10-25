@extends('layouts.app')

@section('title', 'Mi Carrito')

@section('content')
<div class="max-w-5xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">🛒 Mi Carrito de Compras</h1>

    @if(empty($cart))
        <div class="bg-white rounded-xl shadow-lg p-8 text-center">
            <p class="text-gray-600 text-lg mb-4">Tu carrito está vacío 😢</p>
            <a href="{{ route('client.dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold">
                Volver a la Tienda
            </a>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-lg p-6 overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-blue-100 text-gray-700">
                        <th class="p-3">Producto</th>
                        <th class="p-3 text-center">Cantidad</th>
                        <th class="p-3 text-right">Precio</th>
                        <th class="p-3 text-right">Subtotal</th>
                        <th class="p-3 text-center">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $id => $item)
                    <tr class="border-b hover:bg-blue-50 transition">
                        <td class="p-3 flex items-center space-x-3">
                            @if($item['image'])
                                <img src="{{ asset('storage/' . $item['image']) }}" alt="" class="w-14 h-14 rounded-lg object-cover">
                            @else
                                <div class="w-14 h-14 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-box text-gray-500"></i>
                                </div>
                            @endif
                            <span class="font-semibold text-gray-700">{{ $item['name'] }}</span>
                        </td>
                        <td class="p-3 text-center">{{ $item['quantity'] }}</td>
                        <td class="p-3 text-right">S/ {{ number_format($item['price'], 2) }}</td>
                        <td class="p-3 text-right text-green-600 font-semibold">S/ {{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                        <td class="p-3 text-center">
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-6 flex justify-between items-center">
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-lg font-semibold">
                        Vaciar Carrito
                    </button>
                </form>

                <div class="text-right">
                    <p class="text-lg font-semibold text-gray-800">Total: 
                        <span class="text-green-600 text-2xl ml-2">S/ {{ number_format($total, 2) }}</span>
                    </p>
                    <a href="{{ route('client.dashboard') }}" class="mt-3 inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold">
                        Seguir Comprando
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
