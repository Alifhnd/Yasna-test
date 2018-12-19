<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->index();
            $table->char('locale')->index();
            $table->string('value')->index();
            $table->timestamps();
            $table->unsignedInteger('created_by')->default(0)->index();
            $table->unsignedInteger('updated_by')->default(0);
            $table->unsignedInteger('deleted_by')->default(0);
            $table->tinyInteger('converted')->default(0)->index();
            $table->tinyInteger('lock')->default(0)->index();
            $table->softDeletes();
        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('translations');
    }
}
