<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Actividad o gestión</li>
                </ol>

                <template v-if="listado">

                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->
                <vs-tabs :color="colorx">

                    <vs-tab label="Endeudamiento total" icon="open_with" @click="colorx = '#FFA500'">
                    <div class="card">
                        <div class="card-body">

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Activo total</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="activototal" class="form-control" placeholder="Activo total">
                                            <span class="help-block">(*) Ingrese el valor del activo total</span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Pasivo corriente</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="pasivocorriente" class="form-control" placeholder="Pasivo corriente">
                                            <span class="help-block">(*) Ingrese el valor del pasivo corriente</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Pasivo total</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="pasivototal" class="form-control" placeholder="Pasivo total">
                                            <span class="help-block">(*) Ingrese el valor del pasivo total</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Patrimonio total</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="patrimoniototal" class="form-control" placeholder="Patrimonio total">
                                            <span class="help-block">(*) Ingrese el valor del patrimonio total</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="puntoequilibriopesos">Endeudamiento total: {{ parseFloat(parseInt(pasivototal)/parseInt(activototal)).toFixed(3) }}</label>
                                    </div>
                                    <div class="form-group row">
                                        <label for="puntoequilibriopesos">Endeudamiento leverage: {{ parseFloat(parseInt(pasivototal)/parseInt(patrimoniototal)).toFixed(3) }}</label>
                                    </div>
                                    <div class="form-group row">
                                        <label for="puntoequilibriopesos">Concentración Endeudamiento corto plazo: {{ parseFloat(parseInt(pasivocorriente)/parseInt(pasivototal)).toFixed(3) }}</label>
                                    </div>

                        </div>
                    </div>
                    </vs-tab>

                    <vs-tab label="Indicadores de rentabilidad" icon="open_with" @click="colorx = '#FFA500'">
                    <div class="card">
                        <div class="card-body">

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Utilidad bruta</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="utilidadbruta" class="form-control" placeholder="Utilidad bruta">
                                            <span class="help-block">(*) Ingrese el valor de la Utilidad bruta</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Utilidad operacional</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="utilidadoperacional" class="form-control" placeholder="Utilidad operacional">
                                            <span class="help-block">(*) Ingrese el valor de la Utilidad operacional</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Utilidad neta</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="utilidadneta" class="form-control" placeholder="Utilidad neta">
                                            <span class="help-block">(*) Ingrese el valor de la Utilidad neta</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Ingresos totales</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="ingresostotales" class="form-control" placeholder="Ingresos totales">
                                            <span class="help-block">(*) Ingrese el valor de los ingresos totales</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="puntoequilibriopesos">Margen bruto: {{ parseFloat(parseInt(utilidadbruta)/parseInt(ingresostotales)).toFixed(3) }}</label>
                                    </div>
                                    <div class="form-group row">
                                        <label for="puntoequilibriopesos">Margen operacional: {{ parseFloat(parseInt(utilidadoperacional)/parseInt(ingresostotales)).toFixed(3) }}</label>
                                    </div>
                                    <div class="form-group row">
                                        <label for="puntoequilibriopesos">Margen neto: {{ parseFloat(parseInt(utilidadneta)/parseInt(ingresostotales)).toFixed(3) }}</label>
                                    </div>

                        </div>
                    </div>
                    </vs-tab>

                </vs-tabs>
                    <!-- Fin ejemplo de tabla Listado -->
                </div>

                </template>
        </main>
</template>

<script>
    import moment from 'moment';
    export default {
        data(){
            return{
                colorx: '#8B0000',
                listado: 1,
                idProducto:0,
                flag: 0,
                valorpar:0,
                valorcif:0,
                valormatprima:0,
                valormanobra:0,
                costo:0,
                porcentaje:0,
                costosfijos:0,
                materiaprima:0,
                manodeobradirecta:0,
                gastosfijos:0,
                activocorriente:0,
                pasivocorriente:0,
                activototal:0,
                inventario:0,
                pasivototal:0,
                patrimoniototal:0,
                utilidadbruta:0,
                utilidadoperacional:0,
                utilidadneta:0,
                ingresostotales:0,
                arrayPosibles : [],
                errorVinculacion : 0,
                errorMensaje : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'vinculacion',
                buscar : ''
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginacion
            pagesNumber: function(){
                if (this.pagination.to) {
                    return[];
                }

                var from=this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }

                return pagesArray;
            }
        },
        methods : {
            onChange(event) {
                console.log(event.target.value);
                this.identificadorHoja=event.target.value;
                let me=this;
                var url='/hojadecosto/unitariogen/?identificador='+this.identificadorHoja;
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.valorpar=respuesta.costopar;
                me.valorcif=respuesta.acumuladocift;
                me.valormatprima=respuesta.acumuladomp;
                me.valormanobra=respuesta.acumuladomo;
                console.log(me.valorpar);
                console.log(me.valorcif);
                console.log(me.valormatprima);
                console.log(me.valormanobra);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;
                //envia peticion para ver los valores asociados a esa pagina
                me.listarVinculacion(page,buscar,criterio);
                this.listarVinculacionInactiva(page,buscar,criterio);
            },
            indexChange: function(args) {
                let newIndex = args.value
                console.log('Current tab index: ' + newIndex)
                },
            forceRerender() {
                this.componentKey += 1;
               },
            mostrarDetalle(id,producto,area){
                this.listado=0;
                this.identificador=0;
            },
            ocultarDetalle(){
                this.listado=1;
                this.identificador=0;
            },
            validarVinculacion(){
                this.errorVinculacion=0;
                this.errorMensaje=[];

                //if (!this.idEmpleado) this.errorMensaje.push("El nombre del empleado no puede estar vacio");
                if (this.errorMensaje.length) this.errorVinculacion=1;

                return this.errorVinculacion;
            },
            listarPosibles(id){
                let me=this;
                var url='/relaf/posibles?id=' + this.identificador;
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayPosibles=respuesta.posibles;
                    //console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            }
        },
        mounted() {
            this.listarPosibles();
        }
    }
</script>
<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>
