<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Payment;
use App\Models\Shipping;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('client');
    }

    // 🏠 Dashboard principal
    public function dashboard()
    {
        $categories = Category::all();
        $products = Product::where('stock', '>', 0)->get();
        return view('client.dashboard', compact('categories', 'products'));
    }

    // 🛍 Productos por categoría
    public function productsByCategory(Category $category)
    {
        $categories = Category::all();
        $products = Product::where('category_id', $category->id)
                           ->where('stock', '>', 0)
                           ->get();
        return view('client.products', compact('categories', 'products', 'category'));
    }

    // 🔎 Ver producto
    public function showProduct(Product $product)
    {
        return view('client.product-detail', compact('product'));
    }

    // 💳 Mostrar pago
    public function showPayment(Product $product)
    {
        return view('client.payment', compact('product'));
    }

    // 💸 Procesar compra directa
    public function processPayment(Request $request, Product $product)
    {
        $request->validate([
            'delivery_type' => 'required|string',
            'method' => 'required|string',
            'address' => 'nullable|string|max:255'
        ]);

        $shippingCost = $request->delivery_type === 'Envío' ? 10 : 0;
        $total = $product->price + $shippingCost;

        // 🧾 Crear venta
        $sale = Sale::create([
            'user_id' => Auth::id(),
            'total_amount' => $total,
        ]);

        // 📦 Detalle
        SaleItem::create([
            'sale_id' => $sale->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'unit_price' => $product->price,
            'subtotal' => $product->price,
        ]);

        // 🚚 Envío
        Shipping::create([
            'sale_id' => $sale->id,
            'delivery_type' => $request->delivery_type,
            'address' => $request->address,
            'shipping_cost' => $shippingCost,
        ]);

        // 💳 Pago
        Payment::create([
            'sale_id' => $sale->id,
            'method' => $request->method,
            'transaction_id' => 'TXN-' . strtoupper(uniqid()),
            'amount' => $total,
        ]);

        $product->reduceStock(1);

        return redirect()->route('client.purchase.show', $sale->id)
            ->with('success', 'Compra completada con ' . $request->delivery_type . ' y método de pago ' . $request->method);
    }
    // 💳 Mostrar vista de checkout individual (compra directa)
public function showCheckout(Product $product)
{
    // Crea un carrito temporal con solo el producto seleccionado
    $cart = [[
        'name' => $product->name,
        'quantity' => 1,
        'price' => $product->price,
    ]];

    $total = $product->price;

    return view('client.checkout', compact('cart', 'total', 'product'));
}

// 💰 Procesar checkout individual (compra directa)
public function processCheckout(Request $request, Product $product)
{
    $request->validate([
        'delivery_type' => 'required|string',
        'payment_method' => 'required|string',
        'address' => 'nullable|string|max:255',
    ]);

    $shippingCost = $request->delivery_type === 'Envío' ? 10 : 0;
    $total = $product->price + $shippingCost;

    // Crear venta
    $sale = Sale::create([
        'user_id' => Auth::id(),
        'total_amount' => $total,
    ]);

    // Crear detalle
    SaleItem::create([
        'sale_id' => $sale->id,
        'product_id' => $product->id,
        'quantity' => 1,
        'unit_price' => $product->price,
        'subtotal' => $product->price,
    ]);

    // Guardar envío
    Shipping::create([
        'sale_id' => $sale->id,
        'delivery_type' => $request->delivery_type,
        'address' => $request->address,
        'shipping_cost' => $shippingCost,
    ]);

    // Guardar pago
    Payment::create([
        'sale_id' => $sale->id,
        'method' => $request->payment_method,
        'transaction_id' => 'TXN-' . strtoupper(uniqid()),
        'amount' => $total,
    ]);

    $product->reduceStock(1);

    return redirect()->route('client.purchase.show', $sale->id)
        ->with('success', 'Compra completada con ' . $request->delivery_type . ' y método de pago ' . $request->payment_method);
}


    // 📜 Historial de compras
    public function purchaseHistory()
    {
        $sales = Sale::with(['items.product', 'payment', 'shipping'])
                     ->where('user_id', Auth::id())
                     ->orderBy('created_at', 'desc')
                     ->get();

        return view('client.purchase-history', compact('sales'));
    }

    // 🔍 Ver detalle de compra
    public function showPurchase($id)
    {
        $sale = Sale::with(['items.product', 'payment', 'shipping'])
                    ->where('user_id', Auth::id())
                    ->findOrFail($id);

        return view('client.purchase-detail', compact('sale'));
    }

    // 🧾 Generar Boleta PDF
    public function generateReceipt($id)
    {
        $sale = Sale::with(['user', 'items.product', 'payment', 'shipping'])
                    ->where('user_id', Auth::id())
                    ->findOrFail($id);

        $pdf = Pdf::loadView('client.receipt', compact('sale'))
                  ->setPaper('a4', 'portrait');

        return $pdf->download("boleta_venta_{$sale->id}.pdf");
    }
}
