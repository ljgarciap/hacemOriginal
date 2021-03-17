<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Orden de pedido</li>
                </ol>

                <template v-if="listado==0">
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                       <div class="card-header">
                            <i class="fa fa-align-justify"></i> Orden de pedido
                            <button type="button" @click="abrirModal('ordendepedido','crear')" class="btn btn-secondary">
                                <i class="icon-plus"></i>&nbsp;Nueva
                            </button>
                        </div>

                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                        <option value="descripcion">Descripción</option>
                                        <option value="id">Id</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarOrdenPedido(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarOrdenPedido(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Acciones</th>
                                        <th>Fecha</th>
                                        <th>Consecutivo</th>
                                        <th>Cliente</th>
                                        <th>Observaciones</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="orden in arrayOrdenes" :key="orden.id">
                                        <td>
                                        <template v-if="orden.estado==1">
                                            <button type="button" class="btn btn-danger btn-sm" @click="mostrarProductos(orden.id)">
                                                <i class="icon-plus"></i><span> Agregar</span>
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm" @click="abrirModal('detalle','crear',orden.id)">
                                                <i class="icon-cloud-upload"></i><span> Generar</span>
                                            </button>
                                        </template>
                                        <template v-if="orden.estado==2">
                                            <button type="button" class="btn btn-success btn-sm" @click="mostrarDetalle(orden.id)">
                                                <i class="icon-magnifier"></i><span> Detalle</span>
                                            </button>
                                        </template>
                                        </td>
                                        <td v-text="orden.fecha"></td>
                                        <td v-text="orden.consecutivo"></td>
                                        <td v-text="orden.nombreCliente"></td>
                                        <td v-text="orden.observacion"></td>
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

                <template v-if="listado==1">
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Productos &nbsp;
                            <button type="submit" @click="abrirModal('rela','crear',identificador)" class="btn btn-secondary"><i class="fa fa-plus"></i> Nuevo producto</button>
                            </div>
                        <div class="card-body">
                            <productosordenpedido v-bind:identificador="identificador" :key="componentKey" @eliminarproducto="eliminarProducto"></productosordenpedido>
                            <p align="right">
                                <button class="btn btn-danger" @click="ocultarDetalle()" aria-label="Close">Cerrar</button>
                            </p>
                        </div>
                    </div>
                    <!-- Fin ejemplo de tabla Listado -->
                </div>
                </template>

                    <!-- Template para mostrar el detalle luego de generar -->
                <template v-if="listado==2">
                    <div class="container-fluid">
                        <div class="card">
                            <hojadecostossimulador v-bind:identificador="identificador" :key="componentKey" @eliminarproducto="eliminarProducto"></hojadecostossimulador>
                            <p align="right">
                                <button class="btn btn-danger" @click="ocultarDetalle()" aria-label="Close">Cerrar</button>
                            </p>
                        </div>
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
                                        <label class="col-md-3 form-control-label" for="text-input">Observaciones de la orden</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="observacion" class="form-control" placeholder="Observaciones">
                                            <span class="help-block">(*) Ingrese las Observaciones</span>
                                        </div>
                                    </div>

                                    <div v-if="tipoModal==1" class="form-group row">
                                        <label class="col-md-3 form-control-label" for="email-input">Cliente</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="idCliente">
                                                <option value="0" disabled>Seleccione un cliente</option>
                                                <option v-for="cliente in arrayClientes" :key="cliente.id" :value="cliente.id" v-text="cliente.nombreCliente"></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div v-if="tipoModal==1" class="form-group row div-error" v-show="errorOrden">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMensaje" :key="error" v-text="error"></div>
                                        </div>
                                    </div>

                                    <!-- divs para modal tipo 2 -->

                                    <div v-if="tipoModal==2" class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Producto</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="idProducto">
                                                <option value="0" disabled>Seleccione un producto</option>
                                                <option v-for="posible in arrayPosibles" :key="posible.idProducto" :value="posible.idProducto" v-text="posible.producto"></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div v-if="tipoModal==2" class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Unidades</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="cantidad" class="form-control" placeholder="Unidades a producir">
                                            <span class="help-block">(*) Ingrese la cantidad solicitada</span>
                                        </div>
                                    </div>

                                    <div v-if="tipoModal==2" class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Precio Venta</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="precioVenta" class="form-control" placeholder="Precio venta unidad">
                                            <span class="help-block">(*) Ingrese el precio acordado</span>
                                        </div>
                                    </div>

                                    <div v-if="tipoModal==2" class="form-group row div-error" v-show="errorOrden">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMensaje" :key="error" v-text="error"></div>
                                        </div>
                                    </div>

                                    <!-- Si el tipo es 3 solo es modal para mostrar carga -->

                                    <div v-if="tipoModal==3" class="carga">
                                        <p><hr><h1>Generando, por favor espere...</h1><hr></p>
                                    </div>
                                </form>
                            </div>
                            <div v-if="tipoModal==1" class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearOrden()">Guardar</button>
                            </div>
                            <div v-if="tipoModal==2" class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearRelacion()">Guardar</button>
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
    import productosordenpedido from '../components/productosOrdenPedido';
    import hojadecostossimulador from '../components/HojaDeCostosSimulador';
    export default {
        components: {
            productosordenpedido,
            hojadecostossimulador
        },
        data(){
            return{
                idOrden:0,
                id:'',
                identificador:'',
                observacion:'',
                fecha : '',
                estado:'',
                idCliente: 0,
                nombreCliente: '',
                arrayClientes : [],
                arrayOrdenes : [],
                arrayProductos : [],
                modal : 0,
                listado : 0,
                tituloModal : '',
                variable : '',
                registro:'',
                idProducto: 0,
                cantidad:'',
                precioVenta:'',
                tipoModal : 0,
                tipoAccion : 0,
                errorOrden : 0,
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
                criterio : 'descripcion',
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
            listarOrdenPedido(page,buscar,criterio){
                let me=this;
                var url='/ordenpedido?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                //console.log(url);
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayOrdenes=respuesta.ordenes.data;
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
                me.listarOrdenPedido(page,buscar,criterio);
            },
            indexChange: function(args) {
                let newIndex = args.value
                console.log('Current tab index: ' + newIndex)
                },
            forceRerender() {
                this.componentKey += 1;
               },
            listarPosibles(id){
                let me=this;
                var url='/ordenpedidocliente/posibles?id=' + this.identificador;
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
            },
            listarClientes(){
                let me=this;
                var url='/ordenpedido/clientes';
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayClientes=respuesta.clientes;
                    //console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            eliminarProducto(){
                /*
                let me=this;
                axios.put('/materiaprimaproducto/deactivate',{
                    'id': this.id
                }).then(function (response) {
                me.forceRerender();
                me.listarProducto(1,'','materiaprima');
                })
                .catch(function (error) {
                    console.log(error);
                });
                */
            },
            crearOrden(){
                //valido con el metodo de validacion creado
                let me=this;
                this.fecha= moment().format('YYYY-MM-DD');
                axios.post('/ordenpedido/store',{
                    'observacion': this.observacion,
                    'fecha': this.fecha,
                    'idCliente': this.idCliente
                }).then(function (response) {
                me.cerrarModal('0');
                me.listarOrdenPedido(1,'','');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            crearRelacion(){
                //valido con el metodo de validacion creado
                let me=this;
                axios.post('/ordenpedidocliente/store',{
                    'idProducto': this.idProducto,
                    'cantidad': this.cantidad,
                    'precioVenta': this.precioVenta,
                    'idOrdenPedido': this.identificador
                }).then(function (response) {
                me.cerrarModal('0');
                me.forceRerender();
                me.listarOrdenPedido(1,'','');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            mostrarProductos(id){
                this.listado=1;
                this.identificador=id;
            },
            mostrarDetalle(id){
                this.listado=2;
                this.identificador=id;
            },
            generarDetalle(id){
                this.identificador=id;
                let me=this;
                axios.post('/simulacion/estado',{
                    'id': this.identificador
                }).then(function (response) {
                me.cerrarModal('0');
                me.forceRerender();
                me.listarOrdenPedido(1,'','');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            ocultarDetalle(){
                this.listado=0;
            },
            cerrarModal(variable){
                this.modal=this.variable;
                this.tituloModal='';
                this.detalle='';
            },
            abrirModal(modelo, accion, identificador){
            //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
            switch(modelo){
                    case "ordendepedido":
                    {
                        switch (accion) {
                            case 'crear':{
                                this.modal=1;
                                this.tipoModal=1; //carga tipos de campos y footers
                                this.tituloModal='Crear nueva orden de pedido';
                                this.tipoAccion= 1; //carga tipos de botón en el footer
                                this.fecha= moment().format('YYYY-MM-DD');
                                break;
                            }
                        }
                        //this.selectGestionMateria();
                        break;
                    }

                    case "rela":
                    {
                        switch (accion) {
                            case 'crear':{
                                this.modal=1;
                                this.tipoModal=2; //carga tipos de campos y footers
                                this.tituloModal='Agregar productos';
                                this.tipoAccion= 1; //carga tipos de botón en el footer
                                break;
                            }
                        }
                        this.listarPosibles(this.identificador);
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
                                break;
                            }
                        }
                        this.generarDetalle(this.identificador);
                        break;
                    }

                }
            }
        },
        mounted() {
            this.listarOrdenPedido(1,this.buscar,this.criterio);
            this.listarClientes();
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
