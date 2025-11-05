@extends('layouts.app')

@section('title', 'Panel de Administración')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-blue-700 mb-8">📊 Panel de Administración</h1>

    {{-- 🔹 Resumen general --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6 mb-8">
        <div class="bg-blue-100 p-4 rounded-lg shadow">
            <p class="text-blue-800 font-semibold">Productos</p>
            <h2 class="text-2xl font-bold text-blue-900">{{ $stats['products'] }}</h2>
        </div>
        <div class="bg-green-100 p-4 rounded-lg shadow">
            <p class="text-green-800 font-semibold">Ventas hoy</p>
            <h2 class="text-2xl font-bold text-green-900">{{ $stats['sales_today'] }}</h2>
        </div>
        <div class="bg-indigo-100 p-4 rounded-lg shadow">
            <p class="text-indigo-800 font-semibold">Clientes</p>
            <h2 class="text-2xl font-bold text-indigo-900">{{ $stats['clients'] }}</h2>
        </div>
        <div class="bg-yellow-100 p-4 rounded-lg shadow">
            <p class="text-yellow-800 font-semibold">Proveedores</p>
            <h2 class="text-2xl font-bold text-yellow-900">{{ $stats['suppliers'] }}</h2>
        </div>
        <div class="bg-teal-100 p-4 rounded-lg shadow">
            <p class="text-teal-800 font-semibold">Total Ventas</p>
            <h2 class="text-2xl font-bold text-teal-900">{{ $stats['total_sales'] }}</h2>
        </div>
        <div class="bg-emerald-100 p-4 rounded-lg shadow">
            <p class="text-emerald-800 font-semibold">Ingresos Totales</p>
            <h2 class="text-2xl font-bold text-emerald-900">S/ {{ number_format($stats['total_revenue'], 2) }}</h2>
        </div>
    </div>

    {{-- 📈 Gráficos --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Ventas por Mes</h3>
            <canvas id="salesChart"></canvas>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Productos Más Vendidos</h3>
            <canvas id="topProductsChart"></canvas>
        </div>
    </div>

    {{-- ⚠️ Productos con bajo stock --}}
    @if($lowStock->count())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-6 mb-8 rounded-lg shadow">
        <h3 class="text-lg font-bold mb-2">⚠️ Productos con bajo stock</h3>
        <ul class="list-disc ml-6">
            @foreach($lowStock as $product)
                <li>{{ $product->name }} — Stock: {{ $product->stock }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- 🧾 Últimas Ventas --}}
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-semibold mb-4 text-gray-700">Últimas Ventas</h3>
        <table class="w-full border-collapse">
            <thead class="bg-blue-50 text-blue-900">
                <tr>
                    <th class="p-3 border">ID</th>
                    <th class="p-3 border text-left">Cliente</th>
                    <th class="p-3 border">Fecha</th>
                    <th class="p-3 border text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentSales as $sale)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">{{ $sale->id }}</td>
                    <td class="p-3">{{ $sale->user->name }}</td>
                    <td class="p-3">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                    <td class="p-3 text-right text-green-700 font-semibold">
                        S/ {{ number_format($sale->total_amount, 2) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- 📊 Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const months = {!! json_encode($monthlySales->pluck('month')->map(fn($m) => date('M', mktime(0, 0, 0, $m, 1)))) !!};
const totals = {!! json_encode($monthlySales->pluck('total')) !!};

new Chart(document.getElementById('salesChart'), {
    type: 'line',
    data: {
        labels: months,
        datasets: [{
            label: 'Ventas (S/)',
            data: totals,
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59,130,246,0.1)',
            fill: true,
            tension: 0.4
        }]
    }
});

const productNames = {!! json_encode($topProducts->pluck('name')) !!};
const productTotals = {!! json_encode($topProducts->pluck('total_sold')) !!};

new Chart(document.getElementById('topProductsChart'), {
    type: 'bar',
    data: {
        labels: productNames,
        datasets: [{
            label: 'Unidades Vendidas',
            data: productTotals,
            backgroundColor: '#16a34a'
        }]
    }
});
</script>
@endsection
