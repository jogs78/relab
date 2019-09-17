<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lugar;
use App\Item;
use App\User;
use App\Revision;
use DataTables;
use Validator;
use DB;
use Carbon\Carbon;

class LugarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('home.redirect');
    }
	//function to show the principal page
    public function index(){
    	return view('lugares.index_lugar');
    }

//Function to get all data to the table
    public function getDataLugar(){
    	$lugares = Lugar::all();
    	return Datatables::of($lugares)
    		->addColumn('action', function($lugar){
    			return '<a href="#" class="btn btn-xs btn-info edit-lugar" id="'. $lugar->id .'"><i class="fas fa-edit"></i>Editar</a> <a href="#" class="btn btn-xs btn-danger delete-lugar" id="'. $lugar->id .'"><i class="fas fa-trash-alt"></i>Eliminar</a>';
    		})
            ->editColumn('user_add', function($lugar){
                if ($lugar->user_add == 0) {
                    return 'Cristian R.';
                }else{
                    $user = User::findOrFail($lugar->user_add);
                    return $user->nombre.' '.$user->apellido;
                }
            })
            ->editColumn('user_edit', function($lugar){
                if ($lugar->user_edit == 0 || $lugar->user_edit == null) {
                    return 'Nadie';
                }else{
                    $user = User::findOrFail($lugar->user_edit);
                    return $user->nombre.' '.$user->apellido;
                }
            })
    		->addColumn('checkbox', '<input type="checkbox" name="lugar_checkbox[]" class="lugar_checkbox" value="{{ $id }}">')
    		->editColumn('updated_at', function(Lugar $lugar) {
                    return $lugar->updated_at->diffForHumans();
                })
    		->rawColumns(['action','checkbox'])
    		->make(true);
    }

//Function to post data to the table
    public function postDataLugar(Request $request){
    	$validation = Validator::make($request->all(), [
    		'nombre' => 'required',
            'foto' => 'image|mimes:jpeg,jpg,png,gif|max:2048',
    	]);

    	$error_array = array();
    	$success_output = '';

    	if ($validation->fails()) {
    		foreach($validation->messages()->getMessages() as $field_name => $messages){
    			$error_array[] = $messages;
    		}
    	}else{
            $image = $request->file('foto_lugar');
            if ($image != '') {
                $image_name = Carbon::now()->second.rand() . '.' . $image->getClientOriginalExtension();
                \Storage::disk('local')->put($image_name, \File::get($image));

                //Si obtenemos un insert_lugar como valor en el input hidden agregamos
                if ($request->get('button_action') == "insert_lugar") {
                    $lugar = new Lugar;
                    $lugar->foto = $image_name;
                    $lugar->nombre = $request->get('nombre');
                    $lugar->user_add = $request->get('user_add');
                    $lugar->save();
                    
                    $success_output = 'Lugar Registrado Correctamente';
                }

                //Si obtenemos un update_lugar como valor en el input hidden actualizamos
                if ($request->get('button_action') == "update_lugar") {
                    $lugar = Lugar::find($request->get('lugar_id'));
                    $lugar->foto = $image_name;
                    $lugar->nombre = $request->get('nombre');
                    $lugar->user_edit = $request->get("user_edit");
                    $lugar->save();

                    $success_output = 'Lugar Actualizado Correctamente';
                }
            }else{
                //Si obtenemos un insert_lugar como valor en el input hidden agregamos
                if ($request->get('button_action') == "insert_lugar") {
                    $lugar = new Lugar;
                    $lugar->nombre = $request->get('nombre');
                    $lugar->user_add = $request->get('user_add');
                    $lugar->save();
                    
                    $success_output = 'Lugar Registrado Correctamente';
                }

                //Si obtenemos un update_lugar como valor en el input hidden actualizamos
                if ($request->get('button_action') == "update_lugar") {
                    $lugar = Lugar::find($request->get('lugar_id'));
                    $lugar->nombre = $request->get('nombre');
                    $lugar->user_edit = $$request->get("user_edit");
                    $lugar->save();

                    $success_output = 'Lugar Actualizado Correctamente';
                }
    	   }

        }
        $output = array(
                'error' => $error_array,
                'success' => $success_output,
            );

        return response()->json($output);
    }

//Function to obtain the lugar data for update
    public function fetchDataLugar(Request $request){
    	$id = $request->input('id');
    	$lugar = Lugar::find($id);
    	$output = array(
            'foto' => $lugar->foto,
    		'nombre' => $lugar->nombre,
    	);

    	echo json_encode($output);
    }

    //Funcion para eliminar un registro
    public function removeDataLugar(Request $request){
    	$lugar = Lugar::find($request->input('id'));
        $item_lugar = Item::where('lugar_id', $request->input('id'))->first();
        $rev_lugar = Revision::where('lugar_id', $request->input('id'))->first();

        if ($item_lugar != '' || $rev_lugar != '') {
            
            if ($item_lugar != '') {
                return "Ups lo sentimos no podemos eliminar el lugar tiene mobiliario y equipo, para eliminarlo tienes que dejar vacio el lugar cambiar de lugar o eliminar el mobiliario";
            }else{
                return 1;
            }
        }else{

            if ($lugar->delete()) {
                return 'Lugar Eliminado Correctamente';   
            }

        }

    }

    public function deleteRevsNLugar(Request $request){
        $lugar = Lugar::find($request->input('id'));
        $rev_lugar = Revision::where('lugar_id', $request->input('id'))->first();

        
                    $revis = array();
                    $revisiones_lugar = Revision::where('lugar_id', $request->input('id'))->get();
                    if ($revisiones_lugar != "") {
                        foreach ($revisiones_lugar as $revs) {
                            $revis[] = $revs->id;
                        }
                        $revisiones_1 =DB::table('revision_rapidas')->whereIn('revision_id', $revis)->delete();
                        //DB::delete('delete from users');
                        //DB::delete('delete from revision_rapidas where revision_id = ?',[$revis]);
                        /*$revis_rap = array();
                        if ($revisiones_1 != "") {
                            foreach ($revisiones_1 as $revs_rap) {
                                $revis_rap[] = $revs_rap->revision_id;
                            }
                        }*/
                        $revisiones_2 = DB::table('revision_detalladas')->whereIn('revision_id', $revis)->delete();
                        //DB::delete('delete from revision_detalladas where revision_id = ?',[$revis]);
                        $revisiones_3= DB::table('revision_detalladas2')->whereIn('revision_id', $revis)->delete();
                        //DB::delete('delete from revision_detalladas2 where revision_id = ?',[$revis]);
                        /*$revis_det1 = array();
                        $revis_det2 = array();
                        if ($revisiones_2 != "") {
                            foreach ($revisiones_2 as $revs_det1) {
                                $revis_det1[] = $revs_det1->revision_id;
                            }
                        }
                        if ($revisiones_3 != "") {
                            foreach ($revisiones_3 as $revs_det2) {
                                $revis_det2[] = $revs_det2->revision_id;
                            }
                        }*/
                        /*if ($revisiones_1){
                            $revisiones_1->delete();
                        }
                        if ($revisiones_2) {
                            $revisiones_2->delete();
                        }
                        if ($revisiones_3) {
                            $revisiones_3->delete();   
                        }*/
                        //if ($revisiones_lugar != "") {
                            
                        //}
//                        return response()->json([$revis_rap, $revis_det1, $revis_det2]);
                        if (DB::table('revisions')->whereIn('id', $revis)->delete()) {
                            if ($lugar->delete()) {
                        return 'Lugar Eliminado Correctamente';   
                    }
                        }
                    

               }
    }

    //funcion para eliminar multiples registros
    public function massRemoveLugar(Request $request){
    	$lugar_id_array = $request->input('id');
    	$lugar = Lugar::whereIn('id', $lugar_id_array);
        $item_lugar = Item::whereIn('lugar_id', $lugar_id_array);
        $rev_lugar = Revision::whereIn('lugar_id', $lugar_id_array);
    	if ($item_lugar != '' || $rev_lugar != '') {
            
            if ($item_lugar != '') {
                return "Ups lo sentimos no podemos eliminar el lugar tiene mobiliario y equipo, para eliminarlo tienes que dejar vacio el lugar cambiar de lugar o eliminar el mobiliario";
            }else{
                return 1;
            }
        }else{

            if ($lugar->delete()) {
                return 'Lugar Eliminado Correctamente';   
            }

        }
    }
}
