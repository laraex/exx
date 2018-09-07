<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('app_name', 100);
            $table->string('flag', 100)->nullable();
            $table->string('abbr', 3);
            $table->string('script', 20)->nullable();
            $table->string('native', 20)->nullable();
            $table->tinyInteger('active')->unsigned()->default("1");
            $table->tinyInteger('default')->unsigned()->default("0");
            $table->softDeletes();
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
        Schema::dropIfExists('languages');
    }
}
