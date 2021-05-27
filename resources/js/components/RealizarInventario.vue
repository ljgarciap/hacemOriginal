<template>
    <main class="minimo">
        <template v-if="listado==0">
        <!-- Ejemplo de tabla Listado -->
        <div>
                            <div class="table-responsive">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Unidad Base</th>
                                        <th>Cantidad Actual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr v-for="total in arrayProductos" :key="total.id">
                                        <td>{{total.producto}}</td>
                                        <td>{{total.unidadBase}}</td>
                                        <td><input type="number" v-model="cantidad[total.id]" class="form-control" placeholder="Cantidad"></td>
                                </tr>
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-primary" @click="validar(cantidad)">Validar</button>
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
                cantidad: [],
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
                var url='/inventariodetalle/listar?page=' + page + '&id='+identificador;
                console.log(url);
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayProductos=respuesta.productos.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
        validar(cantidad){
                //valido con el metodo de validacion creado
                let me=this;
                console.log('idGestionMateria antes de solicitud');
                cantidad[0]=this.identificador;
                console.log(cantidad,this.identificador);
                console.log('Fin Cargue antes de solicitud');
                axios.post('/inventariodetalle/verificar',{
                    data: cantidad,
                    'id': this.identificador
                }).then(function (response) {
                var respuesta=response.data;
                console.log('Respuesta');
                console.log(respuesta);
                me.$emit('cambiarlistado', { message: '2' });
                me.cerrarModal('0');
                })
                .catch(function (error) {
                    console.log(error);
                });
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
