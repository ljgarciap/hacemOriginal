<template>
        <!-- Ejemplo de tabla Listado -->
        <div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Tipo de costos</th>
                                        <th>Valores costo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="materiadirecta in arrayMateriaDirecta" :key="materiadirecta">
                                        <td>Total Materia prima directa</td>
                                        <td>{{materiadirecta.acumuladomd}}</td>
                                    </tr>
                                    <tr v-for="materiaindirecta in arrayMateriaIndirecta" :key="materiaindirecta">
                                        <td>Total Materia prima indirecta</td>
                                        <td>{{materiaindirecta.acumuladomi}}</td>
                                    </tr>
                                    <tr v-for="manodeobra in arrayManoDeObra" :key="manodeobra">
                                        <td>Total Mano de obra</td>
                                        <td>{{manodeobra.acumuladomo}}</td>
                                    </tr>
                                    <tr v-for="cif in arrayCif" :key="cif">
                                        <td>Total cif</td>
                                        <td>{{cif.acumuladocif}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>COSTO TOTAL</b></td>
                                        <td>Calcular</td>
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
                acumuladomd:0,
                acumuladomi:0,
                acumuladomo:0,
                acumuladocif:0,
                total:0,
                arrayMateriaDirecta:[],
                arrayMateriaIndirecta:[],
                arrayManoDeObra:[],
                arrayCif:[]
            }
        },
        methods : {
                materiaDirecta(identificador){
                let me=this;
                var url='/hojadecosto/materiadirecta/'+this.identificador;
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayMateriaDirecta=respuesta.materiadirecta;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            materiaIndirecta(identificador){
                let me=this;
                var url='/hojadecosto/materiaindirecta/'+this.identificador;
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayMateriaIndirecta=respuesta.materiaindirecta;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            manoDeObra(identificador){
                let me=this;
                var url='/hojadecosto/manodeobra/'+this.identificador;
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayManoDeObra=respuesta.manodeobra;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            }
        },
        mounted() {
            this.materiaDirecta(this.identificador),
            this.materiaIndirecta(this.identificador),
            this.manoDeObra(this.identificador)
        }
    }
</script>

