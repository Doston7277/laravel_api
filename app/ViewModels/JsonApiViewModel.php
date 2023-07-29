<?php

namespace App\ViewModels;

use Illuminate\Contracts\Support\{Jsonable, Responsable};
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JsonApiViewModel implements Jsonable, Responsable
{
    public function __construct(
        protected ?string $message,
        protected mixed $result,
        protected int $code = 200,
        protected bool $success = true,
    ) {
    }

    /**
     * @param string $message
     * @param int $code
     *
     * @return self
     */
    public static function getErrorResponse(string $message, int $code): JsonApiViewModel
    {
        return new self($message, null, $code, false);
    }

    /**
     * @param mixed $result
     *
     * @return JsonApiViewModel
     */
    public static function getSuccessResponse(mixed $result): JsonApiViewModel
    {
        return new self(null, $result, 200, true);
    }

    /**
     * @param $options
     *
     * @return bool|string
     */
    public function toJson($options = 0): bool|string
    {
        if ($this->success) {
            $response = [
                'success' => $this->success,
                'result'  => $this->result,
            ];
        } else {
            $response = [
                'success' => $this->success,
                "error"   => [
                    'code'    => $this->code,
                    'message' => $this->message,
                ],
            ];
        }

        return json_encode($response);
    }

    public function toResponse($request): JsonResponse|Response
    {
        return response()->json($this);
    }
}
