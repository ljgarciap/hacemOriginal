<template>
        <!-- Ejemplo de tabla Listado -->
        <div>
            <div class="form-group row">
                <div class="col-md-9">
                    <div class="input-group">
                        <select class="form-control col-md-3" v-model="criterio">
                        <option value="maquinaria">Maquinaria</option>
                        </select>
                        <input type="text" v-model="buscar" @keyup.enter="listarMaquinaria(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                        <button type="submit" @click="listarMaquinaria(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                    </div>
                </div>
            </div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Maquinaria</th>
                                        <th>Valor</th>
                                        <th>Depreciacion mensual</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                     <tr v-for="maquinaria in arrayMaquinarias" :key="maquinaria.id">
                                        <td v-text="maquinaria.maquinaria"></td>
                                        <td v-text="maquinaria.valor"></td>
                                        <td v-text="maquinaria.depreciacionMensual"></td>
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
        data(){
            return{
                idMaquinaria:0,
                id:'',
                maquinaria:'',
                valor:'',
                tiempoDeVidaUtil:'',
                depreciacionAnual:'',
                depreciacionMensual:'',
                fecha:'',
                estado:'',
                arrayMaquinarias : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorMaquinaria : 0,
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
                criterio : 'maquinaria',
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
            listarMaquinaria(page,buscar,criterio){
                let me=this;
                var url='/maquinaria?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayMaquinarias=respuesta.maquinarias.data;
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
                me.listarMaquinaria(page,buscar,criterio);
            }
        },
        mounted() {
            this.listarMaquinaria(1,this.buscar,this.criterio);
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
