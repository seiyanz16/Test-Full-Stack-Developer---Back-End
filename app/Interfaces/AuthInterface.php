<?php

namespace App\Interfaces;

use App\Http\Requests\Requests\AuthRequest;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

interface AuthInterface
{
    public function register(AuthRequest $request);
    public function login(AuthRequest $request);
    public function logout(Request $request);
}
