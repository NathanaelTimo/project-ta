<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_invoice');
            $table->date('date_invoice');
            $table->string('customer_name');
            $table->string('description')->nullable();
            $table->unsignedInteger('items_id')->nullable();
            $table->unsignedInteger('qty');
            $table->unsignedInteger('price')->nullable();
            $table->unsignedInteger('total')->nullable();

            $table->foreign('items_id')->references('id')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
