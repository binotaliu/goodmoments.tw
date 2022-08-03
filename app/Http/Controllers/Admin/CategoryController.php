<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryCreationRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

final class CategoryController
{
    public function index(): InertiaResponse
    {
        return Inertia::render('Categories/Index', [
            'categories' => Category::paginate(),
        ]);
    }

    public function show(Category $category): InertiaResponse
    {
        return Inertia::render('Categories/Form', [
            'category' => $category,
        ]);
    }

    public function create(): InertiaResponse
    {
        return Inertia::render('Categories/Form');
    }

    public function store(CategoryCreationRequest $request): RedirectResponse
    {
        $category = new Category();

        $category->slug = Str::slug($request->slug);
        $category->name = $request->name;

        $category->save();

        return Redirect::route('admin.categories.show', $category);
    }
}
