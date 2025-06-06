<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class VerifyRequest extends BaseRequest
{
    /**
     * バリデーションルールを定義して返す
     *
     * @return array<string, string|string[]|array>
     */
    public function rules(): array
    {
        return [];
    }
}