<?php

namespace App\Helpers;

/**
 * Format response.
 */
class ResponseFormatter
{
    /**
     * API Response
     *
     * @var array
     */
    protected static $response = [
        'meta' => [
            'code' => 0,
            'status' => 'success',
            'message' => null,
        ],
        'data' => null,
        'total_data' => null
    ];

    /**
     * Give success response.
     */
    public static function success($data = null, $message = null, $total_data = null)
    {
        self::$response['meta']['message'] = $message;
        self::$response['data'] = $data;
        self::$response['total_data'] = $total_data;

        return response()->json(self::$response);
    }

    /**
     * Give error response.
     */
    public static function error($data = null, $message = null, $code = 99)
    {
        self::$response['meta']['status'] = 'error';
        self::$response['meta']['code'] = $code;
        self::$response['meta']['message'] = $message;
        self::$response['data'] = $data;

        return response()->json(self::$response);
    }
}
