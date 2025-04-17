<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\User;

class TransactionService
{
    /**
     * Create a new transaction.
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

        return $transaction;
    }

    /**
     * Delete a transaction.
     *
     * @param Transaction $transaction
     * @return Transaction
     */
    public function deleteTransaction(Transaction $transaction): Transaction
    {
        $transaction->delete();
        return $transaction;
    }
}
