@extends('app')

@section('content')
<div class="container">
<a href="{{url ('rol/create')}}" class="btn btn-success">Agregar Rol</a>
<br/>
<br/>
<table class="table table-light table-hover">
    <thead class="thead-light">
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Estado</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($roles as $rol)
            <tr>
                <td>{{$rol->id}}</td>
                <td>{{$rol->rol}}</td>
                @if ($rol->estado===1)
                <td style="color:green"><b>Activo</b></td>
                @else
                <td style="color:grey"><b>Inactivo</b></td>
                @endif
                <td>
                <a class="btn btn-warning" href="{{url ('/rol/'.$rol->id.'/edit')}}">Editar</a>
                    <form method="get" action="{{ url('/rol/'.$rol->id) .'/deactivate'}}" style="display:inline">
                        {{ csrf_field() }}
                        <button class="btn btn-danger" type="submit" onclick="return confirm('¿Quieres cambiar el estado de este rol?')">Cambiar estado</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>
@endsection

