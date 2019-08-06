<?php

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

/*Route::get('/login', function () {
    return view('auth.login');
});*/

//Lugares Routes
Route::get('/lugares', 'LugarController@index')->name('lugares.index');
Route::get('/lugares/obtener_lugares', 'LugarController@getDataLugar')->name('lugares.getdata');
Route::post('/lugares/agregar_lugar', 'LugarController@postDataLugar')->name('lugares.postdata');
Route::get('/lugares/editar_lugar', 'LugarController@fetchDataLugar')->name('lugares.fetchdata');
Route::get('/lugares/eliminar_lugar', 'LugarController@removeDataLugar')->name('lugares.removedata');
Route::get('/lugares/eliminar_varios_lugares','LugarController@massRemoveLugar')->name('lugares.massRemove');

//Mobiliario Routes
Route::resource('mobis', 'MobiController');
Route::post('/mobi_agregarnuevo','MobiController@addMobiliario');
Route::get('/mobi_lugar/{id}','MobiController@byLugarMobi')->name('mobis.lugarmobi');
Route::get('/mobi_fetchdata/{id}', 'MobiController@fetchDataMobiliario')->name('mobi_fetchdata');
//Cantidades por items
Route::get('/cant_items','MobiController@itemsQuantity');
Route::post('/mobi_update', 'MobiController@update')->name('mobi.update');
//Function to show item details
Route::post('/mobi_detail','MobiController@showDetailMobi')->name('mobi.detail');
Route::get('/mobi_change', 'MobiController@changeLugar')->name('mobi.changelugar');
Route::post('/mobi_move', 'MobiController@moveLugar');
Route::get('/mobi_several_change','MobiController@severalChangeMobi');
Route::get('/mobi_destroy', 'MobiController@destroy')->name('mobi.destroy');
Route::get('/mobi_multipledestroy','MobiController@multipleDestroy')->name('mobi.multiplesDestroy');

//Revisiones Routes
Route::resource('revisiones', 'RevisionesController');
Route::get('/rev_lugar/{id}','RevisionesController@byLugarRev')->name('revisiones.lugarrev');
Route::get('/rev_fetchdata/{id}', 'RevisionesController@fetchDataRev')->name('rev_fetchdata');
Route::get('/rev_daterange/fetch_data/{id}', 'RevisionesController@fetch_data')->name('revdaterange.fetch_data');
Route::get('/rev_ultimas', 'RevisionesController@revUltimasView')->name('rev.ultimas');
Route::post('/rev_ultimas/load_more', 'RevisionesController@revUltimas')->name('rev.ultimasloadmore');

//Notifications
Route::post('/notify_revs','RevisionesController@notifyRevs')->name('rev.notify_revs');


//Users Routes
Route::get('/users', 'UserController@index');
Route::get('/users/obtener_users','UserController@getDataUser')->name('users.getdata');
Route::get('/users/registraruser', 'UserController@create')->name('registraruser');
Route::post('/users/agregaruser','UserController@store')->name('users.agregaruser');
Route::get('/users/fetchdata','UserController@fetchData')->name('users.fetchdata');
Route::post('/users/update', 'UserController@update')->name('users.update');
Route::get('/users/destroy', 'UserController@destroy')->name('users.destroy');
Route::get('/users/multipledestroy','UserController@multipleDestroy')->name('users.multiplesDestroy');
Route::get('/user_change_type', 'UserController@changeType');
Route::post('/user_type_move','UserController@moveType');
Route::post('/users/search','UserController@search')->name('search');
Route::get('/users_conected','UserController@conectedUsers');
Route::resource('users', 'UserController');

//Auth::routes();
// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');     
//Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//Route::post('register', 'Auth\RegisterController@register');  


Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
    
//Home Route
Route::get('/', 'HomeController@index')->name('home');
