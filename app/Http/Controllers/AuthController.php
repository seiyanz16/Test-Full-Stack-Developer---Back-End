<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Interfaces\AuthInterface;
use App\Traits\ApiResponsable;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponsable;

    public function __construct(private AuthInterface $authService)
    {
        $this->authService = $authService;
    }

    public function register(AuthRequest $request)
    {
        $data = $this->authService->register($request);
        return $this->respondWithSuccess($data, 'Successfully registered');
    }

    public function login(AuthRequest $request)
    {
        $data = $this->authService->login($request);
        return $this->respondWithSuccess($data, 'Successfully logged in');
    }

    public function me(Request $request)
    {
        $data = $this->authService->me($request);
        return $this->respondWithSuccess($data, 'Successfully logged in');
    }

    public function logout(Request $request)
    {
        $data = $this->authService->logout($request);
        return $this->respondWithSuccess($data, 'Successfully signed out');
    }
}
