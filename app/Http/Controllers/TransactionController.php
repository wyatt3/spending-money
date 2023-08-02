<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Facades\App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Get all transactions grouped by user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTransactions(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json(Transaction::orderBy('created_at', 'DESC')->get()->groupBy('user_id'));
    }

    /**
     * Add a new transaction.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addTransaction(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'amount' => 'required|numeric',
            'description' => 'required|string',
        ]);

        return response()->json(TransactionService::createTransaction(Auth::user(), $request->amount, $request->description));
    }

    /**
     * Delete a transaction.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteTransaction(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'id' => 'required|numeric|exists:transactions,id',
        ]);

        $transaction = TransactionService::deleteTransaction(Transaction::find($request->id));

        return response()->json($transaction);
    }
}
