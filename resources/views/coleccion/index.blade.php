
<a href="{{url ('coleccion/create')}}">Agregar</a>
<table class="table table-light">

    <thead class="thead-light">
        <tr>
            <th>Opciones</th>
            <th>Id</th>
            <th>Nombre</th>
            <th>Referencia</th>
            <th>Estado</th>
        </tr>
    </thead>

    <tbody>
        @foreach($colecciones as $coleccion)
            <tr>
                <td>
                <a href="{{ route('coleccion.show',['coleccion'=>$coleccion->id]) }}">
                    Ver </a>| Duplicar | <a href="{{url ('/coleccion/'.$coleccion->id.'/edit')}}">Editar</a> | Borrar</td>
                <td>{{$loop->iteration}}</td>
                <td>{{$coleccion->nombre}}</td>
                <td>{{$coleccion->referencia}}</td>
                <td>{{(($coleccion->estado==1)?"Activo":"Inactivo")}}  </td>
            </tr>
        @endforeach 
    </tbody>

</table>