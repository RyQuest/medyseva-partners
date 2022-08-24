<?php

use Illuminate\Support\Facades\Route;

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



// vle routes

Route::prefix('vle')->group(function () {
    Route::get('/', function () {
           return view('vle.index');
    });

    Route::get('/create', function () {
           return view('vle.create');
    });

   Route::get('/edit',function(){

           return view('vle.edit');
    });

  

});

 Route::get('/vle-create', function () {
           return view('vle.create');
    });

   Route::get('/vle-edit',function(){

           return view('vle.edit');
    });


  Route::get('/vle-session',function(){

           return view('vle.session');
    });

  Route::get('/vle-report',function(){

           return view('vle.report');
    });










Route::prefix('wallet')->group(function(){

     Route::get('/',function(){
          
               return view('wallets.index');
         
              });


});


 Route::get('/trx_history',function(){
          
               return view('wallets.trx_history');
         
   });




//Auth::routes();

Route::view('login','livewire.login');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
