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

class CreateRequestsTable extends Migration {

    public function up() {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->timestamp('expire');
            $table->boolean('active')->default(true);
            $table->string('comments', 520)->nullable();
            $table->string('url', 100);
            $table->string('response_address', 100);
            $table->string('response_name', 100);
            $table->string('response_email', 100);
            $table->string('response_document', 100);
            $table->string('response_type', 100);
            $table->foreignId('status_id')->nullable()->references('id')->on('statuses')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('company_id')->nullable()->references('id')->on('companies')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('from_area_id')->nullable()->references('id')->on('areas')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('from_department_id')->nullable()->references('id')->on('departments')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('to_area_id')->nullable()->references('id')->on('areas')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('to_department_id')->nullable()->references('id')->on('departments')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('type_id')->nullable()->references('id')->on('types')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::table('statuses', function (Blueprint $table) {
            $table->dropForeign(['status_id']);
        });
        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
        });
        Schema::table('areas', function (Blueprint $table) {
            $table->dropForeign(['from_area_id']);
        });
        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['from_department_id']);
        });
        Schema::table('areas', function (Blueprint $table) {
            $table->dropForeign(['to_area_id']);
        });
        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['to_department_id']);
        });
        Schema::table('types', function (Blueprint $table) {
            $table->dropForeign(['type_id']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('requests');
    }
}
