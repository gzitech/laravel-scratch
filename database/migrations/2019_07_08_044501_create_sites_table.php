<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->comment('who created the site');
            $table->string('name')->default('');
            $table->unsignedBigInteger('owner_role_id')->default(0)->comment('site owner role id');
            $table->unsignedBigInteger('member_role_id')->default(0)->comment('site member role id');
            $table->unsignedBigInteger('default_role_id')->default(0)->comment('user signup will assign to this role');
            $table->softDeletes();
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
        Schema::dropIfExists('sites');
    }
}
