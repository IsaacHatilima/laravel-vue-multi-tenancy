<?php

namespace App\Services;

use Illuminate\Support\Facades\Password;

class PasswordResetRequestService
{
    /**
     * Create a new class instance.
     */
    public function makeRequest($email): string
    {
        defer(fn () => Password::sendResetLink($email));

        return Password::RESET_LINK_SENT;
    }
}
