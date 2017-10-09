<?php

namespace AK8\PaymentMethods;

use App\PaymentMethods\Enums\PaymentMethods;
use AK8\PaymentMethods\Enums\PaymentStatus;
use AK8\PaymentMethods\Repositories\ShoppingProductsRepo;
use AK8\PaymentMethods\Repositories\ShoppingRepo;
use App\Products\Repositories\ProductsRepo;
use Gloudemans\Shoppingcart\Cart;
use Webpatser\Uuid\Uuid;

/**
 * Class PaymentProcessController
 *
 * Class to manage the Payment Process functions
 *
 * @package App\Http\Controllers
 * @author  Elio Martins
 */
class PaymentProcess
{
    /**
     * @var Cart
     */
    private $cart;

    /**
     * @var ShoppingRepo
     */
    private $shoppingRepo;

    /**
     * @var ShoppingProductsRepo
     */
    private $shoppingProductsRepo;

    /**
     * PaymentProcessController constructor.
     * @param Cart $cart
     * @param ShoppingProductsRepo $shoppingProductsRepo
     * @param ShoppingRepo $shoppingRepo
     */
    public function __construct(Cart $cart, ShoppingProductsRepo $shoppingProductsRepo, ShoppingRepo $shoppingRepo)
    {
        $this->cart = $cart;
        $this->shoppingProductsRepo = $shoppingProductsRepo;
        $this->shoppingRepo = $shoppingRepo;
    }

    /**
     * @param $methodPayment
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function createShopping($methodPayment)
    {
        $cartContent = $this->cart->content();

        if (isset($cartContent) && count($cartContent)) {
            $this->cart->store(Uuid::generate(4));
            $createShopping = $this->shoppingRepo->createShopping(\Auth::user()->id, PaymentStatus::$pending);
            foreach ($cartContent as $product) {
                $this->shoppingProductsRepo->createShoppingProduct($createShopping->id,
                    $product->id, $product->qty, $product->price, $product->subtotal);
            }

            switch ($methodPayment) {
                case PaymentMethods::$transbank :
                    return redirect()->route('transbank-init', [$createShopping->id, $this->cart->total(), \Auth::user()->id]);
                    break;
                case PaymentMethods::$mercadopago :
                    return redirect()->route('create-preferences', [$createShopping->id, $this->cart->total(), \Auth::user()->id]);
                    break;
                default :
                    return redirect()->back();
                    break;
            }
        } else {
            return redirect()->back();
        }
    }

    /**
     * @param $shopping
     * @param $status
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateShopping($shopping, $status)
    {
        $productsRepo = new ProductsRepo();

        $shoppingEdit = $this->shoppingRepo->editShopping($shopping, $status);
        $shoppingProducts = $this->shoppingProductsRepo->getShoppingProductsByShopping($shopping);

        $data['shoppingEdit'] = $shoppingEdit;
        $data['shoppingProducts'] = $shoppingProducts;

        switch ($status) {
            case PaymentStatus::$approved :
                foreach ($shoppingProducts as $product) {
                    $updateQty = $productsRepo->updateQtyProduct($product->id_product, $product->quantity);
                    \Log::debug('PaymentProcessController.updateShopping', ['updateQty' => $updateQty]);
                }
                return view('site.payment.successful', $data);
                break;
            case PaymentStatus::$rejected :
                return view('site.payment.failure', $data);
                break;
            case PaymentStatus::$pending :
                return view('site.payment.pending', $data);
                break;
            case PaymentStatus::$error :
                return view('site.payment.failure', $data);
                break;
            default :
                return view('site.payment.pending', $data);
                break;
        }

    }

}
