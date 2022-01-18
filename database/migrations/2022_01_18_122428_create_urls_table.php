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
            $table->string('name', 30);
            $table->unsignedTinyInteger('time_out');
            $table->tinyInteger('count_link');
            $table->tinyInteger('count_query_url')->default(0);
            $table->tinyInteger('choice');
            $table->integer('status_code');
            $table->boolean('flag_error_code')->default(false);
            $table->boolean('flag_success_code')->default(false);
            $table->unsignedSmallInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users');
//            $table->dateTime('created_at')->useCurrent();
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
        Schema::dropIfExists('urls');
    }
}
