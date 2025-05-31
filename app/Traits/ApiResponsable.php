<?php

namespace App\Traits;

use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use JsonSerializable;

trait ApiResponsable
{
    public function respondWithSuccess(
        array|Arrayable|JsonSerializable|null $contents = null,
        string $message = ''
    ): JsonResponse {
        $contents = $this->morphToArray($contents) ?? [];

        $data = [] === $contents
            ? $this->_api_helpers_defaultSuccessData
            : $contents;

        return $this->apiResponse($data, 200, $message);
    }

    public function respondOk(string $message): JsonResponse
    {
        return $this->respondWithSuccess(['success' => $message], 'Ok');
    }

    public function respondNotFound(string|Exception $message, ?string $key = 'error'): JsonResponse
    {
        return $this->apiResponse(
            [$key => get_class($message)],
            $this->morphMessage($message),
            Response::HTTP_NOT_FOUND,
            false
        );
    }

    public function respondUnAuthenticated(?string $message = null): JsonResponse
    {
        return $this->apiResponse(
            ['error' => 'Unauthenticated'],
            $message ?? 'Unauthenticated',
            Response::HTTP_UNAUTHORIZED,
            false
        );
    }

    public function respondForbidden(?string $message = null): JsonResponse
    {
        return $this->apiResponse(
            ['error' => $message ?? 'Forbidden'],
            '',
            Response::HTTP_FORBIDDEN,
            false
        );
    }

    public function respondError(?string $message = null): JsonResponse
    {
        return $this->apiResponse(
            ['error' => $message ?? 'Error'],
            '',
            Response::HTTP_BAD_REQUEST,
            false
        );
    }

    public function respondCreated(array|Arrayable|JsonSerializable|null $data = null): JsonResponse
    {
        return $this->apiResponse(
            $this->morphToArray($data ?? []),
            Response::HTTP_CREATED,
            'Ok Created'
        );
    }

    public function respondFailedValidation(array $message): JsonResponse
    {
        return $this->apiResponse(
            $message,
            Response::HTTP_UNPROCESSABLE_ENTITY,
            'Validation errors',
            false
        );
    }

    public function respondNoContent(array|Arrayable|JsonSerializable|null $data = null): JsonResponse
    {
        return $this->apiResponse(
            $this->morphToArray($data ?? []),
            Response::HTTP_NO_CONTENT
        );
    }

    private function apiResponse(?array $data = null, int $code = 200, string $message = '', bool $status = true): JsonResponse
    {
        return response()->json([
            'success' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    private function morphToArray(array|Arrayable|JsonSerializable|null $data): ?array
    {
        return match (true) {
            $data instanceof Arrayable => $data->toArray(),
            $data instanceof JsonSerializable => $data->jsonSerialize(),
            default => $data,
        };
    }

    private function morphMessage(string|Exception $message): string
    {
        return $message instanceof Exception ? $message->getMessage() : $message;
    }
}
