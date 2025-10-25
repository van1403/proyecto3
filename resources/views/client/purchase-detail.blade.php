@extends('layouts.app')

@section('title', 'Detalle de Compra')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-6">Detalle de la Compra</h1>

    <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
        <div class="flex justify-between items-center border-b pb-4 mb-4">
            <div>
                <h2 class="text-xl font-semibold">Venta #{{ $sale->id }}</h2>
                <p class="text-gray-500">Realizada el {{ $sale->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="text-right">
                <h3 class="text-2xl font-bold text-green-600">${{ number_format($sale->total_amount, 2) }}</h3>
            </div>
        </div>

        <h3 class="text-lg font-semibold mb-4">Productos Comprados:</h3>
        <ul>
            @foreach($sale->items as $item)
                <li class="flex justify-between border-b py-3">
                    <span>{{ $item->product->name }} (x{{ $item->quantity }})</span>
                    <span>${{ number_format($item->subtotal, 2) }}</span>
                </li>
            @endforeach
        </ul>

        @if($sale->payment)
        <div class="mt-6">
            <h3 class="text-lg font-semibold mb-2">Método de Pago:</h3>
            <p><strong>Tipo:</strong> {{ ucfirst($sale->payment->method) }}</p>
            @if($sale->payment->transaction_id)
                <p><strong>ID Transacción:</strong> {{ $sale->payment->transaction_id }}</p>
            @endif
        </div>
        @endif
    </div>

    <a href="{{ route('client.purchase-history') }}" 
       class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">
        ← Volver al Historial
    </a>
    <a href="{{ route('client.purchase.receipt', $sale->id) }}" 
       class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded ml-3">
        🧾 Descargar Boleta
    </a>
</div>
@endsection
