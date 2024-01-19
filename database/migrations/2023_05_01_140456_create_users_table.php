<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->nullable()->references('id')->on('cities')->cascadeOnDelete();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 400)->unique();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('address', 1000)->nullable();
            $table->tinyInteger('is_admin')->default(0);
            $table->date('verified_at')->nullable();
            $table->string('vcode')->nullable();
            $table->boolean('is_blocked')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
