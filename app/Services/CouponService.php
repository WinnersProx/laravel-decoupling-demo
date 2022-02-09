<?php


namespace App\Services;


class CouponService
{

    private $coupon;

    public function __construct()
    {
        $this->coupon = config('payment.coupon');
    }

    /**
     * @param float $productPrice
     */
    public function applyCouponDiscount(float $productPrice)
    {
        if (!$this->coupon['enabled']) return $productPrice;

        return $productPrice - ($productPrice * $this->coupon['value']);
    }
}
