<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Payment\PaymentService;
use App\Services\Payment\Requests\IDPayRequest;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function pay()
    {
        $user = User::first();
        $IDPayRequest = new IDPayRequest([
            'amount'=>100,
            'user'=> $user,
        ]);
       $paymentService = new PaymentService(PaymentService::IDPAY,$IDPayRequest);
       $paymentService->pay() ;
    }
}
