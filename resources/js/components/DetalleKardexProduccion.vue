<template>
    <main class="minimo">
        <template v-if="listado==0">
        <!-- Ejemplo de tabla Listado -->
        <div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Detalle</th>

                                        <th>Entradas<br>Cantidad</th>
                                        <th>Entradas<br>Precio Unitario</th>
                                        <th>Entradas<br>Precio total</th>
                                        <th>Salidas<br>Cantidad</th>
                                        <th>Salidas<br>Precio Unitario</th>
                                        <th>Salidas<br>Precio total</th>

                                        <th>Saldos<br>Cantidad</th>
                                        <th>Saldos<br>Precio Unitario</th>
                                        <th>Saldos<br>Precio total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="total in arrayProductos" :key="total.idMateria">
                                        <td>{{total.fecha}}</td>
                                        <td>{{total.detalle}}</td>

                                            <td v-if="total.tipologia==1">{{total.cantidad}}</td>
                                            <td v-if="total.tipologia==1">{{total.precio}}</td>
                                            <td v-if="total.tipologia==1">{{total.preciototal}}</td>
                                            <td v-if="total.tipologia==1">0</td>
                                            <td v-if="total.tipologia==1">0</td>
                                            <td v-if="total.tipologia==1">0</td>

                                            <td v-if="total.tipologia==2">0</td>
                                            <td v-if="total.tipologia==2">0</td>
                                            <td v-if="total.tipologia==2">0</td>
                                            <td v-if="total.tipologia==2">{{total.cantidad}}</td>
                                            <td v-if="total.tipologia==2">{{total.precio}}</td>
                                            <td v-if="total.tipologia==2">{{total.preciototal}}</td>

                                        <td>{{total.cantidadSaldos}}</td>
                                        <td>{{total.precioSaldos}}</td>
                                        <td>{{total.totalsaldos}}</td>
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
                arrayProductos:[],
                modal : 0,
                tipoModal : 0,
            }
        },
        methods : {
            acumuladoTotal(identificador){
                let me=this;
                var url='/kardexproduccion/listar/?identificador='+this.identificador;
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayProductos=respuesta.productos.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
        },
        mounted() {
            this.acumuladoTotal(this.identificador)
        }
    }
</script>

<style>
    .minimo {
	min-height: 150px;
    }
</style>
