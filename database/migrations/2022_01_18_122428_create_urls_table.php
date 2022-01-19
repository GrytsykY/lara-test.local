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
            $table->smallInteger('max_count_ping');
            $table->tinyInteger('ping_counter')->default(0);
            $table->integer('status_code');
            $table->dateTime('last_ping')->useCurrent();
            $table->boolean('is_failed')->default(false);
            $table->boolean('is_sent_alert')->default(false);
            $table->unsignedSmallInteger('id_alert');
            $table->unsignedSmallInteger('id_user');
            $table->unsignedSmallInteger('id_project');
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_alert')->references('id')->on('alerts');
            $table->foreign('id_project')->references('id')->on('projects');
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
