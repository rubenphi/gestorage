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

class CreateCompaniesTable extends Migration {

    public function up() {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(true);
            $table->string('name', 100)->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('companies');
    }
}
