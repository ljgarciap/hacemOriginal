Editar
    <label for="nombre">{{'Nombre'}}</label>
    <input disabled type="text" name="nombre" id="nombre" value="{{ $coleccion->nombre }}">
    <br/>
    <label for="referencia">{{'Referencia'}}</label>
    <input disabled type="text" name="referencia" id="referencia " value="{{ $coleccion->referencia }}">
    <br/>
    <a href="{{url ('coleccion')}}">Cerrar</a>

    <br>
    <a href="{{ action ('Tb_productoController@create', ['id'=>$coleccion->id])}}">Agregar</a>
<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>Opciones</th>
            <th>Id</th>
            <th>Nombre</th>
            <th>Referencia</th>
            <th>Descripcion</th>
            <th>Foto</th>
            <th>Coleccion</th>
            <th>estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach($coleccion->productos as $producto)
            <tr>
                <td>Ver | 
                    Duplicar | 
                <a href="{{url('/producto/'.$producto->id.'/edit')}}">Editar</a> | 
                    Borrar |</td>
                <td>{{$loop->iteration}}</td>
                <td>{{$producto->nombre}}</td>
                <td>{{$producto->referencia}}</td>
                <td>{{$producto->descripcion}}</td>
                <td>
                    <img src="{{ asset('storage').'/'.$producto->foto}}" alt="" width="100" height="100"> 
                </td>
                <td>{{$producto->coleccion->nombre}}</td>
                <td>{{(($coleccion->estado==1)?"Activo":"Inactivo")}}  </td>
            </tr>
        @endforeach
    </tbody>
</table>
