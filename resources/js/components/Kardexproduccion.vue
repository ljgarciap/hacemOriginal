<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Kardex de Produccion</li>
                </ol>

                <template v-if="listado==0">
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                       <div class="card-header">
                            <i class="fa fa-align-justify"></i> Kardex de Produccion
                            <button type="button" @click="abrirModal('kardex','crear')" class="btn btn-secondary">
                                <i class="icon-plus"></i>&nbsp;Nuevo Movimiento
                            </button>
                        </div>

                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                        <option value="producto">Producto</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarKardex(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarKardex(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Acciones</th>
                                        <th>Fecha final</th>
                                        <th>Producto</th>
                                        <th>Cantidad existente</th>
                                        <th>Precio promedio</th>
                                        <th>Saldos</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="producto in arrayProductos" :key="producto.id">
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" @click="mostrarDetalle(producto.idGestionMateria)">
                                                <i class="icon-eye"></i><span> Ver kárdex</span>
                                            </button>
                                        </td>
                                        <td v-text="producto.fecha"></td>
                                        <td v-text="producto.producto"></td>
                                        <td v-text="producto.cantidadSaldos"></td>
                                        <td v-text="producto.precioSaldos"></td>
                                        <td v-text="producto.saldos"></td>
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
                            <productoscotizacion v-bind:identificador="identificador" :key="componentKey"></productoscotizacion>
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
                            <detallekardexproduccion v-bind:identificador="identificador" :key="componentKey"></detallekardexproduccion>
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
                                        <label class="col-md-3 form-control-label" for="email-input">Movimiento</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="tipologia">
                                                <option value="0" disabled>Seleccione tipo de documento</option>
                                                <option value="1">Entrada de material</option>
                                                <option value="2">Salida de material</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div v-if="tipoModal==1" class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Consecutivo</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="detalle" class="form-control" placeholder="Consecutivo">
                                            <span class="help-block">(*) Ingrese el número del Movimiento</span>
                                        </div>
                                    </div>
                                    <div v-if="tipoModal==1" class="form-group row">
                                        <label class="col-md-3 form-control-label" for="email-input">Producto</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="idProducto">
                                                <option value="0" disabled>Seleccione una materia</option>
                                                <option v-for="materia in arrayMateriaPrima" :key="materia.idMateria" :value="materia.idMateria" v-text="materia.materia"></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div v-if="tipoModal==1" class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Cantidad</label>
                                        <div class="col-md-9">
                                            <input type="number" v-model="cantidad" class="form-control" placeholder="Cantidad">
                                            <span class="help-block">(*) Ingrese la Cantidad</span>
                                        </div>
                                    </div>
                                    <div v-if="tipoModal==1" class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Precio</label>
                                        <div class="col-md-9">
                                           <input type="number" v-model="precio" class="form-control" placeholder="Precio">
                                           <span class="help-block">(*) Ingrese el Precio</span>
                                        </div>
                                    </div>

                                    <div v-if="tipoModal==1" class="form-group row div-error" v-show="errorKardex">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMensaje" :key="error" v-text="error"></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div v-if="tipoModal==1" class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearKardex()">Guardar</button>
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
import detallekardexproduccion from '../components/DetalleKardexProduccion';

    export default {
        data(){
            return{
                idProducto:0,
                id:'',
                identificador:'',
                fecha : '',
                cantidadSaldos:'',
                precioSaldos:'',
                cantidad:'',
                detalle:'',
                precio:'',
                saldos:'',
                arrayProductos : [],
                arrayMateriaPrima : [],
                producto:'',
                modal : 0,
                listado : 0,
                tituloModal : '',
                variable : '',
                tipologia : 0,
                tipoModal : 0,
                tipoAccion : 0,
                errorKardex : 0,
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
            currentDateTime() {
                return moment().format('YYYY-MM-DD')
            },
            listarProductos(page,buscar,criterio){
                let me=this;
                var url='/kardexproduccion?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayProductos=respuesta.productos.data;
                me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                })
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;
                //envia peticion para ver los valores asociados a esa pagina
                me.listarkardex(page,buscar,criterio);
            },
            indexChange: function(args) {
                let newIndex = args.value
                console.log('Current tab index: ' + newIndex)
                },
            forceRerender() {
                this.componentKey += 1;
               },
            listarMaterias(){
                let me=this;
                var url='/kardexproducciongeneral';
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayMateriaPrima=respuesta.materias;
                console.log(url);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            crearKardex(){
                //valido con el metodo de validacion creado
                if(this.validarKardex()){
                    return;
                }
                let me=this;
                this.fecha= moment().format('YYYY-MM-DD');
                axios.post('/kardexproduccion/store',{
                    'detalle':this.detalle,
                    'fecha': this.fecha,
                    'cantidad':this.cantidad,
                    'precio':this.precio,
                    'tipologia':this.tipologia,
                    'idProducto':this.idProducto
                }).then(function (response) {
                me.cerrarModal('0');
                me.listarKardex(1,'','');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            mostrarDetalle(id){
                this.listado=2;
                this.identificador=id;
            },
            ocultarDetalle(){
                this.listado=0;
            },
            validarKardex(){
                this.errorProducto=0;
                this.errorKardex=0;
                this.errorMensaje=[];

                if (!this.detalle) this.errorMensaje.push("El Detalle no puede estar vacio");
                if (!this.cantidad) this.errorMensaje.push("La Cantidad no puede estar vacia");
                if (!this.precio) this.errorMensaje.push("El Precio no puede estar vacio");
                if (!this.idProducto) this.errorMensaje.push("El producto no puede estar vacio");
                if (this.errorMensaje.length) this.errorKardex=1;

                return this.errorKardex;
            },
            cerrarModal(variable){
                this.modal=this.variable;
                this.tituloModal='';
                this.detalle='';

                this.detalle='';
                this.cantidad='';
                this.precio='';
                this.tipologia='';
                this.tituloModal='';
                this.idProducto='';

                this.listarProductos(1,this.buscar,this.criterio);
            },
            abrirModal(modelo, accion, identificador){
            //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
            switch(modelo){
                    case "kardex":
                    {
                        switch (accion) {
                            case 'crear':{
                                this.modal=1;
                                this.tipoModal=1; //carga tipos de campos y footers
                                this.tituloModal='Crear nuevo kardex de produccion';
                                this.tipoAccion= 1; //carga tipos de botón en el footer
                                this.fecha= moment().format('YYYY-MM-DD');
                                this.listarMaterias();
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
            this.listarProductos(1,this.buscar,this.criterio);
            this.listarMaterias();
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

