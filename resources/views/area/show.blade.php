@extends('app')

@section('content')
<div class="container">
<a href="{{url ('area/create')}}" class="btn btn-success">Ver Area</a>
<br/>
<br/>
<table class="table table-light table-hover">
    <thead class="thead-light">
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach($areas as $area)
            <tr>
                <td>{{$area->id}}</td>
                <td>{{$area->area}}</td>
                <td>{{$area->estado}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>
@endsection

