Editar
<form action="{{url('/producto/'.$producto->id)}}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{method_field('PATCH')}}
    <label for="nombre">{{'Nombre'}}</label>
    <input type="text" name="nombre" id="nombre" value="{{$producto->nombre}}">
    <br/>
    <label for="referencia">{{'Referencia'}}</label>
    <input type="text" name="referencia" id="referencia" value="{{$producto->referencia}}">
    <br/>
    <label for="foto">{{'Foto'}}</label>
    <br/>
    <img src="{{ asset('storage').'/'.$producto->foto}}" alt="" width="100" height="100">
    <br/>
    <input type="file" name="foto" id="foto">
    <br/>
    <label for="descripcion">{{'Descripcion'}}</label>
    <input type="text" name="descripcion" id="descripcion" value="{{$producto->descripcion}}">
    <br/>
    <label for="idColeccion">{{'Coleccion'}}</label>
    <input type="text" name="idColeccion" id="idColeccion" value="{{$producto->idColeccion}}">
    <br/>
    <a href="{{url ('producto')}}">Cerrar</a>
    <input type="submit" value="Editar">
</form>