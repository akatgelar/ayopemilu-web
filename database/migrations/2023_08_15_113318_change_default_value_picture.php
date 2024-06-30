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
        Schema::table('finances', function (Blueprint $table) {
            $table->string('picture')->default('none.png')->change();
        });
        Schema::table('inventories', function (Blueprint $table) {
            $table->string('picture')->default('none.png')->change();
        });
        Schema::table('reports', function (Blueprint $table) {
            $table->string('picture')->default('none.png')->change();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->string('picture')->default('none.png')->change();
        });
        Schema::table('voters', function (Blueprint $table) {
            $table->string('picture')->default('none.png')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
