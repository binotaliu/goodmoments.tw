<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

final class UserController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Users/Index', [
            'users' => User::paginate(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = null;
        $user->is_active = $request->boolean('is_active');
        $user->save();

        return Redirect::route('admin.users.show', ['user' => $user]);
    }
}
