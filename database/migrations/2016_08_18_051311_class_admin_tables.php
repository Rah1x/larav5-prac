<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClassAdminTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email_add', 100)->unique();
            $table->string('pass_w', 100);
            $table->string('first_name', 60);
            $table->string('last_name', 60);
            $table->tinyInteger('is_active')->default(1);
            $table->tinyInteger('is_super_admin')->default(0);
            $table->timestamp('added_on');
        });

        Schema::create('admin_sections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label', 60);
        });

        Schema::create('admin_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin_users_id');
            $table->integer('admin_section_id');
            $table->unique(array('admin_users_id', 'admin_section_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admin_users');
        Schema::drop('admin_sections');
        Schema::drop('admin_permissions');
    }
}
