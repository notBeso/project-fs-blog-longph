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
        Schema::create('blogs', function (Blueprint $table) {
            $table->text('title');
            $table->text('des');
            $table->text('detail');
            $table->string('category');
            $table->boolean('public');
            $table->string('data_public');
            $table->text('position');
            $table->text('thumbs')->nullable();
            $table->id('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
