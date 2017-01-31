<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->integer('id',false,true)->unique();//$table->increments('id');
            $table->primary('id');

            $table->string('name');
            $table->string('type')->nullable();
            $table->string('desc');
            $table->string('pic')->nullable();
            $table->integer('parent',false,true)->nullable();
            $table->integer('price',false,true)->nullable();

            $table->foreign('parent')->references('id')->on('products');
            //$table->text('long_description');
            //$table->text('short_description');
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
        Schema::drop('products');
    }
}
