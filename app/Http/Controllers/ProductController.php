<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;

final class ProductController
{
    public const PRODUCTS_PER_PAGE = 20;
    public function index(?Category $category = null): View
    {
        return view('products.index', [
            'category' => $category,
            'products' => Product
                ::when(
                    $category !== null,
                    static fn (Builder $q) => $q->where('category_id', $category->id),
                )
                ->with('category')
                ->paginate(self::PRODUCTS_PER_PAGE),
        ]);
    }

    public function show(Category $category, Product $product): View
    {
        return view('products.show', [
            'product' => $product,
        ]);
    }
}
