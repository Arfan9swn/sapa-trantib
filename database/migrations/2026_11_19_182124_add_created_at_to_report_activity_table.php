<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('report_activity', function (Blueprint $table) {
            if (!Schema::hasColumn('report_activity', 'created_at')) {
                $table->timestamp('created_at')->nullable()->after('new_value');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_activity', function (Blueprint $table) {
            if (Schema::hasColumn('report_activity', 'created_at')) {
                $table->dropColumn('created_at');
            }
        });
    }
};