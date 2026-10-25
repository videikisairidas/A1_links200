<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            // morthonable
            $table->string('mediable_type');   // App\Models\User, App\Models\Blog, etc.
            $table->unsignedBigInteger('mediable_id');
            // media grouping
            $table->string('collection_name', 50);
            $table->string('file_name');
            $table->json('sizes')->nullable();
            $table->string('title', 100)->nullable();
            $table->string('description', 100)->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['mediable_type', 'mediable_id']);
            $table->index(['collection_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
