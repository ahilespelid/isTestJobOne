<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('last_name', 40)->nullable();
            $table->string('name', 40)->nullable();
            $table->string('middle_name', 40)->nullable();

            $table->string('email', 80)->unique();
            $table->string('phone', 20)->nullable();

            $table->string('pass', 255)->nullable();

            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
