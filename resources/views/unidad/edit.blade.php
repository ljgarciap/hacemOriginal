@extends('app')

@section('content')
<div class="container">
<div class="form-group">

<form action="{{ url('/unidad/'. $unidades->id .'/update' )}}" class="form-horizontal" method="get" enctype="multipart/form-data">
    {{ csrf_field() }}

    <label class="control-label" for="unidad"><b>Unidad</b></label><br>
    <input type="text" class="form-control" name="unidad" id="unidad" value="{{ $unidades->unidad }}">
    <br>

    <input type="submit" class="btn btn-success" value="Editar">
    <a class="btn btn-primary" href="{{url ('unidad')}}">Regresar</a>
</form>
</div>
</div>
@endsection
