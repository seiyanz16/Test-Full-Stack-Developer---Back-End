<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use App\Traits\ApiResponsable;

class Handler extends ExceptionHandler
{
    use ApiResponsable;
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (\Throwable $e) {
            // Log::error($e);
            return $this->apiResponse(
                data: [
                    'status_code' => $e->getCode(),
                    'exception' => get_class($e),
                ],
                code: 500,
                message: $e->getMessage(),
                status: false
            );
        });
    }

    private function checkValidStatusCode($status_code)
    {
        return $status_code >= 100 && $status_code <= 599 ? $status_code :  500;
    }
}