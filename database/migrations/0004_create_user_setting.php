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
        Schema::create('user_setting', function (Blueprint $table) {
            $table->id();
            $table->boolean('content_18')->default(true);
            // $table->boolean('dark_mode')->default(false);
            // $table->boolean('notifications')->default(true);   
            // $table->boolean('email_notifications')->default(true);

            $table->unique('user_id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_setting');
    }
};
