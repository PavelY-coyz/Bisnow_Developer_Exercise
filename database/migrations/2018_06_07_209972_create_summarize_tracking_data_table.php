<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSummarizeTrackingDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('summarize_tracking_data', function (Blueprint $table) {
            $table->increments('id')->unsigned();

            //arguably all of these should be indexed. With millions of records
            //you may want to see data for a specific session/date/type
            //depends on your needs
            $table->string('session_id')->index();
            $table->date('date')->index();
            $table->string('type')->index();

            $table->integer('value');
            //Im pretty sure we want to have this summarized not only by date, but also
            //split it up by types. Otherwise, if a user visited home, news, and/or events
            //the type becomes undefinable.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('summarize_tracking_data');
    }
}
