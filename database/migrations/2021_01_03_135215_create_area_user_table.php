<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


/**
 * Generado por Database Modeler Pro
 * https://play.google.com/store/apps/details?id=adrian.adbm.pro
 *
 * Creado: 3/01/2021
*/

class CreateAreaUserTable extends Migration {

    public function up() {
        Schema::create('area_user', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(true);
            $table->string('rol', 100)->nullable();
            $table->foreignId('area_id')->nullable()->references('id')->on('areas')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::table('areas', function (Blueprint $table) {
            $table->dropForeign(['area_id']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('area_user');
    }
}
