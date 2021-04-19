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
                                    <tr v-for="total in arrayProductos" :key="total.id">
                                        <td>{{total.fecha}}</td>
                                        <td>{{total.detalle}}</td>
                                        <!--
                                        <template v-if="total.tipologia==1">
                                            <td>{{total.cantidad}}</td>
                                            <td>{{total.precio}}</td>
                                            <td>{{total.preciototal}}</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                        </template>
                                        <template v-if="total.tipologia==2">
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>{{total.cantidad}}</td>
                                            <td>{{total.precio}}</td>
                                            <td>{{total.preciototal}}</td>
                                        </template>
                                        -->
                                        <td>{{total.cantidadSaldos}}</td>
                                        <td>{{total.precioSaldos}}</td>
                                        <td>{{total.totalsaldos}}</td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" @click="mostrarDetalle(total)">
                                                <i class="icon-plus"></i><span> Mostrar</span>
                                            </button>
                                        </td>
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
                var url='/kardexalmacen/listar/?identificador='+this.identificador;
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayProductos=respuesta.productos;
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
