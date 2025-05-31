<?php

namespace App\Services;

use App\Exceptions\ModelNotFoundException;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Interfaces\TransactionInterface;
use App\Models\Log;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionService implements TransactionInterface
{
    public function index(Request $request)
    {
        return Transaction::all();
    }

    public function store(StoreTransactionRequest $request)
    {
        $userId = auth('sanctum')->user()->id;
        $payload = $request->validated();

        // Gunakan transaksi database untuk memastikan atomicity
        // Jika ada bagian yang gagal (misal log gagal dibuat), semua akan di-rollback.
        return DB::transaction(function () use ($payload, $userId) {
            // a. Logic Perhitungan Diskon dan Total
            $amount = $payload['amount'];
            $discount = $payload['discount'] ?? 0;

            $discountAmount = ($amount * $discount) / 100;// Default diskon 0 jika tidak ada
            $total = $amount - $discountAmount;

            // Pastikan total tidak negatif jika diskon sangat besar
            if ($total < 0) {
                $total = 0;
            }

            // Gabungkan data perhitungan ke payload
            $payload['amount'] = $amount; // Pastikan amount sudah sesuai
            $payload['discount'] = $discount;
            $payload['total'] = $total;

            $transaction = Transaction::create($payload);

            // b. Simpan semua kegiatan transaksi pada tabel logs
            Log::create([
                'transaction_id' => $transaction->id,
                'user_id' => $userId,
            ]);

            return $transaction;
        });
    }

    public function edit(string $id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            throw new ModelNotFoundException("Transaction not found.");
        }
        return $transaction;
    }

    public function update(UpdateTransactionRequest $request, string $id)
    {
        $userId = auth('sanctum')->user()->id;
        $payload = $request->validated();

        return DB::transaction(function () use ($payload, $id, $userId) {
            $transaction = Transaction::find($id);

            if (!$transaction) {
                throw new ModelNotFoundException("Transaction not found.");
            }

            $amount = $payload['amount'] ?? $transaction->amount;
            $discount = $payload['discount'] ??  ($transaction->discount / $transaction->amount * 100);

            $discountAmount = ($amount * $discount) / 100;
            $total = $amount - $discountAmount;

            if ($total < 0) {
                $total = 0;
            }

            $payload['amount'] = $amount;
            $payload['discount'] = $discount;
            $payload['total'] = $total;
            $payload['note'] = $payload['note'] ?? $transaction->note;

            $transaction->update($payload);

            Log::create([
                'transaction_id' => $transaction->id,
                'user_id' => $userId,
            ]);

            return $transaction;
        });
    }

    public function destroy(string $id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            throw new ModelNotFoundException("Transaction not found.");
        }

        $transaction->delete();

        return $transaction;
    }
}