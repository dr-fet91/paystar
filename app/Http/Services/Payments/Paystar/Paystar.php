<?php

namespace App\Http\Services\Payments\Paystar;

use App\Http\Services\Payments\PaymentInterface;
use Illuminate\Support\Facades\Config;
use PhpParser\Builder\Function_;
use PhpParser\Node\Expr\FuncCall;

class Paystar
{
    public $paystarResponseCode = [
        1 => 'موفق',
        -1 => 'درخواست نامعتبر (خطا در پارامترهای ورودی)',
        -2 => 'درگاه فعال نیست',
        -3 => 'توکن تکراری است',
        -4 => 'مبلغ بیشتر از سقف مجاز درگاه است',
        -5 => 'شناسه ref_num معتبر نیست',
        -6 => 'تراکنش قبلا وریفای شده است',
        -7 => 'پارامترهای ارسال شده نامعتبر است',
        -8 => 'تراکنش را نمیتوان وریفای کرد',
        -9 => 'تراکنش وریفای نشد',
        -98 => 'تراکنش ناموفق',
        -99 => 'خطای سامانه',
    ];

    public function get_token(int $amount, $order_id)
    {
        $callbackAddress = Config::get('paystar.CALLBACK_URL');
        $data = [
            'amount' => $amount,
            'callback_method' => 1,
            'order_id' => $order_id,
            'callback' => Config::get('paystar.CALLBACK_URL'),
            'sign' => hash_hmac('sha512', "$amount#$order_id#$callbackAddress", Config::get('paystar.KEY')),
        ];
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://core.paystar.ir/api/pardakht/create',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),

            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . Config::get('paystar.GATEWAY_ID'),
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
    public function verify(int $amount, $ref_num, $card_number, $tracking_code)
    {
        $callbackAddress = Config::get('paystar.CALLBACK_URL');
        $data = [
            'amount' => $amount,
            'ref_num' => $ref_num,
            'sign' => hash_hmac('sha512', "$amount#$ref_num#$card_number#$tracking_code", Config::get('paystar.KEY')),
        ];
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://core.paystar.ir/api/pardakht/verify',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),

            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . Config::get('paystar.GATEWAY_ID'),
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

}
