<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('new_residence_reports', function (Blueprint $table) {
            $table->unsignedInteger('new_residence_id')->primary()->autoIncrement();
            $table->unsignedInteger('user_id');
            $table->string('nik', 16);
            $table->string('nama', 100);
            $table->string('nomor_telepon', 20);
            $table->text('alamat');
            $table->enum('status', ['pending', 'resolved', 'rejected'])->default('pending');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('new_residence_reports');
    }
};