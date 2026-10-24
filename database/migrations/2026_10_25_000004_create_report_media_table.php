<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_media', function (Blueprint $table) {
            $table->unsignedInteger('media_id')->primary()->autoIncrement();
            $table->unsignedInteger('report_id');
            $table->text('media_url');
            $table->string('media_type', 20);
            $table->timestamp('uploaded_at');

            $table->foreign('report_id')->references('report_id')->on('reports')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_media');
    }
};