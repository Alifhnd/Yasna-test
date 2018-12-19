<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');

            $table->string('slug')->unique();
            $table->string('title');
            $table->string('category');
            $table->integer('order')->default(11)->index() ;
            $table->string('data_type');
            $table->longText('default_value')->nullable();
            $table->longText('custom_value')->nullable();
            $table->boolean('is_localized')->default(0);
            $table->string('css_class')->nullable() ;
            $table->text('hint')->nullable() ;
            $table->longText('meta')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->boolean('converted')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
