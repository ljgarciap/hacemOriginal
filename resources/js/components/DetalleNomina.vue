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
                                     <a :href="url" type="button" @click="exportarExcel(identificador)"><img src="img/avatars/microsoft-excel.png" style="max-height:40px; max-width:40px; ">Exportar a excel</a>
                                 </p>
                            </div>
                            <div class="table-responsive">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>id</th>
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
                                        <button type="button" class="btn btn-info btn-sm" @click="mostrarDetallado(total)">
                                                <i class="icon-eye"></i><span> Detalle</span>
                                        </button>
                                        <button type="button" class="btn btn-success btn-sm" @click="mostrarNovedades(total)">
                                                <i class="icon-magnifier"></i><span> Novedades</span>
                                        </button>
                                        </td>
                                        <td>{{total.idEmpleado}}</td>
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

        <template v-if="listado==1">

                    <div class="container-fluid">
                        <div class="table-responsive">
                        <br>
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Documento</th>
                                        <th>Empleado</th>
                                        <th>Perfil</th>
                                        <th>Nivel Arl</th>
                                        <th>Fecha Vinculación</th>
                                        <th>Contrato</th>
                                        <th>Sueldo básico</th>
                                        <th>Dias labor</th>
                                        <th>Valor base</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="totalNomina in arrayDetallesNomina" :key="totalNomina.id">
                                        <td>{{totalNomina.documento}}</td>
                                        <td>{{totalNomina.nombreEmpleado}}</td>
                                        <td>{{totalNomina.perfil}}</td>
                                        <td>{{totalNomina.nivelArl}}</td>
                                        <td>{{totalNomina.fechaVinculacion}}</td>
                                        <td v-if="totalNomina.tipoContrato==1">Fijo</td>
                                        <td v-else-if="totalNomina.tipoContrato==2">Indefinido</td>
                                        <td v-else-if="totalNomina.tipoContrato==0">A destajo</td>
                                        <td>{{totalNomina.sueldoBasicoMensual}}</td>
                                        <td>{{totalNomina.diasLaborados}}</td>
                                        <td>{{totalNomina.valorDiasLaborados}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        <br>
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Extras diurnas</th>
                                        <th>Valor diurnas</th>
                                        <th>Extras nocturnas</th>
                                        <th>Valor nocturnas</th>
                                        <th>Horas dominicales</th>
                                        <th>Valor dominicales</th>
                                        <th>Extras dominicales diurnas</th>
                                        <th>Valor dominicales diurnas</th>
                                        <th>Extras dominicales nocturnas</th>
                                        <th>Valor dominicales nocturnas</th>
                                        <th>Horas recargos</th>
                                        <th>Valor recargos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="totalNomina in arrayDetallesNomina" :key="totalNomina.id">
                                        <td>{{totalNomina.extrasDiurnas}}</td>
                                        <td>{{totalNomina.valorextrasDiurnas}}</td>
                                        <td>{{totalNomina.extrasNocturnas}}</td>
                                        <td>{{totalNomina.valorextrasNocturnas}}</td>
                                        <td>{{totalNomina.horasDominicales}}</td>
                                        <td>{{totalNomina.valorhorasDominicales}}</td>
                                        <td>{{totalNomina.extrasDominicalesDiurnas}}</td>
                                        <td>{{totalNomina.valorextrasDominicalesDiurnas}}</td>
                                        <td>{{totalNomina.extrasDominicalesNocturnas}}</td>
                                        <td>{{totalNomina.valorextrasDominicalesNocturnas}}</td>
                                        <td>{{totalNomina.recargos}}</td>
                                        <td>{{totalNomina.valorrecargos}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        <br>
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Total extras</th>
                                        <th>Total recargos</th>
                                        <th>Total extras y recargos</th>
                                        <th>Prima extralegal</th>
                                        <th>Bonificaciones</th>
                                        <th>Comisiones</th>
                                        <th>Viaticos</th>
                                        <th>No factor salarial</th>
                                        <th>Devengado sin auxilio</th>
                                        <th>Auxilio</th>
                                        <th>Devengado con auxilio</th>
                                        <th>IBC salario</th>
                                        <th>IBC con tope</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="totalNomina in arrayDetallesNomina" :key="totalNomina.id">
                                        <td>{{totalNomina.totalhorasExtras}}</td>
                                        <td>{{totalNomina.totalrecargos}}</td>
                                        <td>{{totalNomina.totalExtrasyRecargos}}</td>
                                        <td>{{totalNomina.primaExtralegal}}</td>
                                        <td>{{totalNomina.bonificaciones}}</td>
                                        <td>{{totalNomina.comisiones}}</td>
                                        <td>{{totalNomina.viaticos}}</td>
                                        <td>{{totalNomina.noFactorSalarial}}</td>
                                        <td>{{totalNomina.devengadoSinAuxilio}}</td>
                                        <td>{{totalNomina.auxilio}}</td>
                                        <td>{{totalNomina.devengadoConAuxilio}}</td>
                                        <td>{{totalNomina.ibcSalario}}</td>
                                        <td>{{totalNomina.ibcConTope}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        <br>
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Fondo solidaridad</th>
                                        <th>Retención</th>
                                        <th>Sindicato</th>
                                        <th>Prestamos</th>
                                        <th>Otros</th>
                                        <th>Descuento salud</th>
                                        <th>Descuento pensión</th>
                                        <th>Total deducido</th>
                                        <th>Total a pagar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="totalNomina in arrayDetallesNomina" :key="totalNomina.id">
                                        <td>{{totalNomina.fondoSolidaridad}}</td>
                                        <td>{{totalNomina.retencion}}</td>
                                        <td>{{totalNomina.sindicato}}</td>
                                        <td>{{totalNomina.prestamos}}</td>
                                        <td>{{totalNomina.otros}}</td>
                                        <td>{{totalNomina.descuentoSalud}}</td>
                                        <td>{{totalNomina.descuentoPension}}</td>
                                        <td>{{totalNomina.totalDeducido}}</td>
                                        <td>{{totalNomina.totalPagar}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        <br>
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Aporte salud</th>
                                        <th>Aporte pensión</th>
                                        <th>Aporte ARL</th>
                                        <th>Aporte SENA</th>
                                        <th>Aporte ICBF</th>
                                        <th>Aporte caja compensación</th>
                                        <th>Cesantias</th>
                                        <th>Intereses cesantías</th>
                                        <th>Prima de servicios</th>
                                        <th>Vacaciones</th>
                                        <th>Costo Total Mensual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="totalNomina in arrayDetallesNomina" :key="totalNomina.id">
                                        <td>{{totalNomina.aporteSalud}}</td>
                                        <td>{{totalNomina.aportePension}}</td>
                                        <td>{{totalNomina.aporteArl}}</td>
                                        <td>{{totalNomina.aporteSena}}</td>
                                        <td>{{totalNomina.aporteIcbf}}</td>
                                        <td>{{totalNomina.aporteCaja}}</td>
                                        <td>{{totalNomina.cesantias}}</td>
                                        <td>{{totalNomina.interesesCesantias}}</td>
                                        <td>{{totalNomina.primaServicios}}</td>
                                        <td>{{totalNomina.vacaciones}}</td>
                                        <td>{{totalNomina.costoTotalMensual}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

            <p align="right">
                <button class="btn btn-secondary" @click="ocultarDetalle()" aria-label="Close">Regresar</button>
            </p>

        </template>

        <template v-if="listado==2">

                    <div class="container-fluid">
                            <div class="table-responsive">
                            <br>
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
                                        <td v-if="novedad.concepto==50">Retención</td>
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

                    </div>

            <p align="right">
                <button class="btn btn-secondary" @click="ocultarDetalle()" aria-label="Close">Regresar</button>
            </p>

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
                arrayNovedades:[],
                modal : 0,
                idEmpleado : 0,
                tipoModal : 0,
                tipoAccion : 0,
                url:'',
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
            },
        mostrarDetallado(data=[]){
            let me=this;
            this.listado=1;
            this.idEmpleado=data['idEmpleado'];
            /**/
            var url='/nomina/detalles?idEmpleado=' + this.idEmpleado + '&idNomina='+ this.identificador;
                console.log(url);
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                console.log('Respuesta');
                console.log(respuesta);
                me.arrayDetallesNomina=respuesta.detalles;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
        mostrarNovedades(data=[]){
            let me=this;
            this.listado=2;
            this.idEmpleado=data['idEmpleado'];
            /**/
                var url='/novedades/detallado?idEmpleado=' + this.idEmpleado + '&idNomina='+ this.identificador;
                console.log(url);
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                console.log('Respuesta2');
                console.log(respuesta);
                me.arrayNovedades=respuesta.novedades;
                    //console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            exportarExcel(identificador){
            this.url="/nomina/exportar/"+ this.identificador;
            },
        ocultarDetalle(){
                this.listado=0;
            }
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
