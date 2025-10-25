@extends('layouts.app')

@section('title', 'Método de Pago')

@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-white shadow-lg rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-4 text-gray-800">Selecciona un Método de Pago</h2>

    <form action="{{ route('client.processPayment', $product->id) }}" method="POST">
        @csrf

        <div class="space-y-4">
            <label class="flex items-center">
                <input type="radio" name="method" value="Efectivo" required class="mr-2">
                💵 Efectivo
            </label>

            <label class="flex items-center">
                <input type="radio" name="method" value="Tarjeta de Crédito" required class="mr-2">
                💳 Tarjeta de Crédito
            </label>

            <label class="flex items-center">
                <input type="radio" name="method" value="Yape" required class="mr-2">
                📱 Yape
            </label>

            <label class="flex items-center">
                <input type="radio" name="method" value="Plin" required class="mr-2">
                📱 Plin
            </label>
        </div>

        <div class="mt-6">
            <button type="submit" class="bg-green-600 text-white px-5 py-2 rounded hover:bg-green-700">
                Confirmar Pago
            </button>
            <a href="{{ route('client.dashboard') }}" class="ml-3 text-gray-600 hover:underline">Cancelar</a>
        </div>
    </form>
</div>
@endsection
