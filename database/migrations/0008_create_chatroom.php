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
        Schema::create('chatrooms', function (Blueprint $table) {
           $table->uuid('id')->primary();
           $table->string('name', 50)->nullable()->default("chatroom empty");
           $table->boolean('is_group')->default(false);
           $table->timestamps();
        });

        Schema::create('chatroom_user', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('chatroom_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('has_joined')->default(false);
            $table->timestamps();

            $table->unique(['chatroom_id', 'user_id']); 
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('chatroom_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('body');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatrooms');
        Schema::dropIfExists('chatroom_users');
        Schema::dropIfExists('messages');
    }
};
