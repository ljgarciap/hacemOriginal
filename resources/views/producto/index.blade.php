Inicio
<a href="{{url ('producto/create')}}">Agregar</a>
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
        @foreach($productos as $producto)
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
                <td>{{$producto->idColeccion}}</td>
                <td>{{$producto->estado}}</td>
            </tr>
        @endforeach
    </tbody>
</table>