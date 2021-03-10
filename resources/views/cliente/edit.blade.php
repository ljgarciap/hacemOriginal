<!DOCTYPE html>
<html lang="en">
<head>
    <title>Editar Cliente</title>
    <link href="{{asset('css/app.css')}}" rel="stylesheet"> 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
    <div class="container">
    <h5>Editar Cliente</h5>
        <div class="form-group">
    <form method="POST"  action="{{ route('cliente.update',['cliente'=>$tb_cliente->id]) }}">
        @csrf
        {{ method_field('PUT') }}
        <label for="formGroupExampleInput">Documento:</label>
        <input type="number" value="{{ $tb_cliente->documento }}" name="documento" placeholder="Digite el documento" class="form-control"><br>
        <label for="formGroupExampleInput">Nombre Cliente:</label>
        <input type="text" name="nombre" value="{{ $tb_cliente->documento }}" placeholder="Digite el nombre" class="form-control" ><br>
        <label for="formGroupExampleInput">Apellido:</label>
        <input type="text" name="apellido" value="{{ $tb_cliente->apellido }}" placeholder="Digite el apellido" class="form-control" ><br>
        <label for="formGroupExampleInput">Direccion:</label>
        <input type="text" name="direccion" value="{{ $tb_cliente->direccion }}" class="form-control" ><br>
        <label for="formGroupExampleInput">Telefono:</label>
        <input type="number" name="telefono" value="{{ $tb_cliente->telefono }}" class="form-control" ><br>
        <label for="formGroupExampleInput">Correo:</label>
        <input type="text" name="correo" value="{{ $tb_cliente->correo }}" class="form-control" ><br>
        <input type="submit" name="Guardar" class="btn btn-primary">
        <a href="{{ route('cliente.index') }}"><button type="button" class="btn btn-danger">Cancelar</button></a>
    </form>
    </div>
</div>
    </body>
    </html>