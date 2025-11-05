<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boleta de Venta #{{ $sale->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #007bff; padding-bottom: 10px; margin-bottom: 20px; }
        .title { font-size: 20px; font-weight: bold; color: #007bff; }
        .section-title { font-weight: bold; font-size: 14px; margin-top: 15px; margin-bottom: 5px; color: #222; }
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f2f2f2; font-weight: bold; }
        .total { text-align: right; font-size: 14px; font-weight: bold; }
        .footer { text-align: center; margin-top: 30px; font-size: 11px; color: #777; }
        .highlight { color: #007bff; font-weight: bold; }
    </style>
</head>
<body>
    {{-- 🧾 Encabezado --}}
    <div class="header">
        <h1 class="title">Boleta de Venta</h1>
        <p><strong>N° de Venta:</strong> #{{ $sale->id }}</p>
        <p><strong>Fecha:</strong> {{ $sale->created_at->format('d/m/Y H:i') }}</p>
    </div>

    {{-- 👤 Datos del Cliente --}}
    <p class="section-title">Datos del Cliente</p>
    <table width="100%">
        <tr>
            <td><strong>Nombre:</strong> {{ $sale->user->name }}</td>
            <td><strong>DNI:</strong> {{ $sale->user->dni ?? '—' }}</td>
        </tr>
        <tr>
            <td colspan="2"><strong>Correo:</strong> {{ $sale->user->email }}</td>
        </tr>
    </table>

    {{-- 💳 Información del Pago --}}
    <p class="section-title">Método de Pago</p>
    <table width="100%">
        <tr>
            <td><strong>Método:</strong>
                {{ $sale->payment_method ? ucfirst($sale->payment_method) : 'No registrado' }}
            </td>
        </tr>
    </table>

    {{-- 🚚 Información de Entrega --}}
    <p class="section-title">Método de Entrega</p>
    <table width="100%">
        <tr>
            <td><strong>Tipo de Entrega:</strong>
                {{ $sale->delivery_method === 'envio' ? 'Envío a domicilio' : 'Retiro en tienda' }}
            </td>
        </tr>
        @if($sale->delivery_method === 'envio' && $sale->address)
            <tr><td><strong>Dirección:</strong> {{ $sale->address }}</td></tr>
            <tr><td><strong>Costo de Envío:</strong> S/ 10.00</td></tr>
        @else
            <tr><td><strong>Costo de Envío:</strong> S/ 0.00</td></tr>
        @endif
    </table>

    {{-- 🛍️ Productos --}}
    <p class="section-title">Detalle de Productos</p>
    <table class="table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>S/ {{ number_format($item->unit_price, 2) }}</td>
                <td>S/ {{ number_format($item->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- 💰 Totales --}}
    <p class="total">
        Subtotal: S/
        {{ number_format($sale->items->sum('subtotal') - ($sale->delivery_method === 'envio' ? 10 : 0), 2) }} <br>

        @if($sale->delivery_method === 'envio')
            Envío: S/ 10.00 <br>
        @endif

        <span class="highlight">
            Total: S/ {{ number_format($sale->total_amount, 2) }}
        </span>
    </p>

    {{-- 🧾 Footer --}}
    <div class="footer">
        <p>Gracias por su compra en <strong>Sistema de Inventarios</strong></p>
        <p>Desarrollado con ❤️ por Vanesa Sabino</p>
    </div>
</body>
</html>
