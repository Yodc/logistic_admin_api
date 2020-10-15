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


Route::middleware(['cors:api'])->group( function (){ //'jwt.verify'

    Route::resource('/invoices', 'InvoiceController', ['except' => ['edit', 'create']]);
    Route::resource('/packing_lists', 'PackingListController', ['except' => ['edit', 'create']]);
    Route::resource('/tasks', 'TaskCenterController', ['only' => ['index', 'show' , 'destroy']]);
    
    Route::get('404', ['as' => 'notfound', function () {
		return response()->json(['status' => '404']);
	}]);

	Route::get('405', ['as' => 'notallow', function () {
		return response()->json(['status' => '405']);
  }]);

});





