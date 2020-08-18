<?php

namespace App\Http\Controllers;

use App\Tb_coleccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_coleccionController extends Controller
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
            # code...
            $colecciones = Tb_coleccion::orderBy('id','desc')->paginate(5);
        }
        else {
            # code...
            $colecciones = Tb_coleccion::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id','desc')->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$colecciones->total(),
                'current_page'  =>$colecciones->currentPage(),
                'per_page'      =>$colecciones->perPage(),
                'last_page'     =>$colecciones->lastPage(),
                'from'          =>$colecciones->firstItem(),
                'to'            =>$colecciones->lastItem(),
            ],
                'colecciones' => $colecciones
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('coleccion.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datosColeccion=request()->except('_token');

        Tb_coleccion::insert($datosColeccion);

        return redirect('coleccion');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tb_coleccion  $tb_coleccion
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $coleccion= Tb_coleccion::findOrFail($id);

        return view('coleccion.show',compact('coleccion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tb_coleccion  $tb_coleccion
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coleccion= Tb_coleccion::findOrFail($id);

        return view('coleccion.edit',compact('coleccion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tb_coleccion  $tb_coleccion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $datosColeccion=request()->except(['_token','_method']);
        Tb_coleccion::where('id','=',$id)->update($datosColeccion);

        return redirect()->route('coleccion.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tb_coleccion  $tb_coleccion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tb_coleccion $tb_coleccion)
    {
        //
    }
}
