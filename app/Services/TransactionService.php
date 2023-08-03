<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\User;

class TransactionService
{
    /**
     * Create a new transaction and update the user's balance.
     *
     * @param User $user
     * @param integer $amount
     * @param string $description
     * @return Transaction
     */
    public function createTransaction(User $user, float $amount, string $description): Transaction
    {
        $transaction = Transaction::create([
            'user_id' => $user->getKey(),
            'amount' => $amount,
            'description' => $description,
        ]);

        $user->balance += $amount;
        $user->save();

        return $transaction;
    }

    /**
     * Delete a transaction and update the user's balance.
     *
     * @param Transaction $transaction
     * @return Transaction
     */
    public function deleteTransaction(Transaction $transaction): Transaction
    {
        $user = $transaction->user;
        $user->balance -= $transaction->amount;
        $user->save();

        $transaction->delete();
        return $transaction;
    }
}
