<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Facades\App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function getTransactions(Request $request)
    {
        return response()->json(Transaction::all()->groupBy('user_id'));
    }

    public function addTransaction(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'description' => 'required|string',
        ]);

        return TransactionService::createTransaction(Auth::user(), $request->amount, $request->description);
    }

    public function deleteTransaction(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric|exists:transactions,id',
        ]);

        $transaction = Transaction::find($request->id);

        TransactionService::deleteTransaction($transaction);

        return response()->json($transaction);
    }
}
