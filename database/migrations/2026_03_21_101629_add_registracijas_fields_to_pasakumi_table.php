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
        Schema::table('pasakumi', function (Blueprint $table) {
            if (!Schema::hasColumn('pasakumi', 'registracijas_beigu_datums')) {
                $table->date('registracijas_beigu_datums')->nullable();
            }
            if (!Schema::hasColumn('pasakumi', 'registracijas_beigu_laiks')) {
                $table->time('registracijas_beigu_laiks')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasakumi', function (Blueprint $table) {
            if (Schema::hasColumn('pasakumi', 'registracijas_beigu_datums')) {
                $table->dropColumn('registracijas_beigu_datums');
            }
            if (Schema::hasColumn('pasakumi', 'registracijas_beigu_laiks')) {
                $table->dropColumn('registracijas_beigu_laiks');
            }
        });
    }
};
