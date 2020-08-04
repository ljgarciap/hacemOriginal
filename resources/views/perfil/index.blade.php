@extends('app')

@section('content')
<div class="container">
<a href="{{url ('perfil/create')}}" class="btn btn-success">Agregar Perfil</a>
<br/>
<br/>
<table class="table table-light table-hover">
    <thead class="thead-light">
        <tr>
            <th>Id</th>
            <th>Perfil</th>
            <th>Proceso</th>
            <th>Valor Minuto</th>
            <th>Estado</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($perfiles as $perfil)
            <tr>
                <td>{{$perfil->id}}</td>
                <td>{{$perfil->perfil}}</td>
                @foreach ($procesos as $proceso)
                    @if ($proceso->id===$perfil->idProceso)
                    <td>{{$proceso->proceso}}</td>
                    @endif
                @endforeach
                <td>{{$perfil->valorMinuto}}</td>
                @if ($perfil->estado===1)
                <td style="color:green"><b>Activo</b></td>
                @else
                <td style="color:grey"><b>Inactivo</b></td>
                @endif
                <td>
                <a class="btn btn-warning" href="{{url ('/perfil/'.$perfil->id.'/edit')}}">Editar</a>
                    <form method="get" action="{{ url('/perfil/'.$perfil->id.'/deactivate')}}" style="display:inline">
                        {{ csrf_field() }}
                        <button class="btn btn-danger" type="submit" onclick="return confirm('¿Quieres cambiar el estado de este perfil?')">Cambiar estado</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>
@endsection
