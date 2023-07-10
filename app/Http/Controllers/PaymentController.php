<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Braintree\Gateway;
use App\Models\User;
use Illuminate\Support\Carbon;
use App\Models\Doctor;
use Braintree\ClientToken;
use Braintree\Configuration;
use Illuminate\Support\Facades\Auth;




class PaymentController extends Controller
{

    public function initialize() {

        Configuration::environment(env('BRAINTREE_ENV'));
        Configuration::merchantId(env('BRAINTREE_MERCHANT_ID'));
        Configuration::publicKey(env('BRAINTREE_PUBLIC_KEY'));
        Configuration::privateKey(env('BRAINTREE_PRIVATE_KEY'));

        $token = ClientToken::generate();
        return response()->json(['token' => $token]);
    }

    public function process(Request $request) {

        $gateway = new Gateway([
            'environment' => env('BRAINTREE_ENV'),
            'merchantId' => env('BRAINTREE_MERCHANT_ID'),
            'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
            'privateKey' => env('BRAINTREE_PRIVATE_KEY')
        ]);


        $result = $gateway->transaction()->sale([
            'amount' => $request->amount,
            'paymentMethodNonce' => $request->payment_method_nonce,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        if ($result->success) {
            $loggedID = Auth::user()->id;
            $doctor = Doctor::where('user_id', $loggedID)->first();
            $sub = $request->subscription;

            $doctor->subscriptions()->attach($sub, ['end_date' => Carbon::now()->addDays($sub->days_duration)]);



            return response()->json(['success' => true]);

        }
        else {
            return response()->json(['success' => false]);

        }
    }
}
