@extends('app')

@section('content')
<div class="container">
    <div class="form-group">
        <form action="{{url('/area/store')}}" class="form-horizontal" method="GET" enctype="multipart/form-data">
            {{ csrf_field() }}
            <label class="control-label" for="area"><b>Area</b></label>
            <input type="text" class="form-control" name="area" id="Area" value="">
            <br>
            <div>
            <input type="submit" class="btn btn-success" value="Agregar">
            <a class="btn btn-primary" href="{{url ('area')}}">Regresar</a>
        </form>
    </div>
</div>
@endsection
