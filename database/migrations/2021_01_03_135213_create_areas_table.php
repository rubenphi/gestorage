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

class CreateAreasTable extends Migration {

    public function up() {
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(true);
            $table->string('name', 100)->nullable();
            $table->foreignId('company_id')->nullable()->references('id')->on('companies')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('department_id')->nullable()->references('id')->on('departments')->cascadeOnUpdate()->nullOnDelete();
            $table->string('companyArea')->unique();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
        });
        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
        });
        Schema::dropIfExists('areas');
    }
}
