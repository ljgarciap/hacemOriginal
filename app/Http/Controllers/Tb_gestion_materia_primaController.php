<?php

namespace App\Http\Controllers;

use App\Tb_gestion_materia_prima;
use App\Tb_unidad_base;
use App\Tb_tipo_materia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_gestion_materia_primaController extends Controller
{
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index(Request $request)
        {
            //if(!$request->ajax()) return redirect('/');
            $buscar= $request->buscar;
            $criterio= $request->criterio;

            if ($buscar=='') {
                # Modelo::join('tablaqueseune',basicamente un on)
                $gestionmaterias = Tb_gestion_materia_prima::join('tb_unidad_base','tb_gestion_materia_prima.idUnidadBase','=','tb_unidad_base.id')
                ->leftJoin('tb_tipo_materia',function($join){
                    $join->on('tb_gestion_materia_prima.idTipoMateria','=','tb_tipo_materia.id');
                })
                ->select('tb_gestion_materia_prima.id','tb_gestion_materia_prima.gestionMateria','tb_gestion_materia_prima.idUnidadBase','tb_gestion_materia_prima.precioBase','tb_gestion_materia_prima.idTipoMateria','tb_gestion_materia_prima.estado','tb_unidad_base.unidadBase as unidadBase','tb_unidad_base.estado as estado_unidad_base','tb_tipo_materia.tipoMateria as tipoMateria','tb_tipo_materia.estado as estado_tipo_materia')
                ->orderBy('tb_gestion_materia_prima.id','desc')->paginate(5);
            }
            else if($criterio=='tipoMateria'){
                $gestionmaterias = Tb_gestion_materia_prima::join('tb_unidad_base','tb_gestion_materia_prima.idUnidadBase','=','tb_unidad_base.id')
                ->leftJoin('tb_tipo_materia',function($join){
                    $join->on('tb_gestion_materia_prima.idTipoMateria','=','tb_tipo_materia.id');
                })
                ->select('tb_gestion_materia_prima.id','tb_gestion_materia_prima.gestionMateria','tb_gestion_materia_prima.idUnidadBase','tb_gestion_materia_prima.precioBase','tb_gestion_materia_prima.idTipoMateria','tb_gestion_materia_prima.estado','tb_unidad_base.unidadBase as unidadBase','tb_unidad_base.estado as estado_unidad_base','tb_tipo_materia.tipoMateria as tipoMateria','tb_tipo_materia.estado as estado_tipo_materia')
                ->where('tb_tipo_materia.'.$criterio, 'like', '%'. $buscar . '%')
                ->orderBy('tb_gestion_materia_prima.id','desc')->paginate(5);
            }
            else if($criterio=='unidadBase'){
                $gestionmaterias = Tb_gestion_materia_prima::join('tb_unidad_base','tb_gestion_materia_prima.idUnidadBase','=','tb_unidad_base.id')
                ->leftJoin('tb_tipo_materia',function($join){
                    $join->on('tb_gestion_materia_prima.idTipoMateria','=','tb_tipo_materia.id');
                })
                ->select('tb_gestion_materia_prima.id','tb_gestion_materia_prima.gestionMateria','tb_gestion_materia_prima.idUnidadBase','tb_gestion_materia_prima.precioBase','tb_gestion_materia_prima.idTipoMateria','tb_gestion_materia_prima.estado','tb_unidad_base.unidadBase as unidadBase','tb_unidad_base.estado as estado_unidad_base','tb_tipo_materia.tipoMateria as tipoMateria','tb_tipo_materia.estado as estado_tipo_materia')
                ->where('tb_unidad_base.'.$criterio, 'like', '%'. $buscar . '%')
                ->orderBy('tb_gestion_materia_prima.id','desc')->paginate(5);
            }
            else {
                # code...
                $gestionmaterias = Tb_gestion_materia_prima::join('tb_unidad_base','tb_gestion_materia_prima.idUnidadBase','=','tb_unidad_base.id')
                ->leftJoin('tb_tipo_materia',function($join){
                    $join->on('tb_gestion_materia_prima.idTipoMateria','=','tb_tipo_materia.id');
                })
                ->select('tb_gestion_materia_prima.id','tb_gestion_materia_prima.gestionMateria','tb_gestion_materia_prima.idUnidadBase','tb_gestion_materia_prima.precioBase','tb_gestion_materia_prima.idTipoMateria','tb_gestion_materia_prima.estado','tb_unidad_base.unidadBase as unidadBase','tb_unidad_base.estado as estado_unidad_base','tb_tipo_materia.tipoMateria as tipoMateria','tb_tipo_materia.estado as estado_tipo_materia')
                ->where('tb_gestion_materia_prima.'.$criterio, 'like', '%'. $buscar . '%')
                ->orderBy('tb_gestion_materia_prima.id','desc')->paginate(5);

            }

            return [
                'pagination' => [
                    'total'         =>$gestionmaterias->total(),
                    'current_page'  =>$gestionmaterias->currentPage(),
                    'per_page'      =>$gestionmaterias->perPage(),
                    'last_page'     =>$gestionmaterias->lastPage(),
                    'from'          =>$gestionmaterias->firstItem(),
                    'to'            =>$gestionmaterias->lastItem(),
                ],
                    'gestionmaterias' => $gestionmaterias
            ];
        }

        public function selectGestionMateria(){
            $gestionmaterias = Tb_gestion_materia_prima::join('tb_unidad_base','tb_gestion_materia_prima.idUnidadBase','=','tb_unidad_base.id')
            ->select('tb_gestion_materia_prima.id','tb_gestion_materia_prima.gestionMateria','tb_gestion_materia_prima.idUnidadBase','tb_unidad_base.unidadBase as unidadBase','tb_gestion_materia_prima.estado')
            ->where('tb_gestion_materia_prima.estado','=','1')
            ->orderBy('gestionMateria','asc')
            ->get();

            return ['gestionmaterias' => $gestionmaterias];
        }

        public function selectTipoMateria(){
            $tipomaterias = Tb_tipo_materia::where('estado','=','1')
            ->select('id as idTipoMateria','tipoMateria')->orderBy('tipoMateria','asc')->get();

            return ['tipomaterias' => $tipomaterias];
        }

        public function selectUnidadBase(){
            $unidadesbase = Tb_unidad_base::where('estado','=','1')
            ->select('id as idUnidadBase','unidadBase')->orderBy('unidadBase','asc')->get();

            return ['unidadesbase' => $unidadesbase];
        }

        public function store(Request $request)
        {
            if(!$request->ajax()) return redirect('/');
            $tb_gestion_materia_prima=new Tb_gestion_materia_prima();
            $tb_gestion_materia_prima->gestionMateria=$request->gestionMateria;
            $tb_gestion_materia_prima->idUnidadBase=$request->idUnidadBase;
            $tb_gestion_materia_prima->precioBase=$request->precioBase;
            $tb_gestion_materia_prima->idTipoMateria=$request->idTipoMateria;
            $tb_gestion_materia_prima->save();
        }

        public function update(Request $request)
        {
            if(!$request->ajax()) return redirect('/');
            $tb_gestion_materia_prima=Tb_gestion_materia_prima::findOrFail($request->id);
            $tb_gestion_materia_prima->gestionMateria=$request->gestionMateria;
            $tb_gestion_materia_prima->idUnidadBase=$request->idUnidadBase;
            $tb_gestion_materia_prima->precioBase=$request->precioBase;
            $tb_gestion_materia_prima->idTipoMateria=$request->idTipoMateria;
            $tb_gestion_materia_prima->estado='1';
            $tb_gestion_materia_prima->save();
        }

        public function deactivate(Request $request)
        {
            if(!$request->ajax()) return redirect('/');
            $tb_gestion_materia_prima=Tb_gestion_materia_prima::findOrFail($request->id);
            $tb_gestion_materia_prima->estado='0';
            $tb_gestion_materia_prima->save();
        }

        public function activate(Request $request)
        {
            if(!$request->ajax()) return redirect('/');
            $tb_gestion_materia_prima=Tb_gestion_materia_prima::findOrFail($request->id);
            $tb_gestion_materia_prima->estado='1';
            $tb_gestion_materia_prima->save();
        }

}
