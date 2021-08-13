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
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarDetalleNomina(1,buscar,criterio,identificador)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarDetalleNomina(1,buscar,criterio,identificador)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                                 <p align="right">
                                     <a href="/nomina/exportar"><img src="img/avatars/microsoft-excel.png" style="max-height:40px; max-width:40px; ">Exportar a excel</a>
                                 </p>
                            </div>
                            <div class="table-responsive">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Empleado</th>
                                        <th>Proceso</th>
                                        <th>Perfil</th>
                                        <th>Salario Basico Mensual</th>
                                        <th>Total de Ingreso</th>
                                        <th>Total deducido</th>
                                        <th>Total a pagar</th>
                                        <th>Costo Total Mensual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="total in arrayDetalles" :key="total.id">
                                        <td>
                                        <button type="button" class="btn btn-success btn-sm" @click="mostrarNovedades(total.idEmpleado,total.idNomina)">
                                                <i class="icon-magnifier"></i><span> Detalle</span>
                                        </button>
                                        </td>
                                        <td>{{total.nombreEmpleado}}</td>
                                        <td>{{total.proceso}}</td>
                                        <td>{{total.perfil}}</td>
                                        <td>{{total.sueldoBasicoMensual}}</td>
                                        <td>{{total.devengadoConAuxilio}}</td>
                                        <td>{{total.totalDeducido}}</td>
                                        <td>{{total.totalPagar}}</td>
                                        <td>{{total.costoTotalMensual}}</td>
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

                                <!-- Template para mostrar la carga de novedades -->
                <template v-if="listado==3">
                    <div class="container-fluid">
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Empleado</th>
                                        <th>Perfil</th>
                                        <th>Salario Basico Mensual</th>
                                        <th>Documento</th>
                                        <th>Riesgo Arl</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="valor in arrayDetallesNomina" :key="valor.id">
                                        <td>{{valor.nombreEmpleado}}</td>
                                        <td>{{valor.perfil}}</td>
                                        <td>{{valor.sueldoBasicoMensual}}</td>
                                        <td>{{valor.documento}}</td>
                                        <td>{{valor.nivelArl}}</td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>

                            <p align="right">
                                <button class="btn btn-danger" @click="ocultarNovedades()" aria-label="Close">Cerrar</button>
                            </p>
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
                arrayDetalles:[],
                arrayDetallesNomina:[],
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
        listarDetalleNomina(page,identificador){
                let me=this;
                var url='/nomina/listardetalle?page=' + page + '&id='+identificador;
                console.log(url);
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayDetalles=respuesta.detalles.data;
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
                me.listarDetalleNomina(page,this.identificador);
            }
        },
        mostrarNovedades(identificadorEmpleado,identificadorNomina){
            this.listado=3;

            var url='/nomina/detalles?idEmpleado=' + identificadorEmpleado + '&idNomina='+ identificadorNomina;
                console.log(url);
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayDetallesNomina=respuesta.detalles.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
        },
        ocultarNovedades(){
                this.listado=0;
        },
        mounted() {
            this.listarDetalleNomina(1,this.identificador)
        }
    }
</script>

<style>
    .minimo {
	min-height: 150px;
    }
</style>

