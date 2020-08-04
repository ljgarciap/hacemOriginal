@extends('app')

@section('content')
<div class="container">
    <div class="form-group">
        <form action="{{url('/unidad/store')}}" class="form-horizontal" method="GET" enctype="multipart/form-data">
            {{ csrf_field() }}
            <label class="control-label" for="unidad"><b>Unidad</b></label>
            <input type="text" class="form-control" name="unidad" id="Unidad" value="">
            <br>
            <div>
            <input type="submit" class="btn btn-success" value="Agregar">
            <a class="btn btn-primary" href="{{url ('unidad')}}">Regresar</a>
        </form>
    </div>
</div>
@endsection
