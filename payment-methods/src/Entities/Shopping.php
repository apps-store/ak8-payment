<?php

namespace AK8\PaymentMethods\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Shopping
 *
 * Entity to manage the data of Shopping table
 *
 * @package App\PaymentPocess\Entities
 * @author  Elio Martins
 */
class Shopping extends Model
{
    /**
     * Tables
     *
     * @var string
     */
    protected $table = 'shopping';

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
    protected $fillable = ['id_user', 'id_status_shopping'];

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @var bool
     */
    public $incrementing = true;

}
