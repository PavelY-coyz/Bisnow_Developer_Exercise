<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');

            //$table->morphs('image');
            //This is actually news/event item id
            $table->integer('image_id')->unsigned()->index()->nullable();
            $table->string('image_type')->nullable();

            //You may potentially want to delete old photos, so lets save their creation date
            $table->timestamp('created_at')->index()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('images');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
