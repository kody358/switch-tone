<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\GetBrandsRequest;
use App\Http\Requests\Api\V1\GetBrandRequest;
use App\Http\Resources\BrandResource;
use App\Http\Resources\KeySwitchResource;
use App\Models\Brand;
use App\UseCases\Api\Brand\GetBrandsAction;
use App\UseCases\Api\Brand\GetBrandAction;
use App\UseCases\Api\Brand\Models\GetBrandsInput;
use App\UseCases\Api\Brand\Models\GetBrandInput;

class BrandController extends Controller
{
    public function __construct(
        private readonly GetBrandsAction $getBrandsAction,
        private readonly GetBrandAction $getBrandAction,
    ) {}

    /**
     * ブランド一覧を取得
     */
    public function index(GetBrandsRequest $request)
    {
        $input = new GetBrandsInput(
            sortBy: $request->getSortBy(),
            sortOrder: $request->getSortOrder(),
        );

        $output = ($this->getBrandsAction)($input);

        return responseSuccess(
            BrandResource::collection($output->brands),
            $output->message
        );
    }

    /**
     * 指定されたブランドを取得
     */
    public function show(GetBrandRequest $request)
    {
        $input = new GetBrandInput(
            slugOrId: $request->getSlugOrId(),
        );

        $output = ($this->getBrandAction)($input);

        return responseSuccess(
            new BrandResource($output->brand),
            $output->message
        );
    }

    /**
     * 指定されたブランドのキーボードスイッチを取得
     */
    public function switches(GetBrandRequest $request)
    {
        $input = new GetBrandInput(
            slugOrId: $request->getSlugOrId(),
        );

        $brandOutput = ($this->getBrandAction)($input);
        $brand = $brandOutput->brand;

        $switches = $brand->switches()
            ->active()
            ->with('brand') // Eagerロード
            ->orderBy('name')
            ->get();

        return responseSuccess(
            KeySwitchResource::collection($switches),
            "ブランド「{$brand->name}」のキーボードスイッチを取得しました"
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
