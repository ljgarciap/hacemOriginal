<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Productos</li>
                </ol>
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">

                      <!-- Listado -->
                      <template v-if="listado">
                       <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-6">
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
                                            <button type="button" @click="mostrarDetalle()" class="btn btn-success btn-sm">
                                            <i class="icon-eye"></i>
                                            </button> &nbsp;
                                            <button type="button" class="btn btn-warning btn-sm">
                                            <i class="icon-magnifier"></i>
                                            </button> &nbsp;
                                        </td>
                                        <td v-text="producto.producto"></td>
                                        <td v-text="producto.referencia"></td>
                                        <td v-text="producto.foto"></td>
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
                      </template>
                    <!-- Fin Listado -->

                    <!-- Detalle -->
                    <template v-else>
                        <div class="card-body">
                            <vs-tabs :color="colorx">
                            <vs-tab label="Materia Prima" icon="shopping_cart" @click="colorx = '#8B0000'">
                                <materiaprima></materiaprima>
                            </vs-tab>
                            <vs-tab label="Mano de Obra" icon="work" @click="colorx = '#FFA500'">
                                <h2>Pestaña mano de obra asociada</h2>
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
                    </template>
                    <!-- Fin Detalle -->

                    </div>
                    <!-- Fin ejemplo de tabla Listado -->
                </div>
                <!--Inicio del modal agregar/actualizar-->

                <!--Fin del modal-->
        </main>
</template>

<script>
    export default {
        data(){
            return{
                colorx: '#8B0000',
                listado: 1,
                idProducto:0,
                id:'',
                producto:'',
                referencia:'',
                foto:'',
                descripcion:'',
                estado:'',
                arrayProducto : [],
                idColeccion:0,
                coleccion:'',
                referencia:'',
                arrayColeccion:[],
                idArea:0,
                area:'',
                arrayArea:[],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorProducto : 0,
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
            selectColeccion(){
                let me=this;
                var url='/coleccion/selectColeccion';
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayColeccion=respuesta.colecciones;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            selectArea(){
                let me=this;
                var url='/area/selectArea';
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayArea=respuesta.areas;
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
            crearProducto(){
                //valido con el metodo de validacion creado
                if(this.validarProducto()){
                    return;
                }

                let me=this;
                axios.post('/producto/store',{
                    'producto': this.producto,
                    'referencia': this.referencia,
                    'foto': this.foto,
                    'descripcion': this.descripcion,
                    'idColeccion': this.idColeccion,
                    'idArea': this.idArea
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarProducto(1,'','producto');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            editarProducto(){
                if(this.validarProducto()){
                    return;
                }

                let me=this;
                axios.put('/producto/update',{
                    'id': this.idProducto,
                    'producto': this.producto,
                    'referencia': this.referencia,
                    'foto': this.foto,
                    'descripcion': this.descripcion,
                    'idColeccion': this.idColeccion,
                    'idArea': this.idArea
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarProducto(1,'','producto');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            desactivarProducto(id){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Está seguro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Desactivar!',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.put('/producto/deactivate',{
                        'id': id
                    }).then(function (response) {
                    me.listarProducto(1,'','producto');
                    swalWithBootstrapButtons.fire(
                    'Producto desactivado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarProducto();
                }
                })
            },
            activarProducto(id){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Quiere activar este producto?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Activar!',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.put('/producto/activate',{
                        'id': id
                    }).then(function (response) {
                    me.listarProducto(1,'','producto');
                    swalWithBootstrapButtons.fire(
                    'Producto activado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarProducto();
                }
                })
            },
            validarProducto(){
                this.errorProducto=0;
                this.errorMensaje=[];

                if (!this.producto) this.errorMensaje.push("El nombre del producto no puede estar vacio");
                if (this.errorMensaje.length) this.errorProducto=1;

                return this.errorProducto;
            },
            mostrarDetalle(){
                this.listado=0;
            },
            ocultarDetalle(){
                this.listado=1;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.producto='';
            },
            abrirModal(modelo, accion, data=[]){
            //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
            switch(modelo){
                case "producto":
                {
                    switch (accion) {
                        case 'crear':{
                            this.modal=1;
                            this.producto='';
                            this.referencia='';
                            this.foto='';
                            this.descripcion='';
                            this.tituloModal='Crear nuevo producto';
                            this.tipoAccion= 1;
                            this.idColeccion= 1;
                            this.idArea= 1;
                            break;
                        }
                        case 'actualizar':{
                            //console.log(data);
                            this.modal=1;
                            this.tituloModal='Editar producto';
                            this.tipoAccion= 2;
                            this.idProducto=data['id'];
                            this.producto=data['producto'];
                            this.referencia=data['referencia'];
                            this.foto=data['foto'];
                            this.descripcion=data['descripcion'];
                            this.idColeccion=data['idColeccion']; // añadido para alimentar el select
                            this.idArea=data['idArea']; // añadido para alimentar el select
                            break;
                        }
                    }
              }

            }
            this.selectColeccion();
            this.selectArea();
            }
        },
        mounted() {
            this.listarProducto(1,this.buscar,this.criterio);
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
