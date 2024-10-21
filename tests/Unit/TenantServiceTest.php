<?php

use App\Models\Tenant;
use App\Models\User;
use App\Services\TenantService;

test('tenant can be created', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $requestData = new stdClass;
    $requestData->name = 'ZGA';
    $requestData->contact_name = 'Enock Chota';
    $requestData->contact_email = 'enock.chota@mail.com';
    $requestData->contact_cell = '012339475629';

    $tenantService = new TenantService;
    $tenantService->createTenants($requestData);

    $this->assertDatabaseHas('tenants', [
        'name' => 'ZGA',
        'contact_name' => 'Enock Chota',
        'contact_email' => 'enock.chota@mail.com',
        'contact_cell' => '012339475629',
    ]);
});

test('tenant can be updated', function () {
    $user = User::factory()->create();
    $tenant = Tenant::factory()->create();

    $this->actingAs($user);

    $requestData = new stdClass;
    $requestData->name = 'ZGA';
    $requestData->contact_name = 'Jasper Hatilima';
    $requestData->contact_email = 'jasper.hatilima@mail.com';
    $requestData->contact_cell = '012339475629';
    $requestData->subscription = true;
    $requestData->valid_until = now()->addMonth();

    $tenantService = new TenantService;
    $tenantService->updateTenant($tenant, $requestData);

    $this->assertDatabaseHas('tenants', [
        'name' => 'ZGA',
        'contact_name' => 'Jasper Hatilima',
        'contact_email' => 'jasper.hatilima@mail.com',
        'contact_cell' => '012339475629',
    ]);
});

test('tenant subscription can be renewed', function () {
    $user = User::factory()->create();
    $tenant = Tenant::factory()->create();

    $this->actingAs($user);

    $tenantService = new TenantService;
    $tenantService->activateSubscription($tenant);

    $this->assertDatabaseHas('tenants', [
        'subscription' => true,
        'valid_until' => now()->addMonth()->toDateTimeString(),
        'updated_by' => $user->id,
    ]);
});

test('tenant subscription can be canceled', function () {
    $user = User::factory()->create();
    $tenant = Tenant::factory()->create();

    $this->actingAs($user);

    $tenantService = new TenantService;
    $tenantService->cancelSubscription($tenant);

    $this->assertDatabaseHas('tenants', [
        'subscription' => false,
        'updated_by' => $user->id,
    ]);
});

test('tenant can be deleted', function () {
    $user = User::factory()->create();
    $tenant = Tenant::factory()->create();

    $this->actingAs($user);

    $tenantService = new TenantService;
    $tenantService->deleteTenant($tenant);

    $this->assertDatabaseMissing('tenants', ['id' => $tenant]);
});
