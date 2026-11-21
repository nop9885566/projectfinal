<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'subcategory'])->get();
        return view('dashboard.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::with('subcategories')->orderBy('sort_order')->get();
        return view('dashboard.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'image'          => 'nullable|image|max:2048',
            'is_available'   => 'boolean',
        ]);

        $data = $request->all();
        $data['is_available'] = $request->has('is_available');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'เพิ่มเมนูสำเร็จ');
    }

    public function edit(Product $product)
    {
        if (auth()->user()->role === 'staff') {
            abort(403, 'พนักงานสามารถเพิ่มและลบเมนูได้เท่านั้น ไม่สามารถแก้ไขเมนูได้');
        }
        $categories = Category::with('subcategories')->orderBy('sort_order')->get();
        return view('dashboard.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        if (auth()->user()->role === 'staff') {
            abort(403, 'พนักงานสามารถเพิ่มและลบเมนูได้เท่านั้น ไม่สามารถแก้ไขเมนูได้');
        }

        $request->validate([
            'name'           => 'required|string|max:255',
            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'image'          => 'nullable|image|max:2048',
            'is_available'   => 'boolean',
        ]);

        $data = $request->all();
        $data['is_available'] = $request->has('is_available');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'แก้ไขเมนูสำเร็จ');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'ลบเมนูสำเร็จ');
    }
}
