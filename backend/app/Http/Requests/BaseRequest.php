<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{
    /**バリデーションルールを定義して返す
     * 
     * return array<string, string|string[]|array>
     */
    abstract public function rules(): array;

    /**
     * カンマ区切りで渡された配列パラメーターを配列にして返す
     *
     * @param mixed $value
     * @return string[]
     */
    protected function paramtoArray(mixed $value): array
    {
        return (is_string($value) && $value) ? explode(',', $value) : [];
    }

}