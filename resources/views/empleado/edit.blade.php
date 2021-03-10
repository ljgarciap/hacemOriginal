<!DOCTYPE html>
<html lang="en">
<head>
    <title>Editar Empleado</title>
    <link href="{{asset('css/app.css')}}" rel="stylesheet"> 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h5 align="center">Editar Empleado</h5>
        <div class="form-group">
    <form method="POST" action="{{ route('empleado.update',['empleado'=>$tb_empleado->id]) }}">
        @csrf
        {{ method_field('PUT') }}
        <label for="formGroupExampleInput">Documento:</label>
        <input type="number" name="documento" value="{{$tb_empleado->documento}}" placeholder="Digite el documento" class="form-control" id="formGroupExampleInput"><br>
        <select name="idPerfil" class="form-control" required>
        <option>Seleccione un Perfil</option>
         @foreach($tb_perfil as $p)
         <option selected value="{{$p->id}}">{{ $p->perfil }}</option><br>
         @endforeach
         </select>
        <label for="formGroupExampleInput">Nombre:</label>
        <input type="text" name="nombre" value="{{$tb_empleado->nombre}}" placeholder="Digite el nombre" class="form-control" ><br>
        <label for="formGroupExampleInput">Apellido:</label>
        <input type="text" name="apellido" value="{{$tb_empleado->apellido}}" placeholder="Digite el apellido" class="form-control"><br>
        <label for="formGroupExampleInput">Direccion:</label>
        <input type="text" name="direccion" value="{{$tb_empleado->direccion}}" class="form-control"><br>
        <label for="formGroupExampleInput">Telefono:</label>
        <input type="number" name="telefono" value="{{$tb_empleado->telefono}}" class="form-control"><br>
        <label for="formGroupExampleInput">Correo:</label>
        <input type="text" name="correo" class="form-control" value="{{$tb_empleado->correo}}"><br>
        <input type="submit" name="Guardar" class="btn btn-primary">
        <a href="{{ route('empleado.index') }}"><button type="button" class="btn btn-danger">Cancelar</button></a>
    </form>
    </div>
</div>
    </body>
    </html>