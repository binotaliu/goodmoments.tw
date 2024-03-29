<?php

namespace App\Providers;

use App\Actions\Fortify\AuthenticateUser;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Laravel\Fortify\Fortify;

final class FortifyServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerViews();

        Fortify::authenticateUsing(AuthenticateUser::make());
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', static function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email . $request->ip());
        });

        RateLimiter::for('two-factor', static fn (Request $request) => Limit::perMinute(5)->by($request->session()->get('login.id')));
    }

    private function registerViews(): void
    {
        Fortify::loginView(static fn () => Inertia::render('Auth/Login'));
        Fortify::requestPasswordResetLinkView(
            static fn () => Inertia::render('Auth/ForgotPassword', ['status' => session('status')])
        );
        Fortify::resetPasswordView(
            static fn (Request $request) => Inertia::render('Auth/ResetPassword', [
                'email' => $request->input('email'),
                'token' => $request->route('token'),
                'status' => $request->input('status'),
            ])
        );
    }
}
