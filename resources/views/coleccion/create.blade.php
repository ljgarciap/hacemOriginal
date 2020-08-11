Crear
<form action="{{url('/coleccion')}}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <label for="nombre">{{'Nombre'}}</label>
    <input type="text" name="nombre" id="nombre" value="">
    <br/>
    <label for="referencia">{{'Referencia'}}</label>
    <input type="text" name="referencia" id="referencia " value="">
    <br/>
    <a href="{{url ('coleccion')}}">Cerrar</a>
    <input type="submit" value="Agregar">
</form>