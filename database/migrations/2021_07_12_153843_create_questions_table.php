<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('Question');
            $table->string('Option1');
            $table->string('Option2');
            $table->string('Option3');
            $table->string('Option4');
            $table->integer('S1');
            $table->integer('S2');
            $table->integer('S3');
            $table->integer('S4');
            $table->string('convertS1')->nullable();
            $table->string('convertS2')->nullable();
            $table->string('convertS3')->nullable();
            $table->string('convertS4')->nullable();
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
        Schema::dropIfExists('questions');
    }
}
