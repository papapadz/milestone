<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PDFController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// $app_url = config("app.url");
// if (!empty($app_url)) {
//     URL::forceRootUrl($app_url);
//     $schema = explode(':', $app_url)[0];
//     URL::forceScheme($schema);
// }


Route::get('/', function () {
    return view('landing');
})->name('home');

Auth::routes(['verify' => true]);

Route::middleware(['auth','preventBackHistory','verified'])->group(function() {
    /*
    |--------------------------------------------------------------------------
    | HomeController
    |--------------------------------------------------------------------------
    */

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    /*
    |--------------------------------------------------------------------------
    | ManagementController
    |--------------------------------------------------------------------------
    */

    Route::get('task', [ManagementController::class, 'task'])->name('task');

    //add user / add employee
    Route::get('add-employee', [ManagementController::class, 'addEmployee'])->name('addEmployee');
    Route::post('store-employee', [ManagementController::class, 'storeEmployee'])->name('storeEmployee');
    Route::get('add-user', [ManagementController::class, 'addUser'])->name('addUser');
    Route::get('user-lists', [UserController::class, 'userLists'])->name('userLists');

    // change password
    Route::get('manage-account', [ManagementController::class, 'manageAccount'])->name('manageAccount');
    Route::post('manage-account', [ManagementController::class, 'postManageAccount'])->name('postManageAccount');

    // employee list
    Route::get('employee-directory', [ManagementController::class, 'employeeDirectory'])->name('employeeDirectory');

    // company
    Route::get('add-account', [ManagementController::class, 'addAccount'])->name('addAccount');
    Route::post('store-account', [ManagementController::class, 'storeAccount'])->name('storeAccount');
    Route::get('update-account/{id}', [ManagementController::class, 'updateAccount'])->name('updateAccount');

    // supply
    Route::get('supply', [ManagementController::class, 'supply'])->name('supply');
    Route::get('supply/milled', [ManagementController::class, 'supplyMilled'])->name('supply-milled');
    Route::get('suppliers', [ManagementController::class, 'suppliers'])->name('suppliers');
    Route::get('edit-supplier/{id}', [ManagementController::class, 'editSupplier'])->name('editSupplier');
    Route::post('edit-supplier/{id}', [ManagementController::class, 'editSupplier'])->name('editSupplier');
    Route::get('add-supplier', [ManagementController::class, 'addNewSupplier'])->name('addNewSupplier');
    Route::post('add-supplier', [ManagementController::class, 'addNewSupplier'])->name('addNewSupplier');
    Route::get('add-palay', [ManagementController::class, 'addPalay'])->name('addPalay');
    Route::get('product/{id}/edit', [ManagementController::class, 'updateProduct'])->name('updateProduct');
    Route::post('product/{id}/edit', [ManagementController::class, 'updateProduct'])->name('updateProduct');
    Route::post('store-palay', [ManagementController::class, 'storePalay'])->name('storePalay');
    Route::get('view-palay', [ManagementController::class, 'viewPalay'])->name('viewPalay');
    Route::get('product/to-mill/{id}', [ManagementController::class, 'toMillUpdate'])->name('toMillUpdate');
    Route::post('product/to-mill/{id}', [ManagementController::class, 'toMillUpdate'])->name('toMillUpdate');
    Route::get('/viewpdf',[PDFController::class,'getAllPalay']);
    Route::get('/download-pdf',[PDFController::class,'downloadPDF'])->name('download-pdf');

    //task
    Route::get('add-task', [ManagementController::class, 'addTask'])->name('addTask');
    Route::post('store-task', [ManagementController::class, 'storeTask'])->name('storeTask');
    Route::get('update-task/{id}', [ManagementController::class, 'updateTask'])->name('updateTask');
    Route::get('delete-task', [ManagementController::class, 'deleteTask'])->name('deleteTask');

    Route::get('logs', [ManagementController::class, 'logs'])->name('logs');
    Route::get('notifications', [ManagementController::class, 'notifications'])->name('notifications');
    Route::get('notifications/mark/{id}', [ManagementController::class, 'notificationsMark'])->name('notifications-read');
    Route::get('product/to-mill/{id}/sold',[ManagementController::class, 'toMillUpdateSold'])->name('toMillSold'); 
});

/*
|--------------------------------------------------------------------------
| ForgotPasswordController
|--------------------------------------------------------------------------
*/
Route::get('forgot-password', [ForgotPasswordController::class, 'forgotPassword'])->name('forgotPassword');

/*
|--------------------------------------------------------------------------
| LoginController
|--------------------------------------------------------------------------
*/
//Route::get('login', [LoginController::class, 'login'])->name('login');
//Route::post('post-login', [LoginController::class, 'postLogin'])->name('login.post');
//Route::get('logout', [LoginController::class, 'logout'])->name('logout');


