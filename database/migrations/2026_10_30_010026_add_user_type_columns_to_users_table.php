<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'user_type')) {
                $table->string('user_type', 50)->default('warga')->after('role');
            }
            if (!Schema::hasColumn('users', 'user_type_color')) {
                $table->string('user_type_color', 20)->default('#6366f1')->after('user_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'user_type_color')) {
                $table->dropColumn('user_type_color');
            }
            if (Schema::hasColumn('users', 'user_type')) {
                $table->dropColumn('user_type');
            }
        });
    }
};
