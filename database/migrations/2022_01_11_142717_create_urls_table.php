<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urls', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('url', 2048);
            $table->unsignedTinyInteger('time');
            $table->tinyInteger('count_inquiry');
            $table->tinyInteger('count_query_url');
            $table->boolean('choice');
            $table->unsignedSmallInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users');
            $table->dateTime('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('urls');
    }
}
