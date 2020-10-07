<template>
        <main class="main">
            <div>
                <select class="form-control" v-model="idMateriaPrima" @change="selectDatosMateria(gestionmateria.idGestionMateria)">
                    <option v-for="gestionmateria in arrayGestionMaterias" :key="gestionmateria.idGestionMateria" :value="gestionmateria.idGestionMateria" v-text="gestionmateria.gestionMateria"></option>
                </select>
            </div><br>
            <div>
                <input type="text" v-model="precioBase">
                <p v-for="datosmateria in arrayDatosMaterias" :key="datosmateria.idGestion" :value="datosmateria.precioBase" v-text="datosmateria.precioBase">
                </p>
            </div>
        </main>
</template>

<script>
    export default {
                data(){
            return{
                idMateriaPrima:'',
                idGestionMateria:'',
                gestionmateria:'',
                arrayGestionMaterias:[],
                datosmateria:'',
                precioBase:'',
                unidadBase:'',
                arrayDatosMaterias:[],
            }
        },
        methods : {
            selectDatosMateria(idMateriaPrima){
                let me=this;
                var url='/materiaprimaproducto/selectDatosMateria/'+this.idMateriaPrima;
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayDatosMaterias=respuesta.datosmaterias;
                console.log(respuesta);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            selectGestionMateria(){
                let me=this;
                var url='/materiaprimaproducto/selectGestionMateria/';
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayGestionMaterias=respuesta.gestionmaterias;
                console.log(respuesta);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
        },
        mounted() {
            console.log('Component mounted.'),
            this.selectGestionMateria()
        }
    }
</script>
