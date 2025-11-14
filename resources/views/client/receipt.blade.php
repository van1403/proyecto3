<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boleta de Venta #{{ $sale->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }
        h1 { color: #007bff; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background-color: #f5f5f5; }
        .total { text-align: right; font-weight: bold; margin-top: 20px; }
        .footer { text-align: center; margin-top: 30px; font-size: 11px; color: #777; }
    </style>
</head>
<body>
    <h1>🧾 Boleta de Venta #{{ $sale->id }}</h1>

    <p><strong>Cliente:</strong> {{ $sale->user->name }}</p>
    <p><strong>Fecha:</strong> {{ $sale->created_at->format('d/m/Y H:i') }}</p>

    <h3>📦 Productos</h3>
    <table>
        <thead>
            <tr><th>Producto</th><th>Cant.</th><th>Precio</th><th>Subtotal</th></tr>
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

    <h3>💳 Pago</h3>
    @if($sale->payment)
        <p><strong>Método:</strong> {{ ucfirst($sale->payment->method) }}</p>
        <p><strong>ID Transacción:</strong> {{ $sale->payment->transaction_id }}</p>
        <p><strong>Monto Pagado:</strong> S/ {{ number_format($sale->payment->amount, 2) }}</p>
    @else
        <p>No se registró método de pago.</p>
    @endif

    <h3>🚚 Envío</h3>
    @if($sale->shipping)
        <p><strong>Tipo:</strong> {{ $sale->shipping->delivery_type }}</p>
        @if($sale->shipping->delivery_type === 'Envío')
            <p><strong>Dirección:</strong> {{ $sale->shipping->address ?? 'No especificada' }}</p>
        @endif
        <p><strong>Costo de envío:</strong> S/ {{ number_format($sale->shipping->shipping_cost, 2) }}</p>
    @endif

    <p class="total">
        Total: S/ {{ number_format($sale->total_amount, 2) }}
    </p>

    <div class="footer">
        <p>Gracias por su compra 💚</p>
        <p>Desarrollado por Vanessa Sabino</p>
    </div>
</body>
</html>
