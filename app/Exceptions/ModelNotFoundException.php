<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException as Exception;
use App\Traits\ApiResponsable;
use Illuminate\Http\Request;

class ModelNotFoundException extends Exception
{
    use ApiResponsable;
    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request)
    {
        return $this->respondNotFound($this);
    }
}