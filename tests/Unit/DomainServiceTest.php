<?php

use App\Models\Domain;
use App\Models\Tenant;
use App\Models\User;
use App\Services\DomainService;

test('domain can be created', function () {
    $user = User::factory()->create();
    $tenant = Tenant::factory()->create();

    $this->actingAs($user);

    $requestData = new stdClass;
    $requestData->domain = 'sub.domain.com';

    $domainService = new DomainService;
    $domainService->createDomain($tenant, $requestData);

    $this->assertDatabaseHas('domains', [
        'domain' => $requestData->domain,
        'user_id' => $user->id,
    ]);
});

test('domain can be updated', function () {
    $user = User::factory()->create();
    $tenant = Tenant::factory()->create();
    $domain = Domain::factory()->create([
        'tenant_id' => $tenant->id,
    ]);

    $this->actingAs($user);

    $requestData = new stdClass;
    $requestData->domain = 'subdomain.domain.com';

    $domainService = new DomainService;
    $domainService->updateDomain($domain, $requestData);

    $this->assertDatabaseHas('domains', [
        'domain' => $requestData->domain,
    ]);
});

test('domain can be deleted', function () {
    $user = User::factory()->create();
    $tenant = Tenant::factory()->create();
    $domain = Domain::factory()->create([
        'tenant_id' => $tenant->id,
    ]);

    $this->actingAs($user);

    $domainService = new DomainService;
    $domainService->deleteDomain($domain);

    $this->assertDatabaseMissing('domains', ['id' => $domain->id]);
});
