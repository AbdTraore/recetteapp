<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContribuableTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contribuable_taxes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('contribuable_id')->unsigned();
            $table->bigInteger('taxes_id')->unsigned();            
            $table->timestamps();
            $table->foreign('taxes_id')->references('id')->on('taxes')->onDelete('cascade');
            $table->foreign('contribuable_id')->references('id')->on('contribuables')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contribuable_taxes');
    }
}
