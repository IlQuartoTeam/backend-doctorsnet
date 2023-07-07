<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Braintree\ClientToken;
use Braintree\Configuration;




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
}
