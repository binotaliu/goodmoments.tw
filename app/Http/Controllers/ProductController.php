<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;

final class ProductController
{
    public function show(Category $category, Product $product): View
    {
        return view('products.show', [
            'product' => $product,
        ]);
    }
}
