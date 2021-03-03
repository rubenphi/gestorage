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

class CreateDepartmentUserTable extends Migration {

    public function up() {
        Schema::create('department_user', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(true);
            $table->string('rol', 100)->nullable();
            $table->foreignId('department_id')->nullable()->references('id')->on('departments')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->cascadeOnUpdate()->nullOnDelete();
            $table->string('departmentUser')->unique();
            $table->string('companyDepartment')->unique();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('department_user');
    }
}
