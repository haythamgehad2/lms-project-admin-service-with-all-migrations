<?php

namespace App\Helpers;
class ReturnData
{
    /**
     * Create return data for ApiResponse
     */
    public static function create(array $errors, int $code, $data = null,  $message =null,$meta =null ): array
    {
        return [
            'errors' => $errors,
            'code' => $code,
            'data' => $data,
            'messages' => $message,
            'meta' => $meta,
        ];
    }
}
