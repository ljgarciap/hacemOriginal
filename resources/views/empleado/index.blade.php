<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleado</title>
    <link href="{{asset('css/app.css')}}" rel="stylesheet"> 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
<div class="container">
<h2>Crear Empleado</h2>
 <a class="btn btn-success btn-rounded m-t-10 float-right" href="{{ route('empleado.create') }}">Agregar</a>
    <div class="table-responsive m-t-40">
        <table class="table table-hover table table-bordered" width="100%" cellspacing="0" border="1">
            <thead>
                <tr>
                 <th scope="col">Id</th>
                 <th scope="col">Documento</th>
                 <th scope="col">Perfil</th>
                 <th scope="col">Nombre</th>
                 <th scope="col">Apellido</th>
                 <th scope="col">Direccion</th>
                 <th scope="col">Telefono</th>
                 <th scope="col">Correo</th>
                 <th scope="col">Opciones</th>
             </tr>
         </thead>
         <tbody>
            @foreach($tb_empleado as $e)
            <tr>
                <td>{{$e->id}}</td>
                <td>{{$e->documento}}</td>
                @foreach ($tb_perfil as $p)
                @if($p->id == $e->idPerfil)
                <td>{{ $p->perfil }}</td>
                @endif
                @endforeach
                <td>{{$e->nombre}}</td>
                <td>{{$e->apellido}}</td>
                <td>{{$e->direccion}}</td>
                <td>{{$e->telefono}}</td>
                <td>{{$e->correo}}</td>
                <td>
                <center>
             <a class="fas fa-edit btn btn-primary" href="{{ route('empleado.edit',['empleado'=>$e->id]) }}">Editar</a> 
              <br>
             <form method="POST" action="{{ route('empleado.destroy',['empleado'=>$e->id]) }}">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="DELETE">
                <button class="fa fa-trash btn btn-danger">Eliminar</button>
            </form>
        </center>
          </td>
          </td>
      </tr>
      @endforeach
  </tbody>
</table>
</div>
</div>
</body>
</html>