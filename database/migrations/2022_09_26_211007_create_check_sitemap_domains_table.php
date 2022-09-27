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
        Schema::create('check_sitemap_domains', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('domain_id');
            $table->longText('content')->nullable();
            $table->longText('differences_content')->nullable();
            $table->bigInteger('str_length')->nullable();
            $table->integer('rows_number')->nullable();
            $table->enum('status', ['pending', 'not-updated', 'updated', 'no-response']);
            $table->timestamp('last_updated_time')->nullable();
            $table->boolean('is_healthy')->nullable();
            $table->timestamps();
            
            $table->foreign('domain_id')->on('domains')->references('id')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('check_sitemap_domains');
    }
};
