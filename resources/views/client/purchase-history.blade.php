@extends('layouts.app')

@section('title', 'Historial de Compras - Cliente')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Mi Historial de Compras</h1>

    <div class="space-y-6">
        @foreach($sales as $sale)
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Venta #{{ $sale->id }}
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Realizada el {{ $sale->created_at->format('d/m/Y \\a \\l\\a\\s H:i') }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-green-600">${{ number_format($sale->total_amount, 2) }}</p>
                    </div>
                </div>
            </div>
            <div class="border-b border-gray-200">
                <div class="px-4 py-5 sm:p-6">
                    <h4 class="text-md font-medium text-gray-900 mb-3">Productos comprados:</h4>
                    <div class="space-y-3">
                        @foreach($sale->items as $item)
                        <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-b-0">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" 
                                         class="h-10 w-10 rounded object-cover">
                                    @else
                                    <div class="h-10 w-10 rounded bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-box text-gray-400"></i>
                                    </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $item->product->name }}</p>
                                    <p class="text-sm text-gray-500">${{ number_format($item->unit_price, 2) }} c/u</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-900">Cantidad: {{ $item->quantity }}</p>
                                <p class="text-sm font-medium text-green-600">${{ number_format($item->subtotal, 2) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($sales->isEmpty())
    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6 text-center">
            <i class="fas fa-shopping-bag text-4xl text-gray-400 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900">No has realizado compras</h3>
            <p class="mt-1 text-sm text-gray-500">Cuando realices compras, aparecerán aquí.</p>
            <div class="mt-4">
                <a href="{{ route('client.dashboard') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                    Ir de compras
                </a>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection