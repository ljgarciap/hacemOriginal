<template>
        <!-- Ejemplo de tabla Listado -->
        <div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Total Materia prima directa</th>
                                        <th>Total Materia prima indirecta</th>
                                        <th>Total Mano de obra</th>
                                        <th>Total Cif</th>
                                        <th>Total Maquinaria</th>
                                        <th><b>COSTO TOTAL</b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="total in arrayTotales" :key="total.id">
                                        <td v-text="total.acumuladomd"></td>
                                        <td v-text="total.acumuladomi"></td>
                                        <td v-text="total.acumuladomo"></td>
                                        <td v-text="total.acumuladocif"></td>
                                        <td v-text="total.acumuladomaquinaria"></td>
                                        <td v-text="total.acumuladototal"></td>
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
                total:'',
                acumuladomd:0,
                acumuladomi:0,
                acumuladomo:0,
                acumuladocif:0,
                acumuladomaquinaria:0,
                acumuladototal:0,
                arrayTotales:[]
            }
        },
        methods : {
            acumuladoTotal(identificador){
                let me=this;
                var url='/hojadecosto/total/'+this.identificador;
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayTotales=respuesta.totales;
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

