<?php

namespace App\Services\Basket;

use App\Exceptions\QuantityExceededException;
use App\Models\Product;
use App\Services\Storage\SessionStorage;

class Basket
{

    private $storage;

    /**
     * @param $storage
     */
    public function __construct(SessionStorage $storage)
    {
        $this->storage = $storage;
    }

    public function add(Product $product,int $quantity)
    {

        if ($this->has($product)) {
             $quantity = $this->get($product) + $quantity;
        }

        $this->update($product, $quantity);
        $this->storage->set($product->id,$quantity);
    }

    public function update(Product $product, int $quantity)
    {

        if (!$product->hasStock($quantity)) {
            throw new QuantityExceededException();
        }


        if (!$quantity) {
            return $this->storage->unset($product->id);
        }

        $this->storage->set($product->id, [
            'quantity' => $quantity
        ]);
    }

    public function has(Product $product)
    {
        return $this->storage->exists($product->id);
    }

    public function get(Product $product)
    {
        return $this->storage->get($product->id);
    }

    public function itemCount()
    {
        return $this->storage->count();
    }

    public function clear()
    {
        return $this->storage->clear();
    }

    public function all()
    {
        $products = Product::find(array_keys($this->storage->all()));
        foreach ($products as $product){
            $product->quantity = $this->storage->get($product->id);
        }
       return $products;
    }

    public function subTotal()
    {
        $total = 0;
        foreach ($this->all() as $item) {
            $total += $item->price * $item->quantity;
        }


        return $total;
    }
}
