<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proveedor</title>
    <link href="{{asset('css/app.css')}}" rel="stylesheet"> 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h2>Crear Proveedor</h2>
 <a class="btn btn-success btn-rounded m-t-10 float-right" href="{{ route('proveedor.create') }}">Agregar Proveedor</a>
    <div class="table-responsive m-t-40">
        <table class="table table-hover table table-bordered" width="100%" cellspacing="0" border="1">
            <thead>
                <tr>
                 <th scope="col">Id</th>
                 <th scope="col">Nit</th>
                 <th scope="col">Razon Social</th>
                 <th scope="col">Contacto</th>
                 <th scope="col">Telefono</th>
                 <th scope="col">Direccion</th>
                 <th scope="col">Correo</th>
                 <th scope="col">Opciones</th>
             </tr>
         </thead>
         <tbody>
            @foreach($tb_proveedor as $p)
            <tr>
                <td>{{$p->id}}</td>
                <td>{{$p->nit}}</td>
                <td>{{$p->razonSocial}}</td>
                <td>{{$p->contacto}}</td>
                <td>{{$p->telefono}}</td>
                <td>{{$p->direccion}}</td>
                <td>{{$p->correo}}</td>
                <td>
                    <center>
                    <a class="fas fa-edit btn btn-primary" href="{{ route('proveedor.edit',['proveedor'=>$p->id]) }}">Editar</a> 
              <br>
             <form method="POST" action="{{ route('proveedor.destroy',['proveedor'=>$p->id]) }}">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="DELETE">
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