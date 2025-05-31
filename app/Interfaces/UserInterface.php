<?php

namespace App\Interfaces;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;

interface UserInterface
{
    public function index(Request $request);
    public function store(StoreUserRequest $request);
    public function edit(string $id);
    public function update(UpdateUserRequest $request, string $id);
    public function destroy(string $id);
}
