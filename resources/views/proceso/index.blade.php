@extends('app')

@section('content')
<div class="container">
<a href="{{url ('proceso/create')}}" class="btn btn-success">Agregar Proceso</a>
<br/>
<br/>
<table class="table table-light table-hover">
    <thead class="thead-light">
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Area</th>
            <th>Estado</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($procesos as $proceso)
            <tr>
                <td>{{$proceso->id}}</td>
                <td>{{$proceso->proceso}}</td>
                @foreach ($areas as $area)
                    @if ($proceso->idArea===$area->id)
                    <td>{{$area->area}}</td>
                    @endif
                @endforeach
                @if ($proceso->estado===1)
                <td style="color:green"><b>Activo</b></td>
                @else
                <td style="color:grey"><b>Inactivo</b></td>
                @endif
                <td>
                <a class="btn btn-warning" href="{{url ('/proceso/'.$proceso->id.'/edit')}}">Editar</a>
                    <form method="get" action="{{ url('/proceso/'.$proceso->id .'/deactivate')}}" style="display:inline">
                        {{ csrf_field() }}
                        <button class="btn btn-danger" type="submit" onclick="return confirm('¿Quieres cambiar el estado de este proceso?')">Cambiar estado</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>
@endsection

