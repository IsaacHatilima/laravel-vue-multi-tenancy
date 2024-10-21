<?php

namespace App\Services;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TenantService
{
    protected ?User $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function createTenants(object $requestData)
    {
        return DB::transaction(function () use ($requestData) {
            return Tenant::create([
                'tenant_number' => 'PB-'.$this->generateTenantNumber().'-'.strtoupper(substr($requestData->name, 0, 1)),
                'name' => ucwords($requestData->name),
                'valid_until' => now()->addMonth(),
                'contact_name' => ucwords($requestData->contact_name),
                'contact_email' => strtolower($requestData->contact_email),
                'contact_cell' => $requestData->contact_cell,
                'user_id' => $this->user->id,
            ]);
        });
    }

    public function generateTenantNumber(): string
    {
        $lastTenant = Tenant::latest()->first();
        $nextId = $lastTenant ? $lastTenant->id + 1 : 1;

        return str_pad($nextId, 2, '0', STR_PAD_LEFT);
    }

    public function updateTenant($tenant, object $requestData): void
    {
        DB::transaction(function () use ($tenant, $requestData) {
            $tenant->update([
                'name' => ucwords($requestData->name),
                'valid_until' => $requestData->valid_until,
                'contact_name' => ucwords($requestData->contact_name),
                'contact_email' => strtolower($requestData->contact_email),
                'contact_cell' => $requestData->contact_cell,
                'subscription' => $requestData->subscription,
                'updated_by' => $this->user->id,
            ]);
        });
    }

    public function activateSubscription($tenant): void
    {
        DB::transaction(function () use ($tenant) {
            $tenant->update([
                'valid_until' => now()->addMonth(),
                'subscription' => true,
                'updated_by' => $this->user->id,
            ]);
        });
    }

    public function cancelSubscription($tenant): void
    {
        /*
         * This method will also be use by the job to set subscription to false when payment not made.
         * */

        DB::transaction(function () use ($tenant) {
            $updateData = [
                'subscription' => false,
            ];

            if ($this->user) {
                $updateData['updated_by'] = $this->user->id;
            }

            $tenant->update($updateData);
        });
    }

    public function deleteTenant($tenant): void
    {
        DB::transaction(function () use ($tenant) {
            $tenant->delete();
        });
    }
}
