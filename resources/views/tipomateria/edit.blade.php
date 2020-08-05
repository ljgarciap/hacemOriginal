@extends('app')

@section('content')
<div class="container">
<div class="form-group">

<form action="{{ url('/tipomateria/'. $tipomaterias->id .'/update' )}}" class="form-horizontal" method="get" enctype="multipart/form-data">
    {{ csrf_field() }}

    <label class="control-label" for="area"><b>Area</b></label><br>
    <input type="text" class="form-control" name="area" id="area" value="{{ $tipomaterias->area }}">
    <br>

    <input type="submit" class="btn btn-success" value="Editar">
    <a class="btn btn-primary" href="{{url ('area')}}">Regresar</a>
</form>
</div>
</div>
@endsection
