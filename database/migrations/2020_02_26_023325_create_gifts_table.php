<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gifts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('name', 200);
            $table->text('description');
            $table->timestamps();
        });

        DB::table('gifts')->insert(
            [
                'name' => "Mesa ratona",
                'description' => "Una mesa ratona bonita para el living",
            ]
        );

        DB::table('gifts')->insert(
            [
                'name' => "Heladera",
                'description' => "Una heladera para la cocina",
            ]
        );

        DB::table('gifts')->insert(
            [
                'name' => "Sommier de dos plazas",
                'description' => "Un sommier de dos plazas para dormir piola",
            ]
        );

        DB::table('gifts')->insert(
            [
                'name' => "Juego de sabanas de dos plazas",
                'description' => "Un juego de sabanas para el sommier",
            ]
        );

        DB::table('gifts')->insert(
            [
                'name' => "Juego de 24 cubiertos",
                'description' => "Unos buenos cubiertos para hacer comida rica",
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gifts');
    }
}
