<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Vinculacion</li>
                </ol>
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Vinculación &nbsp;
                            <button type="button" @click="abrirModal('vinculacion','crear')" class="btn btn-secondary">
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                        <option value="area">Area</option>
                                        <option value="id">Id</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarVinculacion(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarVinculacion(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Id</th>
                                        <th>Area</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="vinculacion in arrayVinculaciones" :key="vinculacion.id">
                                        <td>
                                            <button type="button" @click="abrirModal('vinculacion','actualizar',vinculacion)" class="btn btn-warning btn-sm">
                                            <i class="icon-pencil"></i>
                                            </button> &nbsp;

                                        <template v-if="vinculacion.estado">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarVinculacion(vinculacion.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-success btn-sm" @click="activarVinculacion(vinculacion.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>

                                        </td>
                                        <td v-text="vinculacion.id"></td>
                                        <td v-text="vinculacion.vinculacion"></td>
                                        <td>
                                            <div v-if="vinculacion.estado">
                                            <span class="badge badge-success">Activo</span>
                                            </div>
                                            <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            </div>
                            <nav>
                                <ul class="pagination">
                                    <li class="page-item" v-if="pagination.current_page > 1">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                    </li>
                                    <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                    </li>
                                    <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
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
                                        <label class="col-md-3 form-control-label" for="text-input">Empleado</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="idEmpleado">
                                                <option value="0" disabled>Seleccione un Empleado</option>
                                                <option v-for="empleado in arrayEmpleados" :key="empleado.idEmpleado" :value="empleado.idEmpleado" v-text="empleado.empleado"></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Tipo Contrato</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="tipoContrato">
                                                <option value="0" disabled>Seleccione un tipo de contrato</option>
                                                <option value="1">Termino Fijo</option>
                                                <option value="2">Termino Indefinido</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Tipo Salario</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="tipoSalario">
                                                <option value="0" disabled>Seleccione un tipo de salario</option>
                                                <option value="1">Fijo</option>
                                                <option value="2">Destajo</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Salario Base</label>
                                        <div class="col-md-9">
                                            <input type="number" v-model="salarioBasicoMensual" class="form-control" placeholder="Ingrese el salario básico mensual">
                                            <span class="help-block">(*) Ingrese el salario básico mensual</span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Fecha de Inicio</label>
                                        <div class="col-md-9">
                                            <input type="date" v-model="fechaInicio" class="form-control" placeholder="Ingrese la fecha de inicio">
                                            <span class="help-block">(*) Ingrese fecha de inicio</span>
                                        </div>
                                    </div>

                                    <div class="form-group row div-error" v-show="errorVinculacion">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMensaje" :key="error" v-text="error"></div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearVinculacion()">Guardar</button>
                                <button type="button" v-if="tipoAccion==2" class="btn btn-warning" @click="editarVinculacion()">Editar</button>
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
    import moment from 'moment';
    export default {
        data(){
            return{
                idEmpleado:0,
                tipoContrato:0,
                tipoSalario:0,
                idNivelArl:0,
                idEps:0,
                idPensiones:0,
                salarioBasicoMensual:'',
                id:'',
                fechaInicio:'',
                estado:'',
                arrayVinculaciones : [],
                arrayEmpleados : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorVinculacion : 0,
                errorMensaje : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'vinculacion',
                buscar : ''
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginacion
            pagesNumber: function(){
                if (this.pagination.to) {
                    return[];
                }

                var from=this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }

                return pagesArray;
            }
        },
        methods : {
            listarVinculacion(page,buscar,criterio){
                let me=this;
                var url='/vinculacion?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayVinculaciones=respuesta.vinculaciones.data;
                me.pagination=respuesta.pagination;
                    //console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;
                //envia peticion para ver los valores asociados a esa pagina
                me.listarVinculacion(page,buscar,criterio);
            },
            indexChange: function(args) {
                let newIndex = args.value
                console.log('Current tab index: ' + newIndex)
                },
            forceRerender() {
                this.componentKey += 1;
               },
            crearVinculacion(){
                //valido con el metodo de validacion creado
                if(this.validarVinculacion()){
                    return;
                }

                let me=this;
                axios.post('/vinculacion/store',{
                    'idEmpleado': this.idEmpleado,
                    'tipoContrato': this.tipoContrato,
                    'tipoSalario': this.tipoSalario,
                    'salarioBasicoMensual': this.salarioBasicoMensual,
                    'fechaInicio': this.fechaInicio
                    //'estado': this.estado,
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarVinculacion(1,'','Vinculacion');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            editarVinculacion(){
                if(this.validarVinculacion()){
                    return;
                }

                let me=this;
                axios.put('/vinculacion/update',{
                    'vinculacion': this.vinculacion,
                    'id': this.idVinculacion
                    //'estado': this.estado,
                    //'dato': this.dato
                }).then(function (response) {
                me.cerrarModal();
                me.listarVinculacion(1,'','vinculacion');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            desactivarVinculacion(id){
                this.fechaFin= moment().format('YYYY-MM-DD');

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
                    axios.put('/vinculacion/deactivate',{
                        'id': id,
                        'fechaFin': fechaFin
                    }).then(function (response) {
                    me.listarVinculacion(1,'','vinculacion');
                    swalWithBootstrapButtons.fire(
                    'Vinculacion desactivada!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarVinculacion();
                }
                })
            },
            activarVinculacion(id){
                this.fechaInicio= moment().format('YYYY-MM-DD');

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
                    axios.put('/vinculacion/activate',{
                        'id': id
                    }).then(function (response) {
                    me.listarVinculacion(1,'','vinculacion');
                    swalWithBootstrapButtons.fire(
                    'Vinculacion activada!'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    me.listarVinculacion();
                }
                })
            },
            validarVinculacion(){
                this.errorVinculacion=0;
                this.errorMensaje=[];

                //if (!this.idEmpleado) this.errorMensaje.push("El nombre del empleado no puede estar vacio");
                if (this.errorMensaje.length) this.errorVinculacion=1;

                return this.errorVinculacion;
            },
            listarEmpleados(){
                let me=this;
                var url='/vinculacion/selectempleado';
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                var respuesta=response.data;
                me.arrayEmpleados=respuesta.empleados;
                    //console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.vinculacion='';
                this.errorVinculacion = 0,
                this.errorMensaje = [],
                this.forceRerender();
            },
            abrirModal(modelo, accion, data=[]){
            //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
            switch(modelo){
                case "vinculacion":
                {
                    switch (accion) {
                        case 'crear':{
                            this.modal=1;
                            this.vinculacion='';
                            this.tituloModal='Crear nueva vinculacion';
                            this.tipoAccion= 1;
                            break;
                        }
                        case 'actualizar':{
                            //console.log(data);
                            this.modal=1;
                            this.tituloModal='Editar área';
                            this.tipoAccion= 2;
                            this.idVinculacion=data['id'];
                            this.vinculacion=data['vinculacion'];
                            break;
                        }
                    }
                }
            }
            }
        },
        mounted() {
            this.listarEmpleados();
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
