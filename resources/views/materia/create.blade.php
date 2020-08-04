@extends('layouts.app')

@section('content')
<div class="container">
    <div class="form-group">
        <form action="{{url('/materias')}}" class="form-horizontal" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <label class="control-label" for="Nombre">{{'Nombre'}}</label>
            <input type="text" class="form-control" name="Nombre" id="Nombre" value="">
            <br>
            <div>
            <label class="control-label" for="UnidadBase">{{'Unidad Base'}}</label>
            <select class="form-control" name="idUnidadBase" id="idUnidadBase">
                @foreach ($unidades as $item)
                    <option value="{{ $item->idUnidadBase }}">{{ $item->idUnidadBase }}</option>
                @endforeach
            </select>
            </div>
            <br>
            <label class="control-label" for="PrecioBase">{{'Precio Base'}}</label>
            <input type="text" class="form-control" name="PrecioBase" id="PrecioBase" value="">
            <br>
            <label class="control-label" for="TipoMateria">{{'Tipo Materia'}}</label>
            <select class="form-control" name="idTipoMateria" id="idTipoMateria">
                @foreach ($tipos as $item)
                    <option value="{{ $item->idTipoMateria }}">{{ $item->idTipoMateria }}</option>
                @endforeach
            </select>
            <br>
            <input type="submit" class="btn btn-success" value="Agregar">
            <a class="btn btn-primary" href="{{url ('materias')}}">Regresar</a>
        </form>
    </div>
</div>
@endsection