<?php

namespace App\UseCases\Api\KeySwitch;

use App\Models\KeySwitch;
use App\UseCases\Api\KeySwitch\Models\GetKeySwitchesInput;
use App\UseCases\Api\KeySwitch\Models\GetKeySwitchesOutput;

class GetKeySwitchesAction
{
    /**
     * キーボードスイッチ一覧を取得
     */
    public function __invoke(GetKeySwitchesInput $input): GetKeySwitchesOutput
    {
        $query = KeySwitch::active()->with('brand');

        // 検索機能
        if (!empty($input->search)) {
            $query->where(function ($q) use ($input) {
                $q->where('name', 'ILIKE', "%{$input->search}%")
                  ->orWhereHas('brand', function ($brandQuery) use ($input) {
                      $brandQuery->where('name', 'ILIKE', "%{$input->search}%");
                  });
            });
        }

        // タイプフィルター
        if (!empty($input->types)) {
            $query->whereIn('type', $input->types);
        }

        // ブランドフィルター
        if (!empty($input->brands)) {
            $query->whereHas('brand', function ($brandQuery) use ($input) {
                $brandQuery->whereIn('slug', $input->brands);
            });
        }

        // 価格フィルター
        if (!empty($input->priceFilters)) {
            $query->where(function ($q) use ($input) {
                foreach ($input->priceFilters as $priceFilter) {
                    switch ($priceFilter) {
                        case 'budget':
                            $q->orWhere('price', '<=', 50000); // 500円以下
                            break;
                        case 'mid-range':
                            $q->orWhereBetween('price', [50001, 100000]); // 500-1000円
                            break;
                        case 'premium':
                            $q->orWhere('price', '>', 100000); // 1000円以上
                            break;
                    }
                }
            });
        }

        // ソート
        if (in_array($input->sortBy, ['name', 'price', 'created_at'])) {
            $query->orderBy($input->sortBy, $input->sortOrder);
        } else {
            $query->orderBy('name', 'asc');
        }

        $switches = $query->get();
        $count = $switches->count();

        return new GetKeySwitchesOutput(
            switches: $switches,
            count: $count,
            message: "キーボードスイッチを{$count}個取得しました"
        );
    }
} 