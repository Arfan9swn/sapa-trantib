<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('user_tags')) {
            Schema::create('user_tags', function (Blueprint $table) {
                $table->unsignedInteger('tag_id')->primary()->autoIncrement();
                $table->string('name', 50)->unique();
                $table->string('color', 20)->default('#6366f1');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('user_tags');
    }
};
