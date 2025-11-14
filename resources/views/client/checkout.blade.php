@extends('layouts.app')

@section('title', 'Confirmar Compra')

@section('content')

@php
    // ⚙️ Si viene por compra directa (no carrito)
    if (!isset($cart) && isset($product)) {
        $cart = [[
            'name' => $product->name,
            'quantity' => 1,
            'price' => $product->price,
        ]];
        $total = $product->price;
    }
@endphp

<div class="max-w-5xl mx-auto bg-white shadow-xl rounded-2xl p-8 mt-10 border border-gray-200">
    {{-- ⚠️ Mensajes de error --}}
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            ⚠️ {{ $errors->first() }}
        </div>
    @endif

    {{-- 🧾 Encabezado --}}
    <div class="text-center border-b-2 border-blue-600 pb-4 mb-6">
        <h1 class="text-3xl font-bold text-blue-700 mb-2">
            <i class="fas fa-file-invoice mr-2"></i> Confirmar Compra
        </h1>
        <p class="text-gray-600 text-sm">Revisa los detalles de tu pedido antes de confirmar.</p>
    </div>

    {{-- 🛍 Tabla de productos --}}
    <table class="w-full border-collapse mb-6">
        <thead>
            <tr class="bg-blue-50 text-blue-900">
                <th class="p-3 border">Producto</th>
                <th class="p-3 border">Cantidad</th>
                <th class="p-3 border">Precio Unitario</th>
                <th class="p-3 border">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cart as $item)
                <tr class="text-center">
                    <td class="p-3 border">{{ $item['name'] }}</td>
                    <td class="p-3 border">{{ $item['quantity'] }}</td>
                    <td class="p-3 border">S/ {{ number_format($item['price'], 2) }}</td>
                    <td class="p-3 border text-green-600 font-semibold">
                        S/ {{ number_format($item['price'] * $item['quantity'], 2) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="text-right text-lg font-bold text-green-700 mb-4">
        Total sin envío: S/ {{ number_format($total, 2) }}
    </p>

    {{-- 🧾 Formulario de confirmación --}}
    <form 
        action="{{ isset($product) ? route('client.processCheckout', $product->id) : route('cart.confirmation') }}" 
        method="POST" 
        class="space-y-4">
        @csrf

        {{-- 🚚 Entrega --}}
        <div>
            <p class="font-semibold text-gray-700">Selecciona método de entrega:</p>
            <label class="block">
                <input type="radio" name="delivery_type" value="Envío" required class="mr-2">
                Envío a domicilio (+S/10)
            </label>
            <label class="block">
                <input type="radio" name="delivery_type" value="Retiro" required class="mr-2">
                Retiro en tienda
            </label>
        </div>

        {{-- 📍 Dirección (solo si selecciona envío) --}}
        <div id="addressField" class="hidden">
            <label class="font-semibold text-gray-700">Dirección de envío:</label>
            <input type="text" name="address" 
                   placeholder="Ingrese su dirección completa"
                   class="w-full p-2 border rounded-lg mt-1 focus:ring focus:ring-blue-200">
        </div>

        <script>
            // Mostrar u ocultar el campo de dirección
            document.querySelectorAll('input[name="delivery_type"]').forEach(radio => {
                radio.addEventListener('change', () => {
                    document.getElementById('addressField').classList.toggle('hidden', radio.value !== 'Envío');
                });
            });
        </script>

        {{-- 💳 Pago --}}
        <div>
            <label class="font-semibold text-gray-700">Método de pago:</label>
            <select name="payment_method" required 
                    class="w-full p-2 border rounded-lg mt-1 focus:ring focus:ring-blue-200">
                <option value="">Seleccione</option>
                <option value="Tarjeta">Tarjeta de crédito/débito</option>
                <option value="Yape">Yape / Plin</option>
                <option value="Efectivo">Efectivo</option>
            </select>
        </div>

        {{-- 🟢 Botón --}}
        <div class="text-center mt-6">
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition">
                <i class="fas fa-check-circle mr-2"></i> Confirmar Compra
            </button>
        </div>
    </form>
</div>
@endsection
