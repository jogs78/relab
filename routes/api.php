<?php

use Illuminate\Http\Request;

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::get('users', function(){
	//return App\User::all();
	return datatables()
		->eloquent(App\User::query())
		->addColumn('btn', 'users.actions')
		//cespecificamos las columnas que no queremos renderizar
		->rawColumns(['btn'])
		->editColumn('updated_at', function(App\User $user) {
                    return $user->updated_at->diffForHumans();
                })
		->toJson();
});

Route::get('/lugar/{id}/mobi','MobiController@byLugar');
Route::get('/lugar/{id}','MobiController@byLugarMobi')->name('api.lugarmobi');
Route::get('/mobi/{id}/items','MobiController@mobiliarios');
Route::get('/prueba', function(){
            

/*$mobis = \DB::select('select item_lugar.lugar_id, item_lugar.lugar_id, pcs.item_id,nombre, num_maquina from item_lugar inner join pcs on item_lugar.item_id = pcs.item_id inner join lugars on item_lugar.lugar_id = 14 where lugars.id = 14');*/

/*$items = \DB::select('select item_lugar.lugar_id, item_lugar.lugar_id, items.id, items.clasificacion, items.descripcion,items.modelo,items.estado,items.marca,items.numero_inventario,items.numero_serie from item_lugar inner join items on item_lugar.item_id = items.id inner join lugars on item_lugar.lugar_id = 20 where lugars.id = 20');*/

//$clasificaciones = \App\Item::getEnumValues('items', 'clasificacion');

$items = \DB::select('select * from items where lugar_id = 20');

$revisiones = \DB::select('select users.nombre, revisions.tipo, revisions.momento, revisions.observaciones, revisions.created_at, revisions.updated_at from users inner join revisions on users.id = revisions.user_id inner join lugars on revisions.lugar_id = lugars.id where lugars.id = 14');

            return $items; 
			        
        });



