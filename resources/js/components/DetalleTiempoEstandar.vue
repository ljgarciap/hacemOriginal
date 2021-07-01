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
                                        <th>Empleado</th>
                                        <th>Proceso</th>
                                        <th>Rol</th>
                                        <th>Genero</th>
                                        <th>Tiempo Elemental</th>
                                        <th>Numero Piezas Toma Tiempos</th>
                                        <th>Piezas por Par</th>
                                        <th>Tiempo en Minutos por Par</th>
                                        <th>Factor Valoración</th>
                                        <th>Tiempo Normal</th>
                                        <th>Factor Pds</th>
                                        <th>Tiempo Estandar en Min</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="total in arrayTiempos" :key="total.id">
                                        <td>{{total.idEmpleado}}</td>
                                        <td>{{total.proceso}}</td>
                                        <td>{{total.perfil}}</td>
                                       <div v-if="total.genero==1">
                                            <td>Masculino</td>
                                            </div>
                                            <div v-else>
                                            <td>Femenino</td>
                                            </div>
                                        <td>{{total.tiempoElemental}}</td>
                                        <td>{{total.numeroPiezas}}</td>
                                        <td>{{total.piezasPar}}</td>
                                        <td>{{total.tiempoPiezas}}</td>
                                        <td>{{total.factorValoracion}}</td>
                                        <td>{{total.tiempoNormal}}</td>
                                        <td>{{total.factorPds}}</td>
                                        <td>{{total.tiempoEstandar}}</td>
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
                arrayTiempos:[],
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
        listarDetalleTiempoEstandar(page,identificador){
                let me=this;
                var url='/tiempoestandardetalle/listardetalle?page=' + page + '&id='+identificador;
                console.log(url);
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayTiempos=respuesta.detalles.data;
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
                me.listarDetalleTiempoEstandar(page,this.identificador);
            }
        },
        mounted() {
            this.listarDetalleTiempoEstandar(1,this.identificador)
        }
    }
</script>

<style>
    .minimo {
	min-height: 150px;
    }
</style>

