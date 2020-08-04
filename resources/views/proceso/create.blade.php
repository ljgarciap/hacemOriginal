@extends('app')

@section('content')
<div class="container">
    <div class="form-group">
        <form action="{{url('/proceso/store')}}" class="form-horizontal" method="GET" enctype="multipart/form-data">
            {{ csrf_field() }}
            <label class="control-label" for="proceso"><b>Proceso</b></label>
            <input type="text" class="form-control" name="proceso" id="proceso" value="">
            <br>
            <label class="control-label" for="idArea">Area</label>
            <select class="form-control" name="idArea" id="idArea">
                @foreach ($areas as $area)
                        <option value="{{ $area->id }}">{{ $area->area }}</option>
                @endforeach
            </select>
        <br>

            <div>
            <input type="submit" class="btn btn-success" value="Agregar">
            <a class="btn btn-primary" href="{{url ('proceso')}}">Regresar</a>
        </form>
    </div>
</div>
@endsection
