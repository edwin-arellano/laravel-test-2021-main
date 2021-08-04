<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ProductRequest;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Index of products
     * 
     * Return list of products in stock
     * 
     */

    public function index(Request $request)
    {
        return $this->showOne(
            Product::inStock()
            ->name($request->name)
            ->get()
        );
    }

    /**
     * Store products
     * 
     * Store a single product
     */
    public function store(ProductRequest $request)
    {
        $user_id = $request->user()->id;
        $product = new Product($request->all());
        $product->user_id = $user_id;
        if($product->save()){
            return $this->showOne([
                'message' => 'Registro del producto exitoso'
            ]);
        } 
        return $this->showError('Error al guardar el producto', [], 400);
    }
}
