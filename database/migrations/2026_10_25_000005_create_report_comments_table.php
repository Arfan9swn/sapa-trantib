<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_comments', function (Blueprint $table) {
            $table->unsignedInteger('comment_id')->primary()->autoIncrement();
            $table->unsignedInteger('report_id');
            $table->text('body');
            $table->timestamp('created_at');

            $table->foreign('report_id')->references('report_id')->on('reports')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_comments');
    }
};