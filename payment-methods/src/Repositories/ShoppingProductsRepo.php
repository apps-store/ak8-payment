<?php
namespace AK8\PaymentMethods\Repositories;

use AK8\PaymentMethods\Entities\ShoppingProducts;

/**
 * Class ShoppingProductsRepo
 *
 * @package App\PaymentProcess\Repositories
 * @author  Elio Martins
 */
class ShoppingProductsRepo
{
    /**
     * @param $shopping
     * @param $product
     * @param $qty
     * @param $unitCost
     * @param $subtotal
     * @return ShoppingProducts
     */
    public function createShoppingProduct($shopping, $product, $qty, $unitCost, $subtotal)
    {
        $shoppingProduct = new ShoppingProducts();
        $shoppingProduct->id_shopping = $shopping;
        $shoppingProduct->id_product = $product;
        $shoppingProduct->quantity = $qty;
        $shoppingProduct->unit_cost = $unitCost;
        $shoppingProduct->subtotal = $subtotal;
        $shoppingProduct->save();

        return $shoppingProduct;
    }

    /**
     * @param $shopping
     * @return mixed
     */
    public function getShoppingProductsByShopping($shopping)
    {
        $shoppingProducts = ShoppingProducts::where('id_shopping', $shopping)->get();

        return $shoppingProducts;
    }

    /**
     * @param $product
     * @return mixed
     */
    public function getShoppingProductsByProduct($product)
    {
        $shoppingProducts = ShoppingProducts::where('id_product', $product)->get();

        return $shoppingProducts;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getShoppingProducts()
    {
        $shoppingProducts = ShoppingProducts::all();

        return $shoppingProducts;
    }

}
