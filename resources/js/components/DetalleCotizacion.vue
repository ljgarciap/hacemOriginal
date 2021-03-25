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
                                        <th>Referencia</th>
                                        <th>Cantidad</th>
                                        <th>Valor</th>
                                        <th>Precio Venta</th>
                                        <th>Id Cotizacion</th>
                                        <th>Detalle</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="total in arrayProductos" :key="total.id">
                                        <td>{{total.producto}}</td>
                                        <td>{{total.referencia}}</td>
                                        <td>{{total.cantidad}}</td>
                                        <td>{{total.valor}}</td>
                                        <td>{{total.precioVenta}}</td>
                                        <td>{{total.idCotizacion}}</td>
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
                producto:'',
                cantidad:'',
                precioVenta:'',
                valor:'',
                arrayProductos:[],
                idProducto:'',
                total:'',
                idCotizacion,
                modal : 0,
                tipoModal : 0,
            }
        },
        methods : {
            acumuladoTotal(identificador){
                let me=this;
                var url='/cotizacioncliente/listar/'+this.identificador;
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayProductos=respuesta.productos;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            mostrarDetalle(data=[]){
                this.listado=1;
                this.identificador=this.identificador;
                this.idProducto=data['idProducto'];
                this.costeoDetalle(this.idProducto,this.identificador);
                this.costeoUnidad(this.idProducto,this.identificador);
                //
                console.log(this.idProducto);
                //
                console.log(this.identificador);
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

<style>
    .minimo {
	min-height: 150px;
    }
</style>
