@extends('layouts.app')

@section('title', 'Editar Producto - Administrador')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 py-12 px-6">
    <div class="max-w-5xl mx-auto bg-white shadow-2xl rounded-2xl p-10">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-10 border-b pb-4">
            ✏️ Editar Producto
        </h1>

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Columna Izquierda -->
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700">Nombre del Producto</label>
                        <input type="text" name="name" id="name" required
                            class="mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('name', $product->name) }}">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700">Descripción</label>
                        <textarea name="description" id="description" rows="4"
                            class="mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="price" class="block text-sm font-semibold text-gray-700">Precio ($)</label>
                            <input type="number" name="price" id="price" step="0.01" min="0" required
                                class="mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                value="{{ old('price', $product->price) }}">
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="stock" class="block text-sm font-semibold text-gray-700">Stock</label>
                            <input type="number" name="stock" id="stock" min="0" required
                                class="mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                value="{{ old('stock', $product->stock) }}">
                            @error('stock')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha -->
                <div class="space-y-6">
                    <div>
                        <label for="category_id" class="block text-sm font-semibold text-gray-700">Categoría</label>
                        <select name="category_id" id="category_id" required
                            class="mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Selecciona una categoría</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="supplier_id" class="block text-sm font-semibold text-gray-700">Proveedor</label>
                        <select name="supplier_id" id="supplier_id" required
                            class="mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Selecciona un proveedor</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id', $product->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Imagen -->
                    <div>
                        <label for="image" class="block text-sm font-semibold text-gray-700">Imagen del Producto</label>
                        @if($product->image)
                            <div class="mt-3 flex items-center space-x-4">
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     alt="{{ $product->name }}" 
                                     class="h-32 w-32 object-cover rounded-xl shadow-md border border-gray-300">
                                <div>
                                    <p class="text-gray-700 text-sm font-medium">Imagen actual</p>
                                    <p class="text-xs text-gray-500">Puedes subir una nueva si deseas reemplazarla</p>
                                </div>
                            </div>
                        @endif

                        <input type="file" name="image" id="image" 
                            class="mt-3 w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            accept="image/*">
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-4 mt-10">
                <a href="{{ route('admin.products') }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-lg shadow-sm font-medium transition transform hover:-translate-y-0.5">
                    Cancelar
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow-md font-medium transition transform hover:-translate-y-0.5">
                    💾 Actualizar Producto
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
