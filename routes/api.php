<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('users/add',[\App\Http\Controllers\UserController::class, 'store'])->name('UserAdd');
Route::post('users/login',[\App\Http\Controllers\UserController::class, 'login'])->name('UserLogin');

Route::group(['middleware'=>'auth:api'], function(){
    Route::apiResource('users','App\Http\Controllers\UserController');
    Route::get('users/companies/{id}',[\App\Http\Controllers\UserController::class, 'showCompanies'])->name('UserCompanies');
    Route::post('users/companies/add',[\App\Http\Controllers\UserController::class, 'addCompanies'])->name('UserAddCompanies');
    Route::delete('users/companies/delete',[\App\Http\Controllers\UserController::class, 'deleteCompanies'])->name('UserDeleteCompanies');
    Route::put('users/companies/update',[\App\Http\Controllers\UserController::class, 'updateCompanies'])->name('UserUpdateCompanies');
    Route::get('users/areas/{id}',[\App\Http\Controllers\UserController::class, 'showAreas'])->name('UserAreas');
    Route::post('users/areas/add',[\App\Http\Controllers\UserController::class, 'addAreas'])->name('UserAddAreas');
    Route::delete('users/areas/delete',[\App\Http\Controllers\UserController::class, 'deleteAreas'])->name('UserDeleteAreas');
    Route::put('users/areas/update',[\App\Http\Controllers\UserController::class, 'updateAreas'])->name('UserUpdateAreas');
    Route::get('users/departments/{id}',[\App\Http\Controllers\UserController::class, 'showDepartments'])->name('UserDepartments');
    Route::post('users/departments/add',[\App\Http\Controllers\UserController::class, 'addDepartments'])->name('UserAddDepartments');
    Route::delete('users/departments/delete',[\App\Http\Controllers\UserController::class, 'deleteDepartments'])->name('UserDeleteDepartments');
    Route::put('users/departments/update',[\App\Http\Controllers\UserController::class, 'updateDepartments'])->name('UserUpdateDepartments');
    Route::get('users/requests/{id}',[\App\Http\Controllers\UserController::class, 'showRequests'])->name('UserRequests');
    Route::apiResource('companies','App\Http\Controllers\CompanyController');
    Route::get('companies/users/{id}',[\App\Http\Controllers\CompanyController::class, 'showUsers'])->name('CompanyUsers');
    Route::get('companies/clients/{id}',[\App\Http\Controllers\CompanyController::class, 'showClients'])->name('CompanyClients');
    Route::get('companies/areas/{id}',[\App\Http\Controllers\CompanyController::class, 'showAreas'])->name('CompanyAreas');
    Route::get('companies/departments/{id}',[\App\Http\Controllers\CompanyController::class, 'showDepartments'])->name('CompanyDepartments');
    Route::get('companies/types/{id}',[\App\Http\Controllers\CompanyController::class, 'showTypes'])->name('CompanyTypes');
    Route::get('companies/statuses/{id}',[\App\Http\Controllers\CompanyController::class, 'showStatuses'])->name('CompanyStatuses');
    Route::get('companies/invitations/{id}',[\App\Http\Controllers\CompanyController::class, 'showInvitations'])->name('CompanyInvitations');
    Route::get('companies/requests/{id}',[\App\Http\Controllers\CompanyController::class, 'showRequests'])->name('CompanyRequests');
    Route::apiResource('areas','App\Http\Controllers\AreaController');
    Route::get('areas/users/{id}',[\App\Http\Controllers\AreaController::class, 'showUsers'])->name('AreaUsers');
    Route::get('areas/requests/output/{id}',[\App\Http\Controllers\AreaController::class, 'showOutputRequests'])->name('AreaOutputRequests');
    Route::get('areas/requests/input/{id}',[\App\Http\Controllers\AreaController::class, 'showInputRequests'])->name('AreaInputRequests');
    Route::apiResource('departments','App\Http\Controllers\DepartmentController');
    Route::get('departments/areas/{id}',[\App\Http\Controllers\DepartmentController::class, 'showAreas'])->name('DepartmentAreas');
    Route::get('departments/users/{id}',[\App\Http\Controllers\DepartmentController::class, 'showUsers'])->name('DepartmentUsers');
    Route::get('departments/requests/output/{id}',[\App\Http\Controllers\DepartmentController::class, 'showOutputRequests'])->name('DepartmentOutputRequests');
    Route::get('departments/requests/input/{id}',[\App\Http\Controllers\DepartmentController::class, 'showInputRequests'])->name('DepartmentInputRequests');
    Route::apiResource('types','App\Http\Controllers\TypeController');
    Route::get('types/requests/{id}',[\App\Http\Controllers\TypeController::class, 'showRequests'])->name('TypeRequests');
    Route::apiResource('invitations','App\Http\Controllers\InvitationController');
    Route::apiResource('statuses','App\Http\Controllers\StatusController');
    Route::apiResource('clients','App\Http\Controllers\ClientController');
    Route::get('clients/companies/{id}',[\App\Http\Controllers\ClientController::class, 'showCompanies'])->name('ClientCompanies');
    Route::post('clients/companies/add',[\App\Http\Controllers\ClientController::class, 'addCompanies'])->name('ClientAddCompanies');
    Route::delete('clients/companies/delete',[\App\Http\Controllers\ClientController::class, 'deleteCompanies'])->name('ClientDeleteCompanies');
    Route::put('clients/companies/update',[\App\Http\Controllers\ClientController::class, 'updateCompanies'])->name('ClientUpdateCompanies');
    Route::apiResource('requests','App\Http\Controllers\RequestController');
    Route::post('users/logout', [\App\Http\Controllers\UserController::class, 'logout'])->name('UsersLogout');
    Route::post('users/alogout', [\App\Http\Controllers\UserController::class, 'logoutAll'])->name('UsersAllLogout');
});

