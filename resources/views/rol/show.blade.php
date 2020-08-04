@extends('app')

@section('content')
<div class="container">
<a href="{{url ('rol/create')}}" class="btn btn-success">Ver Rol</a>
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
        @foreach($roles as $rol)
            <tr>
                <td>{{$rol->id}}</td>
                <td>{{$rol->rol}}</td>
                <td>{{$rol->estado}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>
@endsection

