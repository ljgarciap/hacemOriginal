@extends('app')

@section('content')
<div class="container">
<div class="form-group">
<form action="{{ url('/perfil/'. $perfiles->id .'/update')}}" class="form-horizontal" method="get" enctype="multipart/form-data">
    {{ csrf_field() }}

    <label class="control-label" for="perfil"><b>Perfil</b></label>
    <input type="text" class="form-control" name="perfil" id="perfil" value="{{ $perfiles->perfil }}">
    <br>
    <label class="control-label" for="idProceso">Proceso</label>
        <select class="form-control" name="idProceso" id="idProceso">
            @foreach ($procesos as $proceso)
                @if ($proceso->id===$perfiles->idProceso)
                    <option selected value="{{ $perfiles->idProceso }}">{{ $proceso->proceso }}</option>
                @else
                    <option value="{{ $proceso->id }}">{{ $proceso->proceso }}</option>
                @endif
            @endforeach
        </select>
    <br>
    <input type="number" class="form-control" name="valorMinuto" id="valorMinuto" value="{{ $perfiles->valorMinuto }}">
    <br>
    <input type="submit" class="btn btn-success" value="Editar">
    <a class="btn btn-primary" href="{{url ('perfil')}}">Regresar</a>
</form>
</div>
</div>
@endsection
