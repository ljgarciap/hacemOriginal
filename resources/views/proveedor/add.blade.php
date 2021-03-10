<!DOCTYPE html>
<html lang="en">
<head>
    <title>Agregar Proveedor</title>
    <link href="{{asset('css/app.css')}}" rel="stylesheet"> 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h5 align="center">Agregar Proveedor</h5>
        <div class="form-group">
    <form method="POST" action="{{ route('proveedor.store')}}">
        @csrf
        <label for="formGroupExampleInput">Nit:</label>
        <input type="number" name="nit" placeholder="Nit" class="form-control" id="formGroupExampleInput"><br>
        <label for="formGroupExampleInput">Razón Social:</label>
        <input type="text" name="razonSocial" placeholder="Razón Social" class="form-control" id="formGroupExampleInput"><br>
        <label for="formGroupExampleInput">Contacto:</label>
        <input type="text" name="contacto" placeholder="Contacto" class="form-control" id="formGroupExampleInput"><br>
        <label for="formGroupExampleInput">Telefono:</label>
        <input type="number" name="telefono" placeholder="Telefono" class="form-control" id="formGroupExampleInput"><br>
        <label for="formGroupExampleInput">Dirección:</label>
        <input type="text" name="direccion" placeholder="Dirección" class="form-control" id="formGroupExampleInput"><br>
        <label for="formGroupExampleInput">Correo:</label>
        <input type="text" name="correo" class="form-control" id="formGroupExampleInput"><br>
        <input type="submit" name="Guardar" class="btn btn-primary">
        <a href="{{ route('proveedor.index') }}"><button type="button" class="btn btn-danger">Cancelar</button></a>
    </form>
    </div>
</div>
    </body>
    </html>