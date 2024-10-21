<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDomainsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->uuid('public_id')->unique();
            $table->string('domain', 255)->unique();
            $table->foreignId('tenant_id')->references('id')->on('tenants')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('user_id')->unique()->references('id')->on('users')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->unique()->references('id')->on('users')->onDelete('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domains');
    }
}
