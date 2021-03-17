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
            $table->string('qname',10);
            $table->string('name', 50)->nullable();
            $table->tinyInteger('gender');
            $table->year('birth');
            $table->tinyInteger('birthm');
            $table->tinyInteger('status')->comment('訪問狀態');
            $table->boolean('mail')->comment('不寄郵件');
            $table->tinyInteger('mode')->comment('訪問方式');
            $table->string('licode', 11);
            $table->bigInteger('MainAdd');
            $table->bigInteger('MailAdd');
            $table->longText('note')->nullable();
            $table->longText('innernote')->nullable();
            $table->timestamps();
            $table->primary('sampleid');
        });
        Schema::create('sample_add', function (Blueprint $table) {
            $table->id();
            $table->integer('sampleid');
            $table->tinyInteger('category');
            $table->string('add');
            $table->string('note')->nullable();
            $table->point('GIS')->comment('地理座標');
            $table->boolean('avaliable')->default(1)->comment('是否有效');
            $table->timestamps();
        });
        Schema::create('sample_tel', function (Blueprint $table) {
            $table->id();
            $table->integer('sampleid');
            $table->tinyInteger('category');
            $table->string('number',50);
            $table->string('note')->nullable();
            $table->boolean('avaliable')->default(1)->comment('是否有效');
            $table->timestamps();
        });
        Schema::create('sample_email', function (Blueprint $table) {
            $table->id();
            $table->integer('sampleid');
            $table->tinyInteger('order')->nullable();
            $table->string('email');
            $table->string('note')->nullable();
            $table->boolean('avaliable')->default(1)->comment('是否有效');
            $table->timestamps();
        });
        Schema::create('sample_im', function (Blueprint $table) {
            $table->id();
            $table->integer('sampleid');
            $table->tinyInteger('order')->nullable();
            $table->string('app');
            $table->string('account');
            $table->boolean('avaliable')->default(1)->comment('是否有效');
            $table->timestamps();
        });
        Schema::create('sample_result', function (Blueprint $table) {
            $table->id();
            $table->integer('sampleid');
            $table->year('year')->comment('訪問年');
            $table->integer('result');
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
        Schema::dropIfExists('sample_tel');
        Schema::dropIfExists('sample_email');
        Schema::dropIfExists('sample_im');
        Schema::dropIfExists('sample_result');
    }
}
