<?php

namespace App\Services;
use App\Models\Account;
use Auth;

class updateAccountService
{
    private $amount;

    public function __construct($amount = null)
    {
        $this->amount = $amount / 100;
    }

    public function run()
    {
        return $this->updateAccount();
    }

    protected function updateAccount()
    {
        $user = Auth::user();
        $prev_balance = $user->Accounts->sum('credit') - $user->Accounts->sum('debit');
        $new_balance = $prev_balance + $this->amount;
        $account = Account::create([
            'user_id' => $user->id,
            'balance' => $new_balance,
            'credit' => $this->amount,
            'credit_detail_id' => 1,
        ]);
        //$user->accounts()->save($account);
        return $account;
    }
}
