<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentStoreRequest;
use App\Services\StoreFundService;
use App\Services\UpdateAccountService;

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
        $storeFund = (new StoreFundService($request->amount, $request->trans, $request->reference))->run();
        $updateAccount = (new updateAccountService($request->amount))->run();
    }
}
