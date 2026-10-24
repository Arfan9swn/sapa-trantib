<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->unsignedInteger('report_id')->primary()->autoIncrement();
            $table->string('reference_code', 12)->unique();
            $table->string('title', 50);
            $table->text('description');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('sub_category_id');
            $table->enum('status', ['pending', 'resolved', 'rejected'])->default('pending');
            $table->string('reporter_name', 100);
            $table->string('reporter_phone_number', 20)->nullable();
            $table->text('reporter_location');
            $table->tinyInteger('reporter_rt');
            $table->decimal('latitude', 9, 6)->nullable();
            $table->decimal('longitude', 9, 6)->nullable();
            $table->integer('boosts')->default(0);
            $table->unsignedInteger('assigned_to')->nullable();
            $table->timestamp('submitted_at');
            $table->timestamp('resolved_at')->nullable();
            $table->text('resolution_note')->nullable();
            $table->timestamp('created_at');
            $table->timestamp('updated_at');

            $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('cascade');
            $table->foreign('sub_category_id')->references('sub_category_id')->on('sub_categories')->onDelete('cascade');
            $table->foreign('assigned_to')->references('user_id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};