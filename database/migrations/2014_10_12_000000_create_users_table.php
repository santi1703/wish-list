<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('role')->default(1);
            $table->rememberToken();
            $table->timestamps();
        });

        // Insert some stuff
        DB::table('users')->insert(
            [
                'name' => 'admin',
                'email' => 'santi1703@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('123456'),
                'role' => 0
            ]
        );

        DB::table('users')->insert(
            [
                'name' => 'usuario 1',
                'email' => 'prueba@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('123456'),
                'role' => 1
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
        Schema::dropIfExists('users');
    }
}
