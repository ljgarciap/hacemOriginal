@extends('app')

@section('content')
<div class="container">
<a href="{{url ('unidad/create')}}" class="btn btn-success">Ver Area</a>
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
        @foreach($unidades as $unidad)
            <tr>
                <td>{{$unidad->id}}</td>
                <td>{{$unidad->unidadBase}}</td>
                <td>{{$unidad->estado}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>
@endsection

