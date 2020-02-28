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
            $table->string('first_name');
            $table->string('last_name');
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
                'first_name' => 'admin',
                'last_name' => 'admin',
                'email' => 'santi1703@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('123456'),
                'role' => 0
            ]
        );

        for($i = 1; $i < 10; $i++) {
            DB::table('users')->insert(
                [
                    'first_name' => "usuario $i",
                    'last_name' => "usuario $i",
                    'email' => "usuario$i@gmail.com",
                    'email_verified_at' => now(),
                    'password' => bcrypt('123456'),
                    'role' => 1
                ]
            );
        }

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
