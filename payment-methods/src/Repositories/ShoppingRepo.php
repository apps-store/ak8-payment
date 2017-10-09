<?php
namespace AK8\PaymentMethods\Repositories;

use AK8\PaymentMethods\Entities\Shopping;

/**
 * Class ShoppingRepo
 *
 * @package App\PaymentProcess\Repositories
 * @author  Elio Martins
 */
class ShoppingRepo
{
    /**
     * @param $user
     * @param $status
     * @return Shopping
     */
    public function createShopping($user, $status)
    {
        $shopping = new Shopping();
        $shopping->id_user = $user;
        $shopping->id_status_shopping = $status;
        $shopping->save();

        return $shopping;
    }

    /**
     * @param $id
     * @param $status
     * @return mixed
     */
    public function editShopping($id, $status)
    {
        $shopping = Shopping::where('id', $id)->firstorFail();
        $shopping->update([
            'id_status_shopping' => $status
        ]);

        return $shopping;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getShoppingById($id)
    {
        $shopping = Shopping::where('id', $id)->first();

        return $shopping;
    }

    /**
     * @param $user
     * @return mixed
     */
    public function getShoppingByUser($user)
    {
        $purchases = Shopping::where('id_user', $user)->get();

        return $purchases;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getPurchases()
    {
        $purchases = Shopping::all();

        return $purchases;
    }

}
