<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Variables Financieras</li>
                </ol>
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Variables &nbsp;
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" v-for="financiera in arrayFinancieras" :key="financiera.id">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <table class="table table-bordered table-striped table-sm">
                                <tbody>
                                    <tr>
                                        <td>
                                            Vacaciones
                                        </td>
                                        <td>
                                            <input type="number" name="vacaciones" step="0.01" :value="financiera.vacaciones">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Prima
                                        </td>
                                        <td>
                                            <input type="number" name="prima" step="0.01" :value="financiera.prima">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Cesantías
                                        </td>
                                        <td>
                                            <input type="number" name="cesantias" step="0.01" :value="financiera.cesantias">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Intereses a las cesantías
                                        </td>
                                        <td>
                                            <input type="number" name="intereses" step="0.01" :value="financiera.intereses">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Salud
                                        </td>
                                        <td>
                                            <input type="number" name="salud" step="0.01" :value="financiera.salud">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Pensión
                                        </td>
                                        <td>
                                            <input type="number" name="pension" step="0.01" :value="financiera.pension">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            ARL
                                        </td>
                                        <td>
                                            <input type="number" name="arl" step="0.01" :value="financiera.arl">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Caja de compensación
                                        </td>
                                        <td>
                                            <input type="number" name="caja" step="0.01" :value="financiera.caja">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                                <button type="button" class="btn btn-primary" @click="actualizarDatos(vacaciones,prima,cesantias,intereses,salud,pension,arl,caja)">Actualizar</button>
                            </form>
                            </div>
                        </div>
                    </div>
                    <!-- Fin ejemplo de tabla Listado -->
                </div>
                <!--Inicio del modal agregar/actualizar-->

                <!--Fin del modal-->
        </main>
</template>

<script>
    export default {
        data(){
            return{
                id : 1,
                arrayFinancieras : [],
                vacaciones : '',
                prima : '',
                cesantias : '',
                intereses : '',
                salud : '',
                pension : '',
                arl : '',
                caja : ''
            }
        },
        methods : {
            listarVariables(){
                let me=this;
                var url='/financiera';
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayFinancieras=respuesta.financieras;
                    //console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            actualizarDatos(vacaciones,prima,cesantias,intereses,salud,pension,arl,caja){
                let me=this;
                axios.post('/financiera/actualizar',{
                    'id': 1,
                    'vacaciones' : this.vacaciones,
                    'prima' : this.prima,
                    'cesantias' : this.cesantias,
                    'intereses' : this.intereses,
                    'salud' : this.salud,
                    'pension' : this.pension,
                    'arl' : this.arl,
                    'caja' : this.caja
                }).then(function (response) {
                me.listarVariables()
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        },
        mounted() {
            this.listarVariables()
        }
    }
</script>
<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>
