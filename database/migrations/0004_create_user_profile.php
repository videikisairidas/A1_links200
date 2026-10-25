<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     public function up()
    {
        Schema::create('user_profile', function (Blueprint $table) {
            $table->id();

            $table->unique('user_id'); // Ensures that each user has only one profile
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Links to users table
            $table->string('username', 100)->nullable()->unique();
            $table->string('bio', 1000)->nullable();
            $table->string('first_name', 100)->nullable();
            $table->string('middle_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('social_instagram')->nullable();
            $table->string('social_facebook')->nullable();
            $table->string('social_twitter')->nullable();
            $table->string('website_link')->nullable();
            $table->timestamps();
            $table->timestamp('last_activity')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_profile');
    }
};
