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
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->string('name_fr');
            $table->string('name_ar');
            $table->text('description_ar')->nullable();
            $table->text('description_fr')->nullable();
            $table->string('latitude'); // Added for latitude
            $table->string('longitude');
            $table->unsignedSmallInteger('capacity');
            $table->unsignedDecimal('price_per_hour', 10, 2)->default(0);
            $table->unsignedDecimal('price_per_day', 10, 2)->default(0);
            $table->unsignedDecimal('price_per_week', 10, 2)->default(0);
            $table->unsignedDecimal('price_per_month', 10, 2)->default(0);
            $table->string('working_days');
            $table->time('open_time');
            $table->time('close_time');
            $table->boolean('status')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};
