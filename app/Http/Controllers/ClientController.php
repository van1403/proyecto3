<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('client');
    }

    public function dashboard()
    {
        $categories = Category::all();
        $products = Product::where('stock', '>', 0)->get();
        return view('client.dashboard', compact('categories', 'products'));
    }

    public function productsByCategory(Category $category)
    {
        $categories = Category::all();
        $products = Product::where('category_id', $category->id)
                          ->where('stock', '>', 0)
                          ->get();
        
        return view('client.products', compact('categories', 'products', 'category'));
    }

    public function showProduct(Product $product)
    {
        return view('client.product-detail', compact('product'));
    }

    public function purchaseProduct(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock,
        ]);

        // Create sale
        $sale = Sale::create([
            'user_id' => Auth::id(),
            'total_amount' => $product->price * $request->quantity,
        ]);

        // Create sale item
        SaleItem::create([
            'sale_id' => $sale->id,
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'unit_price' => $product->price,
            'subtotal' => $product->price * $request->quantity,
        ]);

        // Reduce stock
        $product->reduceStock($request->quantity);

        return redirect()->route('client.dashboard')->with('success', 'Compra realizada exitosamente.');
    }

    public function purchaseHistory()
    {
        $sales = Sale::with('items.product')
                    ->where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->get();
        
        return view('client.purchase-history', compact('sales'));
    }
}