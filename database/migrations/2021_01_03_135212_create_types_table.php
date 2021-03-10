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

class CreateTypesTable extends Migration {

    public function up() {
        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(true);
            $table->string('name', 100)->nullable();
            $table->integer('time')->nullable();
            $table->foreignId('company_id')->nullable()->references('id')->on('companies')->cascadeOnUpdate()->nullOnDelete();
            $table->string('companyType')->unique();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
        });
        Schema::dropIfExists('types');
    }
}
