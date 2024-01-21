<?php

namespace App\Http\Responses;

use Illuminate\Http\Exceptions\HttpResponseException;

class ApiErrorResponse
{
    public function __construct(string $message, $status = 400, $data = null, $headers = [], $options = 0)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'data'      => [
                'error' => compact('message')
            ]
        ], $status));
    }
}
