<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Item;
use App\Pc;
use App\Lugar;
use App\User;
use App\RevisionDetallada;
use DB;
use Validator;
use Carbon\Carbon;

class MobiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('home.redirect');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return view('mobiyequipo.mobi');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    public function addMobiliario(Request $request){
        $clasi = $request->clasificacion;

        if($clasi != ''){
//This if is to know, if the item is Pc or something different
        if ($clasi == 'Pc') {
            $rules = array(
                    'descripcion' => 'required',
                    'modelo' => 'required',
                    'estado' => 'required',
                    'marca' => 'required',
                    'numero_inventario' => 'required',
                    'numero_serie' => 'required',
                    'foto' => 'image|mimes:jpeg,jpg,png,gif|max:2048',
                    'num_maquina' => 'required',
                    'ram' => 'required',
                    'disco_duro' => 'required',
                    'sistema_operativo' => 'required',
                    'num_serie_monitor' => 'required',
                    'paq_office_version' => 'required',
                );

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $image = $request->file('foto');
        
        if ($image != '') {
            $image_name = Carbon::now()->second.rand() . '.' . $image->getClientOriginalExtension();
            \Storage::disk('local')->put($image_name, \File::get($image));

            $form_data_item = array(
                    'path' => $image_name,
                    'clasificacion' => $request->clasificacion,
                    'descripcion' => $request->descripcion,
                    'modelo' => $request->modelo,
                    'estado' => $request->estado,
                    'marca' => $request->marca,
                    'numero_inventario' => $request->numero_inventario,
                    'numero_serie' => $request->numero_serie,
                    'lugar_id' => $request->lugar_id,
                    'user_id' => $request->user_id_mobi
            );

        }else{
            $form_data_item = array(
                    'clasificacion' => $request->clasificacion,
                    'descripcion' => $request->descripcion,
                    'modelo' => $request->modelo,
                    'estado' => $request->estado,
                    'marca' => $request->marca,
                    'numero_inventario' => $request->numero_inventario,
                    'numero_serie' => $request->numero_serie,
                    'lugar_id' => $request->lugar_id,
                    'user_id' => $request->user_id_mobi
            );
        }
        
        Item::create($form_data_item);

        
        $item_id = DB::table('items')
            ->select('id')
            ->orderBy('created_at', 'desc')
            ->first();

        $form_data_pc = array(
                    'item_id' => $item_id->id,
                    'num_maquina' => $request->num_maquina,
                    'tiene_camara' => $request->tiene_camara,
                    'tiene_bocinas' => $request->tiene_bocinas,
                    'num_serie_cpu' => $request->numero_serie,
                    'ram' => $request->ram,
                    'disco_duro' => $request->disco_duro,
                    'sistema_operativo' => $request->sistema_operativo,
                    'sistema_operativo_activado' => $request->sistema_operativo_activado,
                    'cable_vga' => $request->cable_vga,
                    'tiene_monitor' => $request->tiene_monitor,
                    'num_serie_monitor' => $request->num_serie_monitor,
                    'tiene_teclado' => $request->tiene_teclado,
                    'tiene_raton' => $request->tiene_raton,
                    'controlador_red' => $request->controlador_red,
                    'paq_office_version' => $request->paq_office_version,
                    'paq_office_activado' => $request->paq_office_activado,
                    'observaciones' => $request->observaciones
        );
        
        Pc::create($form_data_pc);

        }else{

            $rules = array(
                    'descripcion' => 'required',
                    'modelo' => 'required',
                    'estado' => 'required',
                    'marca' => 'required',
                    'numero_inventario' => 'required',
                    'numero_serie' => 'required',
                    'foto' => 'image|mimes:jpeg,jpg,png,gif|max:2048',
                );

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $image = $request->file('foto');
        if ($image != '') {
            $image_name = Carbon::now()->second.rand() . '.' . $image->getClientOriginalExtension();
            \Storage::disk('local')->put($image_name, \File::get($image));

            $form_data = array(
                'path' => $image_name,
                'clasificacion' => $request->clasificacion,
                'descripcion' => $request->descripcion,
                'modelo' => $request->modelo,
                'estado' => $request->estado,
                'marca' => $request->marca,
                'numero_inventario' => $request->numero_inventario,
                'numero_serie' => $request->numero_serie,
                'lugar_id' => $request->lugar_id,
                'user_id' => $request->user_id_mobi
            );

        }else{
            $form_data = array(
                'clasificacion' => $request->clasificacion,
                'descripcion' => $request->descripcion,
                'modelo' => $request->modelo,
                'estado' => $request->estado,
                'marca' => $request->marca,
                'numero_inventario' => $request->numero_inventario,
                'numero_serie' => $request->numero_serie,
                'lugar_id' => $request->lugar_id,
                'user_id' => $request->user_id_mobi
            );
        }

        Item::create($form_data);

        }

        return response()->json(['success' => 'Mobiliario Agregado Correctamente']);
        
        }else{
            return response()->json(['cla' => 'Tienes que elegir una clasificación']);
        }
    }

    public function byLugar($id){
        return Item::where('lugar_id', $id)->get();
    }

    public function mobiliarios($id){

        $item = \DB::select(DB::raw('select * from items where id = :id'), ['id' => $id]);
        $mobi = \DB::select(DB::raw('select * from pcs where item_id = :id'), ['id' => $id]);
        return Pc::where('item_id', $id)->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lugar = Lugar::find($id);
        $lugares = Lugar::all();

        $clasificaciones = \App\Item::getEnumValues('items', 'clasificacion');
        
        return view('mobiyequipo.mobi', compact('lugar','clasificaciones','lugares'));
        
    }

    public function byLugarMobi($id){
        
        $mobis = Item::where('lugar_id', $id)->get();

        return DataTables::of($mobis)
            ->addColumn('change', function($mobi){
                return '<a href="javascript:void(0)" class="btn btn-xs btn-success move-mobi" style="width:100%;" id="'. $mobi->id .'"><i class="fas fa-exchange-alt"></i></a>';
            })
            ->addColumn('action', function($mobi){
                return '<a href="javascript:void(0)" class="btn btn-xs btn-info edit-mobi" id="'. $mobi->id .'"><i class="fas fa-edit"></i></a> <a href="#" class="btn btn-xs btn-danger delete-mobi" id="'. $mobi->id .'"><i class="fas fa-trash-alt"></i></a>';
            })
            ->editColumn('numero_serie', function($mobi){
                if ($mobi->clasificacion == 'Pc') {
                    $pc_ns = Pc::where('item_id',$mobi->id)->first();
                    if ($pc_ns != null || $pc_ns != '') {
                        return $pc_ns->num_serie_cpu;   
                    }else{
                        return '';
                    }
                }else{
                    return $mobi->numero_serie;
                }
            })
            ->addColumn('checkbox', '<input type="checkbox" name="mobi_checkbox[]" class="form-check-input mobi_checkbox" value="{{ $id }}">')
            ->editColumn('updated_at', function(Item $mobi) {
                if ($mobi->updated_at != '') {
                    return $mobi->updated_at->diffForHumans();   
                }else{
                    return $mobi->updated_at;
                }
                })
            ->rawColumns(['action','change','checkbox'])
            ->make(true);

    }

    public function fetchDataMobiliario($id){
            $mobi = Item::find($id);

            if ($mobi->clasificacion != 'Pc') {
                $output = array(
                    'id' => $mobi->id,
                    'path' => $mobi->path,
                    'clasificacion' => $mobi->clasificacion,
                    'descripcion' => $mobi->descripcion,
                    'modelo' => $mobi->modelo,
                    'estado' => $mobi->estado,
                    'marca' => $mobi->marca,
                    'numero_inventario' => $mobi->numero_inventario,
                    'numero_serie' => $mobi->numero_serie,
                );   
            }else{
                $pc = Pc::where('item_id',$id)->first();
                if (!empty($pc)) {
                    $output = array(
                        'id' => $mobi->id,
                        'path' => $mobi->path,
                        'clasificacion' => $mobi->clasificacion,
                        'descripcion' => $mobi->descripcion,
                        'modelo' => $mobi->modelo,
                        'estado' => $mobi->estado,
                        'marca' => $mobi->marca,
                        'numero_inventario' => $mobi->numero_inventario,
                        'numero_serie' => $mobi->numero_serie,
                        'id_pc' => $pc->id,
                        'num_maquina' => $pc->num_maquina,
                        'tiene_camara' => $pc->tiene_camara,
                        'tiene_bocinas' => $pc->tiene_bocinas,
                        'num_serie_cpu' => $pc->num_serie_cpu,
                        'ram' => $pc->ram,
                        'disco_duro' => $pc->disco_duro,
                        'sistema_operativo' => $pc->sistema_operativo,
                        'sistema_operativo_activado' => $pc->sistema_operativo_activado,
                        'cable_vga' => $pc->cable_vga,
                        'tiene_monitor' => $pc->tiene_monitor,
                        'num_serie_monitor' => $pc->num_serie_monitor,
                        'tiene_teclado' => $pc->tiene_teclado,
                        'tiene_raton' => $pc->tiene_raton,
                        'controlador_red' => $pc->controlador_red,
                        'paq_office_version' => $pc->paq_office_version,
                        'paq_office_activado' => $pc->paq_office_activado,
                        'observaciones' => $pc->observaciones
                    );   
                }else{
                    $output = array(
                        'id' => $mobi->id,
                        'path' => $mobi->path,
                        'clasificacion' => $mobi->clasificacion,
                        'descripcion' => $mobi->descripcion,
                        'modelo' => $mobi->modelo,
                        'estado' => $mobi->estado,
                        'marca' => $mobi->marca,
                        'numero_inventario' => $mobi->numero_inventario,
                        'numero_serie' => $mobi->numero_serie
                    );
                }
            }

            return response()->json($output);
        
    }

//Function to know the quantity of each item
    public function itemsQuantity(Request $request){
        $lugar = Lugar::find($request->input('id'));

        $pc_cant = DB::table('items')
            ->where('lugar_id', $lugar->id)
            ->where('clasificacion','Pc')
            ->count();
        $mesa_cant = DB::table('items')
            ->where('lugar_id', $lugar->id)
            ->where('clasificacion','Mesa')
            ->count();
        $silla_cant = DB::table('items')
            ->where('lugar_id', $lugar->id)
            ->where('clasificacion','Silla')
            ->count();
        $piz_cant = DB::table('items')
            ->where('lugar_id', $lugar->id)
            ->where('clasificacion','Pizarrón')
            ->count();
        $television_cant = DB::table('items')
            ->where('lugar_id', $lugar->id)
            ->where('clasificacion','Television')
            ->count();
        $termostato_cant = DB::table('items')
            ->where('lugar_id', $lugar->id)
            ->where('clasificacion','Termostato')
            ->count();
        $ruteador_cant = DB::table('items')
            ->where('lugar_id', $lugar->id)
            ->where('clasificacion','Ruteador')
            ->count();
        $swith_cant = DB::table('items')
            ->where('lugar_id', $lugar->id)
            ->where('clasificacion','Switch')
            ->count();

        $output = array(
            'pc_cant' => $pc_cant,
            'mesa_cant' => $mesa_cant,
            'silla_cant' => $silla_cant,
            'piz_cant' => $piz_cant,
            'television_cant' => $television_cant,
            'termostato_cant' => $termostato_cant,
            'ruteador_cant' => $ruteador_cant,
            'swith_cant' => $swith_cant,
        );

        return response()->json($output);
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
    public function update(Request $request){

        if ($request->get('clasificacion_edit') == 'Pc') {

            $image_name = $request->input('path_edit');
            $image = $request->file('path_file_edit');

            if ($image != '') {

                $rules = array(
                    'descripcion_edit' => 'required',
                    'modelo_edit' => 'required',
                    'estado_edit' => 'required',
                    'marca_edit' => 'required',
                    'numero_inventario_edit' => 'required',
                    'numero_serie_edit' => 'required',
                    'path_file_edit' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048',
                    'num_maquina_edit' => 'required',
                    'num_serie_cpu_edit' => 'required',
                    'ram_edit' => 'required',
                    'disco_duro_edit' => 'required',
                    //'sistema_operativo_edit' => 'required',
                    'num_serie_monitor_edit' => 'required',
                    //'paq_office_version_edit' => 'required',
                );
                $error = Validator::make($request->all(), $rules);
                if ($error->fails()) {
                    return response()->json(['errors' => $error->errors()->all()]);
                }

                $image_name = Carbon::now()->second.rand() . '.' . $image->getClientOriginalExtension();
            
                \Storage::disk('local')->put($image_name, \File::get($image));

            }else{
                $rules = array(
                    'descripcion_edit' => 'required',
                    'modelo_edit' => 'required',
                    'estado_edit' => 'required',
                    'marca_edit' => 'required',
                    'numero_inventario_edit' => 'required',
                    'numero_serie_edit' => 'required',
                    'num_maquina_edit' => 'required',
                    'num_serie_cpu_edit' => 'required',
                    'ram_edit' => 'required',
                    'disco_duro_edit' => 'required',
                    //'sistema_operativo_edit' => 'required',
                    'num_serie_monitor_edit' => 'required',
                    //'paq_office_version_edit' => 'required',
                );

                $error = Validator::make($request->all(), $rules);

                if ($error->fails()) {
                    return response()->json(['errors' => $error->errors()->all()]);
                }
            }

                    $item = Item::find($request->input('mobi_id_edit'));
                    $item->descripcion = $request->input('descripcion_edit');
                    $item->modelo = $request->input('modelo_edit');
                    $item->estado = $request->input('estado_edit');
                    $item->marca = $request->input('marca_edit');
                    $item->path = $image_name;
                    $item->numero_inventario = $request->input('numero_inventario_edit');
                    $item->numero_serie = $request->input('numero_serie_edit');
                    $item->user_edit = $request->input('user_edit');
                    $item->save();

                    $pc = Pc::find($request->input('pc_id_edit'));
                    if ($pc != null) {
                        $pc->num_maquina = $request->get('num_maquina_edit');
                        $pc->tiene_camara  = $request->get('tiene_camara_edit');
                        $pc->tiene_bocinas = $request->get('tiene_bocinas_edit');
                        $pc->num_serie_cpu = $request->get('numero_serie_edit');
                        $pc->ram = $request->get('ram_edit');
                        $pc->disco_duro = $request->input('disco_duro_edit');
                        $pc->sistema_operativo = $request->get('sistema_operativo_edit');
                        $pc->sistema_operativo_activado = $request->get('sistema_operativo_activado_edit');
                        $pc->cable_vga = $request->get('cable_vga_edit');
                        $pc->tiene_monitor = $request->get('tiene_monitor_edit');
                        $pc->num_serie_monitor = $request->input('num_serie_monitor_edit');
                        $pc->tiene_teclado = $request->get('tiene_teclado_edit');
                        $pc->tiene_raton = $request->get('tiene_raton_edit');
                        $pc->controlador_red = $request->get('controlador_red_edit');
                        $pc->paq_office_version = $request->get('paq_office_version_edit');
                        $pc->paq_office_activado = $request->get('paq_office_activado_edit');
                        $pc->observaciones = $request->input('observaciones_edit');
                        $pc->save();   
                    }else{
                        $form_data_pc = array(
                            'item_id' => $item->id,
                            'num_maquina' => $request->input('num_maquina_edit'),
                            'tiene_camara' => $request->get('tiene_camara_edit'),
                            'tiene_bocinas' => $request->get('tiene_bocinas_edit'),
                            'num_serie_cpu' => $request->input('numero_serie_edit'),
                            'ram' => $request->input('ram_edit'),
                            'disco_duro' => $request->input('disco_duro_edit'),
                            'sistema_operativo' => $request->input('sistema_operativo_edit'),
                            'sistema_operativo_activado' => $request->get('sistema_operativo_activado_edit'),
                            'cable_vga' => $request->get('cable_vga_edit'),
                            'tiene_monitor' => $request->get('tiene_monitor_edit'),
                            'num_serie_monitor' => $request->input('num_serie_monitor_edit'),
                            'tiene_teclado' => $request->get('tiene_teclado_edit'),
                            'tiene_raton' => $request->get('tiene_raton_edit'),
                            'controlador_red' => $request->get('controlador_red_edit'),
                            'paq_office_version' => $request->input('paq_office_version_edit'),
                            'paq_office_activado' => $request->get('paq_office_activado_edit'),
                            'observaciones' => $request->input('observaciones_edit')
                        );
                
                        Pc::create($form_data_pc);
                    }

                    return response()->json(['success' => 'Mobiliario Actualizado Correctamente']);
        }else{

            $image_name = $request->input('path_edit');
            $image = $request->file('path_file_edit');

            if ($image != '') {
                $rules = array(
                    'descripcion_edit' => 'required',
                    'modelo_edit' => 'required',
                    'estado_edit' => 'required',
                    'marca_edit' => 'required',
                    'numero_inventario_edit' => 'required',
                    'numero_serie_edit' => 'required',
                    'path_file_edit' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048',
                );
                $error = Validator::make($request->all(), $rules);
                if ($error->fails()) {
                    return response()->json(['errors' => $error->errors()->all()]);
                }

                $image_name = Carbon::now()->second.rand() . '.' . $image->getClientOriginalExtension();
            
            \Storage::disk('local')->put($image_name, \File::get($image));
            }else{
                $rules = array(
                    'descripcion_edit' => 'required',
                    'modelo_edit' => 'required',
                    'estado_edit' => 'required',
                    'marca_edit' => 'required',
                    'numero_inventario_edit' => 'required',
                    'numero_serie_edit' => 'required'
                );

                $error = Validator::make($request->all(), $rules);

                if ($error->fails()) {
                    return response()->json(['errors' => $error->errors()->all()]);
                }
            }

                    $item = Item::find($request->input('mobi_id_edit'));
                    $item->descripcion = $request->input('descripcion_edit');
                    $item->modelo = $request->input('modelo_edit');
                    $item->estado = $request->input('estado_edit');
                    $item->marca = $request->input('marca_edit');
                    $item->path = $image_name;
                    $item->numero_inventario = $request->input('numero_inventario_edit');
                    $item->numero_serie = $request->input('numero_serie_edit');
                    $item->user_edit = $request->input('user_edit');
                    $item->save();

            return response()->json(['success' => 'Mobiliario Actualizado Correctamente']);
        }
        
    }


    //function to show details from the items
    public function showDetailMobi(Request $request){
        $mobi = Item::find($request->id);

        if ($mobi->clasificacion != 'Pc') {
            if ($mobi->user_id != 0 || $mobi->user_id != null) {
                $user_add_mobi = User::where('id',$mobi->user_id)->first();
            }else{
                $user_add_mobi = array(
                    'nombre' => 'Cristian',
                    'apellido' => 'Ruiz'
                );
            }
            if ($mobi->user_edit != 0 || $mobi->user_edit != null) {
                $user_edit_mobi = User::where('id',$mobi->user_edit)->first();
            }else{
                $user_edit_mobi = array(
                    'nombre' => 'Nadie',
                );
            }

            return response()->json(['mobi' => $mobi,'user_add' => $user_add_mobi,'user_edit' => $user_edit_mobi]);
        }else{
            $pc = Pc::where('item_id',$mobi->id)->first();

            if ($mobi->user_id != 0 || $mobi->user_id != null) {
                $user_add_mobi = User::where('id',$mobi->user_id)->first();
            }else{
                $user_add_mobi = array(
                    'nombre' => 'Cristian',
                    'apellido' => 'Ruiz'
                );
            }
            if ($mobi->user_edit != 0 || $mobi->user_edit != null) {
                $user_edit_mobi = User::where('id',$mobi->user_edit)->first();
            }else{
                $user_edit_mobi = array(
                    'nombre' => 'Nadie',
                );
            }

            return response()->json(['mobi' => $mobi,'pc' => $pc,'user_add' => $user_add_mobi,'user_edit' => $user_edit_mobi]);
        }
    }

    public function changeLugar(Request $request){
        //if ($request->ajax()) {
            $id_mobi = $request->input('id');
            $item = Item::findOrFail($id_mobi);
            $nombre_lugar = Lugar::find($item->lugar_id);
            return response()->json([$nombre_lugar->nombre]);
        //}
    }

    public function moveLugar(Request $request){
        
            $id_mobi = $request->input('id');
            $lugar_id = $request->input('lugar_id');
            $item = Item::find($id_mobi);
            $item->lugar_id = $lugar_id;

            if ($item->save()) {
                return response()->json(['success' => 'El cambio de lugar a sido exitoso!']);   
            }else{
                return response()->json(['error' => 'Error al cambiar de lugar!']);   
            }
        
    }

    public function severalChangeMobi(Request $request){
        $mobi_id_array = $request->input('id_1');
        $lugar_id = $request->input('lugar_id');
        $yes = null;
        $it = array();
        $mobi = Item::whereIn('id', $mobi_id_array)->get();
        foreach($mobi as $item){
            $item->lugar_id = $lugar_id;
            $yes = $item->update();
        }
        if ($yes) {
                return response()->json(['success' => 'El cambio de lugar a sido exitoso!']);   
        }else{
                return response()->json(['error' => 'Error al cambiar de lugar!']);   
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $item = Item::find($request->input('id'));
        $pc = Pc::where('item_id',$request->input('id'))->first();
        $revision_detallada_del = DB::table('revision_detalladas')->where('item_id',$request->input('id'));
        $revision_detallada = DB::table('revision_detalladas')
            ->select('revision_id')
            ->where('item_id', $request->input('id'))
            ->get();
        $array_id = array();
        foreach($revision_detallada as $rev) {
            $array_id[] = $rev->revision_id;
        }
        //$rev = json_decode($revision_detallada[0]->revision_id);
        //$ids = json_encode($array_id)
        $revs = DB::table('revisions')
                    ->whereIn('id', $array_id);
        if (!empty($revision_detallada_del)) {
            $revision_detallada_del->delete();
        }
        if (!empty($revs)) {
            $revs->delete();
        }
        if (!empty($pc)) {
            $pc->delete();   
        }
        if ($item->delete()) {
            return 'Mobiliario Eliminado Correctamente';
        }
    }

    public function multipleDestroy(Request $request){
        $mobi_id_array = $request->input('id');
        $mobi = Item::whereIn('id', $mobi_id_array);
        $pc = Pc::whereIn('item_id', $mobi_id_array);
        if (!empty($pc)) {
            $pc->delete();
        }
        if ($mobi->delete()) {
            return 'Mobiliarios Eliminados Correctamente';
        }
    }

}
