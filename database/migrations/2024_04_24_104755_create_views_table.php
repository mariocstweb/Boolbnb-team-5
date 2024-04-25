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

        /* TABELLA VISUALIZZAZIONI */
        Schema::create('views', function (Blueprint $table) {
            $table->id();
            $table->string('code_ip', 45)->unique();
            $table->time('time_of_view', 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        /* BOTTO GIU' LA TABELLA */
        Schema::dropIfExists('views');
    }
};