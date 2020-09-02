<template>
        <!-- Ejemplo de tabla Listado -->
        <div>
            <div class="form-group row">
                <div class="col-md-9">
                    <div class="input-group">
                        <select class="form-control col-md-3" v-model="criterio">
                              <option value="gestionMateria">Materia Prima</option>
                        </select>
                        <input type="text" v-model="buscar" @keyup.enter="listarMateriaPrimaProductos(1,buscar,criterio,this.identificador)" class="form-control" placeholder="Texto a buscar">
                          <button type="submit" @click="listarMateriaPrimaProductos(1,buscar,criterio,this.identificador)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                    </div>
                </div>
            </div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Materia prima</th>
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
        </div>
</template>

<script>
    export default {
        props: {
            identificador: {
            type: Number
            }
         },
        data(){
            return{
                idMateriaPrimaProducto:0,
                idMateriaPrima:'',
                cantidad:0,
                precio:0,
                tipoDeCosto:'Directo',
                arrayMateriaPrimaProductos : [],
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
                listarMateriaPrimaProducto(page,buscar,criterio,identificador){
                let me=this;
                var url='/materiaprimaproducto?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio + '&identificador=' + identificador;
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayMateriaPrimaProductos=respuesta.materiaprimaproductos.data;
                me.pagination=respuesta.pagination;
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
                me.listarMateriaPrimaProducto(page,buscar,criterio);
            },
            crearMateriaPrimaProducto(){
                //valido con el metodo de validacion creado
                if(this.validarMateriaPrimaProducto()){
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
            validarMateriaPrimaProducto(){
                this.errorMateriaPrimaProducto=0;
                this.errorMensaje=[];
                if (!this.materiaprimaproducto) this.errorMensaje.push("El nombre del proceso no puede estar vacio");
                if (this.errorMensaje.length) this.errorMateriaPrimaProducto=1;

                return this.errorMateriaPrimaProducto;
            },
        },
        mounted() {
            this.listarMateriaPrimaProducto(1,'','',this.identificador)
        }
    }
</script>
<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
        z-index: 2000;
    }
    .mostrar{
        display: list-item !important;
        height: 100% !important;
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
