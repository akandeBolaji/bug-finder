<?php

namespace App\Services;
use App\Models\Fund;
use Auth;

class StoreFundService
{
    private $amount;

    private $transaction_code;

    private $reference;

    public function __construct($amount = null, $transaction_code = null, $reference = null)
    {
        $this->amount = $amount;
        $this->transaction_code = $transaction_code;
        $this->reference = $reference;
    }

    public function run()
    {
        return $this->createFund();
    }

    protected function createFund()
    {
        $user = Auth::user();
        $fund = Fund::create([
            'user_id' => $user->id,
            'amount' => $this->amount,
            'email' => $user->email,
            'phone' => $user->phone,
            'reference' => $this->reference,
            'trans' => $this->transaction_code
        ]);
        // $user->funds()->save($fund);
        return $fund;
    }
}
