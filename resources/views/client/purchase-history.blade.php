@extends('layouts.app')

@section('title', 'Mi Historial de Compras')

@section('content')
<div class="max-w-5xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Mi Historial de Compras</h1>

    @forelse($sales as $sale)
        <div class="bg-white shadow-md rounded-lg mb-6 p-6">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Venta #{{ $sale->id }}</h2>
                    <p class="text-gray-500">Realizada el {{ $sale->created_at->format('d/m/Y \a \l\a\s H:i') }}</p>
                </div>
                <div class="text-right">
                    <h3 class="text-2xl font-bold text-green-600">S/ {{ number_format($sale->total_amount, 2) }}</h3>
                </div>
            </div>

            <h4 class="font-semibold text-gray-700 mb-3">Productos comprados:</h4>
            <div class="space-y-3">
                @foreach($sale->items as $item)
                    <div class="flex justify-between items-center border-b pb-2">
                        <div class="flex items-center space-x-3">
                            @if($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-12 h-12 object-cover rounded">
                            @else
                                <img src="https://via.placeholder.com/60" alt="Producto" class="w-12 h-12 rounded">
                            @endif
                            <div>
                                <p class="font-medium text-gray-900">{{ $item->product->name }}</p>
                                <p class="text-gray-500 text-sm">S/ {{ number_format($item->unit_price, 2) }} c/u</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-600">Cantidad: {{ $item->quantity }}</p>
                            <p class="text-green-600 font-semibold">S/ {{ number_format($item->subtotal, 2) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- 🚚 Información breve --}}
            <div class="mt-4 text-sm text-gray-600">
                @if($sale->shipping)
                    <p><strong>Entrega:</strong> {{ $sale->shipping->delivery_type }}</p>
                @endif
                @if($sale->payment)
                    <p><strong>Pago:</strong> {{ ucfirst($sale->payment->method) }}</p>
                @endif
            </div>

            {{-- Botones --}}
            <div class="mt-5 flex justify-end space-x-3">
                <a href="{{ route('client.purchase.show', $sale->id) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition duration-150">
                    👁️ Ver Detalle
                </a>

                <a href="{{ route('client.purchase.receipt', $sale->id) }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow transition duration-150">
                    🧾 Boleta
                </a>
            </div>
        </div>
    @empty
        <div class="bg-white shadow-sm rounded-lg p-6 text-center">
            <i class="fas fa-shopping-basket text-4xl text-gray-400 mb-3"></i>
            <h3 class="text-lg font-medium text-gray-900">Aún no tienes compras registradas.</h3>
        </div>
    @endforelse
</div>
@endsection
