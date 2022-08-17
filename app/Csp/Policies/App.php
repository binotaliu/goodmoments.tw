<?php

declare(strict_types=1);

namespace App\Csp\Policies;

use Illuminate\Http\Request;
use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policies\Policy;
use Spatie\Csp\Scheme;
use Symfony\Component\HttpFoundation\Response;

final class App extends Policy
{
    public function shouldBeApplied(Request $request, Response $response): bool
    {
        if ($request->routeIs('telescope')) {
            return false;
        }

        return parent::shouldBeApplied($request, $response);
    }

    public function configure(): void
    {
        $this->addDirective(Directive::DEFAULT, Keyword::SELF);

        $this->addDirective(Directive::SCRIPT, Keyword::SELF);

        $this->addDirective(Directive::SCRIPT, Keyword::UNSAFE_INLINE);
        $this->addDirective(Directive::SCRIPT, Keyword::UNSAFE_EVAL);
        $this->addDirective(Directive::SCRIPT, 'www.youtube.com');
        $this->addNonceForDirective(Directive::SCRIPT);

        $this->addDirective(Directive::IMG, Keyword::SELF);
        $this->addDirective(Directive::IMG, Scheme::HTTPS);
        $this->addDirective(Directive::IMG, values: Scheme::DATA);

        $this->addDirective(Directive::FRAME, 'www.youtube.com');

        $this->addDirective(Directive::STYLE, Keyword::SELF);
        $this->addNonceForDirective(Directive::STYLE);

        $this->addDirective(Directive::FONT, Keyword::SELF);
        $this->addDirective(Directive::FONT, Scheme::DATA);

        $this->addDirective(Directive::CONNECT, Keyword::SELF);

        $assetUrls = array_filter(config('csp.asset_urls'));

        foreach ($assetUrls as $assetUrl) {
            if (str_starts_with(asset(''), $assetUrl)) {
                continue;
            }

            $assetUrlWithoutScheme = str_replace(['https://', 'http://'], '', $assetUrl);

            $this->addDirective(Directive::FONT, $assetUrlWithoutScheme);
            $this->addDirective(Directive::IMG, $assetUrlWithoutScheme);
            $this->addDirective(Directive::SCRIPT, $assetUrlWithoutScheme);
            $this->addDirective(Directive::STYLE, $assetUrlWithoutScheme);
            $this->addDirective(Directive::FRAME, $assetUrlWithoutScheme);
            $this->addDirective(Directive::CONNECT, 'wss://' . $assetUrlWithoutScheme);
        }
    }
}
