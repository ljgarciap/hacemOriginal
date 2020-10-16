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
                            <button type="button" @click="abrirModal('variables','crear')" class="btn btn-secondary">
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Conceptos</th>
                                        <th>Porcentaje</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr v-for="financiera in arrayFinancieras" :key="financiera.id">
                                            <td v-text="financiera.id"></td>
                                            <td v-text="financiera.conceptoFinanciero"></td>
                                            <td>
                                                <input type="hidden" name="ids[]" :value="financiera.id">
                                                <input type="number" name="porcentajes[]" step="0.01" :value="financiera.porcentaje">
                                            </td>
                                        </tr>
                                </tbody>
                            </table>
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <button type="button" class="btn btn-primary" @click="actualizarDatos(this.ids,this.porcentajes)">Actualizar</button>
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
                id:'',
                conceptoFinanciero:'',
                porcentaje:'',
                estado:'',
                arrayFinancieras : [],
                ids : [],
                porcentajes : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorVariable : 0,
                errorMensaje : []
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
            actualizarDatos(ids,porcentajes){
                let me=this;
                axios.post('/financiera/actualizar',{
                    'ids': this.ids,
                    'porcentajes': this.porcentajes
                    //'estado': this.estado,
                    //'dato': this.dato
                }).then(function (response) {
                me.listarVariables()
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            crearArea(){
                //valido con el metodo de validacion creado
                if(this.validarArea()){
                    return;
                }

                let me=this;
                axios.post('/area/store',{
                    'area': this.area
                    //'estado': this.estado,
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarArea(1,'','area');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            editarArea(){
                if(this.validarArea()){
                    return;
                }

                let me=this;
                axios.put('/area/update',{
                    'area': this.area,
                    'id': this.idArea
                    //'estado': this.estado,
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarVariables();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            validarArea(){
                this.errorVariable=0;
                this.errorMensaje=[];

                if (!this.area) this.errorMensaje.push("El nombre del área no puede estar vacio");
                if (this.errorMensaje.length) this.errorVariable=1;

                return this.errorVariable;
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
