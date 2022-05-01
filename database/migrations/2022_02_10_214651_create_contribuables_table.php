<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContribuablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contribuables', function (Blueprint $table) {
            $table->id(); 
            $table->string("codecontribuable")->unique();
            $table->string("nom");
            $table->string("prenom");
            $table->string("telephone");
            $table->foreignId("activites_id")->constrained("activites")->onDelete('cascade');
            $table->foreignId("zones_id")->constrained("zones")->onDelete('cascade');
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
        Schema::table("activites", function (Blueprint $table)
        {
            $table->dropConstrainedForeignId("activites_id");
        });
        Schema::table("zones", function (Blueprint $table)
        {
            $table->dropConstrainedForeignId("zones_id");
        });

        Schema::dropIfExists('contribuables');
    }
}
