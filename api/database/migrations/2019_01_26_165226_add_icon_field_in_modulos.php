<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIconFieldInModulos extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('modulos', function (Blueprint $table) {
      $table->string('icon')->nullable()->default('fa fa-align-justify');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('modulos', function (Blueprint $table) {
      $table->dropColumn('icon');
    });
  }
}
