<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            // Jika sebelumnya integer biasa, gunakan integer()->nullable()->change()
            // Jika sebelumnya unsignedBigInteger / foreignId, sesuaikan seperti di bawah:
            $table->unsignedBigInteger('sub_category_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->unsignedBigInteger('sub_category_id')->nullable(false)->change();
        });
    }
};