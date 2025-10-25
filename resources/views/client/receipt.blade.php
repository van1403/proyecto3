<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boleta de Venta #{{ $sale->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .container { width: 80%; margin: 0 auto; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f3f3f3; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Boleta de Venta #{{ $sale->id }}</h2>
        <p><strong>Fecha:</strong> {{ $sale->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Cliente:</strong> {{ $sale->user->name }}</p>
        <p><strong>Email:</strong> {{ $sale->user->email }}</p>

        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Total: ${{ number_format($sale->total_amount, 2) }}</h3>

        @if($sale->payment)
        <p><strong>Método de Pago:</strong> {{ ucfirst($sale->payment->method) }}</p>
        @endif
    </div>
</body>
</html>
