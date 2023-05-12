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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id()->unique();
            $table->string('birth_day', 20);
            $table->string('name', 10);
            $table->string('gender', 255);
            $table->string('email', 255);
            $table->unique('email', 'accounts_email_unique');
            $table->string('password', 255);
            $table->string('tel', 255)->nullable(true);
            $table->string('address1', 10)->nullable(true);
            $table->string('address2', 10)->nullable(true);
            $table->string('introduction', 1000)->nullable(true);
            $table->string('upload_image_name', 255)->nullable(true);
            $table->integer('login_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
