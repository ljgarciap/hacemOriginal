@extends('app')

@section('content')
<div class="container">
    <div class="form-group">
        <form action="{{url('/perfil/store')}}" class="form-horizontal" method="GET" enctype="multipart/form-data">
            {{ csrf_field() }}
            <label class="control-label" for="proceso"><b>Perfil</b></label>
            <input type="text" class="form-control" name="perfil" id="perfil" value="">
            <br>
            <label class="control-label" for="idProceso">Area</label>
            <select class="form-control" name="idProceso" id="idProceso">
                @foreach ($procesos as $proceso)
                        <option value="{{ $proceso->id }}">{{ $proceso->proceso }}</option>
                @endforeach
            </select>
        <br>
        <label class="control-label" for="valorMinuto"><b>Valor Minuto</b></label>
        <input type="number" class="form-control" name="valorMinuto" id="valorMinuto" value="">
        <br>
            <div>
            <input type="submit" class="btn btn-success" value="Agregar">
            <a class="btn btn-primary" href="{{url ('perfil')}}">Regresar</a>
        </form>
    </div>
</div>
@endsection
