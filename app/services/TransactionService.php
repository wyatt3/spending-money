<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\User;

class TransactionService
{
    public function createTransaction(User $user, int $amount): Transaction
    {
        $transaction = Transaction::create([
            'user_id' => $user->getKey(),
            'amount' => $amount,
        ]);

        $user->balance += $amount;
        $user->save();

        return $transaction;
    }

    public function deleteTransaction(Transaction $transaction): void
    {
        $user = $transaction->user;
        $user->balance -= $transaction->amount;
        $user->save();

        $transaction->delete();
    }
}
