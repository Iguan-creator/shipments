<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
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
            $table->id();
            $table->string('last_name', 50);
            $table->string('first_name', 50);
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedTinyInteger('role');
            $table->rememberToken();
            $table->timestamps();
        });

        $super = new User();
        $super->last_name = 'Иванов';
        $super->first_name = 'Иван';
        $super->email = env('SUPER_ADMIN_EMAIL');
        $super->password = Hash::make(env('SUPER_ADMIN_PASSWORD'));
        $super->role = 1;
        $super->save();
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
