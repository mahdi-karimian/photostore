<?php

namespace App\Services\Payment\Providers;

use App\Services\Payment\Contracts\AbstractProviderInterface;
use App\Services\Payment\Contracts\PayableInterface;
use App\Services\Payment\Contracts\VerifiableInterface;

class IDPayProvider extends AbstractProviderInterface implements PayableInterface, VerifiableInterface
{
    public function pay()
    {

        $params = array(
            'order_id' => '101',
            'amount' => 10000,
            'name' => 'قاسم رادمان',
            'phone' => '09382198592',
            'mail' => 'my@site.com',
            'desc' => 'توضیحات پرداخت کننده',
            'callback' => 'https://example.com/callback',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.idpay.ir/v1.1/payment');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'X-API-KEY: 6a7f99eb-7c20-4412-a972-6dfb7cd253a4',
            'X-SANDBOX: 1'
        ));

        $result = curl_exec($ch);
        curl_close($ch);

        var_dump($result);
    }

    public function verify()
    {

    }
}
