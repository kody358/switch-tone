<?php

if (!function_exists('responseSuccess')) {
    /**
     * 成功レスポンスを返すヘルパー関数
     */
    function responseSuccess($data = null, string $message = '', int $statusCode = 200)
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($response, $statusCode);
    }
}

if (!function_exists('responseError')) {
    /**
     * エラーレスポンスを返すヘルパー関数
     */
    function responseError(string $message = 'エラーが発生しました', $errors = null, int $statusCode = 400)
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }
}

if (!function_exists('error')) {
    /**
     * エラーログを出力するヘルパー関数
     */
    function error($message, array $context = [])
    {
        \Log::error($message, $context);
    }
}

if (!function_exists('alert')) {
    /**
     * アラートログを出力するヘルパー関数
     */
    function alert($message, array $context = [])
    {
        \Log::alert($message, $context);
    }
} 