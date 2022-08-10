<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\FetchAttachmentsFromProductRequest;
use App\Actions\FillProductInputsFromRequest;
use App\Http\Requests\ProductCreationRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

final class ProductController
{
    public function __construct(
        private readonly FetchAttachmentsFromProductRequest $fetchAttachmentsFromProductRequest,
        private readonly FillProductInputsFromRequest $fillProductInputsFromRequest
    ) {
    }

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

    public function create(Category $category): InertiaResponse
    {
        return Inertia::render('Products/Form', [
            'category' => $category,
        ]);
    }

    public function store(Category $category, ProductCreationRequest $request): RedirectResponse
    {
        $attachments = ($this->fetchAttachmentsFromProductRequest)($request);

        $product = ($this->fillProductInputsFromRequest)($request);
        $product->save();
        $product->attachments()->attach($attachments);

        return Redirect::route('admin.categories.products.show', [$category, $product]);
    }

    public function update(Category $category, Product $product, ProductUpdateRequest $request): RedirectResponse
    {
        $attachments = ($this->fetchAttachmentsFromProductRequest)($request);

        ($this->fillProductInputsFromRequest)($request, $product);
        $product->save();
        $product->attachments()->sync($attachments);

        return Redirect::route('admin.categories.products.show', [$category, $product]);
    }

    public function show(Category $category, Product $product): InertiaResponse
    {
        return Inertia::render('Products/Form', [
            'category' => $category,
            'product' => $product,
        ]);
    }

    public function destroy(Category $category, Product $product): RedirectResponse
    {
        $product->attachments()->delete();
        $product->deleteOrFail();

        return Redirect::route('admin.categories.products.index', $category);
    }
}
