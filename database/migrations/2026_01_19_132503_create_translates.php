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
        if (Schema::hasTable('posts')) {
            Schema::create('translates', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->foreignId('post_id')->constrained('posts')->onDelete('cascade');
                $table->string('lang');
                $table->string('title');
                $table->string('content');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translates');
    }
};
