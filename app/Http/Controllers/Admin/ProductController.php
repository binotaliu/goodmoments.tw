<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductCreationRequest;
use App\Models\Attachment;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use InvalidArgumentException;
use Throwable;

final class ProductController
{
    public function index(?Category $category): InertiaResponse
    {
        return Inertia::render('Products/Index', [
            'categories' => Category::all(),
            'category' => $category,
            'products' => (
                $category ?
                    $category->products() :
                    Product::query()
            )->with('category')->paginate(),
        ]);
    }

    public function store(Category $category, ProductCreationRequest $request): RedirectResponse
    {

        try {
            $attachmentUuids = json_decode($request->header('X-Attachment-UUID'), flags: JSON_THROW_ON_ERROR);
        } catch (Throwable $e) {
            throw new InvalidArgumentException('Invalid X-Attachment-UUID header', previous: $e);
        }

        $attachments = Attachment::whereIn('uuid', $attachmentUuids)->get();
        throw_if(
            $attachments->count() !== count($attachmentUuids),
            InvalidArgumentException::class,
            'Invalid X-Attachment-UUID header'
        );

        $product = new Product();
        $product->slug = Str::slug($request->slug);
        $product->cover_image = $request->cover_image;
        $product->images = $request->images;
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

        $category->products()->save($product);
        $product->attachments()->sync($attachments);

        return Redirect::route('admin.categories.products.show', [$category, $product]);
    }
}
