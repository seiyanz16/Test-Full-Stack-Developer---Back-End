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

    public function respondNotFound(
        string|Exception $message,
        ?string $key = 'error'
    ): JsonResponse {
        return $this->apiResponse(
            data: [$key => get_class($message)],
            message: $this->morphMessage($message),
            code: Response::HTTP_NOT_FOUND,
            status: false
        );
    }

    public function respondUnAuthenticated(?string $message = null): JsonResponse
    {
        return $this->apiResponse(
            data: ['error' => 'Unauthenticated'],
            message: $message ?? 'Unauthenticated',
            code: Response::HTTP_UNAUTHORIZED,
            status: false
        );
    }

    public function respondForbidden(?string $message = null): JsonResponse
    {
        return $this->apiResponse(
            data: ['error' => $message ?? 'Forbidden'],
            code: Response::HTTP_FORBIDDEN,
            status: false
        );
    }

    public function respondError(?string $message = null): JsonResponse
    {
        return $this->apiResponse(
            data: ['error' => $message ?? 'Error'],
            code: Response::HTTP_BAD_REQUEST,
            status: false
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

    public function respondNoContent(
        array|Arrayable|JsonSerializable|null $data = null
    ): JsonResponse {
        $data ??= [];
        $data = $this->morphToArray(data: $data);

        return $this->apiResponse(
            data: $data,
            code: Response::HTTP_NO_CONTENT,
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
