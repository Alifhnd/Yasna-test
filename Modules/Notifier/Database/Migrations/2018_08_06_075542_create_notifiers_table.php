<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotifiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifiers', function (Blueprint $table) {
            $table->increments('id');

            $table->string('slug')->index();
            $table->string('title')->index();
            $table->string('channel')->index();
            $table->string('driver')->index();
            $table->boolean("available_for_admins")->default(false);

            $table->timestamps();
            yasna()->additionalMigrations($table);
        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifiers');
    }
}
