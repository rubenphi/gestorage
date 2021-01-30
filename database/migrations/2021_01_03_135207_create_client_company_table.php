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

class CreateClientCompanyTable extends Migration {

    public function up() {
        Schema::create('client_company', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(true);
            $table->string('address', 500)->nullable();
            $table->string('email', 100)->nullable();
            $table->foreignId('client_id')->nullable()->references('id')->on('clients')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('company_id')->nullable()->references('id')->on('companies')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
        });
        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
        });
        Schema::dropIfExists('client_company');
    }
}
