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

class CreateClientsTable extends Migration {

    public function up() {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(true);
            $table->string('first_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('region', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('document', 100)->nullable();
            $table->string('email',100)->nullable();
            $table->string('address',100)->nullable();
            $table->foreignId('company_id')->nullable()->references('id')->on('companies')->cascadeOnUpdate()->nullOnDelete();
            $table->string('companyDocument')->unique();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
        });
        Schema::dropIfExists('clients');
    }
}
