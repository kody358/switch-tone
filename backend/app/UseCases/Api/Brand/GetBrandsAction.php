<?php

namespace App\UseCases\Api\Brand;

use App\Models\Brand;
use App\UseCases\Api\Brand\Models\GetBrandsInput;
use App\UseCases\Api\Brand\Models\GetBrandsOutput;

class GetBrandsAction
{
    /**
     * ブランド一覧を取得
     */
    public function __invoke(GetBrandsInput $input): GetBrandsOutput
    {
        $query = Brand::active();

        // ソート処理
        if (in_array($input->sortBy, ['name', 'created_at'])) {
            $query->orderBy($input->sortBy, $input->sortOrder);
        } else {
            $query->orderBy('name', 'asc');
        }

        $brands = $query->get();

        return new GetBrandsOutput(
            brands: $brands,
            message: 'ブランド一覧を取得しました'
        );
    }
} 