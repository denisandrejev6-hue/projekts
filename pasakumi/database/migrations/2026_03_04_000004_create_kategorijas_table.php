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
        if (!Schema::hasTable('kategorijas')) {
            Schema::create('kategorijas', function (Blueprint $table) {
                $table->id('ID'); // Primary Key
                $table->string('nosaukums', 45); // Название категории
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategorijas');
    }
};
