@extends('app')

@section('content')
<div class="container">
    <div class="form-group">
        <form action="{{url('/rol/store')}}" class="form-horizontal" method="GET" enctype="multipart/form-data">
            {{ csrf_field() }}
            <label class="control-label" for="rol"><b>Rol</b></label>
            <input type="text" class="form-control" name="rol" id="rol" value="">
            <br>
            <div>
            <input type="submit" class="btn btn-success" value="Agregar">
            <a class="btn btn-primary" href="{{url ('rol')}}">Regresar</a>
        </form>
    </div>
</div>
@endsection
