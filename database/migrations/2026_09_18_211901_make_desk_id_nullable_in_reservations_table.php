<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // ۱. حذف Foreign Key
        try {
            Schema::table('reservations', function (Blueprint $table) {
                $table->dropForeign('reservations_ibfk_2');
            });
        } catch (\Exception $e) {
            // اگه FK وجود نداشت، ادامه بده
        }

        // ۲. حذف ستون desk_id کلاً
        if (Schema::hasColumn('reservations', 'desk_id')) {
            Schema::table('reservations', function (Blueprint $table) {
                $table->dropColumn('desk_id');
            });
        }
    }

    public function down(): void
    {
        // برگردوندن ستون (اگه نیاز شد)
        if (!Schema::hasColumn('reservations', 'desk_id')) {
            Schema::table('reservations', function (Blueprint $table) {
                $table->unsignedBigInteger('desk_id')->nullable()->after('user_id');
            });
        }
    }
};