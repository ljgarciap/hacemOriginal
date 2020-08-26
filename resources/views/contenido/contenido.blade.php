    @extends('principal')
    @section('contenido')

    <template v-if="menu==0">
        <bienvenida></bienvenida>
    </template>

    <template v-if="menu==1">
        <areas></areas>
    </template>

    <template v-if="menu==2">
        <procesos></procesos>
    </template>

    <template v-if="menu==3">
        <perfiles></perfiles>
    </template>

    <template v-if="menu==4">
        <unidades></unidades>
    </template>

    <template v-if="menu==5">
        <materias></materias>
    </template>

    <template v-if="menu==6">
        <gestionmaterias></gestionmaterias>
    </template>

    <template v-if="menu==7">
        <colecciones></coleciones>
    </template>

    <template v-if="menu==8">
        <productos></productos>
    </template>

    <template v-if="menu==9">
        <h1>Vista para Hojas de costo</h1>
    </template>

    <template v-if="menu==10">
        <roles></roles>
    </template>

    <template v-if="menu==11">
        <usuarios></usuarios>
    </template>

    <template v-if="menu==12">
        <h1>Pdf de ayuda</h1>
    </template>

    <template v-if="menu==13">
        <h1>Generalidades</h1>
    </template>

    <template v-if="menu==14">
        <manodeobraproductos></manodeobraproductos>
    </template>

    <template v-if="menu==15">
        <empresa></empresa>
    </template>

    <template v-if="menu==16">
        <ninguno></ninguno>
    </template>

    @endsection
