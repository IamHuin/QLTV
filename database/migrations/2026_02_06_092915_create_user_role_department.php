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
        if (Schema::hasTable('users') && Schema::hasTable('roles') && Schema::hasTable('departments')) {
            Schema::create('user_role_department', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->foreignId('user_id')->constrained('users');
                $table->foreignId('role_id')->constrained('roles');
                $table->foreignId('department_id')->nullable()->constrained('departments');
                $table->string('status')->default('active');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_role_department');
    }
};
