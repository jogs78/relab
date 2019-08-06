<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Lugar;
use App\Revision;
use App\Item;
use App\Pc;
use DB;
use DataTables;
use Validator;

class RevisionesController extends Controller
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
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lugares = Lugar::where('id', $id)->first();

        /*$revisiones = \DB::select(DB::raw('select users.nombre, revisions.tipo, revisions.momento, revisions.observaciones, revisions.created_at, revisions.updated_at from users inner join revisions on users.id = revisions.user_id inner join lugars on revisions.lugar_id = lugars.id where lugars.id = :id'), ['id' => $id]);*/

        return view('revisiones.revisiones_index', compact('lugares'));
    }
    public function byLugarRev($id){
        
                $revs = Revision::where('lugar_id', $id)->get();
        
                return DataTables::of($revs)
                    ->addColumn('action', function($rev){
                        return '<a href="javascript:void(0)" class="btn btn-xs btn-info edit-rev" id="'. $rev->id .'"><i class="fas fa-eye"></i></a>';// <a href="#" class="btn btn-xs btn-danger delete-rev" id="'. $rev->id .'"><i class="fas fa-trash-alt"></i></a>';
                    })
                    ->editColumn('lugar_id', function($lugar){
                        $lugar_nombre = Lugar::where('id',$lugar->lugar_id)->first();
                        return $lugar_nombre->nombre;
                    })
                    ->editColumn('user_id', function($user){
                        $user_nombre = User::where('id',$user->user_id)->first();
                        return $user_nombre->nombre;
                    })
                    ->editColumn('updated_at', function(Revision $rev) {
                        if ($rev->updated_at != '') {
                            return $rev->updated_at->diffForHumans();   
                        }else{
                            return $rev->updated_at;
                        }
                        })
                    ->rawColumns(['action','checkbox'])
                    ->make(true);
        

    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }
    public function fetchDataRev($id){
        $revision = Revision::find($id);
            
        if ($revision->tipo == '') {

            $nombre_user_rev = User::where('id', $revision->user_id)->first();
            $nombre_lugar_rev = Lugar::where('id', $revision->lugar_id)->first();

            $output = array(
                'id' => $revision->id,
                'user_id' => $nombre_user_rev->nombre . ' '.$nombre_user_rev->apellido,
                'lugar_id' => $nombre_lugar_rev->nombre,
                'tipo' => $revision->tipo,
                'momento' => $revision->momento,
                'observaciones' => $revision->observaciones,
                'created_at' => $revision->created_at,
                'updated_at' => $revision->updated_at
            );   
        }else{
                
            if ($revision->tipo == 'Detallada' || $revision->tipo == 'detallada') {
                $rev_detallada = DB::table('revision_detalladas2')
                    ->where('revision_id',$revision->id)
                    ->get();

                $array_item_id = array();
                $array_num_maquina = array();
                $array_tiene_camara = array();
                $array_tiene_bocinas = array();
                $array_num_serie_cpu = array();
                $array_ram = array();
                $array_disco_duro = array();
                $array_sistema_operativo = array();
                $array_sistema_operativo_activado = array();
                $array_cable_vga = array();
                $array_tiene_monitor = array();
                $array_num_serie_monitor = array();
                $array_tiene_teclado = array();
                $array_tiene_raton = array();
                $array_controlador_red = array();
                $array_paq_office_version = array();
                $array_paq_office_activado = array();
                $array_observaciones = array();

                foreach($rev_detallada as $det){
                    $array_item_id[] = $det->item_id;
                    $array_num_maquina[] = $det->num_maquina;
                    $array_tiene_camara[] = $det->tiene_camara;
                    $array_tiene_bocinas[] = $det->tiene_bocinas;
                    $array_num_serie_cpu[] =$det->num_serie_cpu;
                    $array_ram[] = $det->ram;
                    $array_disco_duro[] = $det->disco_duro;
                    $array_sistema_operativo[] = $det->sistema_operativo;
                    $array_sistema_operativo_activado[] = $det->sistema_operativo_activado;
                    $array_cable_vga[] = $det->cable_vga;
                    $array_tiene_monitor[] = $det->tiene_monitor;
                    $array_num_serie_monitor[] = $det->num_serie_monitor;
                    $array_tiene_teclado[] = $det->tiene_teclado;
                    $array_tiene_raton[] = $det->tiene_raton;
                    $array_controlador_red[] = $det->controlador_red;
                    $array_paq_office_version[] = $det->paq_office_version;
                    $array_paq_office_activado[] = $det->paq_office_activado;
                    $array_observaciones[] = $det->observaciones;
                }

                $items_all = Item::whereIn('id', $array_item_id)->get();
                $array_todo_items = array();
                foreach ($items_all as $ia) {
                    $array_todo_items[] = $ia->marca;
                }

                $pcs_all = Pc::whereIn('item_id', $array_item_id)
                    ->orderBy('num_maquina','desc')
                    ->get();
                $array_num_maquina_pc = array();
                $array_tiene_camara_pc = array();
                $array_tiene_bocinas_pc = array();
                $array_num_serie_cpu_pc = array();
                $array_ram_pc = array();
                $array_disco_duro_pc = array();
                $array_sistema_operativo_pc = array();
                $array_sistema_operativo_activado_pc = array();
                $array_cable_vga_pc = array();
                $array_tiene_monitor_pc = array();
                $array_num_serie_monitor_pc = array();
                $array_tiene_teclado_pc =array();
                $array_tiene_raton_pc = array();
                $array_controlador_red_pc =array();
                $array_paq_office_version_pc = array();
                $array_paq_office_activado_pc = array();
                $array_observaciones_pc = array();

                    foreach ($pcs_all as $pcs) {
                        $array_num_maquina_pc[] = $pcs->num_maquina;
                        $array_tiene_camara_pc[] = $pcs->tiene_camara;
                        $array_tiene_bocinas_pc[] = $pcs->tiene_bocinas;
                        $array_num_serie_cpu_pc[] = $pcs->num_serie_cpu;
                        $array_ram_pc[] = $pcs->ram;
                        $array_disco_duro_pc[] = $pcs->disco_duro;
                        $array_sistema_operativo_pc[] = $pcs->sistema_operativo;
                        $array_sistema_operativo_activado_pc[] = $pcs->sistema_operativo_activado;
                        $array_cable_vga_pc[] = $pcs->cable_vga;
                        $array_tiene_monitor_pc[] = $pcs->tiene_monitor;
                        $array_num_serie_monitor_pc[] = $pcs->num_serie_monitor;
                        $array_tiene_teclado_pc[] = $pcs->tiene_teclado;
                        $array_tiene_raton_pc[] = $pcs->tiene_raton;
                        $array_controlador_red_pc[] = $pcs->controlador_red;
                        $array_paq_office_version_pc[] = $pcs->paq_office_version;
                        $array_paq_office_activado_pc[] = $pcs->paq_office_activado;
                        $array_observaciones_pc[] = $pcs->observaciones;
                    }

                    $nombre_user_rev = User::where('id', $revision->user_id)->first();
                    $nombre_lugar_rev = Lugar::where('id', $revision->lugar_id)->first();

                    $output = array(
                        'id' => $revision->id,
                        'user_id' => $nombre_user_rev->nombre.' '.$nombre_user_rev->apellido,
                        'lugar_id' => $nombre_lugar_rev->nombre,
                        'tipo' => $revision->tipo,
                        'momento' => $revision->momento,
                        'observaciones' => $revision->observaciones,
                        'created_at' => $revision->created_at,
                        'updated_at' => $revision->updated_at,
                        'item_id' => $array_item_id,
                        'num_maquina' => $array_num_maquina,
                        'tiene_camara' => $array_tiene_camara,
                        'tiene_bocinas' => $array_tiene_bocinas,
                        'num_serie_cpu' => $array_num_serie_cpu,
                        'ram' => $array_ram,
                        'disco_duro' => $array_disco_duro,
                        'sistema_operativo' => $array_sistema_operativo,
                        'sistema_operativo_activado' => $array_sistema_operativo_activado,
                        'cable_vga' => $array_cable_vga,
                        'tiene_monitor' => $array_tiene_monitor,
                        'num_serie_monitor' => $array_num_serie_monitor,
                        'tiene_teclado' => $array_tiene_teclado,
                        'tiene_raton' => $array_tiene_raton,
                        'controlador_red' => $array_controlador_red,
                        'paq_office_version' => $array_paq_office_version,
                        'paq_office_activado' => $array_paq_office_activado,
                        'observaciones' => $array_observaciones,
                        'items_all' => $array_todo_items,
                        'pc_num_maquina' => $array_num_maquina_pc,
                        'pc_tiene_camara' => $array_tiene_camara_pc,
                        'pc_tiene_bocinas' => $array_tiene_bocinas_pc,
                        'pc_num_serie_cpu' => $array_num_serie_cpu_pc,
                        'pc_ram' => $array_ram_pc,
                        'pc_disco_duro' => $array_disco_duro_pc,
                        'pc_sistema_operativo' => $array_sistema_operativo_pc,
                        'pc_sistema_operativo_activado' => $array_sistema_operativo_activado_pc,
                        'pc_cable_vga' => $array_cable_vga_pc,
                        'pc_tiene_monitor' => $array_tiene_monitor_pc,
                        'pc_num_serie_monitor' => $array_num_serie_monitor_pc,
                        'pc_tiene_teclado' => $array_tiene_teclado_pc,
                        'pc_tiene_raton' => $array_tiene_raton_pc,
                        'pc_controlador_red' => $array_controlador_red_pc,
                        'pc_paq_office_version' => $array_paq_office_version_pc,
                        'pc_paq_office_activado' => $array_paq_office_activado_pc,
                        'pc_observaciones' => $array_observaciones_pc
                    );

                }else if($revision->tipo == 'rapida' || $revision->tipo == 'Rapida' || $revision->tipo == 'Rápida'){

                    $rev_rapida = DB::table('revision_rapidas')
                        ->where('revision_id',$revision->id)
                        ->get();

                    $pc_cant = DB::table('items')
                        ->where('lugar_id', $revision->lugar_id)
                        ->where('clasificacion','Pc')
                        ->count();
                    $mesa_cant = DB::table('items')
                        ->where('lugar_id', $revision->lugar_id)
                        ->where('clasificacion','Mesa')
                        ->count();
                    $silla_cant = DB::table('items')
                        ->where('lugar_id', $revision->lugar_id)
                        ->where('clasificacion','Silla')
                        ->count();
                    $piz_cant = DB::table('items')
                        ->where('lugar_id', $revision->lugar_id)
                        ->where('clasificacion','Pizarrón')
                        ->count();
                    $television_cant = DB::table('items')
                        ->where('lugar_id', $revision->lugar_id)
                        ->where('clasificacion','Television')
                        ->count();
                    $termostato_cant = DB::table('items')
                        ->where('lugar_id', $revision->lugar_id)
                        ->where('clasificacion','Termostato')
                        ->count();
                    $ruteador_cant = DB::table('items')
                        ->where('lugar_id', $revision->lugar_id)
                        ->where('clasificacion','Ruteador')
                        ->count();
                    $swith_cant = DB::table('items')
                        ->where('lugar_id', $revision->lugar_id)
                        ->where('clasificacion','Switch')
                        ->count();

                    $array_clasi = array();
                    $array_cant = array();

                    foreach($rev_rapida as $rapida){
                        $array_clasi[] = $rapida->clasificacion;
                        $array_cant[] = $rapida->cantidad;
                    }

                    $nombre_user_rev = User::where('id', $revision->user_id)->first();
                    $nombre_lugar_rev = Lugar::where('id', $revision->lugar_id)->first();

                    $output = array(
                        'id' => $revision->id,
                        'user_id' => $nombre_user_rev->nombre.' '.$nombre_user_rev->apellido,
                        'lugar_id' => $nombre_lugar_rev->nombre,
                        'tipo' => $revision->tipo,
                        'momento' => $revision->momento,
                        'observaciones' => $revision->observaciones,
                        'created_at' => $revision->created_at,
                        'updated_at' => $revision->updated_at,
                        'pc_cant' => $pc_cant,
                        'mesa_cant' => $mesa_cant,
                        'silla_cant' => $silla_cant,
                        'piz_cant' => $piz_cant,
                        'television_cant' => $television_cant,
                        'termostato_cant' => $termostato_cant,
                        'ruteador_cant' => $ruteador_cant,
                        'swith_cant' => $swith_cant,
                        'clasificacion' => $array_clasi,
                        'cantidad' => $array_cant
                    );
                }
            }

            return response()->json($output);

    }

    public function fetch_data(Request $request, $id){
        if ($request->from_date != '' && $request->to_date != '') {
            $data = DB::table('revisions')
                ->where('lugar_id', $id)
                ->whereBetween('momento', array($request->from_date, $request->to_date))
                ->get();

            $array_updated = array();

            foreach($data as $datup){
                if ($datup->updated_at != '') {
                    $array_updated[] =  \Carbon\Carbon::parse($datup->updated_at)->diffForHumans();   
                }else{
                    $array_updated[] = $datup->updated_at;
                }
            }

            $array_revs = array();
            foreach($data as $revs){
                $array_revs[] = $revs->user_id;
            }

            $user_data = User::whereIn('id',$array_revs)->get();
            $array_users = array();
            foreach($user_data as $user_name){
                $array_users[] = $user_name;
            }

            $lugar = Lugar::find($id);

        }
        
        return response()->json(['user' => $array_users, 'lugar' => $lugar->nombre, 'revs' => $data, 'act' => $array_updated]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }

    public function revUltimasView(){
        return view('revisiones.ultimas_revisiones');
    }

    public function revUltimas(Request $request){
        if ($request->ajax()) {

            if ($request->id > 0) {
                $data = DB::table('revisions')
                    ->where('id', '<', $request->id)
                    ->orderBy('id', 'desc')
                    ->limit(5)
                    ->get();
            }else{
                $data = DB::table('revisions')
                    ->orderBy('id', 'desc')
                    ->limit(5)
                    ->get();
            }

            $output = '';
            $last_id = '';

            if (!$data->isEmpty()) {

                foreach($data as $row){
                    $lugar = Lugar::find($row->lugar_id);
                    $revisor = User::find($row->user_id);

                    if($row->tipo == ''){
                        $output .= '
                            <div class="card border-info mb-3 text-center">
                                <div class="card-header" id="title_header"><h4>Revisión: '. $row->tipo.' - Lugar: '. $lugar->nombre .' </h4> </div>
                                    <div class="card-body text-info">
                                    <h4 class="card-title" id="title_body">Nombre del revisor: '. $revisor->nombre .' '.$revisor->apellido.'</h4>
                                    
                                    <p class="card-text">Momento: '.$row->momento.' - Observaciones: '.$row->observaciones.'</p>
                                    <a href="#" class="btn btn-xs btn-info edit-rev col-md-4 right" id="'. $row->id .'">Ver Detalles <i class="fas fa-eye"></i></a>
                              </div>';
                              if ($row->updated_at != '') {
                                $up = \Carbon\Carbon::parse($row->created_at)->diffForHumans();
                                $output .= '<div class="card-footer bg-transparent border-success">Actualizado: '.$up.'</div>
                            </div>

                            ';
                                }else{
                                    $output .= '<div class="card-footer bg-transparent border-success">Actualizado: '.$row->updated_at.'</div>
                            </div>
                            ';
                                }
                            $last_id = $row->id;

                    }else if ($row->tipo == 'Detallada' || $row->tipo == 'detallada') {
                        $datos_det = DB::table('revision_detalladas2')
                            ->where('revision_id', $row->id)
                            ->get();

                    
                        //$item_num = Item::find($datos_det->item_id);
                            //Clasificación: '.$item_num->clasificacion.'
                        $output .= '
                            <div class="card border-info mb-3 text-center">
                                <div class="card-header" id="title_header"><h4>Revisión: '. $row->tipo.' - Lugar: '. $lugar->nombre .' </h4> </div>
                                    <div class="card-body text-info">
                                    <h4 class="card-title" id="title_body">Nombre del revisor: '. $revisor->nombre .' '.$revisor->apellido.'</h4>';
                                    /*for ($i = 0; $i < count($datos_det); $i++) {
                                        $output .= '<p class="card-text">Item: '.json_encode($array_item_id[$i]);
                                    }*///.', Modelo: '.$item_num->modelo.', Estado: '.$item_num->estado.', Marca: '.$item_num->marca.', Número de inventario: '.$item_num->numero_inventario.', Número de Serie: '.$item_num->numero_serie.'</p>*/
                                    $output .= '<p class="card-text">Momento: '.$row->momento.' - Observaciones: '.$row->observaciones.'</p>
                                    <a href="#" class="btn btn-xs btn-info edit-rev col-md-4 right" id="'. $row->id .'">Ver Detalles <i class="fas fa-eye"></i></a>
                              </div>';
                              if ($row->updated_at != '') {
                                $up = \Carbon\Carbon::parse($row->created_at)->diffForHumans();
                                $output .= '<div class="card-footer bg-transparent border-success">Actualizado: '.$up.'</div>
                            </div>
                            ';
                                }else{
                                    $output .= '<div class="card-footer bg-transparent border-success">Actualizado: '.$row->updated_at.'</div>
                            </div>
                            ';
                                }
                            $last_id = $row->id;

                    }else if($row->tipo == 'rapida' || $row->tipo == 'Rapida' || $row->tipo == 'Rápida'){
                        $datos_rap = DB::table('revision_rapidas')
                            ->where('revision_id', $row->id)
                            ->get();
                        
                        $array_clas = array();
                        $array_cant = array();
                        foreach($datos_rap as $d_r) {
                            $array_clas[] = $d_r->clasificacion;
                            $array_cant[] = $d_r->cantidad;
                        }
                        
                        $output .= '
                            <div class="card border-info mb-3 text-center">
                                <div class="card-header" id="title_header"><h4>Revisión: '. $row->tipo.' - Lugar: '. $lugar->nombre .'</h4>  </div>
                                    <div class="card-body text-info">
                                    <h4 class="card-title" id="title_body">Nombre del revisor: '. $revisor->nombre .' '.$revisor->apellido.'</h4>
                                    <p class="card-text"> Momento: '.$row->momento.' - Observaciones: '.$row->observaciones.'</p>';
                                
                               /*for ($i = 0; $i < count($datos_rap); $i++) {
                                    $output .= '<p class="card-text">Clasificación: '.json_encode($array_clas[$i]).', Cantidad: '.json_encode($array_cant[$i]).'</p>';
                                }*/
                                $output .= '<a href="#" class="btn btn-xs btn-info edit-rev col-md-4 right" id="'. $row->id .'">Ver Detalles <i class="fas fa-eye"></i></a> </div>';
                              if ($row->updated_at != '') {
                                $up = \Carbon\Carbon::parse($row->created_at)->diffForHumans();
                                $output .= '<div class="card-footer bg-transparent border-success">Actualizado: '.$up.'</div>
                            </div>
                            ';
                                }else{
                                    $output .= '<div class="card-footer bg-transparent border-success">Actualizado: '.$row->updated_at.'</div>
                            </div>
                            ';
                                }
                            $last_id = $row->id;
                    }
                    
                }

                $output .= '
                <div id="load_more">
                    <button type="button" name="load_more_button" class="btn btn-success form-control" data-id="'.$last_id.'" id="load_more_button">Cargar Más</button>
                </div>
                <br>
                ';
            }else{
                $output .= '
                <div id="load_more">
                    <button type="button" name="load_more_button" class="btn btn-info form-control">Sin datos</button>
                </div>
                <br>
                ';
            }

            echo $output;

        }
    }

    public function notifyRevs(Request $request){
        $output = '';
        $visto = $request->view;

        if ($visto == 'yes') {
            DB::table('revisions')
                ->where('status_vista', 0)
                ->update(['status_vista' => 1]);
        }else if($visto != ''){
            DB::table('revisions')
                ->where('id', $visto)
                ->update(['status_vista' => 1]);
        }

        $revisiones = DB::table('revisions')
            ->where('status_vista', 0)
            ->orWhere('status_vista',1)
            ->orderBy('momento', 'desc')
            ->limit(5)
            ->get();

        if (count($revisiones) >= 0) {
            foreach($revisiones as $revision){
                $output .= '
                        <li class="elemento_noti ml-1 mr-3" id="visto_'.$revision->status_vista.'">
                            <a href="#" id="'.$revision->id.'" class="dropdown-item not_visto">
                                <strong>Revisión: '.$revision->tipo.'</strong><br>
                                <small><em>'.$revision->momento.'</em></small>
                            </a>
                        </li>
                        ';
            }   
        }

        $revisiones_1 = DB::table('revisions')->where('status_vista', 0)->count();
        $data = array(
            'notification' => $output,
            'unseen_notification' => $revisiones_1,
            'visto' => $visto
        );

        return response()->json($data);
        
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
