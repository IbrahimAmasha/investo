<?php

namespace App\Helpers;

function Successful($status, $message, $data = null, $code = 200)
{
    return response()->json([
        'status' => $status,
        'message' => $message,
        'data' => $data,
    ], $code);
}

function Error($message = "", $code = 404, $data = null)
{
    $response = [
        'status' => $code,
        'message' => $message,
        'data' => $data,
    ];
    return response()->json($response);
}
