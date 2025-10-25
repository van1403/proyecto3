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

    // 🏠 Dashboard principal del cliente
    public function dashboard()
    {
        $categories = Category::all();
        $products = Product::where('stock', '>', 0)->get();

        return view('client.dashboard', compact('categories', 'products'));
    }

    // 🛍 Productos filtrados por categoría
    public function productsByCategory(Category $category)
    {
        $categories = Category::all();
        $products = Product::where('category_id', $category->id)
                           ->where('stock', '>', 0)
                           ->get();
        
        return view('client.products', compact('categories', 'products', 'category'));
    }

    // 🔎 Ver detalles de un producto específico
    public function showProduct(Product $product)
    {
        return view('client.product-detail', compact('product'));
    }

    // 💳 Mostrar pantalla para seleccionar método de pago
    public function showPayment(Product $product)
    {
        return view('client.payment', compact('product'));
    }

    // 💸 Procesar el pago y registrar la venta
    public function processPayment(Request $request, Product $product)
    {
        $request->validate([
            'method' => 'required|string',
        ]);

        // Crear la venta
        $sale = Sale::create([
            'user_id' => Auth::id(),
            'total_amount' => $product->price,
        ]);

        // Crear el detalle de venta
        SaleItem::create([
            'sale_id' => $sale->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'unit_price' => $product->price,
            'subtotal' => $product->price,
        ]);

        // Crear el pago asociado
        Payment::create([
            'sale_id' => $sale->id,
            'method' => $request->method,
            'transaction_id' => 'TXN-' . strtoupper(uniqid()),
            'amount' => $product->price,
        ]);

        // Reducir el stock del producto
        $product->reduceStock(1);

        return redirect()->route('client.purchase-history')
                         ->with('success', 'Compra realizada exitosamente con método de pago: ' . $request->method);
    }

    // 📜 Historial de compras del cliente
    public function purchaseHistory()
    {
        $sales = Sale::with('items.product')
                     ->where('user_id', Auth::id())
                     ->orderBy('created_at', 'desc')
                     ->get();
        
        return view('client.purchase-history', compact('sales'));
    }

    // 🔍 Ver detalles de una compra específica
    public function showPurchase($id)
    {
        $sale = Sale::with(['items.product', 'payment'])
                    ->where('user_id', Auth::id())
                    ->findOrFail($id);

        return view('client.purchase-detail', compact('sale'));
    }

    // 🧾 Generar y descargar la boleta PDF
    public function generateReceipt($id)
    {
         $sale = Sale::with(['items.product', 'payment', 'shipping', 'user'])
                ->where('user_id', Auth::id())
                ->findOrFail($id);

    // Generamos el PDF con la vista 'client.receipt'
    $pdf = Pdf::loadView('client.receipt', compact('sale'))
              ->setPaper('a4', 'portrait');


        return $pdf->download("boleta_venta_{$sale->id}.pdf");
    }

    // (Opcional) 🖨 Mostrar boleta en el navegador sin descargar
    /*
    public function viewReceipt($id)
    {
        $sale = Sale::with(['items.product', 'payment'])
                    ->where('user_id', Auth::id())
                    ->findOrFail($id);

        $pdf = Pdf::loadView('client.receipt', compact('sale'))
                  ->setPaper('a4', 'portrait');

        return $pdf->stream("boleta_venta_{$sale->id}.pdf"); // Mostrar en el navegador
    }
    */

      public function showCheckout(Product $product)
    {
        return view('client.checkout', compact('product'));
    }

     public function processCheckout(Request $request, Product $product)
    {
    $request->validate([
        'delivery_type' => 'required|string',
        'method' => 'required|string',
    ]);

    $shippingCost = $request->delivery_type === 'Envío' ? 10 : 0;
    $total = $product->price + $shippingCost;

    $sale = Sale::create([
        'user_id' => Auth::id(),
        'total_amount' => $total,
    ]);

    SaleItem::create([
        'sale_id' => $sale->id,
        'product_id' => $product->id,
        'quantity' => 1,
        'unit_price' => $product->price,
        'subtotal' => $product->price,
    ]);

    Shipping::create([
        'sale_id' => $sale->id,
        'delivery_type' => $request->delivery_type,
        'address' => $request->address,
        'city' => $request->city,
        'region' => $request->region,
        'postal_code' => $request->postal_code,
        'phone' => $request->phone,
        'shipping_cost' => $shippingCost,
    ]);

    Payment::create([
        'sale_id' => $sale->id,
        'method' => $request->method,
        'transaction_id' => 'TXN-' . strtoupper(uniqid()),
        'amount' => $total,
    ]);

    $product->reduceStock(1);

    return redirect()->route('client.purchase-history')
        ->with('success', 'Compra completada con ' . $request->delivery_type . ' y método de pago ' . $request->method);
}

}

