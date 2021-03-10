<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Cliente</title>
    <link href="{{asset('css/app.css')}}" rel="stylesheet"> 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
    <div class="container">
    <h2>Crear Cliente</h2>
    <a class="btn btn-success btn-rounded m-t-6 float-right" href="{{ route('cliente.create') }}">Agregar Cliente</a>
    <div class="table-responsive m-t-40">
        <table class="table table-hover table table-bordered" width="100%" cellspacing="0" border="1">
            <thead>
                <tr>
                 <th scope="col">Id</th>
                 <th scope="col">Documento</th>
                 <th scope="col">Nombre</th>
                 <th scope="col">Apellido</th>
                 <th scope="col">Direccion</th>
                 <th scope="col">Telefono</th>
                 <th scope="col">Correo</th>
                 <th scope="col">Opciones</th>
             </tr>
         </thead>
         <tbody>
            @foreach($tb_cliente as $c)
            <tr>
                <td>{{$c->id}}</td>
                <td>{{$c->documento}}</td>
                <td>{{$c->nombre}}</td>
                <td>{{$c->apellido}}</td>
                <td>{{$c->direccion}}</td>
                <td>{{$c->telefono}}</td>
                <td>{{$c->correo}}</td>
                <td>
                    <center>
                    <a class="fas fa-edit btn btn-primary" href="{{ route('cliente.edit',['cliente'=>$c->id]) }}">Editar</a>
                     <form method="POST" action="{{ route('cliente.destroy',['cliente'=>$c->id]) }}">
                      {{ csrf_field() }}
                      <input type="hidden" class="btn btn-danger" name="_method" value="DELETE">
                      <button class="fa fa-trash btn btn-danger">Eliminar</button>
                  </form>
              </center>
          </td>
      </tr>
      @endforeach
  </tbody>
</table>
</div>
</div>
</body>
</html>