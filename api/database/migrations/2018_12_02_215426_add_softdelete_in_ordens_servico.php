<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftdeleteInOrdensServico extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */

  public function __construct()
  {
    DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
  }

  public function up()
  {
    Schema::table('ordens_servico', function (Blueprint $table) {
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
    Schema::table('ordens_servico', function (Blueprint $table) {
      $table->dropSoftDeletes();
      $table->timestamp('updated')->change();
    });
  }
}
