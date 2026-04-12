<?php

use Illuminate\Support\Facades\Log;

if (!function_exists('newrelic_notice')) {
    function newrelic_notice(\Throwable $e): void
    {
        $arrErr = [
            'msg' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
            'code' => $e->getCode()
        ];
        Log::notice('Warning erro: ', $arrErr);
    }
}

if (!function_exists('newrelic_notice_error')) {
    function newrelic_notice_error(\Throwable $e): void
    {
        $arrErr = [
            'msg' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
            'code' => $e->getCode()
        ];
        Log::error('Warning erro: ', $arrErr);
    }
}

if (!function_exists('newrelic_name_transaction')) {
    function newrelic_name_transaction(string $name): void
    {
        Log::info('Transaction newrelic: '. $name);
    }
}

if (!function_exists('newrelic_add_custom_parameter')) {
    function newrelic_add_custom_parameter(string $atribute, string $value): void
    {
        Log::info('Add custom parameter: ', [
            'atribute' => $atribute,
            'value' => $value,
        ]);
    }
}
