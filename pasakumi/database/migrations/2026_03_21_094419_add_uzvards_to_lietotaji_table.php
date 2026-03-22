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
        Schema::table('lietotaji', function (Blueprint $table) {
            if (!Schema::hasColumn('lietotaji', 'uzvards')) {
                $table->string('uzvards', 45)->after('vards');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lietotaji', function (Blueprint $table) {
            $table->dropColumn('uzvards');
        });
    }
};
