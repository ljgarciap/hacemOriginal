<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Precio de venta y punto de equilibrio</li>
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
                                            <select class="form-control" v-model="idProducto" @change='onChange($event)'>
                                                <option value="0" disabled>Seleccione un producto</option>
                                                <option v-for="posible in arrayPosibles" :key="posible.idProducto" :value="posible.idProducto" v-text="posible.producto"></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Costo producción</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="costo" class="form-control" placeholder="Costo producto">
                                            <br><span class="help-block">(*) Ingrese el costo de producción - (De hoja: {{this.valorpar}}))</span>
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
                                            <span class="help-block">(*) Ingrese los costos fijos - (De hoja: {{this.valorcif}})</span>
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
                                            <span class="help-block">(*) Ingrese el valor de materia prima - (De hoja: {{this.valormatprima}})</span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Valor mano de obra</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="manodeobradirecta" class="form-control" placeholder="Mano de obra directa">
                                            <span class="help-block">(*) Ingrese el valor de mano de obra directa - (De hoja: {{this.valormanobra}})</span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="puntoequilibriounidad">Punto de equilibrio: {{parseFloat((parseInt(costosfijos)+parseInt(gastosfijos))/
                                            (( parseInt((this.costo)/((100-this.porcentaje)/100)) )-(parseInt(materiaprima)+parseInt(manodeobradirecta)))).toFixed(3)}} unidades</label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="puntoequilibriopesos">Costos + gastos: {{parseInt(costosfijos)+parseInt(gastosfijos)}}</label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="puntoequilibriopesos">Precio venta: {{parseInt((this.costo)/((100-this.porcentaje)/100))}}</label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="puntoequilibriopesos">Costo unitario: {{ parseInt(materiaprima)+parseInt(manodeobradirecta)}}</label>
                                        </div>
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
                me.costo=respuesta.costopar;
                me.valorcif=respuesta.acumuladocift;
                me.costosfijos=respuesta.acumuladocift;
                me.valormatprima=respuesta.acumuladomp;
                me.materiaprima=respuesta.acumuladomp;
                me.valormanobra=respuesta.acumuladomo;
                me.manodeobradirecta=respuesta.acumuladomo;
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
