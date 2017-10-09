<?php

namespace AK8\PaymentMethods\Enums;

/**
 * Static class for the payment status
 *
 * @package app\PaymentProcess\Enums
 * @author  Elio Martins
 */
class PaymentStatus
{
    /**
     * @var int
     */
    public static $approved = 1;

    /**
     * @var int
     */
    public static $rejected = 2;

    /**
     * @var int
     */
    public static $pending = 3;

    /**
     * @var int
     */
    public static $error = 4;

}
