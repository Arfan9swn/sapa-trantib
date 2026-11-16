<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'full_name')) {
                $table->string('full_name', 255)->nullable()->after('email');
            }
            if (! Schema::hasColumn('users', 'phone_number')) {
                $table->string('phone_number', 25)->nullable()->unique()->after('full_name');
            }

            // Make auth fields optional for warga/guest accounts (name + phone only).
            // Use ->change() without ->unique() since the unique indexes already exist.
            $table->string('username', 50)->nullable()->change();
            $table->string('email', 255)->nullable()->change();
            $table->string('password_hash', 255)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'phone_number')) {
                $table->dropUnique(['phone_number']);
            }
            if (Schema::hasColumn('users', 'full_name')) {
                $table->dropColumn(['full_name', 'phone_number']);
            }
            $table->string('username', 50)->nullable(false)->change();
            $table->string('email', 255)->nullable(false)->change();
            $table->string('password_hash', 255)->nullable(false)->change();
        });
    }
};
