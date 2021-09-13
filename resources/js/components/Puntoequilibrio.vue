<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Punto de equilibrio individual</li>
                </ol>

                <template v-if="listado==1">
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Punto de equilibrio individual &nbsp;
                            <button type="button" @click="mostrarDetalle()" class="btn btn-secondary">
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button>
                        </div>
                        <div class="card-body">
                            <!--
                            <div class="form-group row">
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                        <option value="id">Id</option>
                                        <option value="area">Area</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarArea(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarArea(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            -->
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Detalle</th>
                                        <th>Precio de venta</th>   
                                        <th>Punto de equilibrio</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="precio in arrayPrecios" :key="precio.id">
                                        <td v-text="precio.detalle"></td>
                                        <td v-text="precio.preciodeventa"></td>
                                        <td v-text="precio.puntodeequilibrio"></td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                            <nav>
                                <ul class="pagination">
                                    <li class="page-item" v-if="pagination.current_page > 1">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                    </li>
                                    <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                    </li>
                                    <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                </template>

                <template v-if="listado==2">

                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->
                <vs-tabs :color="colorx">

                    <vs-tab label="Punto de equilibrio" icon="open_with" @click="colorx = '#FFA500'">
                    <div class="card">
                        <div class="card-body">

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Producto</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="idProducto" @change='onChange($event)'>
                                                <option value="0" disabled>Seleccione un producto</option>
                                                <option v-for="posible in arrayPosibles" :key="posible.id" :value="posible.id" v-text="posible.detalle"></option>
                                            </select>
                                        </div>
                                    </div>

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
                                            (( parseInt(this.preciodeventa) )-(parseInt(materiaprima)+parseInt(manodeobradirecta)))).toFixed(3)}} pares</label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="puntoequilibriopesos">Costos + gastos: {{parseInt(costosfijos)+parseInt(gastosfijos)}}</label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="puntoequilibriopesos">Precio venta: {{parseInt(this.preciodeventa)}}</label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="puntoequilibriopesos">Costo unitario: {{ parseInt(materiaprima)+parseInt(manodeobradirecta)}}</label>
                                        </div>
                                    </div>

                                    <p v-show="condicion">
                                        <input type="text" v-model="idProducto">
                                    </p>

                                    <p v-show="condicion">
                                        <input type="text" v-model="preciodeventa">
                                    </p>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-primary" @click="crearPuntoEquilibrio(),ocultarDetalle()">Guardar</button>
                                        </div>
                                    </div>

                        </div>
                    </div>
                    </vs-tab>

                    <vs-tab label="Cerrar" icon="cancel_schedule_send" @click="ocultarDetalle()">
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
                condicion:false,
                listado: 1,
                idProducto:0,
                flag: 0,
                preciodeventa:0,
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
                componentKey:0
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginacion
            pagesNumber: function(){
                if (!this.pagination.to) {
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
                //var url='/hojadecosto/unitariogen/?identificador='+this.identificadorHoja;
                var url='/simulaciones/unitariogen/?identificador='+this.identificadorHoja;
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.valorpar=respuesta.costopar;
                me.costo=respuesta.costopar;
                me.preciodeventa=respuesta.precioventa;
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
            indexChange: function(args) {
                let newIndex = args.value
                console.log('Current tab index: ' + newIndex)
                },
            forceRerender() {
                this.componentKey += 1;
               },
            mostrarDetalle(){
                this.listado=2;
                this.identificador=0;
            },
            ocultarDetalle(){
                this.listado=1;
                this.identificador=0;
                this.listarPrecios(1);
            },
            validarVinculacion(){
                this.errorVinculacion=0;
                this.errorMensaje=[];

                //if (!this.idEmpleado) this.errorMensaje.push("El nombre del empleado no puede estar vacio");
                if (this.errorMensaje.length) this.errorVinculacion=1;

                return this.errorVinculacion;
            },
            crearPuntoEquilibrio(){
                //valido con el metodo de validacion creado
                /*
                if(this.validarManoDeObraProducto()){
                    return;
                }
                */

                axios.post('/simulaciones/storePuntoEquilibrio',{
                    'idProducto': this.idProducto,
                    'preciodeventa': this.preciodeventa,
                    'costosfijos': this.costosfijos,
                    'gastosfijos': this.gastosfijos,
                    'materiaprima': this.materiaprima,
                    'manodeobradirecta': this.manodeobradirecta
                }).then(function (response) {
                this.ocultarDetalle();
                this.forceRerender();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            forceRerender() {
                this.componentKey += 1;
               },
            listarPrecios(page){
                let me=this;
                var url='/simulaciones/listarPuntos?page=' + page;
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayPrecios=respuesta.puntos.data;
                me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },       
            cambiarPagina(page){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;
                //envia peticion para ver los valores asociados a esa pagina
                me.listarPrecios(page);
            },    
            listarPosibles(id){
                let me=this;
                //var url='/relaf/posibles?id=' + this.identificador;
                var url='/simulaciones/posibles?id=' + this.identificador;
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
            this.listarPrecios(1);
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
