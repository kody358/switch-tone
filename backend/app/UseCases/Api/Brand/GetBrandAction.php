<?php

namespace App\UseCases\Api\Brand;

use App\Models\Brand;
use App\UseCases\Api\Brand\Models\GetBrandInput;
use App\UseCases\Api\Brand\Models\GetBrandOutput;

class GetBrandAction
{
    /**
     * 指定されたブランドを取得
     */
    public function __invoke(GetBrandInput $input): GetBrandOutput
    {
        // スラッグまたはIDで検索
        $brand = is_numeric($input->slugOrId) 
            ? Brand::findOrFail($input->slugOrId)
            : Brand::where('slug', $input->slugOrId)->firstOrFail();

        return new GetBrandOutput(
            brand: $brand,
            message: 'ブランド詳細を取得しました'
        );
    }
} 