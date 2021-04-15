<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Kardex Producto Terminado</li>
                </ol>
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Kardex Producto Terminado &nbsp;
                            <button type="button" @click="abrirModal('kardex','crear')" class="btn btn-secondary">
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-9">
                                    <div class="input-group">
                                       <select class="form-control col-md-3" v-model="criterio">
                                        <option value="detalle">Acciones</option>
                                        <option value="fecha">Fecha</option>
                                        <option value="producto">Producto</option>
                                        <option value="cantidad">Cantidad Existente</option>
                                        <option value="precio">Precio promedio</option>
                                        <option value="precioSaldos">Saldos</option>
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
                                        <th>Fecha</th>
                                        <th>Producto</th>
                                        <th>Cantidad existente</th>
                                        <th>Precio promedio</th>
                                        <th>Saldos</th>
                                        <th>Tipologia</th>
                                    </tr>
                                </thead>
                                <tbody>
                                       <tr v-for="kardex in arrayKardexes" :key="kardex.id">
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" @click="mostrarKardex(kardex.id)">
                                                <i class="icon-eye"></i><span> Ver kárdex</span>
                                            </button>
                                        </td>
                                        <td v-text="kardex.fecha"></td>
                                        <td v-text="kardex.producto"></td>
                                        <td v-text="kardex.cantidadSaldos"></td>
                                        <td v-text="kardex.precioSaldos"></td>
                                        <td v-text="kardex.saldos"></td>
                                       <td>
                                            <div v-if="kardex.tipologia=='1'">
                                            <span class="badge badge-success">Ingreso</span>
                                            </div>
                                            <div v-else>
                                            <span class="badge badge-danger">Salida</span>
                                            </div>
                                        </td>
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
                <!--Inicio del modal agregar/actualizar-->
                <div class="modal fade" tabindex="-1" :class="{'mostrar':modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-primary modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" v-text="tituloModal"></h4>
                                <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                                <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                               <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

                                    <div v-if="tipoModal==1" class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Detalle</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="detalle" class="form-control" placeholder="Detalle">
                                            <span class="help-block">(*) Ingrese el detalle del Kardex</span>
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
                                    <div v-if="tipoModal==1" class="form-group row">
                                        <label class="col-md-3 form-control-label" for="email-input">Producto</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="idProducto">
                                                <option value="0" disabled>Seleccione un producto</option>
                                                <option v-for="producto in arrayProductos" :key="producto.idProducto" :value="producto.idProducto" v-text="producto.producto"></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div v-if="tipoModal==1" class="form-group row">
                                        <label class="col-md-3 form-control-label" for="email-input">Tipologia</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="tipologia">
                                                <option value="0" disabled>Seleccione una Tipologia</option>
                                                <option>Ingreso</option>
                                                <option>Salida</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div v-if="tipoModal==1" class="form-group row div-error" v-show="errorKardex">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMensaje" :key="error" v-text="error"></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
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
    export default {
        data(){
            return{
                idKardex:0,
                id:'',
                fecha: 0,
                detalle:'',
                cantidad:'',
                precio:'',
                precioSaldos: 0,
                cantidadSaldos:'',
                tipologia:'1',
                arrayKardexes : [],
                idProducto: 0,
                producto : '',
                arrayProductos: [],
                modal : 0,
                listado : 0,
                tituloModal : '',
                variable : '',
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
                criterio : 'fecha',
                buscar : ''
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
            listarKardex(page,buscar,criterio){
                let me=this;
                var url='/kardexproducto?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayKardexes=respuesta.kardex.data;
                me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                })
            },
             selectProducto(){
                let me=this;
                var url='/producto/selectProducto';
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayProductos=respuesta.productos;
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
                me.listarKardex(page,buscar,criterio);
            },
            crearKardex(){
                //valido con el metodo de validacion creado
                if(this.validarKardex()){
                    return;
                }
               let me=this;
                this.fecha= moment().format('YYYY-MM-DD');
                axios.post('/kardexproducto/store',{
                    'detalle':this.detalle,
                    'fecha': this.fecha,
                    'cantidad':this.cantidad,
                    'precio':this.precio,
                    'idProducto':this.idProducto,
                    'tipologia':this.tipologia
                }).then(function (response) {
                me.cerrarModal();
                me.listarKardex(1,'','kardex');
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
                if (this.errorMensaje.length) this.errorKardex=1;

                return this.errorKardex;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.kardex='';
            },
            abrirModal(modelo, accion, data=[]){
            //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
            switch(modelo){
                case "kardex":
                {
                    switch (accion) {
                        case 'crear':{
                            this.modal=1;
                            this.tipoModal=1; //carga tipos de campos y footers
                            this.kardex='';
                            this.idProducto=data['idProducto'];
                            this.tituloModal='Crear nuevo kardex de producto terminado';
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
            this.listarKardex(1,this.buscar,this.criterio);
            this.selectProducto();
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
