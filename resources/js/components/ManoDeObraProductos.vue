<template>
        <main class="main">
                <!-- Breadcrumb -->
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Mano De Obra Producto
                            <button type="button" @click="abrirModal('manodeobraproducto','crear')" class="btn btn-secondary">
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                        <option value="perfil">Perfil</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarManoDeObraProducto(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarManoDeObraProducto(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Perfil</th>
                                        <th>Tiempo</th>
                                        <th>Precio</th>
                                        <th>Hoja De Costo</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="manodeobraproducto in arraymanodeobraproducto" :key="manodeobraproducto.id">
                                        <td>
                                            <button type="button" @click="abrirModal('manodeobraproducto','actualizar',manodeobraproducto)" class="btn btn-warning btn-sm">
                                            <i class="icon-pencil"></i>
                                            </button> &nbsp;

                                        <template v-if="manodeobraproducto.estado">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarmanodeobraproducto(manodeobraproducto.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-success btn-sm" @click="activarProducto(manodeobraproducto.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>

                                        </td>
                                        <td v-text="manodeobraproducto.perfil"></td>
                                        <td v-text="manodeobraproducto.tiempo"></td>
                                        <td v-text="manodeobraproducto.precio"></td>
                                        <td v-text="manodeobraproducto.hoja"></td>
                                        <td>
                                            <div v-if="manodeobraproducto.estado">
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
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">perfil</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="idperfil">
                                                <option value="0" disabled> Seleccione perfil</option>
                                                <option v-for="perfil in arrayPerfil" :key="perfil.idperfil" :value="perfil.idperfil" v-text="perfil.perfil"></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="idPerfil" class="form-control" placeholder="Nombre de la mano de obra">
                                            <span class="help-block">(*) Ingrese el nombre de la mano de obra</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Tiempo</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="tiempo" class="form-control" placeholder="Numero del tiempo">
                                            <span class="help-block">(*) Ingrese el numero del tiempo</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Precio</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="precio" class="form-control" placeholder="Valor del precio">
                                            <span class="help-block">(*) Ingrese el valor del precio</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Hoja</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="idHoja" class="form-control" placeholder="Nombre de hoja de costo">
                                            <span class="help-block">(*) Ingrese el nombre de hoja de costo</span>
                                        </div>
                                    </div>
                                    <div class="form-group row div-error" v-show="errorManoDeObraProducto">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMensaje" :key="error" v-text="error"></div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearManoDeObraProducto()">Guardar</button>
                                <button type="button" v-if="tipoAccion==2" class="btn btn-warning" @click="editarManoDeObraProducto()">Editar</button>
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
                idManoDeObraProducto:0,
                id:'',
                tiempo:'',
                precio:'',
                estado:'',
                arrayManoDeObraProducto : [],
                idperfil:0,
                perfil:'',
                valorMinuto:'',
                arrayPerfil:[],
                idHoja:0,
                idProducto:'',
                arrayHoja:[],
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
                criterio : 'manodeobraproducto',
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
            listarManoDeObraProducto(page,buscar,criterio){
                let me=this;
                var url='/manodeobraproducto?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayManoDeObraProducto=respuesta.manodeobraproductos.data;
                me.pagination=respuesta.pagination;
                    //console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            selectManoDeObraProducto(){
                let me=this;
                var url='/manodeobraproducto/selectManoDeObraProducto';
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayPerfil=respuesta.perfiles;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            selectPerfil(){
                let me=this;
                var url='/perfil/selectPerfil';
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayPerfil=respuesta.perfiles;
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
                me.listarManoDeObraProducto(page,buscar,criterio);
            },
            crearManoDeObraProducto(){
                //valido con el metodo de validacion creado
                if(this.validarManoDeObraProducto()){
                    return;
                }

                let me=this;
                axios.post('/manodeobraproducto/store',{
                    'idPerfil': this.idPerfil,
                    'tiempo': this.tiempo,
                    'precio': this.precio,
                    'idHoja': this.idHoja
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarManoDeObraProducto(1,'','manodeobraproducto');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            editarManoDeObraProducto(){
                if(this.validarManoDeObraProducto()){
                    return;
                }

                let me=this;
                axios.put('/manodeobraproducto/update',{
                    'idPerfil': this.idPerfil,
                    'tiempo': this.tiempo,
                    'precio': this.precio,
                    'idHoja': this.idHoja
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarManoDeObraProducto(1,'','manodeobraproducto');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            desactivarManodeObraProducto(id){
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
                    axios.put('/manodeobraproducto/deactivate',{
                        'id': id
                    }).then(function (response) {
                    me.listarManoDeObraProducto(1,'','manodeobraproducto');
                    swalWithBootstrapButtons.fire(
                    'Mano de obra desactivado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarManoDeObraProducto();
                }
                })
            },
            activarManoDeObraProducto(id){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Quiere activar esta mano de obra?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Activar!',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.put('/manodeobraproducto/activate',{
                        'id': id
                    }).then(function (response) {
                    me.listarManoDeObraProducto(1,'','manodeobraproducto');
                    swalWithBootstrapButtons.fire(
                    'Mano  de obra activado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarManoDeObraProducto();
                }
                })
            },
            validarManoDeObraProducto(){
                this.errorManoDeObraProducto=0;
                this.errorMensaje=[];

                if (!this.producto) this.errorMensaje.push("El nombre de la mano de obra no puede estar vacio");
                if (this.errorMensaje.length) this.errorManoDeObraProducto=1;

                return this.errorManoDeObraProducto;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.producto='';
            },
            abrirModal(modelo, accion, data=[]){
            //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
            switch(modelo){
                case "manodeobraproducto":
                {
                    switch (accion) {
                        case 'crear':{
                            this.modal=1;
                            this.idPerfil='';
                            this.tiempo='';
                            this.precio='';
                            this.tituloModal='Crear nueva mano de obra';
                            this.tipoAccion= 1;
                            this.idHoja= 1;
                            break;
                        }
                        case 'actualizar':{
                            //console.log(data);
                            this.modal=1;
                            this.tituloModal='Editar producto';
                            this.tipoAccion= 2;
                            this.idManoDeObraProducto=data['id'];
                            this.idPerfil=data['idPerfil'];
                            this.tiempo=data['tiempo'];
                            this.precio=data['precio'];
                            this.idHoja=data['idHoja']; // añadido para alimentar el select
                            break;
                        }
                    }
              }

            }
            this.selectManoDeObraProducto();
            this.selectPerfil();
            }
        },
        mounted() {
            this.listarManoDeObraProducto(1,this.buscar,this.criterio);
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
