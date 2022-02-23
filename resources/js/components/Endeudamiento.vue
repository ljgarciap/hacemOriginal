<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Endeudamiento</li>
                </ol>

                <template v-if="listado==1">
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Endeudamiento &nbsp;
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
                                        <th>Activo total</th>
                                        <th>Pasivo total</th>
                                        <th>Pasivo corriente</th>
                                        <th>Patrimonio total</th>
                                        <th>Endeudamiento total</th>
                                        <th>Leverage</th>
                                        <th>Corto plazo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="precio in arrayPrecios" :key="precio.id">
                                        <td v-text="precio.detalle"></td>
                                        <td v-text="precio.activototal"></td>
                                        <td v-text="precio.pasivototal"></td>
                                        <td v-text="precio.pasivocorriente"></td>
                                        <td v-text="precio.patrimoniototal"></td>
                                        <td v-text="precio.endeudamientototal"></td>
                                        <td v-text="precio.leverage"></td>
                                        <td v-text="precio.cortoplazo"></td>
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
                                    <div class="form-group row"> <!--Deberia multiplicarlo por 100--->
                                        <label for="puntoequilibriopesos">Endeudamiento total: {{ parseFloat(100*pasivototal/activototal).toFixed(2) }} %</label>
                                    </div>
                                    <div class="form-group row">
                                        <label for="puntoequilibriopesos">Endeudamiento leverage: {{ parseFloat(100*pasivototal/patrimoniototal).toFixed(2) }} %</label>
                                    </div>
                                    <div class="form-group row">
                                        <label for="puntoequilibriopesos">Concentración Endeudamiento corto plazo: {{ parseFloat(100*pasivocorriente/pasivototal).toFixed(2) }} %</label>
                                    </div>

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
                listado: 1,
                idProducto:0,
                flag: 0,
                activototal:0,
                pasivototal:0,
                pasivocorriente:0,
                patrimoniototal:0,
                pasivototal:0,
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
                offset : 3
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
            crearPuntoEquilibrio(){
                //valido con el metodo de validacion creado
                /*
                if(this.validarManoDeObraProducto()){
                    return;
                }
                */

                axios.post('/simulaciones/storeEndeudamiento',{
                    'activototal': this.activototal,
                    'pasivototal': this.pasivototal,
                    'pasivocorriente': this.pasivocorriente,
                    'patrimoniototal': this.patrimoniototal
                }).then(function (response) {
                this.ocultarDetalle();
                this.forceRerender();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarEndeudamiento(page){
                let me=this;
                var url='/simulaciones/listarEndeudamiento?page=' + page;
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayPrecios=respuesta.endeudamiento.data;
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
                me.listarEndeudamiento(page);
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
                this.listarEndeudamiento(1);
            }
        },
        mounted() {
            this.listarEndeudamiento();
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
