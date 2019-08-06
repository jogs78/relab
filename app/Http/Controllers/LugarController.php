<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lugar;
use App\Item;
use App\User;
use App\Revision;
use DataTables;
use Validator;
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
            return "Ups lo sentimos no podemos eliminar el lugar ya tiene mobiliario o revisiones, para eliminarlo tienes que dejar vacio el lugar cambiar de lugar o eliminar el mobiliario y revisiones";
        }else{
            if ($lugar->delete()) {
                echo 'Lugar Eliminado Correctamente';   
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
            return "Ups lo sentimos no podemos eliminar estos lugares ya tiene mobiliario o revisiones, para eliminarlo tienes que dejar vacio el lugar cambiar de lugar o eliminar el mobiliario y revisiones";
        }else{
            if ($lugar->delete()) {
                echo 'Lugares Eliminado Correctamente';   
            }
        }
    }
}
