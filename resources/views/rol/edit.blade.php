@extends('app')

@section('content')
<div class="container">
<div class="form-group">

<form action="{{ url('/rol/'. $roles->id .'/update' )}}" class="form-horizontal" method="get" enctype="multipart/form-data">
    {{ csrf_field() }}

    <label class="control-label" for="area"><b>Rol</b></label><br>
    <input type="text" class="form-control" name="rol" id="rol" value="{{ $roles->rol }}">
    <br>

    <input type="submit" class="btn btn-success" value="Editar">
    <a class="btn btn-primary" href="{{url ('rol')}}">Regresar</a>
</form>
</div>
</div>
@endsection
