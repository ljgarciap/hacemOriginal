<template>
    <main>
        <template v-if="listado==0">
        <!-- Ejemplo de tabla Listado -->
        <div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Referencia</th>
                                        <th>Unidades</th>
                                        <th>Tiempo (h)</th>
                                        <th>Tiempo total (h)</th>
                                        <th>Cif total</th>
                                        <th>Cif unitario</th>
                                        <th>Costo unitario</th>
                                        <th>Detalle</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="total in arrayProductos" :key="total.id">
                                        <td>{{total.producto}}</td>
                                        <td>{{total.referencia}}</td>
                                        <td>{{total.unidades}}</td>
                                        <td>{{total.tiempo | redondeodec}}</td>
                                        <td>{{total.tiempo*total.unidades | redondeo}}</td>
                                        <td>{{total.tiempo*total.unidades*valorbase | redondeo}}</td>
                                        <td>{{total.tiempo*valorbase | redondeo}}</td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-sm" @click="abrirModal(total)">
                                                <i class="icon-magnifier"></i><span> Ver</span>
                                            </button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" @click="mostrarDetalle(total)">
                                                <i class="icon-plus"></i><span> Mostrar</span>
                                            </button>
                                        </td>
                                        <!-- <td>{{total.acumuladototal | currency}}</td> -->
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                    <!-- Fin ejemplo de tabla Listado -->
        </div>
                <!--Inicio del modal agregar/actualizar-->
                <div class="modal fade" tabindex="-1" :class="{'mostrar':modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-primary modal-lg" role="document">
                        <div class="modal-content">
                                <div class="modal-body">
                                    <div v-if="tipoModal==1" class="form-group row">
                                        <div class="table-responsive col-md-12">
                                            <table class="table table-bordered table-striped table-sm">
                                                <thead>
                                                    <tr>
                                                        <!--<th>Foto</th>-->
                                                        <!--<th>Minutos</th>-->
                                                        <th>Unidades</th>
                                                        <th>Materia directa</th>
                                                        <th>Materia indirecta</th>
                                                        <th>Mano de obra</th>
                                                        <th>Cif unitarios</th>
                                                        <!--<th>Total Maquinaria</th>-->
                                                        <th><b>COSTO TOTAL</b></th>
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="totalc in arrayTotales" :key="totalc.id">
                                                        <!--<td v-text="total.foto"></td>-->
                                                        <!--<td v-text="total.acumuladotiempomo"></td>-->
                                                        <td>{{totalc.estimadoproduccion}}</td>
                                                        <td>{{totalc.acumuladomd | currency}}</td>
                                                        <td>{{totalc.acumuladomi | currency}}</td>
                                                        <td>{{totalc.acumuladomo | currency}}</td>
                                                        <td>{{totalc.cifunitario | currency}}</td>
                                                        <td>{{totalc.acumuladototal | currency}}</td>
                                                        <td><button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!--Fin del modal-->
        </template>

        <template v-if="listado==1">
            <div class="row">

                <div class="table-responsive col-md-4">
                    <h2>MATERIA PRIMA</h2>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Detalle</th>
                                <th>Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="materiaprima in arrayMateriaPrima" :key="materiaprima.id">
                                <td>{{materiaprima.gestionMateria}}</td>
                                <td>{{materiaprima.subtotal | currency}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="table-responsive col-md-4">
                    <h2>MANO DE OBRA</h2>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Detalle</th>
                                <th>Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="manodeobra in arrayManoDeObra" :key="manodeobra.id">
                                <td>{{manodeobra.proceso}}</td>
                                <td>{{manodeobra.subtotal | currency}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="table-responsive col-md-4">
                    <h2>COSTOS INDIRECTOS</h2>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Detalle</th>
                                <th>Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Depreciación</td>
                                <td>{{depreciacion | currency}}</td>
                            </tr>
                            <tr v-for="concepto in arrayConceptos" :key="concepto.id">
                                <td>{{concepto.concepto}}</td>
                                <td>{{concepto.valor | currency}}</td>
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
                producto:'',
                referencia:'',
                unidades:'',
                tiempo:'',
                produccion:'',
                acumuladocifto:'',
                acumuladocalculo:'',
                valorbase:'',
                arrayProductos:[],
                idProducto:'',
                total:'',
                acumuladomd:0,
                acumuladomi:0,
                acumuladomo:0,
                acumuladocif:0,
                acumuladomaquinaria:0,
                acumuladocift:0,
                acumuladototal:0,
                arrayTotales:[],
                arrayMateriaPrima:[],
                arrayManoDeObra:[],
                arrayConceptos:[],
                depreciacion:0,
                modal : 0,
                tipoModal : 0
            }
        },
        methods : {
            acumuladoTotal(identificador){
                let me=this;
                var url='/hojadecosto/ciftiempos/'+this.identificador;
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayProductos=respuesta.productos;
                me.produccion=respuesta.produccion;
                me.acumuladocifto=respuesta.acumuladocift;
                me.acumuladocalculo=respuesta.acumuladocalculo;
                me.valorbase=respuesta.valorbase;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            costeoUnidad(idProducto,identificador){
                let me=this;
                var url='/hojadecosto/unitario?identificador=' + this.idProducto + '&simulacion=' + this.identificador;
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayTotales=respuesta.totales;
                //console.log(url);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            costeoDetalle(idProducto,identificador){
                let me=this;
                var url='/hojadecosto/detalle?identificador=' + this.idProducto + '&simulacion=' + this.identificador;
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayMateriaPrima=respuesta.materiaprimaproductos;
                me.arrayManoDeObra=respuesta.manodeobraproductos;
                me.arrayConceptos=respuesta.conceptos;
                me.depreciacion=respuesta.acumuladomaquinaria;
                //console.log(url);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            abrirModal(data=[]){
            //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
                this.modal=1;
                this.tipoModal=1;
                this.idProducto=data['idProducto'];
                this.costeoUnidad(this.idProducto);
                //console.log(this.idProducto);
            },
            cerrarModal(){
                this.modal=0;
            },
            mostrarDetalle(data=[]){
                this.listado=1;
                this.identificador=this.identificador;
                this.idProducto=data['idProducto'];
                this.costeoDetalle(this.idProducto,this.identificador);
                //console.log(this.identificador);
            },
            ocultarDetalle(){
                this.listado=0;
            },
        },
        mounted() {
            this.acumuladoTotal(this.identificador)
        }
    }
</script>

