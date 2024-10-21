<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use function Illuminate\Support\defer;

class UserRegistrationService
{
    /**
     * Create a new class instance.
     */
    public function registerUser($data)
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'email' => $data->email,
                'password' => Hash::make($data->password),
            ]);

            $user->profile()->create([
                'first_name' => ucwords($data->first_name),
                'last_name' => ucwords($data->last_name),
            ]);

            defer(fn () => event(new Registered($user)));

            return $user;
        });

    }
}
