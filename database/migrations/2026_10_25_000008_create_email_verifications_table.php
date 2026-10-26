<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_verifications', function (Blueprint $table) {
            $table->unsignedInteger('otp_id')->primary()->autoIncrement();
            $table->string('email', 255);
            $table->string('otp_code', 6);
            $table->timestamp('expires_at');
            $table->timestamp('used_at')->nullable();
            $table->timestamp('created_at');
            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_verifications');
    }
};