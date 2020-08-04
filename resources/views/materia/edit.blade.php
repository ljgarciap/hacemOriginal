@extends('layouts.app')

@section('content')
<div class="container">
<div class="form-group">
<form action="{{ url('/materias/'. $materia->id )}}" class="form-horizontal" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('PUT')}}

    <label class="control-label" for="Nombre">{{'Nombre'}}</label>
    <input type="text" class="form-control" name="Nombre" id="Nombre" value="{{ $materia->Nombre }}">
    <br>
    <label class="control-label" for="UnidadBase">{{'Unidad Base'}}</label>
        <select class="form-control" name="idUnidadBase" id="idUnidadBase">
            @foreach ($unidades as $item)
                @if ($materia->idUnidadBase==$item->idUnidadBase)
                    <option selected value="{{ $item->idUnidadBase }}">{{ $item->idUnidadBase }}</option>
                @else
                    <option value="{{ $item->idUnidadBase }}">{{ $item->idUnidadBase }}</option>
                @endif 
            @endforeach
        </select>
    <br>
    <label class="control-label" for="PrecioBase">{{'Precio Base'}}</label>
    <input type="text" class="form-control" name="PrecioBase" id="PrecioBase" value="{{ $materia->PrecioBase }}">
    <br>
    <label class="control-label" for="TipoMateria">{{'Tipo Materia'}}</label>
        <select class="form-control" name="idTipoMateria" id="idTipoMateria">
            @foreach ($tipos as $item)
                @if ($materia->idTipoMateria==$item->idTipoMateria)
                    <option selected value="{{ $item->idTipoMateria }}">{{ $item->idTipoMateria }}</option>
                @else
                    <option value="{{ $item->idTipoMateria }}">{{ $item->idTipoMateria }}</option>
                @endif          
            @endforeach
        </select>
    <br>
    <input type="submit" class="btn btn-success" value="Editar">
    <a class="btn btn-primary" href="{{url ('materias')}}">Regresar</a>
</form>
</div>
</div>
@endsection