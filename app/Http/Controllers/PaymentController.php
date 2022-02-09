<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    private $paymentService;

    public function __construct()
    {
        $this->paymentService = new PaymentService();
    }

    public function processPayment(Request $request)
    {
        $this->paymentService
            ->setProductPrice(1600)
            ->computeNetAmount();

        return view('welcome', [
            'netAmount' => $this->paymentService->netAmount,
            'productPrice' => $this->paymentService->productPrice,
            'transactionFees' => $this->paymentService->transactionFees,
        ]);
    }
}
