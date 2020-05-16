<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentStoreRequest;
use App\Http\Requests\PaystackRequest;
use App\Services\StoreFundService;
use App\Services\UpdateAccountService;
use Paystack;

class FundController extends Controller
{
    private $storeFundService;

    private $updateAccountService;

    public function __construct(StoreFundService $storeFundService, UpdateAccountService $updateAccountService)
    {
        $this->middleware('auth');
        $this->storeFundService = $storeFundService;
        $this->updateAccountService = $updateAccountService;
    }

    public function postPaystack(PaymentStoreRequest $request)
    {
        $storeFund = (new StoreFundService($request->amount/100, $request->trans, $request->reference))->run();
        $updateAccount = (new updateAccountService($request->amount/100))->run();
    }

     /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway(PaystackRequest $request)
    {
        request()->amount = request()->amount * 100;
        return Paystack::getAuthorizationUrl()->redirectNow();
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        $paymentDetails = Paystack::getPaymentData();
        $amount = $paymentDetails['data']['amount']/100;
        $id = $paymentDetails['data']['id'];
        $reference = $paymentDetails['data']['reference'];
        $storeFund = (new StoreFundService($amount, $id, $reference))->run();
        $updateAccount = (new updateAccountService($amount))->run();
        return redirect('home')->with('status', 'Fund Successful!');
        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
    }
}
