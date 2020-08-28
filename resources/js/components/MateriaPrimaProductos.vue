<template>
        <main>

                    <!-- Ejemplo de tabla Listado -->
                            <div class="form-group row">
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <button type="button" @click="abrirModal('gestionMateria','crear')" class="btn btn-secondary">
                                        <i class="icon-plus"></i>&nbsp;Nueva materia prima
                                        </button>
                                        <select class="form-control col-md-3" v-model="criterio">
                                        <option value="gestionMateria">Materia Prima</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarMateriaPrimaProductos(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarMateriaPrimaProductos(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Producto</th>
                                        <th>Unidad</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="materiaprimaproducto in arrayMateriaPrimaProductos" :key="materiaprimaproducto.id">
                                        <td>
                                            <button type="button" @click="abrirModal('gestionMateria','actualizar',materiaprimaproducto)" class="btn btn-warning btn-sm">
                                            <i class="icon-pencil"></i>
                                            </button> &nbsp;

                                        <template v-if="materiaprimaproducto.estado">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarMateriaPrimaProducto(materiaprimaproducto.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-success btn-sm" @click="activarMateriaPrimaProducto(materiaprimaproducto.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                        </td>
                                        <td v-text="materiaprimaproducto.gestionMateria"></td>
                                        <td v-text="materiaprimaproducto.unidadBase"></td>
                                        <td v-text="materiaprimaproducto.cantidad"></td>
                                        <td v-text="materiaprimaproducto.precio"></td>
                                        <td v-text="materiaprimaproducto.subtotal"></td>
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
                    <!-- Fin ejemplo de tabla Listado -->

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
                                <!--
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Area</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="idArea">
                                                <option v-for="area in arrayArea" :key="area.idArea" :value="area.idArea" v-text="area.area"></option>
                                            </select>
                                        </div>
                                    </div>
                                -->
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Cantidad</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="cantidad" class="form-control" placeholder="Nombre de proceso">
                                            <span class="help-block">(*) Ingrese la cantidad de material</span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Precio</label>
                                        <div class="col-md-9">
                                            <input type="number" v-model="precio" class="form-control">
                                            <span class="help-block">(*) Ingrese el precio</span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Tipo de costo</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="tipoDeCosto">
                                                <option value="Directo">Costo Directo</option>
                                                <option value="Indirecto">Costo Indirecto</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row div-error" v-show="errorMateriaPrimaProducto">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMensaje" :key="error" v-text="error"></div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearMateriaPrimaProducto()">Guardar</button>
                                <button type="button" v-if="tipoAccion==2" class="btn btn-warning" @click="editarMateriaPrimaProducto()">Editar</button>
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
                idMateriaPrimaProducto:0,
                id:'',
                idMateriaPrima:'',
                cantidad:0,
                precio:0,
                tipoDeCosto:'Directo',
                arrayMateriaPrimaProductos: [],
                idArea:0,
                area:'',
                arrayArea:[],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
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
                criterio : 'gestionMateria',
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
            listarMateriaPrimaProducto(page,buscar,criterio){
                let me=this;
                var url='/materiaprimaproducto?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayProceso=respuesta.materiaprimaproductos.data;
                me.pagination=respuesta.pagination;
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
            selectMateriaPrimaProducto(){
                let me=this;
                var url='/materiaprimaproducto/selectMateriaPrimaProducto';
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayMateriaPrimaProductos=respuesta.materiaprimaproductos;
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
                me.listarProceso(page,buscar,criterio);
            },
            crearMateriaPrimaProducto(){
                //valido con el metodo de validacion creado
                if(this.validarProceso()){
                    return;
                }

                let me=this;
                axios.post('/materiaprimaproducto/store',{
                    'materiaprimaproducto': this.materiaprimaproducto,
                    'idArea': this.idArea
                }).then(function (response) {
                me.cerrarModal();
                me.listarMateriaPrimaProducto(1,'','gestionMateria');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            editarMateriaPrimaProducto(){
                if(this.validarMateriaPrimaProducto()){
                    return;
                }

                let me=this;
                axios.put('/materiaPrimaProducto/update',{
                    'id': this.idMateriaPrimaProducto,
                    'materiaPrimaProducto': this.materiaPrimaProducto,
                    'idArea': this.idArea
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarMateriaPrimaProducto(1,'','materiaprima');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            desactivarMateriaPrimaProducto(id){
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
                    axios.put('/materiaprimaproducto/deactivate',{
                        'id': id
                    }).then(function (response) {
                    me.listarMateriaPrimaProducto(1,'','gestionMateria');
                    swalWithBootstrapButtons.fire(
                    'Materia prima producto desactivado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarMateriaPrimaProducto();
                }
                })
            },
            activarMateriaPrimaProducto(id){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Quiere activar este proceso?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Activar!',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.put('/materiaprimaproducto/activate',{
                        'id': id
                    }).then(function (response) {
                    me.listarMateriaPrimaProductos(1,'','gestionMateria');
                    swalWithBootstrapButtons.fire(
                    'Proceso activado!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarMateriaPrimaProducto();
                }
                })
            },
            validarMateriaPrimaProducto(){
                this.errorMateriaPrimaProducto=0;
                this.errorMensaje=[];
                if (!this.materiaprimaproducto) this.errorMensaje.push("El nombre del proceso no puede estar vacio");
                if (this.errorMensaje.length) this.errorMateriaPrimaProducto=1;

                return this.errorMateriaPrimaProducto;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.materiaprimaproducto='';
            },
            abrirModal(modelo, accion, data=[]){
            //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
            switch(modelo){
                case "gestionMateria":
                {
                    switch (accion) {
                        case 'crear':{
                            this.modal=1;
                            this.materiaprimaproducto='';
                            this.idArea=data['idArea'];
                            this.tituloModal='Crear nuevo proceso';
                            this.tipoAccion= 1;
                            this.idArea=1;
                            break;
                        }
                        case 'actualizar':{
                            //console.log(data);
                            this.modal=1;
                            this.tituloModal='Editar proceso';
                            this.tipoAccion= 2;
                            this.idMateriaPrimaProducto=data['id'];
                            this.proceso=data['materiaprimaproducto'];
                            this.idArea=data['idArea'];
                            break;
                        }
                    }
              }

            }
            this.selectArea();
            }
        },
        mounted() {
            //this.listarMateriaPrimaProducto(1,this.buscar,this.criterio);
            this.selectMateriaPrimaProducto();
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
