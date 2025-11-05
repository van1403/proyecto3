<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function __construct()
   {
       $this->middleware('auth');
        $this->middleware('admin');
    }

    public function dashboard()
{
    // 📊 Resumen general
    $stats = [
        'products' => Product::count(),
        'sales_today' => Sale::whereDate('created_at', today())->count(),
        'clients' => User::where('role', 'client')->count(),
        'suppliers' => Supplier::count(),
        'total_sales' => Sale::count(), // 🔹 Esta clave antes no existía
        'total_revenue' => Sale::sum('total_amount'), // 🔹 Nueva también
    ];

    // 📈 Ventas por mes (últimos 6 meses)
    $monthlySales = Sale::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->take(6)
        ->get();

    // 🧮 Crecimiento mensual (%)
    $currentMonth = now()->month;
    $previousMonth = now()->subMonth()->month;

    $salesCurrent = Sale::whereMonth('created_at', $currentMonth)->sum('total_amount');
    $salesPrevious = Sale::whereMonth('created_at', $previousMonth)->sum('total_amount');
    $growth = $salesPrevious > 0 ? (($salesCurrent - $salesPrevious) / $salesPrevious) * 100 : 0;

    // 🛍️ Productos más vendidos
    $topProducts = \DB::table('sale_items')
        ->join('products', 'sale_items.product_id', '=', 'products.id')
        ->select('products.name', \DB::raw('SUM(sale_items.quantity) as total_sold'))
        ->groupBy('products.name')
        ->orderByDesc('total_sold')
        ->take(5)
        ->get();

    // 🔔 Productos con bajo stock
    $lowStock = Product::where('stock', '<', 5)->get();

    // 📦 Productos sin stock
    $outOfStock = Product::where('stock', '=', 0)->get();

    // 🧾 Últimas ventas
    $recentSales = Sale::with('user')->latest()->take(5)->get();

    // 💬 Comentarios (futuro módulo)
    $comments = [];

    return view('admin.dashboard', compact(
        'stats',
        'monthlySales',
        'growth',
        'topProducts',
        'lowStock',
        'outOfStock',
        'recentSales',
        'comments'
    ));
}


    // Categories
    public function categories()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function createCategory()
    {
        return view('admin.categories.create');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Category::create($request->all());

        return redirect()->route('admin.categories')->with('success', 'Categoría creada exitosamente.');
    }

    public function editCategory(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($request->all());

        return redirect()->route('admin.categories')->with('success', 'Categoría actualizada exitosamente.');
    }

    public function destroyCategory(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories')->with('success', 'Categoría eliminada exitosamente.');
    }

    // Suppliers
    public function suppliers()
    {
        $suppliers = Supplier::all();
        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function createSupplier()
    {
        return view('admin.suppliers.create');
    }

    public function storeSupplier(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
        ]);

        Supplier::create($request->all());

        return redirect()->route('admin.suppliers')->with('success', 'Proveedor creado exitosamente.');
    }

    public function editSupplier(Supplier $supplier)
    {
        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function updateSupplier(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
        ]);

        $supplier->update($request->all());

        return redirect()->route('admin.suppliers')->with('success', 'Proveedor actualizado exitosamente.');
    }

    public function destroySupplier(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('admin.suppliers')->with('success', 'Proveedor eliminado exitosamente.');
    }

    // Products
    public function products()
    {
        $products = Product::with(['category', 'supplier'])->get();
        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('admin.products.create', compact('categories', 'suppliers'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }

        Product::create($data);

        return redirect()->route('admin.products')->with('success', 'Producto creado exitosamente.');
    }

    public function editProduct(Product $product)
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('admin.products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Eliminar imagen anterior si existe
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }

        $product->update($data);

        return redirect()->route('admin.products')->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroyProduct(Product $product)
    {
        // Eliminar imagen si existe
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Producto eliminado exitosamente.');
    }

    // Sales
    public function sales()
    {
        $sales = Sale::with(['user', 'items.product'])->orderBy('created_at', 'desc')->get();
        return view('admin.sales.index', compact('sales'));
    }
}