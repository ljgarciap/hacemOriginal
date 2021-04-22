<template>
   <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Toma de Inventarios</li>
                </ol>
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Inventarios &nbsp;
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Unidad Base</th>
                                        <th>Actualizar Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="total in arrayProductos" :key="total.id">
                                        <td>{{total.producto}}</td>
                                        <td>{{total.cantidad}}</td>
                                        <td>{{total.idUnidadBase}}</td>
                                        <td>
                                            <input type="number" v-model="cantidad" step="0.01">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-primary" @click="actualizarDatos(cantidad)">Actualizar</button>
                            </div>
                        </div>
                    </div>
        </div>
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
                cantidad:'',
                modal : 0,
                tipoModal : 0,
            }
        },
        methods : {
            listarInventario(identificador){
                let me=this;
                var url='/inventario/?identificador='+this.identificador;
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayProductos=respuesta.productos.data;
                me.cantidad=respuesta.cantidad;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
                actualizarDatos(identificador){
                let me=this;
                axios.post('/inventario/actualizar',{
                    'id': this.identificador,
                    'cantidad' : this.cantidad
                }).then(function (response) {
                me.listarInventario()
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        },
        mounted() {
            this.listarInventario(this.identificador)
        }
    }
</script>

<style>
    .minimo {
	min-height: 150px;
    }
</style>
