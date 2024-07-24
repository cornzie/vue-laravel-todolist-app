<?php

namespace App\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use RuntimeException;

/**
 * Class ApiResponse
 * Handles the structure and creation of API responses.
 */
class ApiResponse implements Responsable
{
    /**
     * @throws RuntimeException
     */
    public function __construct(
        protected int $code,
        protected array $data = [],
        protected string $message = '',
        protected array $headers = []
    ) {
        if (! (($code >= 200 && $code <= 300) || ($code >= 400 && $code <= 600))) {
            throw new RuntimeException("{$code} is not a valid HTTP code");
        }
    }

    /**
     * Creates the JsonResponse for the current request.
     */
    public function toResponse($request): JsonResponse
    {
        $payload = match (true) {
            $this->code >= 500 => ['error_message' => 'Internal server error'],
            $this->code >= 400 => ['error_message' => $this->message],
            $this->code >= 200 => ['data' => $this->data],
            default => ['error_message' => 'Unknown error']
        };

        $response = response()->json(
            data: $payload,
            status: $this->code,
            options: JSON_UNESCAPED_UNICODE
        );

        foreach ($this->headers as $key => $value) {
            $response->header($key, $value);
        }

        return $response;
    }

    /**
     * Factory method to create an instance of the current class.
     */
    protected static function createInstance(int $code, array $data = [], string $message = '', array $headers = []): self
    {
        return new self($code, $data, $message, $headers);
    }

    /**
     * Creates a 200 OK response.
     */
    public static function ok(array $data, array $headers = []): self
    {
        return self::createInstance(code: 200, data: $data, headers: $headers);
    }

    /**
     * Creates a 201 Created response.
     */
    public static function created(array $data, array $headers = []): self
    {
        return self::createInstance(code: 201, data: $data, headers: $headers);
    }

    /**
     * Creates a 204 No Content response.
     */
    public static function noContent(array $headers = []): self
    {
        return self::createInstance(code: 204, headers: $headers);
    }

    /**
     * Creates a 401 Unauthorized response.
     */
    public static function unauthorized(string $message = 'Unauthorized', array $headers = []): self
    {
        return self::createInstance(code: 401, message: $message, headers: $headers);
    }

    /**
     * Creates a 403 Forbidden response.
     */
    public static function forbidden(string $message = 'Forbidden', array $headers = []): self
    {
        return self::createInstance(code: 403, message: $message, headers: $headers);
    }

    /**
     * Creates a 404 Not Found response.
     */
    public static function notFound(string $message = 'Item not found', array $headers = []): self
    {
        return self::createInstance(404, message: $message, headers: $headers);
    }

    /**
     * Creates a 500 internal server error.
     */
    public static function serverError(string $message = 'Server error', array $headers = []): self
    {
        return self::createInstance(500, message: $message, headers: $headers);
    }
}
