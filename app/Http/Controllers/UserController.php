<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Illuminate\Http\Request;
//use Request;
use Illuminate\Support\Facades\Crypt;
use App\User;
use DB;
use DataTables;
use Validator;

class UserController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$users = User::all();
        $type = DB::select( DB::raw("SHOW COLUMNS FROM users WHERE Field = 'tipo_usuario'") )[0]->Type;
             preg_match('/^enum\((.*)\)$/', $type, $matches);
             $enum = array();
             foreach( explode(',', $matches[1]) as $value )
             {
               $v = trim( $value, "'" );
               $enum = array_add($enum, $v, $v);
             }
             //return $enum;
        
        return view('users.users_index', compact('enum'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create_users');
    }

    //Function to get all data to the table
    public function getDataUser(){
        //$lugares = Lugar::select('id','nombre', 'updated_at');
        $users = User::all();
        return Datatables::of($users)
            ->addColumn('action', function($user){
                return '<a href="#" class="btn btn-xs btn-info edit-user" id="'. $user->id .'"><i class="fas fa-user-edit"></i></a> <a href="#" class="btn btn-xs btn-danger delete-user" id="'. $user->id .'"><i class="fas fa-trash-alt"></i></a>';
            })
            ->addColumn('checkbox', '<input type="checkbox" name="user_checkbox[]" class="user_checkbox" value="{{ $id }}">')
            ->editColumn('updated_at', function(User $user) {
                if ($user->updated_at != '') {
                    return $user->updated_at->diffForHumans();   
                }else{
                    return $user->updated_at;
                }
                })
            ->rawColumns(['action','checkbox'])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'nombre' => 'required',
            'apellido' => 'required',
            'telefono' => 'required|min:10|numeric',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|string|min:6',
            'foto' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048',
        );

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $image = $request->file('foto');
        $new_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('imguser'), $new_name);

        $form_data = array(
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'telefono' => $request->telefono,
            'tipo_usuario' => $request->tipo_usuario,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'path' => $new_name,
            'numcontrol' => $request->numcontrol
        );

        User::create($form_data);

        return response()->json(['success' => 'Usuario Agregado Correctamente']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    public function fetchData(Request $request){
        if ($request->ajax()) {
            $id = $request->input('id');
            $mobi = User::findOrFail($id);
            /*$output = array(
                'nombre' => $mobi->nombre,
                'apellido' => $mobi->apellido,
                'telefono' => $mobi->telefono,
                'tipo_usuario' => $mobi->tipo_usuario,
                'email' => $mobi->email,
                'path' => $mobi->path,
                'numcontrol' => $mobi->numcontrol
            );*/

            //echo json_encode($output);   
            return response()->json(['data' => $mobi]);
        }
    }

    public function search(){
        return view('users.buscar_users.php');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $image_name = $request->input('path');
        $image = $request->file('path_file');
        if ($image != '') {
            $rules = array(
                'nombre' => 'required',
                'apellido' => 'required',
                'telefono' => 'required|min:10|numeric',
                'email' => 'required|email|max:255',
                'path_file' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048',
            );
            $error = Validator::make($request->all(), $rules);
            if ($error->fails()) {
                return response()->json(['errors' => $error->errors()->all()]);
            }

            $image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('imguser'), $image_name);
        }else{
            $rules = array(
                'nombre' => 'required',
                'apellido' => 'required',
                'telefono' => 'required|min:10|numeric',
                'email' => 'required|email|max:255',
            );

            $error = Validator::make($request->all(), $rules);

            if ($error->fails()) {
                return response()->json(['errors' => $error->errors()->all()]);
            }
        }

        /*$form_data = array(
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'telefono' => $request->telefono,
            'tipo_usuario' => $request->tipo_usuario,
            'email' => $request->email,
            'path' => $image_name,
            'numcontrol' => $request->numcontrol
        );

        User::whereId($request->user_id)
            ->update($form_data);*/
        $user = User::find($request->input('user_id'));
                $user->nombre = $request->input('nombre');
                $user->apellido = $request->input('apellido');
                $user->telefono = $request->input('telefono');
                $user->email = $request->input('email');
                $user->path = $image_name;
                $user->numcontrol = $request->input('numcontrol');
                $user->save();

        return response()->json(['success' => 'Usuario Actualizado Correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = User::find($request->input('id'));
        if ($user->delete()) {
            return 'Usuario Eliminado Correctamente';
        }
    }

    public function multipleDestroy(Request $request){
        $user_id_array = $request->input('id');
        $user = User::whereIn('id', $user_id_array);

        if ($user->delete()) {
            return 'Usuarios Eliminados Correctamente';
        }
    }
}
