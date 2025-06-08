<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\GetKeySwitchesRequest;
use App\Http\Requests\Api\V1\GetKeySwitchRequest;
use App\Http\Resources\KeySwitchResource;
use App\Models\KeySwitch;
use App\UseCases\Api\KeySwitch\GetKeySwitchesAction;
use App\UseCases\Api\KeySwitch\Models\GetKeySwitchesInput;

class KeySwitchController extends Controller
{
    public function __construct(
        private readonly GetKeySwitchesAction $getKeySwitchesAction,
    ) {}

    /**
     * キーボードスイッチ一覧を取得（検索・フィルタリング機能付き）
     */
    public function index(GetKeySwitchesRequest $request)
    {
        $input = new GetKeySwitchesInput(
            search: $request->getSearch(),
            types: $request->getTypes(),
            brands: $request->getBrands(),
            priceFilters: $request->getPriceFilters(),
            sortBy: $request->getSortBy(),
            sortOrder: $request->getSortOrder(),
        );

        $output = ($this->getKeySwitchesAction)($input);

        return responseSuccess(
            KeySwitchResource::collection($output->switches),
            $output->message
        );
    }

    /**
     * 指定されたキーボードスイッチを取得
     */
    public function show(GetKeySwitchRequest $request)
    {
        $switch = KeySwitch::with('brand', 'reviews.user')
            ->findOrFail($request->getId());

        return responseSuccess(
            new KeySwitchResource($switch),
            'キーボードスイッチの詳細を取得しました'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
