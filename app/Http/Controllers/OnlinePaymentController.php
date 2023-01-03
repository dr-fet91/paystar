<?php

namespace App\Http\Controllers;

use App\Http\Services\Payments\Paystar\Paystar;
use App\Models\OnlinePayment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Inertia\Inertia;
use Exception;

class OnlinePaymentController extends Controller
{

    public $payment, $gateway;
    public function __construct(Request $request = null)
    {
        $tmp = null;
        if ($request->gateway) {
            $tmp = $request->gateway;
        } elseif ($request->order_id) {
            $payment = OnlinePayment::where('order_id', $request->order_id)->first();
            $tmp = $payment->gateway;
        }
        switch ($tmp) {
            case 'paystar':
                $this->payment = new Paystar();
                $this->gateway = 'paystar';
                break;

            default:
                # code...
                break;
        }
    }

    public function pay(Request $request)
    {
        $user = auth()->user();
        try {
            $order = $user->orders()->where('order_status', 0)->first();
            $result = json_decode($this->payment->get_token($order->amount, $order->id), 1);

            $pay = OnlinePayment::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'order_id' => $order->id,
                    'status' => 1,
                ],
                [
                    'user_id' => $user->id,
                    'order_id' => $order->id,
                    'amount' => $order->amount,
                    'gateway' => $this->gateway,
                    'status' => $result['status'] ? 1 : 2,
                    'bank_first_response' => $result,
                ],
            );
            if (!$result['status'] || @$result['data']['payment_amount'] != $order->amount) {
                throw new Exception("Error Processing Request", $result['status']);
            }
            return redirect(route('online.payment.final-approval'));
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('مشکلی در سفارش وجود دارد لطفا پس از بررسی اطلاعات مجدد تلاش نمایید.');
        }
    }

    public function finalApproval()
    {

        $user = auth()->user();
        $order = $user->orders()->where('order_status', 0)->first();
        $payment = OnlinePayment::where(['order_id' => $order->id, 'status' => 1])->first();
        return Inertia::render('Market/Product/FinalApproval', [
            'order' => $order,
            'gateway' => @$payment->gateway,
            'token' => @$payment->bank_first_response['data']['token'],
            'BankUrl' => Config::get("$payment->gateway.PAYMENT_ADDRESS"),
        ]);
    }

    public function callBack(Request $request)
    {
        try {
            $user = auth()->user();
            $order = $user->orders()->where('order_status', 0)->first();
            $status = $request->status;
            $payment = OnlinePayment::where(['user_id' => $user->id, 'order_id' => $order->id, 'status' => 1])->first();
            $data = $payment->toArray();
            $message = '';
            $error = '';

            if ($status == 1) {
                $verify = json_decode($this->payment->verify($order->amount, $request->ref_num, $request->card_number, $request->tracking_code), 1);
                $data['bank_second_response'] = $verify;
                if ($verify['data']['price'] == $order->amount) {
                    $data['status'] = 3;
                    $message = @$this->payment->paystarResponseCode[$request->status];
                } else {
                    $data['status'] = 2;
                    $message = 'پرداخت ناموفق';
                }
            } else {
                $data['status'] = 2;
                $message = @$this->payment->paystarResponseCode[$request->status];;
                $data['bank_second_response'] = $request->all();
            }
            $data['transaction_id'] = $request->transaction_id;
            $data['tracking_code'] = $request->tracking_code;
            $data['card_number'] = $request->card_number;
           
            $payment->update($data);
        } catch (\Throwable $th) {
            $message = 'خطا در انجام تراکنش';
        }
        return Inertia::render('Market/Product/Results', [
            'order' => $order,
            'gateway' => @$payment->gateway,
            'tracking_code' => @$request->tracking_code,
            'card_number' => @$request->card_number,
            'card_number' => @$request->card_number,
            'message' => $message,
        ]);
    }
}
