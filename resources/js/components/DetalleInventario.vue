<template>
    <main class="minimo">
        <template v-if="listado==0">
        <!-- Ejemplo de tabla Listado -->
        <div>
            <div class="form-group row">
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                        <option value="id">Id</option>
                                        <option value="idProducto">Producto</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarDetalleInventario(1,buscar,criterio,identificador)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarDetalleInventario(1,buscar,criterio,identificador)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Unidad Base</th>
                                        <th>Cantidad Sistema</th>
                                        <th>Cantidad Actual</th>
                                        <th>Diferencia</th>
                                        <th>Observación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="total in arrayProductos" :key="total.id">
                                        <td>{{total.producto}}</td>
                                        <td>{{total.unidadBase}}</td>
                                        <td>{{total.cantidadSistema}}</td>
                                        <td>{{total.cantidadActual}}</td>
                                        <td>{{total.diferencia}}</td>
                                        <td>{{total.observacion}}</td>
                                    </tr>
                                </tbody>
                            </table>
                            </form>
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
    </main>
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
                listado : 0,
                arrayProductos:[],
                modal : 0,
                tipoModal : 0,
                tipoAccion : 0,
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
        listarDetalleInventario(page,identificador){
                let me=this;
                var url='/inventariodetalle?page=' + page + '&id='+identificador;
                console.log(url);
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayProductos=respuesta.detalles;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
        cambiarPagina(page){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;
                //envia peticion para ver los valores asociados a esa pagina
                me.listarDetalleInventario(page,this.identificador);
            }
        },
        mounted() {
            this.listarDetalleInventario(1,this.identificador)
        }
    }
</script>

<style>
    .minimo {
	min-height: 150px;
    }
</style>

