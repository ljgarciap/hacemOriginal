@extends('app')

@section('content')
<div class="container">
<div class="form-group">
<form action="{{ url('/proceso/'. $procesos->id .'/update')}}" class="form-horizontal" method="get" enctype="multipart/form-data">
    {{ csrf_field() }}

    <label class="control-label" for="proceso"><b>Proceso</b></label><br>
    <input type="text" class="form-control" name="proceso" id="proceso" value="{{ $procesos->proceso }}">
    <br>
    <label class="control-label" for="idArea">Area</label>
        <select class="form-control" name="idArea" id="idArea">
            @foreach ($areas as $area)
                @if ($procesos->idArea===$area->id)
                    <option selected value="{{ $procesos->idArea }}">{{ $area->area }}</option>
                @else
                    <option value="{{ $area->id }}">{{ $area->area }}</option>
                @endif
            @endforeach
        </select>
    <br>
    <input type="submit" class="btn btn-success" value="Editar">
    <a class="btn btn-primary" href="{{url ('proceso')}}">Regresar</a>
</form>
</div>
</div>
@endsection
