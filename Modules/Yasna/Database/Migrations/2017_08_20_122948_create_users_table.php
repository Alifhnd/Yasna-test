<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            /*-----------------------------------------------
            | Primary Key ...
            */
            $table->increments('id');

            /*-----------------------------------------------
            | Personal Info ...
            */
            $table->string('code_melli', 20)->nullable()->index();
            $table->string('email')->nullable()->index();
            $table->string('name_title')->nullable();
            $table->string('name_first')->nullable()->index();
            $table->string('name_last')->nullable()->index();
            $table->string('name_father')->nullable();
            $table->string('name_firm')->nullable();
            $table->string('full_name')->nullable();
            $table->string('code_id')->nullable();
            $table->tinyInteger('gender')->default(0)->index();

            /*-----------------------------------------------
            | Contact Details ...
            */
            $table->string('mobile')->nullable()->index();
            $table->string('tel_emergency')->nullable()->index();

            $table->string('tel')->nullable() ;
            $table->unsignedInteger('country')->nullable()->index() ;
            $table->unsignedInteger('province')->nullable()->index();
            $table->unsignedInteger('city')->nullable()->index();
            $table->unsignedInteger('neighbourhood')->nullable()->index();
            $table->text('home_address')->nullable();
            $table->string('postal_code')->nullable();

            /*-----------------------------------------------
            | Birth Info...
            */
            $table->date('birth_date')->nullable()->index();
            $table->unsignedInteger('birth_city')->nullable()->index();

            /*-----------------------------------------------
            | Marital Info ...
            */
            $table->tinyInteger('marital')->default(0)->index();
            $table->date('marriage_date')->nullable()->index();

            /*-----------------------------------------------
            | Education ...
            */
            $table->string('job')->nullable();

            $table->tinyInteger('edu_level')->nullable()->index();
            $table->unsignedInteger('edu_country')->nullable()->index();
            $table->unsignedInteger('edu_province')->nullable()->index();
            $table->unsignedInteger('edu_city')->nullable()->index();
            $table->string('edu_field')->nullable();

            /*-----------------------------------------------
            | Authentication ...
            */
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->string('reset_token')->nullable();
            $table->boolean('password_force_change')->default(0);
            $table->text('cache_roles')->nullable() ;

            /*-----------------------------------------------
            | Familiarization ...
            */
            $table->tinyInteger('familiarization')->nullable();
            $table->string('motivation')->nullable();

            /*-----------------------------------------------
            | Meta ...
            */
            $table->longText('meta')->nullable();
            $table->longText('preferences')->nullable() ;

            /*-----------------------------------------------
            | Domains ...
            */
            $table->string('domain')->nullable();
            $table->unsignedInteger('from_domain')->nullable()->index();
            $table->unsignedInteger('from_event_id')->default(0)->index();

            /*-----------------------------------------------
            | Change Logs ...
            */
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->default(0)->index();
            $table->unsignedInteger('updated_by')->default(0);
            $table->unsignedInteger('deleted_by')->default(0);
            $table->unsignedInteger('published_by')->default(0);

            /*-----------------------------------------------
            | Indexes ...
            */
            $table->tinyInteger('converted')->default(0)->index();

            $table->index('created_at');
        });
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
