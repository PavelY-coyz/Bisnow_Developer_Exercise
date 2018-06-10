<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackPageViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('track_page_views', function (Blueprint $table) {
          //url,ip,session_id, item_type created_at (and even email) can be indexed. Dependings on
          //the type of queuries you will run
          $table->increments('id')->unsigned();
          $table->string('url')->index();
          $table->ipAddress('ip')->index();
          $table->string('session_id')->index();
          $table->string('email');
          $table->string('marketing_tracking_code');

          $table->integer('item_Id')->unsigned();
          $table->string('item_type')->index();
          $table->timestamp('created_at')->index()->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('track_page_views');
    }
}
