@extends('layouts.app')

@section('title', 'Compra Confirmada')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-xl mt-10 text-center">
    <h1 class="text-3xl font-bold text-green-600 mb-4">
        ✅ ¡Compra Confirmada!
    </h1>
    <p class="text-gray-600 mb-6">Gracias por tu compra. Aquí tienes los detalles:</p>

    <div class="text-left mb-6">
        <p><strong>N° de Boleta:</strong> #{{ $sale->id }}</p>
        <p><strong>Método de entrega:</strong> {{ ucfirst($sale->delivery_method) }}</p>
        @if($sale->delivery_method === 'envio')
            <p><strong>Dirección:</strong> {{ $sale->address ?? 'No especificada' }}</p>
        @endif
        <p><strong>Método de pago:</strong> {{ ucfirst($sale->payment_method) }}</p>
        <p class="font-bold text-green-700 mt-4">Total pagado: S/ {{ number_format($sale->total_amount, 2) }}</p>
    </div>

    <a href="{{ route('client.purchase-history') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md">
        Ver mis compras
    </a>
</div>
@endsection
