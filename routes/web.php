<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeController;

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

Route::get('/', function () {
    return view('welcome');
});


//------------------------------------{{  Laravel Crud with Events &Listeners  }} ********************************//

Route::middleware('auth')->group(function(){
Route::get('/dashboard',[UserController::class,'dashboard']);
Route::get('/view',[UserController::class,'view'])->name('dashboard');
Route::get('/edit/{id}',[UserController::class,'edit']);
Route::post('/update/{id}',[UserController::class,'update']);
Route::get('/delete/{id}',[UserController::class,'delete']);
Route::get('change-user-status/{id}',[UserController::class,'StatusChange']);

});

//------------------------------------------- {{  Jquery Crud  }}-------------------------------------------------//

Route::get('/employee',[EmployeeController::class,'index']);
Route::post('/save-employee',[EmployeeController::class,'store']);
Route::get('/fetch-employee',[EmployeeController::class,'fetchemployee']);
Route::get('/edit-employee/{id}',[EmployeeController::class,'edit']);
Route::post('/update-employee/{id}',[EmployeeController::class,'update']);
Route::delete('/delete-employee/{id}',[EmployeeController::class,'destroy']);
Route::post('/tasks/update-status', [EmployeeController::class, 'updateStatus'])->name('tasks.updateStatus');



require __DIR__.'/auth.php';


//-------------------------------------------- {{ ADMIN  }}-----------------------------------------------------//

Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function(){

  Route::namespace('Auth')->middleware('guest:admin')->group(function(){
     
     // login route
     Route::get("login","AuthenticatedSessionController@create")->name("login");
     Route::post("login","AuthenticatedSessionController@store")->name("adminlogin");

  });
   Route::middleware('admin')->group(function(){
    Route::get("dashboard","HomeController@index")->name("dashboard");
   });
   Route::post("logout","Auth\AuthenticatedSessionController@destroy")->name("logout");

});



Route::post('add-post',[UserController::class,'add_post']);