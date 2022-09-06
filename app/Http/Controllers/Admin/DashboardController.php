<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

final class DashboardController
{
    public const CACHE_PREFIX = 'admin-dashboard:';
    public const CACHE_TTL_SECONDS = 60 * 15;

    public function __invoke(): InertiaResponse
    {
        return Inertia::render('Dashboard', [
            'pendingArticlesCount' => $this->getPendingArticlesCount(),
            'articlesCount' => $this->getArticlesCount(),
            'activeBannersCount' => $this->getActiveBannersCount(),
            'bannersCount' => $this->getBannersCount(),
            'categoriesCount' => $this->getCategoriesCount(),
            'productsCount' => $this->getProductsCount(),
            'support' => config('support'),
        ]);
    }

    private function getPendingArticlesCount(): int
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'pending-articles-count',
            self::CACHE_TTL_SECONDS,
            static fn () => Article::where('published_at', '>', now())->count()
        );
    }

    private function getArticlesCount(): int
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'articles-count',
            self::CACHE_TTL_SECONDS,
            static fn () => Article::count()
        );
    }

    private function getActiveBannersCount(): int
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'active-banners-count',
            self::CACHE_TTL_SECONDS,
            static fn () => Banner::whereActive()->count()
        );
    }

    private function getBannersCount(): int
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'banners-count',
            self::CACHE_TTL_SECONDS,
            static fn () => Banner::count()
        );
    }

    private function getCategoriesCount(): int
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'categories-count',
            self::CACHE_TTL_SECONDS,
            static fn () => Category::count()
        );
    }

    private function getProductsCount(): int
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'products-count',
            self::CACHE_TTL_SECONDS,
            static fn () => Product::count(),
        );
    }
}
