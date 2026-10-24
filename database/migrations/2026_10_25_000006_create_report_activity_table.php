<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_activity', function (Blueprint $table) {
            $table->unsignedInteger('activity_id')->primary()->autoIncrement();
            $table->unsignedInteger('report_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('action', 50);
            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();
            $table->timestamp('created_at');

            $table->foreign('report_id')->references('report_id')->on('reports')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_activity');
    }
};