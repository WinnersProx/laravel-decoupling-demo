<?php


namespace App\Services;


class PaymentService
{

    /**
     * @var float the net amount
     */
    public float $netAmount;

    public float $productPrice;

    public float $vat;

    public float $transactionFees;

    public array $discount;


    public function __construct()
    {
        $this->discount = config('payment.discount');
        $this->vat = config('payment.vat');
        $this->transactionFees = config('payment.transaction_fees');
    }

    public function setProductPrice($productPrice)
    {
        $this->productPrice = $productPrice;

        return $this;
    }

    /**
     * Process the payments
     */
    public function computeNetAmount()
    {

        $this->netAmount = (new CouponService())
            ->applyCouponDiscount($this->productPrice);

        $this->applyTransactionFees()
            ->applyMembershipDiscount();

        $this->applyVat();

        return $this->netAmount;
    }

    public function applyMembershipDiscount()
    {
        if ($this->discount['enabled']) {
            $this->netAmount -= ($this->netAmount * $this->discount['value']);
        }

        return $this;
    }

    public function applyTransactionFees()
    {
        if ($this->transactionFees) {
            $this->netAmount += $this->transactionFees;
        }

        return $this;
    }

    public function applyVat()
    {
        if ($this->vat) {
            $this->netAmount += ($this->netAmount * $this->vat);
        }

        return $this;
    }
}
