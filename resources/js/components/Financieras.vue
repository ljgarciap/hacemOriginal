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
                                        <th>Variable Financiera</th>
                                        <th>Porcentaje</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal"></form>

                                        <tr v-for="financiera in arrayFinancieras" :key="financiera.id">
                                            <td v-text="financiera.id"></td>
                                            <td v-text="financiera.conceptoFinanciero"></td>
                                            <!--<td><input type="text" :value="financiera.conceptoFinanciero"></td>-->
                                            <td><input type="number" step="0.01" :value="financiera.porcentaje"></td>
                                        </tr>

                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                    <!-- Fin ejemplo de tabla Listado -->
                </div>
                <!--Inicio del modal agregar/actualizar-->
                <div class="modal fade" tabindex="-1" :class="{'mostrar':modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-primary modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" v-text="tituloModal"></h4>
                                <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                                <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="area" class="form-control" placeholder="Nombre de área">
                                            <span class="help-block">(*) Ingrese el nombre del área</span>
                                        </div>
                                    </div>

                                    <div class="form-group row div-error" v-show="errorVariable">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMensaje" :key="error" v-text="error"></div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearArea()">Guardar</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
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
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.area='';
            },
            abrirModal(modelo, accion, data=[]){
            //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
            switch(modelo){
                case "variables":
                {
                    switch (accion) {
                        case 'crear':{
                            this.modal=1;
                            this.area='';
                            this.tituloModal='Crear nueva área';
                            this.tipoAccion= 1;
                            break;
                        }
                    }
                }
            }
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
