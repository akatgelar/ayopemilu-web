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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('role_id')->nullable();
            $table->integer('election_id')->nullable();
            $table->string('gender')->nullable();
            $table->date('bod')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('picture')->nullable();
            $table->text('notes')->nullable();
            $table->date('expired_date')->nullable();
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
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
