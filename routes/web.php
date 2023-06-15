<?php

use App\Http\Controllers\AcademicTypeController;
use App\Http\Controllers\AdminRoleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SubjectController;
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

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});

Route::get('admin/login', [AuthController::class, 'login'])->name('login');
Route::post('admin/login', [AuthController::class,'loginDashboard'])->name('login.post');

Route::group(['prefix' => 'admin','middleware' => ['auth','prevent-back-history'],'as' =>'backend.'],function() {
    Route::get('dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
    Route::controller(AuthController::class)->group(function (){
        Route::get('logout','logout')->name('logout');
        Route::get('lock','lock')->name('lock');
        Route::post('lock','unlock')->name('unlock');
    });
     Route::controller(RolePermissionController::class)->group(function (){
         Route::get('/roles', 'index')->name('role.list');
         Route::get('/create-role', 'createRole')->name('create.role');
         Route::post('/store-role', 'storeRole')->name('store.role');
         Route::get('/edit-role/{id}', 'editRole')->name('edit.role');
         Route::post('/update-role/{id}', 'updateRole')->name('update.role');
         Route::get('/delete-role/{id}', 'deleteRole')->name('delete.role');
     });

     Route::controller(AdminRoleController::class)->group(function (){
         Route::get('/list','adminList')->name('user.list');
         Route::get('/create','createAdmin')->name('create.admin');
         Route::post('/store','storeAdmin')->name('store.admin');
         Route::get('/edit/{id}','editAdmin')->name('edit.admin');
         Route::post('/update','updateAdmin')->name('update.admin');
         Route::get('/delete/{id}','deleteAdmin')->name('delete.admin');
     });


    Route::group(['prefix' => 'academic-type', 'as'=>'academic.type.' ],function (){
         Route::controller(AcademicTypeController::class)->group(function (){
             Route::get('','index')->name('index');
             Route::post('/store','store')->name('store');
             Route::get('/edit/{id}','edit')->name('edit');
             Route::get('/delete/{id}','delete')->name('delete');
             Route::get('/active','active')->name('status.active');
             Route::get('/inactive','inactive')->name('status.inactive');
         });
     });

    Route::group(['prefix' => 'subject', 'as'=>'subject.' ],function (){
        Route::controller(SubjectController::class)->group(function (){
            Route::get('','index')->name('index');
            Route::post('/store','store')->name('store');
            Route::get('/edit/{id}','edit')->name('edit');
            Route::get('/delete/{id}','delete')->name('delete');
            Route::get('/active','active')->name('status.active');
            Route::get('/inactive','inactive')->name('status.inactive');
        });
    });

    Route::group(['prefix' => 'chapter', 'as'=>'chapter.' ],function (){
        Route::controller(ChapterController::class)->group(function (){
            Route::get('{id}','index')->name('index');
            Route::post('/store','store')->name('store');
            Route::get('/edit/{id}','edit')->name('edit');
            Route::get('/delete/{id}','delete')->name('delete');
            Route::get('/active/chapter-status','active')->name('status.active');
            Route::get('/inactive/chapter-status','inactive')->name('status.inactive');
        });
    });

    Route::group(['prefix' => 'question', 'as'=>'question.' ],function (){
        Route::controller(QuestionController::class)->group(function (){
            Route::get('{id}','index')->name('index');
            Route::post('/store','store')->name('store');
            Route::get('/edit/{id}','edit')->name('edit');
            Route::get('/delete/{id}','delete')->name('delete');
            Route::get('/active/chapter-status','active')->name('status.active');
            Route::get('/inactive/chapter-status','inactive')->name('status.inactive');
        });
    });

});
