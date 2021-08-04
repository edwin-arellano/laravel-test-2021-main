<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductBuyRequest;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Transaction;

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
        return $this->showAll(
            Product::inStock()
                ->name($request->name)
                ->get()
                ->toArray()
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

    /**
     * Buy product
     *
     * Buy a single product
     */
    public function buy(ProductBuyRequest $request, $id)
    {
        $user_id = $request->user()->id;
        $product = Product::findOrFail($id);
        $quantity = $request->quantity;

        if ($product->isOwnedByUser($user_id)) {
            return $this->showError('El comprador no puede adquirir sus propios productos', [], 400);
        }

        if ($product->isOutOfStock($quantity)) {
            return $this->showError('El producto no cuenta con la cantidad suficiente en almacén', [], 400);
        }

        if ($this->createTransaction($product, $user_id, $quantity)) {
            return $this->showOne(['message' => 'La transacción ha sido exitosa']);
        }

        return $this->showError('Error al guardar la transacción', [], 400);
    }

    public function createTransaction($product, $user_id, $quantity)
    {
        $transaction = Transaction::create([
            'quantity' => $quantity,
            'user_id' => $user_id,
            'product_id' => $product->id,
        ]);

        $product->quantity -= $quantity;

        return $product->save();
    }
}
