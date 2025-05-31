<?php

namespace App\Interfaces;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;

interface TransactionInterface
{
    public function index(Request $request);
    public function store(StoreTransactionRequest $request);
    public function edit(string $id);
    public function update(UpdateTransactionRequest $request, string $id);
    public function destroy(string $id);
}
