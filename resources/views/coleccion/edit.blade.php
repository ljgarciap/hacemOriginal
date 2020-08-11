Editar
<form action="{{ url ('/coleccion/' . $coleccion->id)}}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{method_field('PATCH')}}
    <label for="nombre">{{'Nombre'}}</label>
    <input type="text" name="nombre" id="nombre" value="{{ $coleccion->nombre }}">
    <br/>
    <label for="referencia">{{'Referencia'}}</label>
    <input type="text" name="referencia" id="referencia " value="{{ $coleccion->referencia }}">
    <br/>
    <a href="{{url ('coleccion')}}">Cerrar</a>
    <input type="submit" value="Editar">
</form>