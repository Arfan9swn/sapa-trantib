<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Run the migrations. */
    public function up(): void
    {
        Schema::create('rts', function (Blueprint $table) {
            $table->unsignedInteger('rt_id')->primary()->autoIncrement();
            $table->string('rt_number', 10)->unique();
            $table->string('head_name', 50);
            $table->unsignedInteger('population')->default(0);
            $table->unsignedInteger('reports_reported')->default(0);
            $table->enum('report_type', ['category', 'subcategory'])->default('category');
            $table->timestamps();
        });
    }

    /** Reverse the migrations. */
    public function down(): void
    {
        Schema::dropIfExists('rts');
    }
};
 
