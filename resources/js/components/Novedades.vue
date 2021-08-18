<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Novedades</li>
                </ol>

                <template v-if="listado==0">
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                       <div class="card-header">
                            <i class="fa fa-align-justify"></i> Novedades
                        </div>

                        <div class="card-body">

                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Fecha novedad</th>
                                        <th>Concepto</th>
                                        <th>Observación</th>
                                        <th>Cantidad</th>
                                        <th>Valor</th>
                                        <th>Empleado</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="novedad in arrayNovedades" :key="novedad.id">
                                        <td v-text="novedad.fechaNovedad"></td>

                                        <td v-if="novedad.concepto==1">Ingreso por labor</td>
                                        <td v-if="novedad.concepto==2">Horas extras y recargos</td>
                                        <td v-if="novedad.concepto==3">Prima extralegal</td>
                                        <td v-if="novedad.concepto==4">Bonificaciones</td>
                                        <td v-if="novedad.concepto==5">Comisiones</td>
                                        <td v-if="novedad.concepto==6">Viaticos</td>
                                        <td v-if="novedad.concepto==7">Conceptos que no son factor salarial</td>
                                        <td v-if="novedad.concepto==51">Sindicato</td>
                                        <td v-if="novedad.concepto==52">Préstamos</td>
                                        <td v-if="novedad.concepto==53">Embargos</td>
                                        <td v-if="novedad.concepto==54">Descuento por libranza/otros</td>

                                        <td v-text="novedad.observacion"></td>
                                        <td v-text="novedad.cantidad"></td>
                                        <td v-text="novedad.valor"></td>
                                        <td v-text="novedad.empleado"></td>
                                        <!--
                                        <td v-text="novedad.tipologia"></td>
                                        <td v-text="novedad.idEmpleado"></td>
                                        <td v-text="novedad.idNomina"></td>
                                        -->
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
                </template>
        </main>
</template>

<script>
import moment from 'moment';
    export default {
        props: {
            identificadorEmpleado: {
            type: Number
            },
            identificadorNomina: {
            type: Number
            }
         },
        data(){
            return{
                id:'',
                tipologiasalario:0,
                observacion:'',
                identificador:'',
                idEmpleado:0,
                idExtra:0,
                extras:0,
                cantidad:1,
                unitario:0,
                valor:0,
                fecha : '',
                flag : 0,
                concepto : 0,
                valor: 0,
                arrayNovedades : [],
                mensajecantidad:'',
                modal : 0,
                desplegable : 0,
                listado : 0,
                tituloModal : '',
                variable : '',
                hoy : '',
                tipologia : 0,
                tipoModal : 0,
                tipoAccion : 0,
                errorNovedad : 0,
                extraDiurna: 0,
                extraNocturna: 0,
                horaDominical: 0,
                festivaDiurna: 0,
                festivaNocturna: 0,
                recargos: 0,
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
                componentKey:0
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
            onChange(event) {
            //console.log(event.target.value);
            this.flag=event.target.value;
            console.log('Valor flag:');
            console.log(this.flag);
            },
            listarNovedades(idEmpleado,idNomina){
                let me=this;
                var url='/novedades/detallado?idEmpleado=' + idEmpleado + '&idNomina=' + idNomina;
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayNovedades=respuesta.novedades.data;
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
                me.listarNovedades(page,buscar,criterio);
            },
            indexChange: function(args) {
                let newIndex = args.value
                console.log('Current tab index: ' + newIndex)
                },
            forceRerender() {
                this.componentKey += 1;
               },
            mostrarDetalle(id){
                this.listado=2;
                this.identificador=id;
            },
            ocultarDetalle(){
                this.listado=0;
            },
        mounted() {
            this.listarNovedades(1,'','fechaNovedad');
        }
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
    .carga{
        background-color: #3c29297a !important;
        width: 100% !important;
        height: 100% !important;
        text-align: center;
        color: #ffffffff;
    }
</style>
