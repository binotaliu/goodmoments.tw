<?php

declare(strict_types=1);

namespace App\Actions;

use App\Http\Requests\ProductCreationRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\Support\Str;

final class FillProductInputsFromRequest
{
    public function __invoke(ProductCreationRequest|ProductUpdateRequest $request, ?Product $product = null): Product
    {
        if ($product === null) {
            $product = new Product();
        }

        $product->slug = Str::slug($request->slug);
        $product->name = [
            'en' => $request->input('name.en'),
            'zh_Hant_TW' => $request->input('name.zh_Hant_TW'),
            'zh_Oan' => $request->input('name.zh_Oan'),
        ];
        $product->price = $request->price;
        $product->unit = [
            'en' => $request->input('unit.en'),
            'zh_Hant_TW' => $request->input('unit.zh_Hant_TW'),
            'zh_Oan' => $request->input('unit.zh_Oan'),
        ];
        $product->description = [
            'en' => $request->input('description.en'),
            'zh_Hant_TW' => $request->input('description.zh_Hant_TW'),
            'zh_Oan' => $request->input('description.zh_Oan'),
        ];

        $product->category_id = $request->route('category')?->id;

        return $product;
    }
}
