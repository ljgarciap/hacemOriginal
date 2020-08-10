    @extends('principal')
    @section('contenido')

    <template v-if="menu==0">
        <bienvenida></bienvenida>
    </template>

    <template v-if="menu==1">
        <areas></areas>
    </template>

    <template v-if="menu==2">
        <h1>Prueba de cambio 2</h1>
    </template>

    <template v-if="menu==3">
        <h1>Prueba de cambio 3</h1>
    </template>

    <template v-if="menu==4">
        <h1>Prueba de cambio 4</h1>
    </template>

    <template v-if="menu==5">
        <h1>Prueba de cambio 5</h1>
    </template>

    <template v-if="menu==6">
        <h1>Prueba de cambio 6</h1>
    </template>

    <template v-if="menu==7">
        <h1>Prueba de cambio 7</h1>
    </template>

    <template v-if="menu==8">
        <h1>Prueba de cambio 8</h1>
    </template>

    <template v-if="menu==9">
        <h1>Prueba de cambio 9</h1>
    </template>

    <template v-if="menu==10">
        <h1>Prueba de cambio 10</h1>
    </template>

    <template v-if="menu==11">
        <h1>Prueba de cambio 11</h1>
    </template>

    <template v-if="menu==12">
        <h1>Pdf de ayuda</h1>
    </template>

    <template v-if="menu==13">
        <h1>Generalidades</h1>
    </template>

    <template v-if="menu==14">
        <admin></admin>
    </template>

    <template v-if="menu==15">
        <empresa></empresa>
    </template>

    @endsection
