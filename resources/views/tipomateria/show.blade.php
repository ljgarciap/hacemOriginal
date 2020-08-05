@extends('app')

@section('content')
<div class="container">
<a href="{{url ('tipomateria/create')}}" class="btn btn-success">Ver tipos de materia</a>
<br/>
<br/>
<table class="table table-light table-hover">
    <thead class="thead-light">
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tipomaterias as $tipomateria)
            <tr>
                <td>{{$tipomateria->id}}</td>
                <td>{{$tipomateria->area}}</td>
                <td>{{$tipomateria->estado}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>
@endsection

