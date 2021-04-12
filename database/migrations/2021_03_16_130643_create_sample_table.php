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
            $table->integer('sampleId');
            $table->string('quesName',10);
            $table->string('name', 50)->nullable();
            $table->tinyInteger('gender');
            $table->year('birthYear');
            $table->tinyInteger('birthMonth')->nullable();
            $table->tinyInteger('status')->comment('訪問狀態')->default(1);
            $table->boolean('mail')->comment('是否寄送紙本郵件')->default(1);
            $table->tinyInteger('mode')->comment('訪問方式')->default(1);
            $table->string('liCode', 11);
            $table->bigInteger('mainAdd')->comment('訪問地址');
            $table->bigInteger('mailAdd')->comment('郵寄地址')->nullable();
            $table->bigInteger('emailFirst')->comment('優先寄送eamil')->nullable();
            $table->bigInteger('imFirst')->comment('優先使用的通訊軟體')->nullable();
            $table->longText('note')->nullable()->comment('樣本公開註記');
            $table->longText('innerNote')->nullable()->comment('樣本內部註記');
            $table->timestamps();
            $table->primary('sampleId');
        });
        Schema::create('sample_add', function (Blueprint $table) {
            $table->id();
            $table->integer('sampleId');
            $table->tinyInteger('category');
            $table->string('add');
            $table->string('note')->nullable();
            $table->point('GPS')->comment('地理座標');
            $table->boolean('avaliable')->default(1)->comment('是否有效');
            $table->timestamps();
        });
        Schema::create('sample_tel', function (Blueprint $table) {
            $table->id();
            $table->integer('sampleId');
            $table->tinyInteger('category');
            $table->string('number',50);
            $table->string('note')->nullable();
            $table->boolean('avaliable')->default(1)->comment('是否有效');
            $table->timestamps();
        });
        Schema::create('sample_email', function (Blueprint $table) {
            $table->id();
            $table->integer('sampleId');
            $table->string('email');
            $table->string('note')->nullable();
            $table->boolean('avaliable')->default(1)->comment('是否有效');
            $table->timestamps();
        });
        Schema::create('sample_im', function (Blueprint $table) {
            $table->id();
            $table->integer('sampleId');
            $table->string('app');
            $table->string('account');
            $table->boolean('avaliable')->default(1)->comment('是否有效');
            $table->timestamps();
        });
        Schema::create('sample_result', function (Blueprint $table) {
            $table->id();
            $table->integer('sampleId');
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
