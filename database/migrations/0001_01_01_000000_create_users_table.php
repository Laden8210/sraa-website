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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('name');
            $table->string('billeting_quarter');
            $table->string('division');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('role')->default('user');
            $table->boolean('is_deleted')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('participants', function (Blueprint $table) {
            $table->id('participant_id');
            $table->string('name');
            $table->string('participant_role');
            $table->string('division');
            $table->string('school');
            $table->string('event');
            $table->string('username')->unique();
            $table->string('password');
            $table->boolean('is_deleted')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('attendance', function (Blueprint $table) {
            $table->id('attendance_id');
            $table->foreignId('participant_id')->references('participant_id')->on('participants')->onDelete('cascade');
            $table->date('date_recorded');
            $table->time('time_recorded');
            $table->string('reference_number');
            $table->string('type');
            $table->foreignId('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
