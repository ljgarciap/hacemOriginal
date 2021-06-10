<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Tiempo estandar</li>
                </ol>

                <template v-if="listado==0">
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                       <div class="card-header">
                            <i class="fa fa-align-justify"></i> Tiempo Estandar
                            <button type="button" @click="abrirModal('tiempoestandar','crear')" class="btn btn-secondary">
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button>
                        </div>

                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                         <option value="id">Id</option>
                                        <option value="empleado">Empleado</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarTiempoEstandar(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarTiempoEstandar(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Acciones</th>
                                        <th>Empleado</th>
                                         <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="tiempoestandar in arrayTiempoEstandar" :key="tiempoestandar.id">
                                        <td>
                                        <template>
                                            <button type="button" class="btn btn-danger btn-sm" @click="mostrarWestingHouse(tiempoestandar.id)">
                                                <i class="icon-plus"></i><span> Westing House</span>
                                            </button>
                                        </template>
                                         <!--<template v-if="tiempoestandar.estado==2">
                                           <button type="button" class="btn btn-warning btn-sm" @click="mostrarObservacion(tiempoestandar.id)">
                                                <i class="icon-plus"></i><span> Realizar Observación</span>
                                            </button>
                                        </template>-->
                                        <template>
                                            <button type="button" class="btn btn-success btn-sm" @click="mostrarDetalle(tiempoestandar.id)">
                                                <i class="icon-magnifier"></i><span> Detalle Tiempo Estandar</span>
                                            </button>
                                        </template>
                                        </td>
                                        <td v-text="tiempoestandar.nombreEmpleado"></td>
                                        <td v-text="tiempoestandar.fecha"></td>
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

                <template  v-if="listado==1">
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Westing House &nbsp;
                            </div>
                        <div class="card-body">
                            <westinghouse v-bind:identificador="identificador" :key="componentKey" @cambiarlistado="cambiarlistado"></westinghouse>
                            <p align="right">
                                <button class="btn btn-danger" @click="ocultarDetalle()" aria-label="Close">Cerrar</button>
                            </p>
                        </div>
                    </div>
                    <!-- Fin ejemplo de tabla Listado -->
                </div>
                </template>
                <!--<template v-if="listado==2 ">
                <div class="container-fluid">
                     Ejemplo de tabla Listado 

                    <div class="card">
                        <div class="card-header">
                       <i class="fa fa-align-justify"></i> Observación Inventario &nbsp;
                        </div>
                        <div class="card-body">
                            <observacioninventario v-bind:identificador="identificador" :key="componentKey" @finalizarlistado="finalizarlistado"></observacioninventario>
                            <p align="right">
                                <button  class="btn btn-danger" @click="ocultarDetalle()" aria-label="Close">Cerrar</button>
                            </p>
                        </div>
                    </div>-->
                    <!-- Fin ejemplo de tabla Listado -->
                <!--</div>
                </template>-->
                <template v-if="listado==3 ">
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                        <div class="card-header">
                       <i class="fa fa-align-justify"></i> Detalle Tiempo Estandar &nbsp;
                        </div>
                        <div class="card-body">
                            <detalletiempoestandar v-bind:identificador="identificador" :key="componentKey"></detalletiempoestandar>
                            <p align="right">
                                <button  class="btn btn-danger" @click="ocultarDetalle()" aria-label="Close">Cerrar</button>
                            </p>
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

                                    <div v-if="tipoModal==1" class="form-group row">
                                        <label class="col-md-3 form-control-label" for="email-input">Empleado</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="idEmpleado">
                                                <option value="0" disabled>Seleccione un empleado</option>
                                                <option v-for="empleado in arrayEmpleados" :key="empleado.id" :value="empleado.id" v-text="empleado.nombreEmpleado"></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div v-if="tipoModal==1" class="form-group row div-error" v-show="errorTiempoEstandar">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMensaje" :key="error" v-text="error"></div>
                                        </div>
                                    </div>
                                    <div v-if="tipoModal==3" class="carga">
                                        <p><hr><h1>Generando, por favor espere...</h1><hr></p>
                                    </div>
                                </form>
                            </div>
                            <div v-if="tipoModal==1" class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearTiempoEstandar()">Guardar</button>
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
    import westinghouse from '../components/WestingHouse';
    import detalletiempoestandar from '../components/DetalleTiempoEstandar';
    export default {
        components: {
            westinghouse,
            detalletiempoestandar
        },
        data(){
            return{
                idTiempoEstandar:0,
                id:'',
                identificador:'',
                fecha : '',
                estado:'',
                idEmpleado: 0,
                nombreEmpleado: '',
                arrayEmpleados : [],
                arrayTiempoEstandar : [],
                modal : 0,
                listado : 0,
                tituloModal : '',
                variable : '',
                registro:'',
                tipoModal : 0,
                tipoAccion : 0,
                errorTiempoEstandar : 0,
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
                criterio : 'id',
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
            currentDateTime() {
                return moment().format('YYYY-MM-DD')
            },
            listarTiempoEstandar(page,buscar,criterio){
                let me=this;
                var url='/tiempoestandar?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                //console.log(url);
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayTiempoEstandar=respuesta.tiempoestandar.data;
                me.pagination=respuesta.pagination;
                    //console.log(response);
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
                me.listarTiempoEstandar(page,buscar,criterio);
            },
            indexChange: function(args) {
                let newIndex = args.value
                console.log('Current tab index: ' + newIndex)
                },
            forceRerender() {
                this.componentKey += 1;
               },
            listarEmpleados(){
                let me=this;
                var url='/tiempoestandar/empleados';
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
            crearTiempoEstandar(){
                //valido con el metodo de validacion creado
                let me=this;
                this.fecha= moment().format('YYYY-MM-DD');
                axios.post('/tiempoestandar/store',{
                    'fecha': this.fecha,
                    'idEmpleado': this.idEmpleado
                }).then(function (response) {
                me.cerrarModal('0');
                me.listarTiempoEstandar(1,'','');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
           mostrarWestingHouse(id){
                this.listado=1;
                this.identificador=id;
                console.log(this.identificador);
            },
           /* mostrarObservacion(id){
                this.listado=2;
                this.identificador=id;
                console.log(this.identificador);
            },*/
            mostrarDetalle(id){
                this.listado=3;
                this.identificador=id;
                (this.identificador);
            },
            generarDetalle(id){
                this.identificador=id;
                let me=this;
                axios.post('/tiempoestandar/estado',{
                    'id': this.identificador
                }).then(function (response) {
                me.cerrarModal('0');
                me.forceRerender();
                me.listarTiempoEstandar(1,'','');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            ocultarDetalle(){
                this.listarTiempoEstandar(1,this.buscar,this.criterio);
                this.forceRerender();
                this.listado=0;
            },
            cambiarlistado(payload){
                //this.listado=2;
                this.listado = payload.message;
            },
            /*finalizarlistado(payload){
                //this.listado=2;
                this.listado = payload.message;
            },*/
            cerrarModal(variable){
                this.modal=this.variable;
                this.tituloModal='';
                this.detalle='';
                this.errorTiempoEstandar = 0,
                this.errorMensaje = [],
                this.forceRerender();
            },
            abrirModal(modelo, accion, identificador){
            //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
            switch(modelo){
                    case "tiempoestandar":
                    {
                        switch (accion) {
                            case 'crear':{
                                this.modal=1;
                                this.tipoModal=1; //carga tipos de campos y footers
                                this.tituloModal='Crear tiempo estandar';
                                this.tipoAccion= 1; //carga tipos de botón en el footer
                                this.fecha= moment().format('YYYY-MM-DD');
                                break;
                            }
                        }
                        break;
                    }
                    case "detalle":
                    {
                        switch (accion) {
                            case 'crear':{
                                this.modal=1;
                                this.tipoModal=3; //carga tipos de campos y footers
                                this.tituloModal='Generando, por favor espere...';
                                this.identificador=identificador;
                                this.generarDetalle(this.identificador);
                                break;
                            }
                        }
                        break;
                    }

                }
            }
        },
        mounted() {
            this.listarTiempoEstandar(1,this.buscar,this.criterio);
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
