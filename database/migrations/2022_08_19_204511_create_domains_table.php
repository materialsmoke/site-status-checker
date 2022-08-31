<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->string('description', 255)->nullable();
            $table->double('was_offline_minutes_in_last_hour')->default(0);
            $table->double('was_offline_minutes_in_last_four_hours')->default(0);
            $table->double('was_offline_minutes_in_last_day')->default(0);
            $table->double('was_offline_minutes_in_last_week')->default(0);
            $table->double('was_offline_minutes_in_last_month')->default(0);
            $table->double('was_offline_minutes_in_last_year')->default(0);
            $table->double('was_offline_total')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('domains');
    }
};
