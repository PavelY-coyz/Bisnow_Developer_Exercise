<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_items', function (Blueprint $table) {
          $table->increments('id')->unsigned();
          $table->string('name')->index();
          $table->mediumText('description');
          $table->timestamp('created_at')->index()->default(DB::raw('CURRENT_TIMESTAMP'));
          $table->timestamp('updated_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
          $table->timestamp('event_date')->index()->default(DB::raw('CURRENT_TIMESTAMP'));
          //$table->timestamp('deleted_at')->nullable();
          //$table->boolean('hidden')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_items');
    }
}
