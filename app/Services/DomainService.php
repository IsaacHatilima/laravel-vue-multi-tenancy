<?php

namespace App\Services;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DomainService
{
    private User $user;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function createDomain(Tenant $tenant, $request): void
    {
        DB::transaction(function () use ($tenant, $request) {
            $tenant->domains()->create([
                'domain' => $request->domain,
                'tenant_id' => $tenant->id,
                'user_id' => $this->user->id,
            ]);
        });
    }

    public function updateDomain($domain, object $request): void
    {
        DB::transaction(function () use ($domain, $request) {
            $domain->update([
                'domain' => $request->domain,
                'updated_by' => $this->user->id,
            ]);
        });
    }

    public function deleteDomain($domain): void
    {
        DB::transaction(function () use ($domain) {
            $domain->delete();
        });
    }
}
