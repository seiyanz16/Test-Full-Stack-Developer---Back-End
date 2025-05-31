<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException as Exception;
use App\Traits\ApiResponsable;
use Illuminate\Http\Request;

class AuthenticationException extends Exception
{
    use ApiResponsable;
    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request)
    {
        return $this->respondUnAuthenticated($this->getMessage());
    }
}