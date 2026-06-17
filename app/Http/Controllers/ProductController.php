<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['category', 'min_price', 'max_price', 'search']);
        $sort = $request->get('sort', 'default');

        $products = Product::with('category')
            ->filter($filters)
            ->sort($sort)
            ->paginate(12)
            ->withQueryString();

        $categories = Category::all();

        return view('catalog.list', compact('products', 'categories', 'sort'));
    }

    public function indexPanel()
    {
        // Получаем товары с привязкой к категории, пагинация по 10 штук
        $products = Product::with('category')->paginate(10);

        // Передаем данные в Blade-шаблон users.products
        return view('catalog.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('catalog.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'price' => 'required|numeric|min:0',
            'height' => 'required|numeric|min:0',
            'width' => 'required|numeric|min:0',
            'light_requirement' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only([
            'name', 'description', 'price', 'height', 'width', 'light_requirement', 'category_id'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = 'image/product/';
            if (!is_dir(public_path($path))) {
                mkdir(public_path($path), 0777, true);
            }

            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path($path), $filename);

            if (isset($product) && $product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            $data['image'] = $path . $filename;
        }

        Product::create($data);

        return redirect()->route('products.panel')->with('success', 'Товар добавлен');
    }



    public function show(string $id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('catalog.product', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        $data = $product;

        return view('catalog.edit', compact('data', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'price' => 'required|numeric|min:0',
            'height' => 'required|numeric|min:1',
            'width' => 'required|numeric|min:1',
            'light_requirement' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:5120', // 5MB
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = 'image/product/';
            if (!is_dir(public_path($path))) {
                mkdir(public_path($path), 0777, true);
            }

            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path($path), $filename);

            // Удаление старого изображения при редактировании
            if (isset($product) && $product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            $data['image'] = $path . $filename;
        }

        $product->update($data);

        return redirect()->route('products.panel')->with('success', 'Товар успешно обновлён');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->orders()->count() > 0) {
            return redirect()->route('products.panel')
                ->with('error', 'Невозможно удалить товар, так как с ним есть заказы.');
        }

        $product->delete();

        return redirect()->route('products.panel')
            ->with('success', 'Товар успешно удален.');
    }



    public function index1()
    {
        return view('layout.layouts');
    }

    public function info()
    {
        return view('layout.info');
    }

    public function contacts()
    {
        return view('layout.contacts');
    }

    public function employees()
    {
        return view('layout.employees');
    }
}
