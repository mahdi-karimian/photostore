<?php

namespace App\Services\Payment;

use App\Services\Payment\Contracts\RequestInterface;
use App\Services\Payment\Exeptions\ProviderNotFoundException;

class PaymentService
{
    public const IDPAY = 'IDPayProvider';
    public const ZARINPAL = 'ZARINPALProvider';


    public function __construct(private string $providerName, private RequestInterface $request)
    {

    }

    public function pay()
    {
        return $this->findProvider()->pay();
    }

//    /**
//     * @throws ProviderNotFoundException
//     */
    private function findProvider()
    {
        $className = 'App\\Services\\Payment\\Requests\\' . $this->providerName;
        if (!class_exists($className)) {
            throw new ProviderNotFoundException('درگاه پرداخت انتخاب شده یافت نشد');
        }
        return new $className($this->request);
    }
}


