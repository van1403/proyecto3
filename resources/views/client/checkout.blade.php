@extends('layouts.app')

@section('title', 'Finalizar Compra')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white shadow-lg rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Detalles de la Compra</h2>

    <form action="{{ route('client.processCheckout', $product->id) }}" method="POST">
        @csrf

        {{-- 🏠 Tipo de entrega --}}
        <h3 class="text-lg font-semibold mb-2">Entrega</h3>
        <div class="space-y-2 mb-4">
            <label class="flex items-center">
                <input type="radio" name="delivery_type" value="Envío" required class="mr-2">
                🚚 Envío (S/10 adicionales)
            </label>
            <label class="flex items-center">
                <input type="radio" name="delivery_type" value="Retiro" required class="mr-2">
                🏬 Retiro en tienda
            </label>
        </div>

        {{-- 📦 Campos de dirección --}}
        <div id="shippingFields" class="hidden space-y-3 mb-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium">Ciudad</label>
                    <input type="text" name="city" class="w-full border rounded px-3 py-2" placeholder="Ej: Lima">
                </div>
                <div>
                    <label class="block text-sm font-medium">Región</label>
                    <input type="text" name="region" class="w-full border rounded px-3 py-2" placeholder="Ej: Lima">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium">Dirección</label>
                <input type="text" name="address" class="w-full border rounded px-3 py-2">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium">Código Postal</label>
                    <input type="text" name="postal_code" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium">Teléfono</label>
                    <input type="text" name="phone" class="w-full border rounded px-3 py-2">
                </div>
            </div>
        </div>

        {{-- 💳 Método de pago --}}
        <h3 class="text-lg font-semibold mb-2">Método de Pago</h3>
        <div class="space-y-2 mb-6">
            <label class="flex items-center">
                <input type="radio" name="method" value="Efectivo" required class="mr-2"> 💵 Efectivo
            </label>
            <label class="flex items-center">
                <input type="radio" name="method" value="Tarjeta de Crédito" required class="mr-2"> 💳 Tarjeta
            </label>
            <label class="flex items-center">
                <input type="radio" name="method" value="Yape" required class="mr-2"> 📱 Yape
            </label>
            <label class="flex items-center">
                <input type="radio" name="method" value="Plin" required class="mr-2"> 📱 Plin
            </label>
        </div>

        {{-- 🧾 Resumen --}}
        <h3 class="text-lg font-semibold mb-2">Resumen de la Compra</h3>
        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            <p><strong>Producto:</strong> {{ $product->name }}</p>
            <p><strong>Precio:</strong> S/{{ number_format($product->price, 2) }}</p>
            <p id="shipping-cost" class="text-gray-600">Costo de envío: S/0.00</p>
            <p class="mt-2 font-bold text-lg" id="total-amount">
                Total: S/{{ number_format($product->price, 2) }}
            </p>
        </div>

        {{-- Botón --}}
        <div class="text-center">
            <button type="submit" class="bg-green-600 text-white px-5 py-2 rounded hover:bg-green-700">
                Confirmar Compra
            </button>
        </div>
    </form>
</div>

{{-- Script para mostrar campos y sumar envío --}}
<script>
    const deliveryInputs = document.querySelectorAll('input[name="delivery_type"]');
    const shippingFields = document.getElementById('shippingFields');
    const totalText = document.getElementById('total-amount');
    const shippingText = document.getElementById('shipping-cost');
    const basePrice = {{ $product->price }};

    deliveryInputs.forEach(input => {
        input.addEventListener('change', () => {
            if (input.value === 'Envío') {
                shippingFields.classList.remove('hidden');
                shippingText.textContent = "Costo de envío: S/10.00";
                totalText.textContent = "Total: S/" + (basePrice + 10).toFixed(2);
            } else {
                shippingFields.classList.add('hidden');
                shippingText.textContent = "Costo de envío: S/0.00";
                totalText.textContent = "Total: S/" + basePrice.toFixed(2);
            }
        });
    });
</script>
@endsection
