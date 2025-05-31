<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Interfaces\TransactionInterface;
use App\Traits\ApiResponsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    use ApiResponsable;

    public function __construct(private TransactionInterface $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function index(Request $request) : JsonResponse
    {
        return $this->respondWithSuccess($this->transactionService->index($request), 'Success');
    }

    public function store(StoreTransactionRequest $request)
    {
        return $this->respondWithSuccess($this->transactionService->store($request), 'Success');
    }

    public function edit(string $id)
    {
        return $this->respondWithSuccess($this->transactionService->edit($id), 'Success');
    }

    public function update(UpdateTransactionRequest $request, string $id)
    {
        return $this->respondWithSuccess($this->transactionService->update($request, $id), 'Transaction updated successfully');
    }
}
