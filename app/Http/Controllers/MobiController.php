<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Item;
use App\Pc;
use App\Lugar;
use App\RevisionDetallada;
use DB;
use Validator;

class MobiController extends Controller
{
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
        $clasi = $request->clasificacion;
//        $lugar_id = $request->lugar_id;
        if ($clasi == 'Pc') {
            $rules = array(
                    'descripcion' => 'required',
                    'modelo' => 'required',
                    'estado' => 'required',
                    'marca' => 'required',
                    'numero_inventario' => 'required',
                    'numero_serie' => 'required',
                    'foto' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048',
                    'num_maquina' => 'required',
                    'num_serie_cpu' => 'required',
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
        $new_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('imgmobi'), $new_name);

        $form_data_item = array(
                    'path' => $new_name,
                    'clasificacion' => $request->clasificacion,
                    'descripcion' => $request->descripcion,
                    'modelo' => $request->modelo,
                    'estado' => $request->estado,
                    'marca' => $request->marca,
                    'numero_inventario' => $request->numero_inventario,
                    'numero_serie' => $request->numero_serie,
                    'lugar_id' => $request->lugar_id
        );
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
                    'num_serie_cpu' => $request->num_serie_cpu,
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
                    'foto' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048',
                );

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $image = $request->file('foto');
        $new_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('imgmobi'), $new_name);

        $form_data = array(
            'path' => $new_name,
            'clasificacion' => $request->clasificacion,
            'descripcion' => $request->descripcion,
            'modelo' => $request->modelo,
            'estado' => $request->estado,
            'marca' => $request->marca,
            'numero_inventario' => $request->numero_inventario,
            'numero_serie' => $request->numero_serie,
            'lugar_id' => $request->lugar_id
        );

        Item::create($form_data);

        }

        return response()->json(['success' => 'Mobiliario Agregado Correctamente']);
        
        //return response()->json($form_data_pc);
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
        /*$items = \DB::select(DB::raw('select * from items where lugar_id = :id'), ['id' => $id]);
        $mobis = \DB::select(DB::raw('select * from items inner join lugars on items.lugar_id = :id1 inner join pcs on items.id = pcs.item_id where lugars.id = :id2'), ['id1' => $id, 'id2'=>$id]);
        //$mobi = \DB::select(DB::raw('select * from pcs where item_id = :id'), ['id' => $id]);*/

        $clasificaciones = \App\Item::getEnumValues('items', 'clasificacion');
        //return view('mobiyequipo.mobi', compact('items','mobis','lugar','clasificaciones'));
        return view('mobiyequipo.mobi', compact('lugar','clasificaciones','lugares'));
        
    }
    public function byLugarMobi($id){
        
        $mobis = Item::where('lugar_id', $id)->get();
        //$lugar = Lugar::where('id',$lugar_id)->first();
        return DataTables::of($mobis)
            ->addColumn('action', function($mobi){
                return '<a href="javascript:void(0)" class="btn btn-xs btn-info edit-mobi" id="'. $mobi->id .'"><i class="fas fa-edit"></i></a> <a href="javascript:void(0)" class="btn btn-xs btn-success move-mobi" id="'. $mobi->id .'"><i class="fas fa-exchange-alt"></i></a> <a href="#" class="btn btn-xs btn-danger delete-mobi" id="'. $mobi->id .'"><i class="fas fa-trash-alt"></i></a>';
            })
            //->addColumn('checkbox', '<input type="checkbox" name="mobi_checkbox[]" class="mobi_checkbox" value="{{ $id }}">')
            ->editColumn('updated_at', function(Item $mobi) {
                if ($mobi->updated_at != '') {
                    return $mobi->updated_at->diffForHumans();   
                }else{
                    return $mobi->updated_at;
                }
                })
            ->rawColumns(['action','checkbox'])
            ->make(true);

    }

    public function fetchDataMobiliario($id){
        //if ($request->ajax()) {
            //$id = $request->input('id');
            //$clasi = $request->input('clasi');
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

            //echo json_encode($output);   
            return response()->json($output);
        //}
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
        /*$valor = $request->get('clasificacion');
        return response()->json(['valor' => $valor]);*/

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
                    'sistema_operativo_edit' => 'required',
                    'num_serie_monitor_edit' => 'required',
                    'paq_office_version_edit' => 'required',
                );
                $error = Validator::make($request->all(), $rules);
                if ($error->fails()) {
                    return response()->json(['errors' => $error->errors()->all()]);
                }

                $image_name = rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('imgmobi'), $image_name);
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
                    'sistema_operativo_edit' => 'required',
                    'num_serie_monitor_edit' => 'required',
                    'paq_office_version_edit' => 'required',
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
                    $item->save();

                    $pc = Pc::find($request->input('pc_id_edit'));
                    $pc->num_maquina = $request->input('num_maquina_edit');
                    $pc->tiene_camara  = $request->get('tiene_camara_edit');
                    $pc->tiene_bocinas = $request->get('tiene_bocinas_edit');
                    $pc->num_serie_cpu = $request->input('num_serie_cpu_edit');
                    $pc->ram = $request->input('ram_edit');
                    $pc->disco_duro = $request->input('disco_duro_edit');
                    $pc->sistema_operativo = $request->input('sistema_operativo_edit');
                    $pc->sistema_operativo_activado = $request->get('sistema_operativo_activado_edit');
                    $pc->cable_vga = $request->get('cable_vga_edit');
                    $pc->tiene_monitor = $request->get('tiene_monitor_edit');
                    $pc->num_serie_monitor = $request->input('num_serie_monitor_edit');
                    $pc->tiene_teclado = $request->get('tiene_teclado_edit');
                    $pc->tiene_raton = $request->get('tiene_raton_edit');
                    $pc->controlador_red = $request->get('controlador_red_edit');
                    $pc->paq_office_version = $request->input('paq_office_version_edit');
                    $pc->paq_office_activado = $request->get('paq_office_activado_edit');
                    $pc->observaciones = $request->input('observaciones_edit');
                    $pc->save();
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

                $image_name = rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('imgmobi'), $image_name);
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
                    $item->save();
        }
        

        return response()->json(['success' => 'Mobiliario Actualizado Correctamente']);
    }

    public function changeLugar(Request $request){
        if ($request->ajax()) {
            $id_mobi = $request->input('id');
            $item = Item::find($id_mobi);
            $nombre_lugar = Lugar::find($item->lugar_id);
            return response()->json([$nombre_lugar->nombre]);
        }
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
