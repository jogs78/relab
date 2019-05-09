<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Lugar;
use App\Revision;
use App\Item;
use DB;
use DataTables;
use Validator;

class RevisionesController extends Controller
{
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
            
            //return response()->json(['rev' => $revision, 'rev_det' => $rev_detallada->item_id]);
            if ($revision->tipo == '') {
                $nombre_user_rev = User::where('id', $revision->user_id)->first();
                $nombre_lugar_rev = Lugar::where('id', $revision->lugar_id)->first();
                $output = array(
                    'id' => $revision->id,
                    'user_id' => $nombre_user_rev->nombre,
                    'lugar_id' => $nombre_lugar_rev->nombre,
                    'tipo' => $revision->tipo,
                    'momento' => $revision->momento,
                    'observaciones' => $revision->observaciones,
                    'created_at' => $revision->created_at,
                    'updated_at' => $revision->updated_at
                );   
            }else{
                
                if ($revision->tipo == 'Detallada' || $revision->tipo == 'detallada') {
                    $rev_detallada = DB::table('revision_detalladas')
                        ->where('revision_id',$revision->id)
                        ->get();

                    $nombre_user_rev = User::where('id', $revision->user_id)->first();
                    $nombre_lugar_rev = Lugar::where('id', $revision->lugar_id)->first();

                    $output = array(
                        'id' => $revision->id,
                        'user_id' => $nombre_user_rev->nombre,
                        'lugar_id' => $nombre_lugar_rev->nombre,
                        'tipo' => $revision->tipo,
                        'momento' => $revision->momento,
                        'observaciones' => $revision->observaciones,
                        'created_at' => $revision->created_at,
                        'updated_at' => $revision->updated_at,
                        'item_id' => $rev_detallada[0]->item_id,
                        'num_maquina' => $rev_detallada[0]->num_maquina,
                        'tiene_camara' => $rev_detallada[0]->tiene_camara,
                        'tiene_bocinas' => $rev_detallada[0]->tiene_bocinas,
                        'num_serie_cpu' => $rev_detallada[0]->num_serie_cpu,
                        'ram' => $rev_detallada[0]->ram,
                        'disco_duro' => $rev_detallada[0]->disco_duro,
                        'sistema_operativo' => $rev_detallada[0]->sistema_operativo,
                        'sistema_operativo_activado' => $rev_detallada[0]->sistema_operativo_activado,
                        'cable_vga' => $rev_detallada[0]->cable_vga,
                        'tiene_monitor' => $rev_detallada[0]->tiene_monitor,
                        'num_serie_monitor' => $rev_detallada[0]->num_serie_monitor,
                        'tiene_teclado' => $rev_detallada[0]->tiene_teclado,
                        'tiene_raton' => $rev_detallada[0]->tiene_raton,
                        'controlador_red' => $rev_detallada[0]->controlador_red,
                        'paq_office_version' => $rev_detallada[0]->paq_office_version,
                        'paq_office_activado' => $rev_detallada[0]->paq_office_activado,
                        'observaciones' => $rev_detallada[0]->observaciones
                    );

                }else if($revision->tipo == 'rapida' || $revision->tipo == 'Rapida' || $revision->tipo == 'Rápida'){

                    $rev_rapida = DB::table('revision_rapidas')
                        ->where('revision_id',$revision->id)
                        ->get();

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
                        'user_id' => $nombre_user_rev->nombre,
                        'lugar_id' => $nombre_lugar_rev->nombre,
                        'tipo' => $revision->tipo,
                        'momento' => $revision->momento,
                        'observaciones' => $revision->observaciones,
                        'created_at' => $revision->created_at,
                        'updated_at' => $revision->updated_at,
                        'clasificacion' => $array_clasi,
                        'cantidad' => $array_cant
                    );
                }
            }

            //echo json_encode($output);   
            return response()->json($output);

    }

    public function fetch_data(Request $request, $id){
        if ($request->from_date != '' && $request->to_date != '') {
                
                $data = DB::table('revisions')
                    ->where('lugar_id', $id)
                    ->whereBetween('momento', array($request->from_date, $request->to_date))
                    ->get();

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
            return response()->json(['user' => $array_users, 'lugar' => $lugar->nombre, 'revs' => $data]);
            //return response()->json(['user' => $user_data, 'rev' => $data]);

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
                            <div class="card border-info mb-3">
                                <div class="card-header" id="title_header"><h4>Revisión: '. $row->tipo.' - Lugar: '. $lugar->nombre .' </h4></div>
                                    <div class="card-body text-info">
                                    <h4 class="card-title" id="title_body">Nombre del revisor: '. $revisor->nombre .' '.$revisor->apellido.'</h4>
                                    
                                    <p class="card-text">Momento: '.$row->momento.' - Observaciones: '.$row->observaciones.'</p>
                                    <p class="card-text">Núm. de Maquina: '.$datos_det->num_maquina.'</p>
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
                        $datos_det = DB::table('revision_detalladas')
                            ->where('revision_id', $row->id)
                            ->first();
                        $item_num = Item::find($datos_det->item_id);

                        $output .= '
                            <div class="card border-info mb-3">
                                <div class="card-header" id="title_header"><h4>Revisión: '. $row->tipo.' - Lugar: '. $lugar->nombre .' Clasificación: '.$item_num->clasificacion.'</h4></div>
                                    <div class="card-body text-info">
                                    <h4 class="card-title" id="title_body">Nombre del revisor: '. $revisor->nombre .' '.$revisor->apellido.'</h4>
                                    <p class="card-text">Descripción: '.$item_num->descripcion.', Modelo: '.$item_num->modelo.', Estado: '.$item_num->estado.', Marca: '.$item_num->marca.', Número de inventario: '.$item_num->numero_inventario.', Número de Serie: '.$item_num->numero_serie.'</p>
                                    <p class="card-text">Momento: '.$row->momento.' - Observaciones: '.$row->observaciones.'</p>
                                    <p class="card-text">Núm. de Maquina: '.$datos_det->num_maquina.'</p>
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
                            <div class="card border-info mb-3">
                                <div class="card-header" id="title_header"><h4>Revisión: '. $row->tipo.' - Lugar: '. $lugar->nombre .'</h4></div>
                                    <div class="card-body text-info">
                                    <h4 class="card-title" id="title_body">Nombre del revisor: '. $revisor->nombre .' '.$revisor->apellido.'</h4>
                                    <p class="card-text"> Momento: '.$row->momento.' - Observaciones: '.$row->observaciones.'</p>';
                                
                               for ($i = 0; $i < count($datos_rap); $i++) {
                                    $output .= '<p class="card-text">Clasificación: '.json_encode($array_clas[$i]).', Cantidad: '.json_encode($array_cant[$i]).'</p>';
                                }
                                $output .= '</div>';
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
