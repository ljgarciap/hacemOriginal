Crear
<form action="{{url('/producto')}}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <label for="nombre">{{'Nombre'}}</label>
    <input type="text" name="nombre" id="nombre" value="">
    <br/>
    <label for="referencia">{{'Referencia'}}</label>
    <input type="text" name="referencia" id="referencia" value="">
    <br/>
    <label for="foto">{{'Foto'}}</label>
    <input type="file" name="foto" id="foto" value="">
    <br/>
    <label for="descripcion">{{'Descripcion'}}</label>
    <input type="text" name="descripcion" id="descripcion" value="">
    <br/>
    <input type="hidden" name="idColeccion" id="idColeccion" value="{{ $idColeccion }}" />
    <br/>
    <a href="{{url ('coleccion/'.$idColeccion)}}">Cerrar</a>
    <input type="submit" value="Agregar">
</form>