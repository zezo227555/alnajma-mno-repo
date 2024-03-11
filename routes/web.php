<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\StoresController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('login/', [AuthController::class, 'show_login_form'])->name('auth.show.login');
Route::get('loged/', [AuthController::class, 'login'])->name('auth.login');

Route::middleware(['auth'])->group(function () {

    Route::get('logout/', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('', [AuthController::class, 'Home'])->name('home');

    Route::middleware(['alnajma_auth'])->group(function () {
        Route::get('user/deposet_form/{user_id}', [UserController::class, 'user_deposet_form'])->name('user.user_deposet_form');
        Route::post('user/deposet/{user_id}', [UserController::class, 'user_deposet'])->name('user.user_deposet');
        Route::post('alnajma_topup/{user_id}', [UserController::class, 'alnajma_topup'])->name('user.alnajma_topup');
        Route::post('alnajma_dissmisal/{user_id}', [UserController::class, 'alnajma_dissmisal'])->name('user.alnajma_dissmisal');
        Route::get('reports/alnajma_adda_to_admin_form/', [ReportsController::class, 'alnajma_adda_to_admin_form'])->name('reports.alnajma_adda_to_admin_form');
        Route::get('reports/alnajma_adds_form/', [ReportsController::class, 'alnajma_adds_form'])->name('reports.alnajma_adds_form');
        Route::get('edit_alnajma_adds_form/{id}', [ReportsController::class, 'edit_alnajma_adds_form'])->name('reports.alnajma.edit_alnajma_adds_form');
        Route::post('edit_alnajma_adds/{id}', [ReportsController::class, 'edit_alnajma_adds'])->name('reports.alnajma.edit_alnajma_adds');
    });

        Route::get('user/dissmisal_form/{user_id}', [UserController::class, 'user_dissmisal_form'])->name('user.user_dissmisal_form');
        Route::post('user/dissmisal/{user_id}', [UserController::class, 'user_dissmisal'])->name('user.user_dissmisal');


    Route::middleware(['admin_alnajma_auth'])->group(function () {
        Route::get('reports/edit_admin_dissmisal_form/{id}', [ReportsController::class, 'edit_admin_dissmisal_form'])->name('reports.alnajma.edit_admin_dissmisal_form');
        Route::post('reports/edit_admin_dissmisal/{id}', [ReportsController::class, 'edit_admin_dissmisal'])->name('reports.alnajma.edit_admin_dissmisal');
        Route::resource('user', UserController::class);
        Route::get('admins', [UserController::class, 'all_admins'])->name('user.all_admins');
        Route::get('accounters', [UserController::class, 'all_accounters'])->name('user.all_accounters');
        Route::get('admins/account', [UserController::class, 'admins_account'])->name('admins.admins_account');
        Route::get('users/account', [UserController::class, 'repos_account'])->name('user.repos_account');
        Route::post('users/deposet_search/{user_id}', [UserController::class, 'repo_deposet_search'])->name('user.repo_deposet_search');
        Route::post('users/admins_deposet_search/{user_id}', [UserController::class, 'admins_deposet_search'])->name('user.admins_deposet_search');
        Route::post('users/alnajma_deposet_search/', [UserController::class, 'alnajma_deposet_search'])->name('user.alnajma_deposet_search');
    });
    
    Route::resource('stores', StoresController::class);

    Route::middleware(['repo_auth'])->group(function (){
        Route::get('stores/deposet_form/{store_id}', [StoresController::class, 'store_deposet_form'])->name('store.store_deposet_form');
        Route::post('stores/deposet/{store_id}', [StoresController::class, 'store_deposet'])->name('store.store_deposet');
        Route::get('stores/dissmisal_form/{store_id}', [StoresController::class, 'store_dissmisal_form'])->name('store.store_dissmisal_form');
        Route::post('stores/dissmisal/{store_id}', [StoresController::class, 'store_dissmisal'])->name('store.store_dissmisal');
    });
    

    Route::get('reports/admin_adds_to_repo_form/', [ReportsController::class, 'admin_adds_to_repo_form'])->name('reports.admin_adds_to_repo_form');
    Route::post('reports/admin_adds_to_repo/{id}', [ReportsController::class, 'admin_adds_to_repo'])->name('reports.admin_adds_to_repo');
    
    Route::get('reports/store_account_form/', [ReportsController::class, 'store_account_form'])->name('reports.store_account_form');
    Route::get('reports/store_account/{id}', [ReportsController::class, 'store_account'])->name('reports.store_account');
    Route::get('reports/alnajma_adds_to_admin_form', [ReportsController::class, 'alnajma_adds_to_admin_form'])->name('reports.alnajma_adds_to_admin_form');
    Route::post('reports/alnajma_adds_to_admin', [ReportsController::class, 'alnajma_adds_to_admin'])->name('reports.alnajma_adds_to_admin');
    Route::get('reports/repo_account_statment_form', [ReportsController::class, 'repo_account_statment_form'])->name('reports.repo_account_statment_form');
    Route::post('reports/repo_account_statment', [ReportsController::class, 'repo_account_statment'])->name('reports.repo_account_statment');
    
    Route::get('edit_repo_dissmisal_form/{id}', [ReportsController::class, 'edit_repo_dissmisal_form'])->name('reports.admin.edit_repo_dissmisal_form');
    Route::post('edit_repo_dissmisal/{id}', [ReportsController::class, 'edit_repo_dissmisal'])->name('reports.admin.edit_repo_dissmisal');
    Route::get('get_repo_stores_balance/{id}', [ReportsController::class, 'get_repo_stores_balance'])->name('reports.get_repo_stores_balance');
    Route::get('get_repo_stores_balance_report/{id}', [ReportsController::class, 'get_repo_stores_balance_report'])->name('reports.get_repo_stores_balance_report');
    Route::get('reports/repos_salary_from', [ReportsController::class, 'repos_salary_from'])->name('reports.repos_salary_from');
    Route::post('reports/repos_salary', [ReportsController::class, 'repos_salary'])->name('reports.repos_salary');

    Route::get('reports/repo_adds_form/', [ReportsController::class, 'repo_adds_form'])->name('reports.admin.repo_adds_form');
    Route::post('reports/repo_adds/', [ReportsController::class, 'repo_adds'])->name('reports.admin.repo_adds');

    Route::post('reports/edit_store_dissmisal_deposet/{id}', [ReportsController::class, 'edit_store_dissmisal_deposet'])->name('reports.repo.edit_store_dissmisal_deposet');
    Route::get('reports/edit_store_dissmisal_deposet_form/{id}', [ReportsController::class, 'edit_store_dissmisal_deposet_form'])->name('reports.repo.edit_store_dissmisal_deposet_form');
});