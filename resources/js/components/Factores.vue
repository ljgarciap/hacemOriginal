<template>
        <main>

                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Factor Nomina &nbsp;
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <table class="table table-bordered table-striped table-sm">
                                <tbody>
                                    <tr>
                                        <td>
                                            Extra Diurna
                                        </td>
                                        <td>
                                            <input type="number" v-model="extraDiurna"  step="0.01" class="form-control" placeholder="Extra Diurna">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Extra Nocturna
                                        </td>
                                        <td>
                                            <input type="number" v-model="extraNocturna" step="0.01" class="form-control" placeholder="Extra Nocturna">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Hora Dominical
                                        </td>
                                        <td>
                                            <input type="number" v-model="horaDominical" step="0.01" class="form-control" placeholder="Hora Dominical">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Festiva Diurna
                                        </td>
                                        <td>
                                            <input type="number" v-model="festivaDiurna" step="0.01" class="form-control" placeholder="Festiva Diurna">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Festiva Nocturna
                                        </td>
                                        <td>
                                            <input type="number" v-model="festivaNocturna" step="0.01" class="form-control" placeholder="Festiva Nocturna">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Recargos
                                        </td>
                                        <td>
                                            <input type="number" v-model="recargos" step="0.01" class="form-control" placeholder="Recargos">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Salario mínimo mensual legal vigente
                                        </td>
                                        <td>
                                            <input type="number" v-model="minimolegal" step="0.01" class="form-control" placeholder="SMMLV">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Auxilio de transporte
                                        </td>
                                        <td>
                                            <input type="number" v-model="auxilio" step="0.01" class="form-control" placeholder="Auxilio">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                                <!-- <button type="button" class="btn btn-success" @click="guardarDatos()">Guardar</button> -->
                                <button v-if="id==1" type="button" class="btn btn-primary" @click="actualizarDatos(extraDiurna,extraNocturna,horaDominical,festivaDiurna,festivaNocturna,recargos,minimolegal,auxilio)">Actualizar</button>
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
         props: {
            identificador: {
            type: Number
            }
         },
        data(){
            return{
                id : 1,
                identificador:0,
                extraDiurna : '',
                extraNocturna : '',
                horaDominical : '',
                festivaDiurna : '',
                festivaNocturna : '',
                recargos : '',
                minimolegal : '',
                auxilio : ''
            }
        },
        methods : {
            listarFactorNomina(){
                let me=this;
                var url='/factores';
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.extraDiurna=respuesta.extraDiurna;
                me.extraNocturna=respuesta.extraNocturna;
                me.horaDominical=respuesta.horaDominical;
                me.festivaDiurna=respuesta.festivaDiurna;
                me.festivaNocturna=respuesta.festivaNocturna;
                me.recargos=respuesta.recargos;
                me.minimolegal=respuesta.minimolegal;
                me.auxilio=respuesta.auxilio;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            guardarDatos(){
                //valido con el metodo de validacion creado
                let me=this;
                axios.post('/factores/store',{
                    'nombre' : this.nombre,
                    'extraDiurna' : this.extraDiurna,
                    'extraNocturna' : this.extraNocturna,
                    'horaDominical' : this.horaDominical,
                    'festivaDiurna' : this.festivaDiurna,
                    'festivaNocturna' : this.festivaNocturna,
                    'recargos' : this.recargos,
                    'minimolegal' : this.minimolegal,
                    'auxilio' : this.auxilio
                }).then(function (response) {
                me.listarFactorNomina();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            actualizarDatos(extraDiurna,extraNocturna,horaDominical,festivaDiurna,festivaNocturna,recargos){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success'
                },
                buttonsStyling: false
                })
                let me=this;
                axios.post('/factores/actualizar',{
                    'id': 1,
                    'extraDiurna' : this.extraDiurna,
                    'extraNocturna' : this.extraNocturna,
                    'horaDominical' : this.horaDominical,
                    'festivaDiurna' : this.festivaDiurna,
                    'festivaNocturna' : this.festivaNocturna,
                    'recargos' : this.recargos,
                    'minimolegal' : this.minimolegal,
                    'auxilio' : this.auxilio
                }).then(function (response) {
                swalWithBootstrapButtons.fire('Registro actualizado');
                me.listarFactorNomina()
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        },
        mounted() {
            this.listarFactorNomina()
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
