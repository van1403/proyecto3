<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;

class CartController extends Controller
{
    // 🛒 Mostrar carrito
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        return view('client.cart', compact('cart', 'total'));
    }

    // ➕ Agregar producto al carrito
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $request->input('quantity', 1);
        } else {
            $cart[$id] = [
                "id" => $product->id,
                "name" => $product->name,
                "price" => $product->price,
                "quantity" => $request->input('quantity', 1),
                "image" => $product->image,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Producto agregado al carrito.');
    }

    // ♻️ Actualizar cantidad
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = max(1, $request->quantity);
            session()->put('cart', $cart);
        }
        return redirect()->route('cart.index')->with('success', 'Cantidad actualizada.');
    }

    // ❌ Eliminar producto
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->route('cart.index')->with('success', 'Producto eliminado.');
    }

    // 🧹 Vaciar carrito
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Carrito vaciado.');
    }

    // 💳 Vista de checkout (confirmación de compra)
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        return view('client.checkout', compact('cart', 'total'));
    }

    // ✅ Confirmar compra y crear venta real
   public function confirm(Request $request)
{
    $cart = session()->get('cart', []);

    if (empty($cart)) {
        return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
    }

    // Validamos los datos del formulario
    $request->validate([
        'delivery_method' => 'required|string',
        'payment_method' => 'required|string',
        'address' => 'nullable|string|max:255',
    ]);

    // Calculamos total
    $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

    // Si es envío, agregar S/10 al total
    if ($request->delivery_method === 'envio') {
        $total += 10;
    }

    // Crear la venta con los datos completos
    $sale = Sale::create([
        'user_id' => Auth::id(),
        'total_amount' => $total,
        'delivery_method' => $request->delivery_method,
        'address' => $request->address,
        'payment_method' => $request->payment_method,
    ]);

    // Guardar los productos vendidos
    foreach ($cart as $item) {
        SaleItem::create([
            'sale_id' => $sale->id,
            'product_id' => $item['id'],
            'quantity' => $item['quantity'],
            'unit_price' => $item['price'],
            'subtotal' => $item['price'] * $item['quantity'],
        ]);

        // Reducir stock
        $product = Product::find($item['id']);
        if ($product) {
            $product->reduceStock($item['quantity']);
        }
    }

    // Limpiar carrito
    session()->forget('cart');

    // Redirigir a la vista de boleta o detalle de compra
    return redirect()->route('client.purchase.show', $sale->id)
                     ->with('success', 'Compra confirmada correctamente.');
}

}
