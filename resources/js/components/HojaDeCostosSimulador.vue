<template>
        <!-- Ejemplo de tabla Listado -->
        <div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Referencia</th>
                                        <th>Unidades</th>
                                        <th>Tiempo</th>
                                        <th>Tiempo total</th>
                                        <th>Valor total</th>
                                        <th>Valor unitario</th>
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
                                        <!-- <td>{{total.acumuladototal | currency}}</td> -->
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                    <!-- Fin ejemplo de tabla Listado -->
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
                producto:'',
                referencia:'',
                unidades:'',
                tiempo:'',
                produccion:'',
                acumuladocift:'',
                acumuladocalculo:'',
                valorbase:'',
                arrayProductos:[]
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
                me.acumuladocift=respuesta.acumuladocift;
                me.acumuladocalculo=respuesta.acumuladocalculo;
                me.valorbase=respuesta.valorbase;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            }
        },
        mounted() {
            this.acumuladoTotal(this.identificador)
        }
    }
</script>

