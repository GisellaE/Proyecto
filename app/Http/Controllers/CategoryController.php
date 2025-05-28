<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();

        $categories->transform(function ($category) {
            if ($category->image) {
                $category->image_url = asset('storage/' . $category->image);
            }
            return $category;
        });

        return Inertia::render('Categories/Index', [
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        return Inertia::render('Categories/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'boolean',
        ]);

        $slug = $request->slug ?: Str::slug($request->name);
        $imagePath = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $imagePath = $file->storeAs('categories', $filename, 'public');
        }

        Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'image' => $imagePath,
            'status' => $request->status ?? true, // por defecto true si no viene
        ]);

        return redirect()->route('categories.index')->with('success', 'Categoría creada correctamente');
    }

    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = $category->products()->with('category')->get();

        $products->transform(function ($product) {
            if ($product->image) {
                $product->image_url = asset('storage/' . $product->image);
            }
            return $product;
        });

        if ($category->image) {
            $category->image_url = asset('storage/' . $category->image);
        }

        return Inertia::render('Categories/Show', [
            'category' => $category,
            'products' => $products,
        ]);
    }

    public function edit($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        return Inertia::render('Categories/Edit', [
            'category' => $category,
        ]);
    }

    public function update(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($category->id)],
            'slug' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($category->id)],
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'boolean',
        ]);

        $imagePath = $category->image;

        if ($request->hasFile('image')) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $imagePath = $file->storeAs('categories', $filename, 'public');
        }

        $category->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'image' => $imagePath,
            'status' => $request->status ?? true,
        ]);

        return redirect()->route('categories.index')->with('success', 'Categoría actualizada correctamente');
    }

    public function destroy($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        if ($category->products()->count() > 0) {
            return redirect()->route('categories.index')->with('error', 'No se puede eliminar la categoría porque tiene productos asociados.');
        }

        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Categoría eliminada correctamente');
    }
}
