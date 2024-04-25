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

        /* TABELLA SPONSOR */
        Schema::create('sponsors', function (Blueprint $table) {
            $table->id();
            $table->string('label', 20)->unique();
            $table->string('description');
            $table->string('color');
            $table->decimal('price', 4, 2);
            $table->time('duration');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        /* BUTTI GIU' LA TABELLA */
        Schema::dropIfExists('sponsors');
    }
};