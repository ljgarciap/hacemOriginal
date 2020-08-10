<?php

namespace App\Http\Controllers;

use App\Tb_area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_areaController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $areas = Tb_area::all();
        return $areas;
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        //$datosAreas =request()->except('_token');
        //Tb_area::insert($datosAreas);
        //return redirect('area');
        $tb_area=new Tb_area();
        $tb_area->area=$request->area;
        $tb_area->save();
    }

    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $tb_area=Tb_area::findOrFail($request->id);
        $tb_area->area=$request->area;
        $tb_area->estado='1';
        $tb_area->save();
    }

    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $tb_area=Tb_area::findOrFail($request->id);
        $tb_area->estado='0';
        $tb_area->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $tb_area=Tb_area::findOrFail($request->id);
        $tb_area->estado='1';
        $tb_area->save();
    }
}
