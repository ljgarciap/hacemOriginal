@extends('app')

@section('content')
<div class="container">
<a href="{{url ('unidad/create')}}" class="btn btn-success">Agregar Unidad</a>
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
        @foreach($tipomaterias as $tipomateria)
            <tr>
                <td>{{$tipomateria->id}}</td>
                <td>{{$tipomateria->tipoMateria}}</td>
                @if ($tipomateria->estado===1)
                <td style="color:green"><b>Activo</b></td>
                @else
                <td style="color:grey"><b>Inactivo</b></td>
                @endif
                <td>
                <a class="btn btn-warning" href="{{url ('/area/'.$tipomateria->id.'/edit')}}">Editar</a>
                    <form method="get" action="{{ url('/area/'.$tipomateria->id) .'/deactivate'}}" style="display:inline">
                        {{ csrf_field() }}
                        <button class="btn btn-danger" type="submit" onclick="return confirm('¿Quieres cambiar el estado de este tipo de materia?')">Cambiar estado</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>
@endsection

