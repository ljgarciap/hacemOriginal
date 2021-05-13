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
                                        <th>Unidad</th>
                                        <th>Cantidad</th>
                                        <th>Observación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="total in arrayProductos" :key="total.idInventario">
                                        <td>{{total.producto}}</td>
                                        <td>{{total.unidadBase}}</td>
                                        <td>{{total.cantidad}}</td>
                                        <td>{{total.observacion}}</td>
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
            detalleInventario(identificador){
                let me=this;
                var url='/inventario/listar/?identificador='+this.identificador;
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
            this.detalleInventario(this.identificador)
        }
    }
</script>

<style>
    .minimo {
	min-height: 150px;
    }
</style>
