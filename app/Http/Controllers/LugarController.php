<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lugar;
use App\Item;
use App\Revision;
use DataTables;
use Validator;

class LugarController extends Controller
{
	//function to show the principal page
    public function index(){
    	return view('lugares.index_lugar');
    }

//Function to get all data to the table
    public function getDataLugar(){
    	$lugares = Lugar::select('id','nombre', 'updated_at');
    	return Datatables::of($lugares)
    		->addColumn('action', function($lugar){
    			return '<a href="#" class="btn btn-xs btn-info edit-lugar" id="'. $lugar->id .'"><i class="fas fa-edit"></i>Editar</a> <a href="#" class="btn btn-xs btn-danger delete-lugar" id="'. $lugar->id .'"><i class="fas fa-trash-alt"></i>Eliminar</a>';
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
    	]);

    	$error_array = array();
    	$success_output = '';

    	if ($validation->fails()) {
    		foreach($validation->messages()->getMessages() as $field_name => $messages){
    			$error_array[] = $messages;
    		}
    	}else{
    		//Si obtenemos un insert_lugar como valor en el input hidden agregamos
    		if ($request->get('button_action') == "insert_lugar") {
    			$lugar = new Lugar;
    			$lugar->nombre = $request->get('nombre');
    			$lugar->save();
    			//$success_output = '<div class="alert alert-success">Lugar Registrado</div>';
    			$success_output = 'Lugar Registrado Correctamente';
    		}

    		//Si obtenemos un update_lugar como valor en el input hidden actualizamos
    		if ($request->get('button_action') == "update_lugar") {
    			$lugar = Lugar::find($request->get('lugar_id'));
    			$lugar->nombre = $request->get('nombre');
    			$lugar->save();
    			/*$success_output = '<div class="alert alert-success">
    				Lugar Actualizado
    			</div>';*/
    			$success_output = 'Lugar Actualizado Correctamente';
    		}
    	}

    	$output = array(
    		'error' => $error_array,
    		'success' => $success_output
    	);

    	echo json_encode($output);
    }

//Function to obtain the lugar data for update
    public function fetchDataLugar(Request $request){
    	$id = $request->input('id');
    	$lugar = Lugar::find($id);
    	$output = array(
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
