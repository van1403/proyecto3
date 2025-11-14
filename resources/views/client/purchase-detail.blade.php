@extends('layouts.app')

@section('title', 'Detalle de Compra')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Detalle de la Compra</h1>

    <div class="bg-white shadow-lg rounded-lg p-6 mb-8 border border-gray-200">
        {{-- 🧾 Encabezado --}}
        <div class="flex justify-between items-center border-b pb-4 mb-4">
            <div>
                <h2 class="text-xl font-semibold text-blue-700">Venta #{{ $sale->id }}</h2>
                <p class="text-gray-500">Realizada el {{ $sale->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="text-right">
                <h3 class="text-2xl font-bold text-green-600">
                    S/ {{ number_format($sale->total_amount, 2) }}
                </h3>
            </div>
        </div>

        {{-- 🛍 Productos --}}
        <h3 class="text-lg font-semibold mb-4">Productos Comprados:</h3>
        <ul>
            @foreach($sale->items as $item)
                <li class="flex justify-between border-b py-3">
                    <span>{{ $item->product->name }} (x{{ $item->quantity }})</span>
                    <span>S/ {{ number_format($item->subtotal, 2) }}</span>
                </li>
            @endforeach
        </ul>

        {{-- 💳 Método de Pago --}}
        <div class="mt-6">
            <h3 class="text-lg font-semibold mb-2">Método de Pago:</h3>
            @if($sale->payment)
                <p><strong>Tipo:</strong> {{ ucfirst($sale->payment->method) }}</p>
                <p><strong>ID Transacción:</strong> {{ $sale->payment->transaction_id }}</p>
                <p><strong>Monto Pagado:</strong> S/ {{ number_format($sale->payment->amount, 2) }}</p>
            @else
                <p class="text-gray-500">No se registró información de pago.</p>
            @endif
        </div>

        {{-- 🚚 Método de Entrega --}}
        <div class="mt-6">
            <h3 class="text-lg font-semibold mb-2">Método de Entrega:</h3>
            @if($sale->shipping)
                <p><strong>Tipo:</strong> {{ $sale->shipping->delivery_type }}</p>

                @if($sale->shipping->delivery_type === 'Envío')
                    <p><strong>Dirección:</strong> {{ $sale->shipping->address ?? 'No especificada' }}</p>
                    <p><strong>Costo de Envío:</strong> S/ {{ number_format($sale->shipping->shipping_cost, 2) }}</p>
                @else
                    <p>Retiro en tienda</p>
                @endif
            @else
                <p class="text-gray-500">No se registró información de entrega.</p>
            @endif
        </div>

        {{-- 💰 Totales --}}
        <div class="mt-6 border-t pt-4 text-right">
            <p><strong>Subtotal:</strong> S/ {{ number_format($sale->items->sum('subtotal'), 2) }}</p>

            @if($sale->shipping)
                <p><strong>Envío:</strong> S/ {{ number_format($sale->shipping->shipping_cost, 2) }}</p>
            @endif

            <p class="text-lg font-bold text-green-700 mt-2">
                Total: S/ {{ number_format($sale->total_amount, 2) }}
            </p>
        </div>
    </div>

    {{-- 🔙 Botones --}}
    <div class="flex justify-end gap-3">
        <a href="{{ route('client.purchase-history') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded shadow-md transition">
            ← Volver al Historial
        </a>

        <a href="{{ route('client.purchase.receipt', $sale->id) }}" 
           class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded shadow-md transition">
            🧾 Descargar Boleta
        </a>
    </div>
</div>
@endsection
