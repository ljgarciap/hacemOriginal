<template>
    <main class="minimo">
        <template v-if="listado==0">
        <!-- Ejemplo de tabla Listado -->
        <div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>% Participación ventas</th>
                                        <th>Margen de contribución</th>
                                        <th>Promedio ponderado MC</th>
                                        <th>Punto equilibrio total</th>
                                        <th>Punto equilibrio producto (cantidades)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="total in arrayTotales" :key="total.id">
                                        <td>{{total.producto}}</td>
                                        <td>{{total.porcentajeparticipacion}} %</td>
                                        <td>$ {{total.margencontribucion}}</td>
                                        <td>$ {{total.promedioponderado}}</td>
                                        <td>{{total.puntodeequilibriototal  | redondeo}}</td>
                                        <td>{{total.puntodeequilibrioproducto  | redondeo}}</td>
                                        <!-- <td>{{total.acumuladototal | currency}}</td> -->
                                    </tr>
                                </tbody>
                            </table>
                            </div>
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
                arrayTotales:[],
                costopar : ''
            }
        },
        methods : {
            multiproductoDetalle(identificador){
                let me=this;
                var url='/relaf/selectDetallado?idSimulador=' + this.identificador;
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayTotales=respuesta.detallado;
                //console.log(url);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            mostrarDetalle(data=[]){
                this.listado=1;
                this.identificador=this.identificador;
            },
            ocultarDetalle(){
                this.listado=0;
            },
        },
        mounted() {
            this.multiproductoDetalle(this.identificador)
        }
    }
</script>

<style>
    .minimo {
	min-height: 150px;
    }
</style>
