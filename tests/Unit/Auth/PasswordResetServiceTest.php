<?php

use App\Models\User;
use App\Services\PasswordResetRequestService;

test('can change password', function () {

    $passwordResetRequestService = new PasswordResetRequestService;
    $user = User::factory()->create();

    $status = $passwordResetRequestService->makeRequest($user->email);

    expect($status)->toEqual('passwords.sent');
});
