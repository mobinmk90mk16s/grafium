<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('scheduling', 'deleted_at')) {
            Schema::table('scheduling', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        DB::statement("ALTER TABLE scheduling MODIFY COLUMN status VARCHAR(30) NOT NULL DEFAULT 'available'");
    }

    public function down(): void
    {
        if (Schema::hasColumn('scheduling', 'deleted_at')) {
            Schema::table('scheduling', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }

        DB::statement("ALTER TABLE scheduling MODIFY COLUMN status ENUM('available','reserved','maintenance','blocked') NOT NULL DEFAULT 'available'");
    }
};