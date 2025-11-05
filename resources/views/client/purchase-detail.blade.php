@extends('layouts.app')

@section('title', 'Detalle de Compra')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-6">Detalle de la Compra</h1>

    <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
        {{-- 🧾 Encabezado --}}
        <div class="flex justify-between items-center border-b pb-4 mb-4">
            <div>
                <h2 class="text-xl font-semibold">Venta #{{ $sale->id }}</h2>
                <p class="text-gray-500">Realizada el {{ $sale->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="text-right">
                <h3 class="text-2xl font-bold text-green-600">S/ {{ number_format($sale->total_amount, 2) }}</h3>
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

        {{-- 💳 Método de pago --}}
        <div class="mt-6">
            <h3 class="text-lg font-semibold mb-2">Método de Pago:</h3>
            @if($sale->payment_method)
                <p>{{ ucfirst($sale->payment_method) }}</p>
            @else
                <p class="text-gray-500">No se registró información de pago.</p>
            @endif
        </div>

        {{-- 🚚 Método de entrega --}}
        <div class="mt-6">
            <h3 class="text-lg font-semibold mb-2">Método de Entrega:</h3>
            @if($sale->delivery_method)
                <p>
                    {{ $sale->delivery_method === 'envio' ? 'Envío a domicilio' : 'Retiro en tienda' }}
                </p>
                @if($sale->delivery_method === 'envio' && $sale->address)
                    <p><strong>Dirección:</strong> {{ $sale->address }}</p>
                @endif
            @else
                <p class="text-gray-500">No se registró información de entrega.</p>
            @endif
        </div>

        {{-- 💰 Totales --}}
        <div class="mt-6 border-t pt-4 text-right">
            <p><strong>Subtotal:</strong>
                S/ {{ number_format(
                    $sale->items->sum('subtotal') - ($sale->delivery_method === 'envio' ? 10 : 0), 2
                ) }}
            </p>

            @if($sale->delivery_method === 'envio')
                <p><strong>Envío:</strong> S/ 10.00</p>
            @endif

            <p class="text-lg font-bold text-green-700">
                Total: S/ {{ number_format($sale->total_amount, 2) }}
            </p>
        </div>
    </div>

    {{-- 🔙 Botones --}}
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
