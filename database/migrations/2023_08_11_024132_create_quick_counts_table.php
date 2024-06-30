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
        Schema::create('quick_counts', function (Blueprint $table) {
            $table->id();
            $table->integer('election_id')->nullable();
            $table->string('provinsi_kode')->nullable();
            $table->string('kota_kode')->nullable();
            $table->string('kecamatan_kode')->nullable();
            $table->string('kelurahan_kode')->nullable();
            $table->string('tps_kode')->nullable();
            $table->integer('number_voters')->nullable();
            $table->integer('number_vote')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quick_counts');
    }
};
