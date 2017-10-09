<?php

namespace AK8\PaymentMethods\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ShoppingProducts
 *
 * Entity to manage the data of shopping_products table
 *
 * @package App\PaymentPocess\Entities
 * @author  Elio Martins
 */
class ShoppingProducts extends Model
{
    /**
     * Tables
     *
     * @var string
     */
    protected $table = 'shopping_products';

    /**
     * Primary key
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = ['id_shopping', 'id_product', 'quantity', 'unit_cost', 'subtotal'];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var bool
     */
    public $incrementing = true;

}
