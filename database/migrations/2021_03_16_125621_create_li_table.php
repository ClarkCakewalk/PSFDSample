<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('li', function (Blueprint $table) {
            $table->id();
            $table->char('licode', 11);
            $table->string('liname', 45);
            $table->timestamps();
        });
        Schema::create('li_dist', function (Blueprint $table) {
            $table->id();
            $table->char('distcode', 11);
            $table->string('distname', 45);
            $table->timestamps();
        });
        Schema::create('li_city', function (Blueprint $table) {
            $table->id();
            $table->char('citycode', 11);
            $table->string('cityname', 45);
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
        Schema::dropIfExists('li');
        Schema::dropIfExists('li_dist');
        Schema::dropIfExists('li_city');
    }
}
