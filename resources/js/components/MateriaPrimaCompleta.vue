<template>
        <!-- Ejemplo de tabla Listado -->
        <div>
            <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm">
                <thead>
                    <tr>
                        <th>Materia prima</th>
                        <th>Unidad de medida</th>
                        <th>Unidades a entregar</th>
                        <th>Unidades entregadas</th>
                        <th>Faltantes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="completo in arrayCompletos" :key="completo.id">
                        <td v-text="completo.producto"></td>
                        <td v-text="completo.unidadBase"></td>
                        <td v-text="completo.cantidadRequerida"></td>
                        <td v-text="completo.cantidadEntregada"></td>
                        <td v-text="completo.diferencia"></td>
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

<script>
    export default {
        props: {
            identificador: {
            type: Number
            }
         },
        data(){
            return{
                arrayCompletos : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3
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
            listarCompletosOrden(page,identificador){
                let me=this;
                var url='/ordenpedidocliente/listarcompletos?page=' + page + '&identificador=' + identificador;
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayCompletos=respuesta.productos.data;
                me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                console.log(url);
                })
            },
            cambiarPagina(page){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;
                //envia peticion para ver los valores asociados a esa pagina
                this.listarCompletosOrden(page,this.identificador);
            }
        },
        mounted() {
            this.listarCompletosOrden(1,this.identificador);
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
