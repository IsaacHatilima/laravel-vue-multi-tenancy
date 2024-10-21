<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileService
{
    private User $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function updateProfile($request): void
    {
        DB::transaction(function () use ($request) {
            if ($this->user->email !== $request->email) {
                $this->user->fill([
                    'email_verified_at' => null,
                    'email' => $request->email,
                ]);
                $this->user->save();
            }

            $profile = $this->user->profile;

            $profile->fill([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
            ]);

            if ($profile->isDirty()) {
                $profile->save();
            }
        });
    }

    public function copyRecoveryCodes($request): void
    {
        DB::transaction(function () use ($request) {
            $user = $request->user();
            $user->downloaded_code = ! $user->downloaded_code;
            $user->save();
        });
    }

    public function cancelTwoFactorAuthentication($request): void
    {
        DB::transaction(function () use ($request) {
            $user = $request->user();
            $user->two_factor_confirmed_at = null;
            $user->save();
        });
    }

    public function deleteAccount($request): void
    {
        Auth::logout();

        DB::transaction(function () {
            $this->user->delete();
        });

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
