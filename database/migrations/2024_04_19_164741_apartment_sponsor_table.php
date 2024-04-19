<?php

use App\Models\Apartment;
use App\Models\Sponsor;
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
        Schema::create('apartment_sponsor', function (Blueprint $table) {
            $table->foreignIdFor(Apartment::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Sponsor::class)->constrained()->cascadeOnDelete();
            $table->dateTime('start_date');
            $table->dateTime('expiration_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartment_sponsor');
    }
};
