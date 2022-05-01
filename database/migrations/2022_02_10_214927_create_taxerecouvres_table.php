<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxerecouvresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxerecouvres', function (Blueprint $table) {
            $table->id();
            $table->string("taxemensuelle");
            $table->string("taxeannuelle");
            $table->string("janvier")->nullable();
            $table->string("fevrier")->nullable();
            $table->string("mars")->nullable();
            $table->string("avril")->nullable();
            $table->string("mai")->nullable();
            $table->string("juin")->nullable();
            $table->string("juillet")->nullable();
            $table->string("aout")->nullable();
            $table->string("septembre")->nullable();
            $table->string("octobre")->nullable();
            $table->string("novembre")->nullable();
            $table->string("decembre")->nullable();
            $table->string("exercice");
            $table->foreignId("contribuables_id")->constrained("contribuables")->onDelete('cascade');
            $table->foreignId("taxes_id")->constrained("taxes")->onDelete('cascade');
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
        Schema::table("contribuables", function (Blueprint $table)
        {
            $table->dropConstrainedForeignId("contribuables_id");
        });
        Schema::table("taxes", function (Blueprint $table)
        {
            $table->dropConstrainedForeignId("taxes_id");
        });
        Schema::dropIfExists('taxerecouvres');
    }
}
