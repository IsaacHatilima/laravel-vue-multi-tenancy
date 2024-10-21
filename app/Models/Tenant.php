<?php

namespace App\Models;

use App\Traits\ModelHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains, HasFactory, ModelHelpers;

    protected $guarded = [
        'public_id',
    ];

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'user_id',
            'updated_by',
            'subscription',
            'tenant_number',
            'name',
            'public_id',
            'valid_until',
            'contact_name',
            'contact_cell',
            'contact_email',
        ];
    }

    public function getIncrementing(): bool
    {
        return true;
    }
}
