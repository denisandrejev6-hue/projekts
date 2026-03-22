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
        if (!Schema::hasTable('jaunumi_images')) {
            Schema::create('jaunumi_images', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('jaunumi_id');
                $table->foreign('jaunumi_id')->references('id')->on('jaunumi')->onDelete('cascade');
                $table->string('image_path');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jaunumi_images');
    }
};
