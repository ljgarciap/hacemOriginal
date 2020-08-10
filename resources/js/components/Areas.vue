<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item"><a href="#">Admin</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Areas
                            <button type="button" @click="abrirModal('area','crear')" class="btn btn-secondary">
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" id="opcion" name="opcion">
                                        <option value="nombre">Nombre</option>
                                        <option value="descripcion">Descripción</option>
                                        </select>
                                        <input type="text" id="texto" name="texto" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Id</th>
                                        <th>Descripción</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="area in arrayAreas" :key="area.id">
                                        <td>
                                            <button type="button" @click="abrirModal('area','actualizar',area)" class="btn btn-warning btn-sm">
                                            <i class="icon-pencil"></i>
                                            </button> &nbsp;

                                        <template v-if="area.estado">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarArea(area.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-success btn-sm" @click="activarArea(area.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>

                                        </td>
                                        <td v-text="area.id"></td>
                                        <td v-text="area.area"></td>
                                        <td>
                                            <div v-if="area.estado">
                                            <span class="badge badge-success">Activo</span>
                                            </div>
                                            <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            <nav>
                                <ul class="pagination">
                                    <li class="page-item">
                                        <a class="page-link" href="#">Ant</a>
                                    </li>
                                    <li class="page-item active">
                                        <a class="page-link" href="#">1</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">2</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">3</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">4</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Sig</a>
                                    </li>
                                </ul>
                            </nav>
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

                                    <!--
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                        <div class="col-md-9">
                                            <input type="email" v-model="estado" class="form-control" placeholder="Enter Email">
                                        </div>
                                    </div>
                                    -->

                                    <div class="form-group row div-error" v-show="errorArea">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMensaje" :key="error" v-text="error"></div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearArea()">Guardar</button>
                                <button type="button" v-if="tipoAccion==2" class="btn btn-warning" @click="editarArea()">Editar</button>
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
                area_id:0,
                id:'',
                area:'',
                estado:'',
                arrayAreas : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorArea : 0,
                errorMensaje : []
            }
        },
        methods : {
            listarArea(){
                let me=this;
                // Make a request for a user with a given ID
                axios.get('/area').then(function (response) {
                    // handle success
                me.arrayAreas=response.data;
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
                me.listarArea();
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
                    'id': this.area_id
                    //'estado': this.estado,
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarArea();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            desactivarArea(id){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Está seguro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Desactivar!',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.put('/area/deactivate',{
                        'id': id
                    }).then(function (response) {
                    me.listarArea();
                    swalWithBootstrapButtons.fire(
                    'Area desactivada!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarArea();
                }
                })
            },
            activarArea(id){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Quiere activar este registro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Activar!',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.put('/area/activate',{
                        'id': id
                    }).then(function (response) {
                    me.listarArea();
                    swalWithBootstrapButtons.fire(
                    'Area activada!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarArea();
                }
                })
            },
            validarArea(){
                this.errorArea=0;
                this.errorMensaje=[];

                if (!this.area) this.errorMensaje.push("El nombre del área no puede estar vacio");
                if (this.errorMensaje.length) this.errorArea=1;

                return this.errorArea;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.area='';
            },
            abrirModal(modelo, accion, data=[]){
            //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
            switch(modelo){
                case "area":
                {
                    switch (accion) {
                        case 'crear':{
                            this.modal=1;
                            this.area='';
                            this.tituloModal='Crear nueva área';
                            this.tipoAccion= 1;
                            break;
                        }
                        case 'actualizar':{
                            //console.log(data);
                            this.modal=1;
                            this.tituloModal='Editar área';
                            this.tipoAccion= 2;
                            this.area_id=data['id'];
                            this.area=data['area'];
                            break;
                        }
                    }
                }
            }
            }
        },
        mounted() {
            this.listarArea();
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
