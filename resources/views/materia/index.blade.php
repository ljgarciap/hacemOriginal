@extends('layouts.app')

@section('content')
<div class="container">
<a href="{{url ('materias/create')}}" class="btn btn-success">Agregar Materia</a>
<br/>
<br/>
<table class="table table-light table-hover">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Unidad Base</th>
            <th>Precio Base</th>
            <th>Tipo De Materia</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($materias as $materia)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$materia->Nombre}}</td>
                <td>{{$materia->idUnidadBase}}</td>
                <td>{{$materia->PrecioBase}}</td>
                <td>{{$materia->idTipoMateria}}</td>
                <td>
                <a class="btn btn-warning" href="{{url ('/materias/'.$materia->id.'/edit')}}">Editar</a> 
                    <form method="post" action="{{ url('/materias/'.$materia->id) }}" style="display:inline">
                        {{ csrf_field() }}
                        {{method_field('DELETE')}}
                        <button class="btn btn-danger" type="submit" onclick="return confirm('¿Quieres Borrar Esta Materia?')">Borrar</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>
@endsection
