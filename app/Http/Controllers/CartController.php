<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Payment;
use App\Models\Shipping;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        return view('client.cart', compact('cart', 'total'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        $cart[$id]['id'] = $product->id;
        $cart[$id]['name'] = $product->name;
        $cart[$id]['price'] = $product->price;
        $cart[$id]['quantity'] = ($cart[$id]['quantity'] ?? 0) + $request->input('quantity', 1);
        $cart[$id]['image'] = $product->image;

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Producto agregado al carrito.');
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = max(1, $request->quantity);
            session()->put('cart', $cart);
        }
        return redirect()->route('cart.index')->with('success', 'Cantidad actualizada.');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Producto eliminado.');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Carrito vaciado.');
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        return view('client.checkout', compact('cart', 'total'));
    }

    public function confirm(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');

        $request->validate([
            'delivery_type' => 'required|string',
            'payment_method' => 'required|string',
            'address' => 'nullable|string|max:255',
        ]);

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $shippingCost = $request->delivery_type === 'Envío' ? 10 : 0;
        $total += $shippingCost;

        $sale = Sale::create(['user_id' => Auth::id(), 'total_amount' => $total]);

        foreach ($cart as $item) {
            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);
            Product::find($item['id'])?->reduceStock($item['quantity']);
        }

        Shipping::create([
            'sale_id' => $sale->id,
            'delivery_type' => $request->delivery_type,
            'address' => $request->address,
            'shipping_cost' => $shippingCost,
        ]);

        Payment::create([
            'sale_id' => $sale->id,
            'method' => $request->payment_method,
            'transaction_id' => 'TXN-' . strtoupper(uniqid()),
            'amount' => $total,
        ]);

        session()->forget('cart');

        return redirect()->route('client.purchase.show', $sale->id)
                         ->with('success', 'Compra confirmada con ' . $request->delivery_type . ' y método de pago ' . $request->payment_method);
    }
}
