<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSampleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sample', function (Blueprint $table) {
            $table->integer('sampleid');
            $table->char('qname',10);
            $table->char('name', 50)->nullable();
            $table->tinyInteger('gender');
            $table->year('birth');
            $table->tinyInteger('birthm');
            $table->tinyInteger('status');
            $table->boolean('mail');
            $table->tinyInteger('mode');
            $table->char('licode', 11);
            $table->bigInteger('MainAdd');
            $table->bigInteger('MailAdd');
            $table->longText('note');
            $table->longText('innernote');
            $table->timestamps();
            $table->primary('sampleid');
        });
        Schema::create('sample_add', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('category');
            $table->char('add');
            $table->char('note');
            $table->point('GIS');
            $table->boolean('avaliable')->default(1);
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
        Schema::dropIfExists('sample');
        Schema::dropIfExists('sample_add');
    }
}
