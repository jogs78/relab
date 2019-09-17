<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Illuminate\Http\Request;
//use Request;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
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
        
        $type = DB::select( DB::raw("SHOW COLUMNS FROM users WHERE Field = 'tipo_usuario'") )[0]->Type;
             preg_match('/^enum\((.*)\)$/', $type, $matches);
             $enum = array();
             foreach( explode(',', $matches[1]) as $value )
             {
               $v = trim( $value, "'" );
               $enum = array_add($enum, $v, $v);
             }
        
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
        
        $users = User::all();
        return Datatables::of($users)
        
            ->addColumn('action', function($user){
                
                    return '<a href="#" class="btn btn-xs btn-info edit-user" id="'. $user->id .'"><i class="fas fa-user-edit"></i></a> <a href="#" class="btn btn-xs btn-danger delete-user" id="'. $user->id .'"><i class="fas fa-trash-alt"></i></a>';
                
            })
            ->addColumn('changeType', function($user){
                
                    return '<a href="javascript:void(0)" class="btn btn-xs btn-success change-type" id="'. $user->id .'"><i class="fas fa-exchange-alt"></i></a>';
                
            })
            //->addColumn('checkbox', '<input type="checkbox" name="user_checkbox[]" class="user_checkbox" value="{{ $id }}">')
            ->editColumn('status', function($user){
                if ($user->status == 0) {
                    return 'Desconectado';
                }else{
                    return 'Conectado';
                }
            })
            ->editColumn('updated_at', function(User $user) {
                if ($user->updated_at != '') {
                    return $user->updated_at->diffForHumans();   
                }else{
                    return $user->updated_at;
                }
                })
            ->rawColumns(['action','changeType'])
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
            'foto' => 'image|mimes:jpeg,jpg,png,gif|max:2048',
        );

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $image = $request->file('foto');
        if ($image != '') {
            $new_name = Carbon::now()->second.rand() . '.' . $image->getClientOriginalExtension();
            \Storage::disk('local')->put($new_name, \File::get($image));

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
        }else{
            $form_data = array(
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'telefono' => $request->telefono,
                'tipo_usuario' => $request->tipo_usuario,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'numcontrol' => $request->numcontrol
            );
        }

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

    public function profile(Request $request){
        return view('users.perfil');
    }

    public function getProfile(Request $request){
        if ($request->ajax()) {
            $id = $request->input('id');
            $user = User::findOrFail($id);
            return response()->json(['user' => $user]);
        }
    }

    public function fetchData(Request $request){
        if ($request->ajax()) {
            $id = $request->input('id');
            $user = User::findOrFail($id);  
            return response()->json(['data' => $user]);
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

            $image_name = Carbon::now()->second.rand() . '.' . $image->getClientOriginalExtension();
            \Storage::disk('local')->put($image_name, \File::get($image));
            $user = User::find($request->input('user_id'));
                $user->nombre = $request->input('nombre');
                $user->apellido = $request->input('apellido');
                $user->telefono = $request->input('telefono');
                $user->email = $request->input('email');
                $user->path = $image_name;
                $user->numcontrol = $request->input('numcontrol');
                $user->activo = $request->input('activo');
                $user->save();
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
            $user = User::find($request->input('user_id'));
                $user->nombre = $request->input('nombre');
                $user->apellido = $request->input('apellido');
                $user->telefono = $request->input('telefono');
                $user->email = $request->input('email');
                $user->numcontrol = $request->input('numcontrol');
                $user->activo = $request->input('activo');
                $user->save();
        }

        return response()->json(['success' => 'Usuario Actualizado Correctamente']);
    }

    public function changeType(Request $request){
        if ($request->ajax()) {
            $id_user = $request->input('id');
            $user = User::find($id_user);
            return response()->json([$user->tipo_usuario]);
        }
    }

    public function moveType(Request $request){
        $id_user = $request->input('id');
            $user_type = $request->input('user_type');
            $user = User::find($id_user);
            $user->tipo_usuario = $user_type;

            if ($user->save()) {
                return response()->json(['success' => 'Tipo de usuario cambiado exitosamente!']);   
            }else{
                return response()->json(['error' => 'Error al cambiar el tipo de usuario!']);   
            }
    }

//Function to see all conected users
    public function conectedUsers(){
        $output = '';
        $users = User::where('status',1)->get();
        
        return response()->json($users);
        
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
        $revision_detallada_del = DB::table('revision_detalladas')->where('user_id',$request->input('id'));
        $revision_detallada = DB::table('revision_detalladas')
            ->select('revision_id')
            ->where('user_id', $request->input('id'))
            ->get();

        $array_id = array();
        foreach($revision_detallada as $rev) {
            $array_id[] = $rev->revision_id;
        }
        $revs = DB::table('revisions')
                    ->whereIn('id', $array_id);
        if (!empty($revision_detallada_del)) {
            $revision_detallada_del->delete();
        }
        if (!empty($revs)) {
            $revs->delete();
        }
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
