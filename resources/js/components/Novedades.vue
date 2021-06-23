<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Novedades</li>
                </ol>

                <template v-if="listado==0">
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                       <div class="card-header">
                            <i class="fa fa-align-justify"></i> Novedades
                            <button type="button" @click="abrirModal('novedad','crear')" class="btn btn-secondary">
                                <i class="icon-plus"></i>&nbsp;Entrada
                            </button>
                            <button type="button" @click="abrirModal('novedad','crears')" class="btn btn-secondary">
                                <i class="icon-plus"></i>&nbsp;Salida
                            </button>
                        </div>

                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                        <option value="producto">Fecha</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarNovedades(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarNovedades(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Acciones</th>
                                        <th>Fecha novedad</th>
                                        <th>Concepto</th>
                                        <th>Valor</th>
                                        <th>Empleado</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="novedad in arrayNovedades" :key="novedad.id">
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" @click="mostrarDetalle(novedad.idProducto)">
                                                <i class="icon-eye"></i><span> Ver kárdex</span>
                                            </button>
                                        </td>
                                        <td v-text="novedad.fechaNovedad"></td>
                                        <td v-text="novedad.concepto"></td>
                                        <td v-text="novedad.valor"></td>
                                        <!--
                                        <td v-text="novedad.tipologia"></td>
                                        <td v-text="novedad.idEmpleado"></td>
                                        <td v-text="novedad.idNomina"></td>
                                        -->
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
                    <!-- Fin ejemplo de tabla Listado -->
                </div>
                </template>

                <!--Inicio del modal agregar/actualizar-->
                <div class="modal fade" tabindex="-1" :class="{'mostrar':modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-primary modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header" v-if="tipoModal!=3">
                                <h4 class="modal-title" v-text="tituloModal"></h4>
                                <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                                <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

                                    <div v-if="tipoModal==1" class="form-group row"> <!-- Si es una entrada -->
                                        <label class="col-md-3 form-control-label" for="email-input">Novedad</label>
                                        <div v-if="desplegable==1" class="col-md-9">
                                            <select class="form-control" v-model="concepto" @change='onChange($event)'>
                                                <option value="0" disabled>Seleccione tipo de novedad</option>
                                                <option value="1">Horas extras y recargos</option>
                                                <option value="2">Prima extralegal</option>
                                                <option value="3">Bonificaciones</option>
                                                <option value="4">Comisiones</option>
                                                <option value="5">Viaticos</option>
                                                <option value="6">No factor salarial</option>
                                            </select>
                                        </div>
                                        <div v-else-if="desplegable==2" class="col-md-9"> <!-- Si es una salida -->
                                            <select class="form-control" v-model="concepto" @change='onChange($event)'>
                                                <option value="0" disabled>Seleccione tipo de novedad</option>
                                                <option value="7">Fondo de solaridad</option>
                                                <option value="8">Retenciòn en la fuente</option>
                                                <option value="9">Sindicato</option>
                                                <option value="10">Préstamos</option>
                                                <option value="11">Embargos</option>
                                                <option value="12">Descuento por libranza/otros</option>
                                                <!--
                                                <option value="13">Descuento a salud</option>
                                                <option value="14">Descuento a pensión</option>
                                                -->
                                            </select>
                                        </div>
                                    </div>

                                    <div v-if="tipoModal==1" class="form-group row">

                                        <label class="col-md-3 form-control-label" for="text-input">Valor</label>
                                        <div class="col-md-9">
                                            <input type="number" v-model="valor" class="form-control" placeholder="Valor">
                                            <span class="help-block">(*) Ingrese el Valor</span>
                                        </div>

                                        <label class="col-md-3 form-control-label" for="text-input">Empleado</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="idEmpleado">
                                                <option value="0" disabled>Seleccione empleado</option>
                                                <option v-for="empleado in arrayEmpleados" :key="empleado.id" :value="empleado.id" v-text="empleado.empleado"></option>
                                            </select>
                                            <span class="help-block">(*) Empleado</span>
                                        </div>

                                        <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Fecha de Novedad</label>
                                        <div class="col-md-9">
                                            <input type="date" v-model="fechaNovedad" class="form-control" placeholder="Ingrese la fecha de la novedad">
                                            <span class="help-block">(*) Ingrese fecha de novedad</span>
                                        </div>
                                        </div>

                                    </div>

                                    <div v-if="tipoModal==1" class="form-group row div-error" v-show="errorNovedad">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMensaje" :key="error" v-text="error"></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div v-if="tipoModal==1" class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearnovedad()">Guardar</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!--Fin del modal-->
        </main>
</template>

<script>
import moment from 'moment';
    export default {
        data(){
            return{
                id:'',
                identificador:'',
                idEmpleado:'',
                fecha : '',
                flag : 0,
                valor:'',
                arrayNovedades : [],
                arrayEmpleados : [],
                mensajecantidad:'',
                modal : 0,
                desplegable : 0,
                listado : 0,
                tituloModal : '',
                variable : '',
                hoy : '',
                tipologia : 0,
                tipoModal : 0,
                tipoAccion : 0,
                errorNovedad : 0,
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
                criterio : 'producto',
                buscar : '',
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
            //console.log(event.target.value);
            this.flag=event.target.value;
            },
            listarNovedades(page,buscar,criterio){
                let me=this;
                var url='/novedades?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayNovedades=respuesta.novedades.data;
                me.pagination=respuesta.pagination;
                    //console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            currentDateTime() {
                return moment().format('YYYY-MM-DD')
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;
                //envia peticion para ver los valores asociados a esa pagina
                me.listarNovedades(page,buscar,criterio);
            },
            indexChange: function(args) {
                let newIndex = args.value
                console.log('Current tab index: ' + newIndex)
                },
            forceRerender() {
                this.componentKey += 1;
               },
            crearNovedad(){
                //valido con el metodo de validacion creado
                if(this.validarNovedad()){
                    return;
                }
                let me=this;
                this.fecha= moment().format('YYYY-MM-DD');
                axios.post('/novedad/store',{
                    'fechaNovedad': this.fechaNovedad,
                    'concepto':this.concepto,
                    'valor':this.valor,
                    'tipologia':this.tipologia,
                    'idEmpleado':this.idEmpleado
                    //'idNomina':this.idNomina
                }).then(function (response) {
                me.cerrarModal('0');
                me.listarNovedades(1,'','');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarEmpleados(){
                let me=this;
                var url='/vinculacion/selectempleado';
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayEmpleados=respuesta.empleados;
                    //console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            mostrarDetalle(id){
                this.listado=2;
                this.identificador=id;
            },
            ocultarDetalle(){
                this.listado=0;
            },
            validarnovedad(){
                this.errorProducto=0;
                this.errorNovedad=0;
                this.errorMensaje=[];

                if (!this.idEmpleado) this.errorMensaje.push("El empleado no puede estar vacio");
                if (this.errorMensaje.length) this.errorNovedad=1;

                return this.errorNovedad;
            },
            cerrarModal(variable){
                this.modal=this.variable;
                this.tituloModal='';
                this.detalle='';
                this.idEmpleado='';
                this.mensajecantidad='';
                this.valor='';
                this.tipologia='';
                this.flag=0;
                this.errorNovedad=0;
                this.errorMensaje=[];
                this.tituloModal='';

                this.listarNovedades(1,this.buscar,this.criterio);
            },
            abrirModal(modelo, accion, identificador){
            //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
            switch(modelo){
                    case "novedad":
                    {
                        switch (accion) {
                            case 'crear':{
                                this.modal=1;
                                this.tipologia=1;
                                this.tipoModal=1; //carga tipos de campos y footers
                                this.tituloModal='Ingreso de novedades';
                                this.desplegable= 1; //carga tipos de botón en el footer
                                this.tipoAccion= 1; //carga tipos de botón en el footer
                                this.fechaNovedad= moment().format('YYYY-MM-DD');
                                this.listarNovedades();
                                break;
                            }
                            case 'crears':{
                                this.modal=1;
                                this.tipologia=2;
                                this.tipoModal=1; //carga tipos de campos y footers
                                this.tituloModal='Ingreso de novedades deducibles';
                                this.desplegable= 2; //carga tipos de botón en el footer
                                this.tipoAccion= 1; //carga tipos de botón en el footer
                                this.fechaNovedad= moment().format('YYYY-MM-DD');
                                this.listarNovedades();
                                break;
                            }
                        }
                        break;
                    }

                }
            }
        },
        mounted() {
            this.listarNovedades(1,this.buscar,this.criterio);
            this.listarEmpleados();
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
    .carga{
        background-color: #3c29297a !important;
        width: 100% !important;
        height: 100% !important;
        text-align: center;
        color: #ffffffff;
    }
</style>
