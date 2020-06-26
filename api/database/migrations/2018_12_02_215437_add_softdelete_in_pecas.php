<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftdeleteInPecas extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('pecas', function (Blueprint $table) {
      $table->softDeletes();
      $table->dateTime('updated')->change();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('pecas', function (Blueprint $table) {
      $table->dropSoftDeletes();
      $table->timestamp('updated')->change();
    });
  }
}
