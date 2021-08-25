<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Utilidades</li>
                </ol>

                <template v-if="listado">

                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->
                <vs-tabs :color="colorx">
                    <vs-tab label="Precio de venta" icon="open_with" @click="colorx = '#8B0000'">
                    <div class="card">
                        <div class="card-body">

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Producto</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="idProducto">
                                                <option value="0" disabled>Seleccione un producto</option>
                                                <option v-for="posible in arrayPosibles" :key="posible.idProducto" :value="posible.idProducto" v-text="posible.producto"></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Costo producción</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="costo" class="form-control" placeholder="Costo producto">
                                            <span class="help-block">(*) Ingrese el costo de producción</span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Margen</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="porcentaje" class="form-control" placeholder="Porcentaje">
                                            <span class="help-block">(*) Ingrese el porcentaje a aplicar</span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="precioventa">Precio de venta: {{precioventa}}</label><br>
                                            <label for="precioventa">Precio de venta: {{parseInt((this.costo)/((100-this.porcentaje)/100))}}</label>
                                        </div>
                                    </div>

                        </div>
                    </div>
                    </vs-tab>

                    <vs-tab label="Punto de equilibrio" icon="open_with" @click="colorx = '#FFA500'">
                    <div class="card">
                        <div class="card-body">

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Costos fijos</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="costosfijos" class="form-control" placeholder="Costos fijos">
                                            <span class="help-block">(*) Ingrese los costos fijos</span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Gastos fijos</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="gastosfijos" class="form-control" placeholder="Gastos fijos">
                                            <span class="help-block">(*) Ingrese los gastos fijos</span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Valor materia prima</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="materiaprima" class="form-control" placeholder="Materia prima">
                                            <span class="help-block">(*) Ingrese el valor de materia prima</span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Valor mano de obra</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="manodeobradirecta" class="form-control" placeholder="Mano de obra directa">
                                            <span class="help-block">(*) Ingrese el valor de mano de obra directa</span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="puntoequilibriounidad">Punto de equilibrio: {{(parseInt(costosfijos)+parseInt(gastosfijos))/
                                            ( ( parseInt(costo)/parseInt((100-porcentaje)/100) )-(parseInt(materiaprima)+parseInt(manodeobradirecta)) )}}</label>
                                            <span class="help-block">(*) Costos fijos + Gastos fijos / el resto</span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="puntoequilibriopesos">Costos + gastos: {{costosygastos}}</label>
                                            <span class="help-block">(*) Costos fijos + Gastos fijos</span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="puntoequilibriopesos">Precio venta: {{precioventa}}</label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="puntoequilibriopesos">Costo unitario: {{costounitario}}</label>
                                        </div>
                                    </div>

                        </div>
                    </div>
                    </vs-tab>

                    <vs-tab label="Razón corriente" icon="open_with" @click="colorx = '#FFA500'">
                    <div class="card">
                        <div class="card-body">

                        </div>
                    </div>
                    </vs-tab>

                    <vs-tab label="Capital de trabajo" icon="open_with" @click="colorx = '#FFA500'">
                    <div class="card">
                        <div class="card-body">

                        </div>
                    </div>
                    </vs-tab>

                    <vs-tab label="Prueba ácida" icon="open_with" @click="colorx = '#FFA500'">
                    <div class="card">
                        <div class="card-body">

                        </div>
                    </div>
                    </vs-tab>

                    <vs-tab label="Endeudamiento total" icon="open_with" @click="colorx = '#FFA500'">
                    <div class="card">
                        <div class="card-body">

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
                costo:0,
                porcentaje:0,
                costosfijos:0,
                materiaprima:0,
                manodeobradirecta:0,
                gastosfijos:0,
                costovariable:0,
                precioventa:0,
                costosygastos:0,
                costounitario:0,
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
            precioventa: function () {
                return parseInt((this.costo)/((100-this.porcentaje)/100));
            },
            costosygastos: function(){
                return parseInt(costosfijos)+parseInt(gastosfijos);
            },
            costounitario: function(){
                return parseInt(materiaprima)+parseInt(manodeobradirecta);
            },
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
