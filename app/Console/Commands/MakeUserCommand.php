<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

final class MakeUserCommand extends Command
{
    protected $signature = 'make:user';
    protected $description = 'Create a new user';

    public function handle(): int
    {
        $username = $this->ask('Username');
        $name = $this->ask('Name');
        $email = $this->ask('Email');
        $password = $this->secret('Password');

        $user = new User();
        $user->name = $name;
        $user->username = $username;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->email_verified_at = now();
        $user->is_active = true;
        $user->save();

        return self::SUCCESS;
    }
}
