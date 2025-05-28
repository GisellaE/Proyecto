<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    // Mostrar lista de productos (con paginación)
    public function index()
    {
        // Obtenemos los productos con sus categorías
        $products = Product::with('category')->get();

        // Obtenemos todas las categorías para los filtros
        $categories = Category::all();

        // Modificar los productos para agregar la URL completa de la imagen en el campo 'image'
        // Transformar productos para incluir URL de imagen
        $products->transform(function ($product) {
            if ($product->image) {
                $product->image_url = asset('storage/' . $product->image);
            }
            return $product;
        });

        // Retornar los productos a la vista de Inertia
        return Inertia::render('Products/Index', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    // Mostrar formulario para crear producto
    public function create()
    {
        // Obtener todas las categorías
        $categories = Category::all();

        return Inertia::render('Products/Create', [
            'categories' => $categories,
        ]);
    }

    // Guardar producto nuevo
    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'brand' => 'required|string|max:100',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        // Generamos el slug si no se pasa uno
        $slug = $request->slug ?: Str::slug($request->name);

        // Subir la imagen si se proporciona
        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $imagePath = $file->storeAs('products', $filename, 'public');
        }

        // Crear el nuevo producto en la base de datos
        Product::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'price' => $request->price,
            'brand' => $request->brand,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'image' => $imagePath,
        ]);

        // Redirigir al índice de productos con un mensaje de éxito
        return redirect()->route('products.index')->with('success', 'Producto creado correctamente');
    }

    // Mostrar detalle de un producto (por slug)
    public function show($slug)
    {
        $product = Product::with('category')->where('slug', $slug)->firstOrFail();

        // Agregar URL de imagen
        if ($product->image) {
            $product->image_url = asset('storage/' . $product->image);
        }

        // Productos relacionados (misma categoría)
        $relatedProducts = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        $relatedProducts->transform(function ($product) {
            if ($product->image) {
                $product->image_url = asset('storage/' . $product->image);
            }
            return $product;
        });

        return Inertia::render('Products/Show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }

    // Mostrar formulario para editar producto (por slug)
    public function edit($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $categories = Category::all();

        // Retornar la vista de edición con el producto y las categorías disponibles
        return Inertia::render('Products/Edit', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    // Actualizar producto (por slug)
    public function update(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        // Validación de los datos del formulario de actualización
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products')->ignore($product->id),
            ],
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'brand' => 'required|string|max:100',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        // Actualizamos el slug
        $slug = $request->slug;

        // Ruta de la imagen
        $imagePath = $product->image;

        // Subir la nueva imagen si se proporciona
        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $imagePath = $file->storeAs('products', $filename, 'public');
        }

        // Actualizar los datos del producto
        $product->update([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'price' => $request->price,
            'brand' => $request->brand,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'image' => $imagePath,
        ]);

        // Redirigir al índice de productos con un mensaje de éxito
        return redirect()->route('products.index')->with('success', 'Producto actualizado correctamente');
    }

    // Eliminar producto (por slug)
    public function destroy($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        // Si el producto tiene una imagen, la eliminamos del almacenamiento
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Eliminar el producto de la base de datos
        $product->delete();

        // Redirigir al índice de productos con un mensaje de éxito
        return redirect()->route('products.index')->with('success', 'Producto eliminado correctamente');
    }
}
