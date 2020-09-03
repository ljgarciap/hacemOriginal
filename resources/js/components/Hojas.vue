<template>
        <main class="main">
            <div id="over" class="overbox">
                <a v-on:click="hideLightbox()"><p class="cierre"><b>Cerrar</b></p></a>
                <div id="content">
                    <center><img :src="fotoCarga" alt=""></center>
                </div>
            </div>
            <div id="fade" class="fadebox">&nbsp;</div>
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Productos</li>
                </ol>
                      <!-- Listado -->
                      <template v-if="listado">
                    <!-- Ejemplo de tabla Listado -->
                    <div class="container-fluid">
                        <div class="card">
                            <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                        <option value="producto">Producto</option>
                                        <option value="coleccion">Coleccion</option>
                                        <option value="area">Area</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarProducto(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarProducto(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Producto</th>
                                        <th>Referencia</th>
                                        <th>Foto</th>
                                        <th>Descripcion</th>
                                        <th>Coleccion</th>
                                        <th>Area</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="producto in arrayProducto" :key="producto.id">
                                        <td>
                                            <button type="button" @click="mostrarDetalle(producto.idHojaDeCosto,producto.producto)" class="btn btn-success btn-sm">
                                            <i class="icon-eye"></i>
                                            </button> &nbsp;
                                            <button type="button" class="btn btn-warning btn-sm">
                                            <i class="icon-magnifier"></i>
                                            </button> &nbsp;
                                        </td>
                                        <td v-text="producto.producto"></td>
                                        <td v-text="producto.referencia"></td>
                                        <td><a v-on:click="showLightbox(producto.foto)">Ver producto</a></td>
                                        <td v-text="producto.descripcion"></td>
                                        <td v-text="producto.coleccion"></td>
                                        <td v-text="producto.area"></td>
                                        <td>
                                            <div v-if="producto.estado">
                                            <span class="badge badge-success">Activo</span>
                                            </div>
                                            <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
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
                    </div>
                      </template>
                    <!-- Fin Listado -->

                    <!-- Detalle -->
                    <template v-else>
                        <div class="container-fluid">
                            <div class="card">
                                <vs-tabs :color="colorx">

                                <vs-tab label="Materia Prima" icon="shopping_cart" @click="colorx = '#8B0000'">

                                    <div class="card-header">
                                        <i class="fa fa-align-justify"></i> Producto: {{this.productoNombre}} &nbsp;
                                        <button type="button" @click="abrirModal('gestionMateria','crear')" class="btn btn-secondary">
                                            <i class="icon-plus"></i>&nbsp;Nueva materia prima
                                        </button>
                                    </div>

                                    <div class="card-body">
                                        <materiaprima v-bind:identificador="identificador"></materiaprima>
                                    </div>

                                </vs-tab>

                                <vs-tab label="Mano de Obra" icon="work" @click="colorx = '#FFA500'">

                                    <div class="card-header">
                                        <i class="fa fa-align-justify"></i> Producto: {{this.productoNombre}} &nbsp;
                                        <button type="button" @click="abrirModal('gestionManoDeObra','crear')" class="btn btn-secondary">
                                            <i class="icon-plus"></i>&nbsp;Nueva mano de obra
                                        </button>
                                    </div>

                                    <div class="card-body">
                                        <manodeobra v-bind:identificador="identificador"></manodeobra>
                                    </div>

                                </vs-tab>

                                <vs-tab label="CIF" icon="compare_arrows" @click="colorx = '#CB3234'">
                                    <h2>Pestaña cif asociados</h2>
                                </vs-tab>

                                <vs-tab label="Servicios Directos" icon="account_circle" @click="colorx = '#0000FF'">
                                    <h2>Pestaña servicios asociados</h2>
                                </vs-tab>

                                <vs-tab label="Cerrar" icon="cancel_schedule_send" @click="ocultarDetalle()">
                                </vs-tab>

                                </vs-tabs>
                            </div>
                        </div>
                    </template>
                    <!-- Fin Detalle -->
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
                                        <label class="col-md-3 form-control-label" for="text-input">Cantidad</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="cantidad" class="form-control" placeholder="Cantidad de material">
                                            <span class="help-block">(*) Ingrese la cantidad de material</span>
                                        </div>
                                    </div>

                                    <div v-if="tipoModal==1" class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Precio</label>
                                        <div class="col-md-9">
                                            <input type="number" v-model="precio" class="form-control">
                                            <span class="help-block">(*) Ingrese el precio</span>
                                        </div>
                                    </div>

                                    <div v-if="tipoModal==1" class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Tipo de costo</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="tipoDeCosto">
                                                <option value="Directo">Costo Directo</option>
                                                <option value="Indirecto">Costo Indirecto</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div v-if="tipoModal==1" class="form-group row div-error" v-show="errorMateriaPrimaProducto">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMensaje" :key="error" v-text="error"></div>
                                        </div>
                                    </div>

                                        <!--------------divs para modal tipo 2--------------------->

                                    <div v-if="tipoModal==2" class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Perfil</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="idPerfil">
                                                <option value="Directo">Costo Directo</option>
                                                <option value="Indirecto">Costo Indirecto</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div v-if="tipoModal==2" class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Tiempo</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="tiempo" class="form-control" placeholder="Tiempo de mano de obra">
                                            <span class="help-block">(*) Ingrese el tiempo de mano de obra</span>
                                        </div>
                                    </div>

                                    <div v-if="tipoModal==2" class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Precio</label>
                                        <div class="col-md-9">
                                            <input type="number" v-model="precio" class="form-control">
                                            <span class="help-block">(*) Ingrese el precio</span>
                                        </div>
                                    </div>

                                    <div v-if="tipoModal==2" class="form-group row div-error" v-show="errorMateriaPrimaProducto">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMensaje" :key="error" v-text="error"></div>
                                        </div>
                                    </div>

                                </form>
                            </div>

                                <!--------------------------divs para footer tipo 1 y 2--------------------------------->

                            <div v-if="tipoModal==1" class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearMateriaPrimaProducto()">Guardar</button>
                                <button type="button" v-if="tipoAccion==2" class="btn btn-warning" @click="editarMateriaPrimaProducto()">Editar</button>
                            </div>

                            <div v-if="tipoModal==2" class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearMateriaPrimaProducto()">Guardar</button>
                                <button type="button" v-if="tipoAccion==2" class="btn btn-warning" @click="editarMateriaPrimaProducto()">Editar</button>
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog tipo Modal 1 -->
                </div>
                <!--Fin del modal-->
        </main>
</template>

<script>
    import materiaprima from '../components/MateriaPrimaProductos';
    import manodeobra from '../components/ManoDeObraProductos';
    export default {
        components: {
            materiaprima,
            manodeobra
        },
        data(){
            return{
                colorx: '#8B0000',
                listado: 1,
                idHojaDeCosto:0,
                idProducto:0,
                id:'',
                producto:'',
                referencia:'',
                foto:'',
                descripcion:'',
                estado:'',
                idColeccion:0,
                coleccion:'',
                referencia:'',
                idArea:0,
                area:'',
                arrayProducto : [],
                cantidad:0,
                precio:0,
                tipoDeCosto:'Directo',
                modal : 0,
                tituloModal : '',
                tipoModal : 0,
                tipoAccion : 0,
                fotoCarga:'',
                errorMateriaPrimaProducto : 0,
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
                identificador: 0,
                productoNombre:'',
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
              indexChange: function(args) {
                let newIndex = args.value
                console.log('Current tab index: ' + newIndex)
                },
            listarProducto(page,buscar,criterio){
                let me=this;
                var url='/producto?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayProducto=respuesta.productos.data;
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
                me.listarProducto(page,buscar,criterio);
            },
            mostrarDetalle(id,producto){
                this.listado=0;
                this.identificador=id;
                this.productoNombre=producto;
            },
            ocultarDetalle(){
                this.listado=1;
                this.identificador=0;
                this.productoNombre='';
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.materiaprimaproducto='';
                this.manodeobraproducto='';
                this.tipoModal=0;
            },
            abrirModal(modelo, accion, data=[]){
            //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
            switch(modelo){

                case "gestionMateria":
                {
                    switch (accion) {
                        case 'crear':{
                            this.modal=1;
                            this.tipoModal=1; //carga tupos de campos y footers
                            this.materiaprimaproducto='';
                            this.idMateriaPrima=data['idMateriaPrima'];
                            this.cantidad=data['cantidad'];
                            this.precio=data['precio'];
                            this.idHoja=this.identificador;
                            this.tituloModal='Asignar nueva materia';
                            this.tipoAccion= 1; //carga tipos de botón en el footer
                            break;
                        }
                        case 'actualizar':{
                            //console.log(data);
                            this.modal=1;
                            this.tipoModal=1;
                            this.idMateriaPrima=data['id'];
                            this.cantidad=data['cantidad'];
                            this.precio=data['precio'];
                            this.tipoDeCosto=data['tipoDeCosto'];
                            this.idHoja=this.identificador;
                            this.tituloModal='Editar materia prima';
                            this.tipoAccion= 2;
                            break;
                        }
                    }
                    break;
                }

                case "gestionManoDeObra":
                {
                    switch (accion) {
                        case 'crear':{
                            this.modal=1;
                            this.tipoModal=2;
                            this.manodeobraproducto='';
                            this.idPerfil=data['idPerfil'];
                            this.tiempo=data['tiempo'];
                            this.precio=data['precio'];
                            this.idHoja=this.identificador;
                            this.tituloModal='Asignar nueva mano de obra';
                            this.tipoAccion= 1;
                            break;
                        }
                        case 'actualizar':{
                            //console.log(data);
                            this.modal=1;
                            this.tipoModal=2;
                            this.idManoDeObraProducto=data['id'];
                            this.idPerfil=data['idPerfil'];
                            this.tiempo=data['tiempo'];
                            this.precio=data['precio'];
                            this.idHoja=this.identificador;
                            this.tituloModal='Editar mano de obra';
                            this.tipoAccion= 2;
                            break;
                        }
                    }
                    break;
                }

            }
            this.selectArea();
            },
            //funciones para uso del lightbox
            showLightbox(fotoCarga) {
                this.fotoCarga=fotoCarga;
                document.getElementById('over').style.display='block';
                document.getElementById('fade').style.display='block';
            },
            hideLightbox() {
                this.fotoCarga='';
                document.getElementById('over').style.display='none';
                document.getElementById('fade').style.display='none';
            },
            //cierre de funciones para uso del lightbox
        },
        mounted() {
            this.listarProducto(1,this.buscar,this.criterio)
        }
    }
</script>
<style>
    .fadebox {
	display: none;
	position: absolute;
	top: 0%;
	left: 0%;
	width: 100%;
	height: 100%;
	background-color: black;
	z-index:3001;
	-moz-opacity: 0.8;
	opacity:.80;
	filter: alpha(opacity=80);
    }
    .overbox {
        display: none;
        position: absolute;
        top: 5%;
        left: 5%;
        width: 90%;
        height: 90%;
        z-index:3002;
        overflow: auto;
    }
    #content {
        background: #FFFFFF;
        border: solid 3px #CCCCCC;
        padding: 10px;
    }
    .cierre {
        font-weight: 9rem;
        color:#FFFFFF;
    }
</style>
