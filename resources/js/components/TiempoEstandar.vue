<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Tiempo Estandar</li>
                </ol>
                      <!-- Listado -->
                <template v-if="listado==1">
                    <!-- Ejemplo de tabla Listado -->
                    <div class="container-fluid">
                        <div class="card">
                            <div class="card-header">
                            <i class="fa fa-align-justify"></i> Tiempo Estandar
                            <button type="button" @click="abrirModal('tiempoestandar','crear')" class="btn btn-secondary">
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button>
                           </div>
                            <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                        <option value="id">Id</option>
                                        <option value="idEmpleado">Empleado</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarTiempoEstandar(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarTiempoEstandar(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Empleado</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="tiempoestandar in arrayTiempoEstandar" :key="tiempoestandar.id">
                                        <td>
                                            <template v-if="tiempoestandar.estado==1">
                                            <button type="button" class="btn btn-danger btn-sm" @click="mostrarTiempoEstandar(tiempoestandar.id)">
                                                <i class="icon-plus"><span>Agregar</span></i>
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm" @click="abrirModal('detalle','crear',tiempoestandar.id)">
                                                <i class="icon-plus"><span>Validar</span></i>
                                            </button>
                                            </template>
                                            <template v-if="tiempoestandar.estado==0">
                                            <button type="button" class="btn btn-success btn-sm" @click="mostrarDetalle(tiempoestandar.id)">
                                                <i class="icon-eye"></i><span>Ver Detalle Tiempo Estandar</span>
                                            </button>
                                        </template>
                                        </td>
                                        <td v-text="tiempoestandar.nombreEmpleado"></td>
                                        <td v-text="tiempoestandar.fecha"></td>
                                        <td>
                                            <div v-if="tiempoestandar.estado">
                                            <span class="badge badge-warning">En Proceso</span>
                                            </div>
                                            <div v-else>
                                            <span class="badge badge-success">Finalizado</span>
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
                    </div>
                    </template>
                    <!-- Fin Listado -->
 
                    <!-- Detalle -->
                    <template v-if="listado==2">
                        <div class="container-fluid">
                            <div class="card">
                                <vs-tabs :color="colorx">

                                <vs-tab label="Ciclos" icon="pan_tool" @click="colorx = '#8B0000'">

                                    <div class="card-header">
                                        <i class="fa fa-align-justify"></i> Ciclos &nbsp;
                                        <button type="button" @click="abrirModal('ciclos','crear')" class="btn btn-secondary">
                                            <i class="icon-plus"></i>&nbsp;Nuevo Ciclo
                                        </button>
                                    </div>

                                    <div class="card-body">
                                        <ciclos v-bind:identificador="identificador" :key="componentKey" @abrirmodal="abrirModal"></ciclos>
                                    </div>

                                </vs-tab>

                                <vs-tab label="Westing House" icon="pan_tool" @click="colorx = '#FFA500'">

                                    <div class="card-header">
                                        <i class="fa fa-align-justify"></i> Westing House &nbsp;
                                        <button type="button" @click="abrirModal('westinghouse','crear')" class="btn btn-secondary">
                                            <i class="icon-plus"></i>&nbsp;Asignar Nueva Westing House
                                        </button>
                                    </div>

                                    <div class="card-body">
                                        <westinghouse v-bind:identificador="identificador" :key="componentKey" @abrirmodal="abrirModal"></westinghouse>
                                    </div>

                                </vs-tab>

                               <vs-tab label="Pds" icon="pan_tool" @click="colorx = '#4611DC'">

                                    <div class="card-header">
                                        <i class="fa fa-align-justify"></i> Pds &nbsp;
                                        <button type="button" @click="abrirModal('pds','crear')" class="btn btn-secondary">
                                            <i class="icon-plus"></i>&nbsp;Nueva Pds
                                        </button>
                                    </div>

                                    <div class="card-body">
                                        <pds v-bind:identificador="identificador" :key="componentKey" @abrirmodal="abrirModal"></pds>
                                    </div>

                                </vs-tab>

                                <vs-tab label="Cerrar" icon="cancel_schedule_send" @click="ocultarDetalle()">
                                </vs-tab>

                                </vs-tabs>
                            </div>
                        </div>
                    </template>

                <template v-if="listado==3">
                <div class="container-fluid">
                    <!-- Ejemplo de tabla Listado -->

                    <div class="card">
                        <div class="card-header">
                       <i class="fa fa-align-justify"></i> Detalle del Tiempo Estandar &nbsp;
                        </div>
                        <div class="card-body">
                            <detalletiempoestandar v-bind:identificador="identificador" :key="componentKey"></detalletiempoestandar>
                            <p align="right">
                                <button  class="btn btn-danger" @click="ocultarDetalle()" aria-label="Close">Cerrar</button>
                            </p>
                        </div>
                    </div>
                    <!-- Fin ejemplo de tabla Listado -->
                </div>
                </template>
                    <!-- Fin Detalle -->

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

                                     <!--Inicia el modal para crear tiempo estandar-->
                                     <div v-if="tipoModal==1" class="form-group row">
                                        <label class="col-md-3 form-control-label" for="email-input">Empleado</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="idEmpleado">
                                                <option value="0" disabled>Seleccione un empleado</option>
                                                <option v-for="empleado in arrayEmpleados" :key="empleado.id" :value="empleado.id" v-text="empleado.nombreEmpleado"></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div v-if="tipoModal==1" class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input"># Piezas de la Toma de Tiempos <br></label>
                                        <div class="col-md-9">
                                            <input type="number" step="0.01" v-model="numeroPiezas" class="form-control" placeholder="# Piezas de la Toma de Tiempos">
                                            <span class="help-block">(*) Ingrese el numero de piezas</span>
                                        </div>
                                    </div>
                                    <div v-if="tipoModal==1" class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Piezas por Par <br></label>
                                        <div class="col-md-9">
                                            <input type="number" step="0.01" v-model="piezasPar" class="form-control" placeholder="Piezas por Par">
                                            <span class="help-block">(*) Ingrese las piezas por par</span>
                                        </div>
                                    </div>

                                    <div v-if="tipoModal==1" class="form-group row div-error" v-show="errorTiempoEstandar">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMensaje" :key="error" v-text="error"></div>
                                        </div>
                                    </div> 
                                    <div v-if="tipoModal==1" class="modal-footer">
                                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                                   <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearTiempoTiempoEstandar()">Guardar</button>
                                   </div>
                                    <!--Termina el modal para crear tiempo estandar-->
                                    
                                    <!--Inicia el modal para crear ciclos-->
                                    <div v-if="tipoModal==2" class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Tiempo en Ciclos<br></label>
                                        <div class="col-md-9">
                                            <input type="number" step="0.01" v-model="tiempo" class="form-control" placeholder="Tiempo en Ciclos">
                                            <span class="help-block">(*) Ingrese el tiempo en ciclos</span>
                                        </div>
                                    </div>

                                     <div v-if="tipoModal==2" class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Piezas <br></label>
                                        <div class="col-md-9">
                                            <input type="number" step="0.01" v-model="piezas" class="form-control" placeholder="Piezas">
                                            <span class="help-block">(*) Ingrese las piezas</span>
                                        </div>
                                    </div>
                                    <div v-if="tipoModal==2" class="form-group row">
                                        <div class="col-md-9">
                                            <input type="hidden" v-model="idTiempoEstandar" id="idTiempoEstandar">
                                        </div>
                                    </div>

                                    <div v-if="tipoModal==2" class="form-group row div-error" v-show="errorCiclos">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMensaje" :key="error" v-text="error"></div>
                                        </div>
                                    </div>
                                    <!--Termina el modal para crear ciclos-->

                                   <!--Inicia el modal para crear westing house y pds-->
                                    <div v-if="tipoModal==3" class="form-group row"> <!-- Si es una entrada -->
                                        <label class="col-md-3 form-control-label" for="email-input">Movimiento</label>
                                        <div v-if="desplegable==1" class="col-md-9">
                                            <select class="form-control" v-model="idTiempoEstandar" @change='onChange($event)'>
                                                <option value="0" disabled>Seleccione una westing House</option>
                                                <option value="1">Calificación Habilidades</option>
                                                <option value="2">Calificación Esfuerzo</option>
                                                <option value="3">Calificación Condiciones</option>
                                                <option value="4">Calificación Consistencia</option>
                                                <!-- <option value="3">Inventario inicial</option> -->
                                            </select>
                                        </div>
                                    </div>
                                     <div v-if="tipoModal==4" class="form-group row"> 
                                        <label class="col-md-3 form-control-label" for="email-input">Movimiento</label>
                                        <div v-if="desplegable==2" class="col-md-9"> <!-- Si es una salida -->
                                            <select class="form-control" v-model="idTiempoEstandar" @change='onChange($event)'>
                                                <option value="0" disabled>Seleccione un pds</option>
                                                <option value="5">Esfuezo Mental</option>
                                                <option value="6">Esfuerzo Fisico</option>
                                                <option value="7">Suplementarios</option>
                                                <option value="8">Necesidades Personales</option>
                                                <option value="9">Monotonia</option>
                                                <option value="10">Espera</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <!--Inicia el modal para crear westing house-->
                                     <!--Inicio de sección rango-->
                                    <div v-if="tipoModal==3" class="form-group row">
                                        <label v-if="flag==1" class="col-md-3 form-control-label" for="text-input">Rango</label>
                                        <label v-else-if="flag==2" class="col-md-3 form-control-label" for="text-input">Rango</label>
                                        <label v-else-if="flag==3" class="col-md-3 form-control-label" for="text-input">Rango</label>
                                        <label v-else-if="flag==4" class="col-md-3 form-control-label" for="text-input">Rango</label>
                                        <div v-if="flag==1" class="col-md-9">
                                            <input type="text" v-model="rango" class="form-control" placeholder="Rango">
                                            <span class="help-block">(*) Ingrese el rango</span>
                                        </div>
                                        <div v-if="flag==2" class="col-md-9">
                                            <input type="text" v-model="rango" class="form-control" placeholder="Rango">
                                            <span class="help-block">(*) Ingrese el rango</span>
                                        </div>
                                        <div v-if="flag==3" class="col-md-9">
                                            <input type="text" v-model="rango" class="form-control" placeholder="Rango">
                                            <span class="help-block">(*) Ingrese el rango</span>
                                        </div>
                                        <div v-if="flag==4" class="col-md-9">
                                            <input type="text" v-model="rango" class="form-control" placeholder="Rango">
                                            <span class="help-block">(*) Ingrese el rango</span>
                                        </div>
                                    </div>
                                     <!--Cierre sección rango-->

                                     <!--Inicio de sección porcentaje-->
                                    <div v-if="tipoModal==3" class="form-group row">
                                        <label v-if="flag==1" class="col-md-3 form-control-label" for="text-input">Porcentaje</label>
                                        <label v-else-if="flag==2" class="col-md-3 form-control-label" for="text-input">Porcentaje</label>
                                        <label v-else-if="flag==3" class="col-md-3 form-control-label" for="text-input">Porcentaje</label>
                                        <label v-else-if="flag==4" class="col-md-3 form-control-label" for="text-input">Porcentaje</label>
                                        <div v-if="flag==1" class="col-md-9">
                                            <input type="number" v-model="porcentaje" class="form-control" placeholder="Porcentaje">
                                            <span class="help-block">(*) Ingrese el porcentaje</span>
                                        </div>
                                        <div v-if="flag==2" class="col-md-9">
                                            <input type="number" v-model="porcentaje" class="form-control" placeholder="Porcentaje">
                                            <span class="help-block">(*) Ingrese el porcentaje</span>
                                        </div>
                                        <div v-if="flag==3" class="col-md-9">
                                            <input type="number" v-model="porcentaje" class="form-control" placeholder="Porcentaje">
                                            <span class="help-block">(*) Ingrese el porcentaje</span>
                                        </div>
                                        <div v-if="flag==4" class="col-md-9">
                                            <input type="number" v-model="porcentaje" class="form-control" placeholder="Porcentaje">
                                            <span class="help-block">(*) Ingrese el porcentaje</span>
                                        </div>
                                    </div>
                                     <!--Cierre sección porcentaje-->

                                      <!--Inicio de sección clasificación-->
                                    <div v-if="tipoModal==3" class="form-group row">
                                        <label v-if="flag==1" class="col-md-3 form-control-label" for="text-input">Clasificación</label>
                                        <label v-else-if="flag==2" class="col-md-3 form-control-label" for="text-input">Clasificación</label>
                                        <label v-else-if="flag==3" class="col-md-3 form-control-label" for="text-input">Clasificación</label>
                                        <label v-else-if="flag==4" class="col-md-3 form-control-label" for="text-input">Clasificación</label>
                                        <div v-if="flag==1" class="col-md-9">
                                            <input type="text" v-model="clasificacion" class="form-control" placeholder="Clasificación">
                                            <span class="help-block">(*) Ingrese la clasificación</span>
                                        </div>
                                        <div v-if="flag==2" class="col-md-9">
                                            <input type="text" v-model="clasificacion" class="form-control" placeholder="Clasificación">
                                            <span class="help-block">(*) Ingrese la clasificación</span>
                                        </div>
                                        <div v-if="flag==3" class="col-md-9">
                                            <input type="text" v-model="clasificacion" class="form-control" placeholder="Clasificación">
                                            <span class="help-block">(*) Ingrese la clasificación</span>
                                        </div>
                                        <div v-if="flag==4" class="col-md-9">
                                            <input type="text" v-model="clasificacion" class="form-control" placeholder="Clasificación">
                                            <span class="help-block">(*) Ingrese la clasificación</span>
                                        </div>
                                    </div>
                                     <!--Cierre sección clasificación-->

                                     <div v-if="tipoModal==3" class="form-group row div-error" v-show="errorWestingHouse">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMensaje" :key="error" v-text="error"></div>
                                        </div>
                                    </div>
                                    <!--Termina el modal para crear westing house-->

                                    <!--Inicia el modal para crear pds-->
                                    <!--Inicio sección esfuerzoMental,esfuerzoFisico,Suplementarios-->
                                       <!--Inicio de sección grado-->
                                    <div v-if="tipoModal==4" class="form-group row">
                                        <label v-if="flag==5" class="col-md-3 form-control-label" for="text-input">Grado</label>
                                        <label v-else-if="flag==6" class="col-md-3 form-control-label" for="text-input">Grado</label>
                                        <label v-else-if="flag==7" class="col-md-3 form-control-label" for="text-input">Grado</label>
                                        <div v-if="flag==5" class="col-md-9">
                                            <input type="text" v-model="grado" class="form-control" placeholder="Grado">
                                            <span class="help-block">(*) Ingrese el grado</span>
                                        </div>
                                         <div v-if="flag==6" class="col-md-9">
                                            <input type="text" v-model="grado" class="form-control" placeholder="Grado">
                                            <span class="help-block">(*) Ingrese el grado</span>
                                        </div>
                                         <div v-if="flag==7" class="col-md-9">
                                            <input type="text" v-model="grado" class="form-control" placeholder="Grado">
                                            <span class="help-block">(*) Ingrese el grado</span>
                                        </div>
                                    </div>
                                     <!--Cierre sección grado-->

                                      <!--Inicio de sección porcentaje-->
                                    <div v-if="tipoModal==4" class="form-group row">
                                        <label v-if="flag==5" class="col-md-3 form-control-label" for="text-input">Porcentaje</label>
                                        <label v-else-if="flag==6" class="col-md-3 form-control-label" for="text-input">Porcentaje</label>
                                        <label v-else-if="flag==7" class="col-md-3 form-control-label" for="text-input">Porcentaje</label>
                                        <div v-if="flag==5" class="col-md-9">
                                            <input type="number" v-model="porcentaje" class="form-control" placeholder="Porcentaje">
                                            <span class="help-block">(*) Ingrese el porcentaje</span>
                                        </div>
                                        <div v-if="flag==6" class="col-md-9">
                                            <input type="number" v-model="porcentaje" class="form-control" placeholder="Porcentaje">
                                            <span class="help-block">(*) Ingrese el porcentaje</span>
                                        </div>
                                        <div v-if="flag==7" class="col-md-9">
                                            <input type="number" v-model="porcentaje" class="form-control" placeholder="Porcentaje">
                                            <span class="help-block">(*) Ingrese el porcentaje</span>
                                        </div>
                                    </div>
                                     <!--Cierre sección porcentaje-->
                                     <!--Cierre sección esfuerzoMental,esfuerzoFisico,Suplementarios-->

                                       <!--Inicio de sección necesidades personales-->
                                    <div v-if="tipoModal==4" class="form-group row">
                                        <label v-if="flag==8" class="col-md-3 form-control-label" for="text-input">Rango</label>
                                        <div v-if="flag==8" class="col-md-9">
                                            <input type="text" v-model="rango" class="form-control" placeholder="Rango">
                                            <span class="help-block">(*) Ingrese el rango</span>
                                        </div>
                                    </div>
                                     <div v-if="tipoModal==4" class="form-group row">
                                        <label v-if="flag==8" class="col-md-3 form-control-label" for="text-input">Porcentaje Hombre</label>
                                         <div v-if="flag==8" class="col-md-9">
                                            <input type="number" v-model="porcentajeHombre" class="form-control" placeholder="Porcentaje Hombre">
                                            <span class="help-block">(*) Ingrese el porcentaje hombre</span>
                                        </div>
                                         </div>
                                      <div v-if="tipoModal==4" class="form-group row">
                                        <label v-if="flag==8" class="col-md-3 form-control-label" for="text-input">Porcentaje Mujer</label>
                                        <div v-if="flag==8" class="col-md-9">
                                            <input type="number" v-model="porcentajeMujer" class="form-control" placeholder="Porcentaje Mujer">
                                            <span class="help-block">(*) Ingrese el porcentaje mujer</span>
                                        </div>
                                         </div>
                                     <!--Cierre sección necesidades Personales-->

                                      <div v-if="tipoModal==4" class="form-group row div-error" v-show="errorPds">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMensaje" :key="error" v-text="error"></div>
                                        </div>
                                    </div>
                                    <!--Termina el modal para crear pds-->
                                 <!-- Si el tipo es 3 solo es modal para mostrar carga -->

                                    <div v-if="tipoModal==5" class="carga">
                                        <p><hr><h1>Generando, por favor espere...</h1><hr></p>
                                    </div>
                                </form>
                            </div>

                                <!-- divs para footer tipo 2 y 3 -->

                            <div v-if="tipoModal==2" class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearCiclos()">Guardar</button>
                            </div>

                            <div v-if="tipoModal==3 && flag==1" class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearHabilidades()">Guardar</button>
                            </div>
                            <div v-if="tipoModal==3 && flag==2" class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearEsfuerzo()">Guardar</button>
                            </div>
                            <div v-if="tipoModal==3 && flag==3" class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1 " class="btn btn-primary" @click="crearCondiciones()">Guardar</button>
                            </div>
                            <div v-if="tipoModal==3 && flag==4" class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearConsistencia()">Guardar</button>
                            </div>

                            <div v-if="tipoModal==4 && flag==5" class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearEsfuerzoMental()">Guardar</button>
                            </div>
                            <div v-if="tipoModal==4 && flag==6" class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="crearEsfuerzoFisico()">Guardar</button>
                            </div>
                            <div v-if="tipoModal==4 && flag==7" class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1 " class="btn btn-primary" @click="crearSuplementarios()">Guardar</button>
                            </div>
                             <div v-if="tipoModal==4 && flag==8" class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1 " class="btn btn-primary" @click="crearPersonales()">Guardar</button>
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog tipo Modal 1 -->
                </div>
                <!--Fin del modal-->
        </main>
</template>

<script>
    import moment from 'moment';
    import detalletiempoestandar from '../components/DetalleTiempoEstandar.vue';
    import ciclos from '../components/Ciclos';
    import westinghouse from '../components/WestingHouse';
    import pds from '../components/Pds';
    export default {
        components: {
            detalletiempoestandar,
            ciclos,
            westinghouse,
            pds
        },
        data(){
            return{
                colorx: '#8B0000',
                listado: 1,
                identificador:0,
                idTiempoEstandar:0,
                id:'',
                fecha : '',
                numeroPiezas:0,
                piezasPar:0,
                estado: '',
                variable : '',
                idEmpleado: 0,
                nombreEmpleado: '',
                arrayEmpleados : [],
                arrayTiempoEstandar : [],
                rango:'',
                porcentaje:0,
                clasificacion:'',
                tituloModal : '',
                tipoModal : 0,
                tipoAccion : 0,
                tiempo:0,
                piezas:0,
                grado:'',
                porcentajeHombre:0,
                porcentajeMujer:0,
                errorTiempoEstandar : 0,
                errorCiclos:0,
                errorWestingHouse:0,
                errorPds:0,
                errorMensaje : [],
                modal : 0,
                seleccion:0,
                flag : 0,
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'id',
                identificador: 0,
                buscar : '',
                componentKey:0
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginacion
            pagesNumber: function(){
                if (!this.pagination.to) {
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
            onChange(event) {
            //console.log(event.target.value);
            this.flag=event.target.value;
            },
            indexChange: function(args) {
                let newIndex = args.value
                console.log('Current tab index: ' + newIndex)
                },
            forceRerender() {
                this.componentKey += 1;
               },
            listarTiempoEstandar(page,buscar,criterio){
                let me=this;
                var url='/tiempoestandar?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayTiempoEstandar=respuesta.tiempoestandar.data;
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
                me.listarTiempoEstandar(page,buscar,criterio);
            },
            indexChange: function(args) {
                let newIndex = args.value
                console.log('Current tab index: ' + newIndex)
                },
            forceRerender() {
                this.componentKey += 1;
               },
            listarEmpleados(){
                let me=this;
                var url='/tiempoestandar/empleados';
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
            crearTiempoTiempoEstandar(){
                //valido con el metodo de validacion creado
                 //valido con el metodo de validacion creado
                if(this.validarTiempoEstandar()){
                    return;
                }

                let me=this;
                this.fecha= moment().format('YYYY-MM-DD');
                axios.post('/tiempoestandar/store',{
                    'fecha': this.fecha,
                    'idEmpleado': this.idEmpleado,
                    'numeroPiezas':this.numeroPiezas,
                    'piezasPar':this.piezasPar
                }).then(function (response) {
                me.cerrarModal('0');
                me.listarTiempoEstandar(1,'','');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
             validarTiempoEstandar(){
                this.errorTiempoEstandar=0;
                this.errorMensaje=[];

                if (!this.numeroPiezas) this.errorMensaje.push("El numero de piezas no puede estar vacio");
                if (!this.piezasPar) this.errorMensaje.push("Las piezas por par no pueden estar vacias");
                if (this.errorMensaje.length) this.errorTiempoEstandar=1;

                return this.errorTiempoEstandar;
            },
            mostrarTiempoEstandar(id){
                this.listado=2;
                this.identificador=id;
                (this.identificador);
            },
            mostrarTiempo(id){
                this.listado=3;
                this.identificador=id;
                console.log(this.identificador);
            },
            mostrarDetalle(id){
                this.listado=3;
                this.identificador=id;
                (this.identificador);
            },
            generarDetalle(id){
                this.identificador=id;
                let me=this;
                axios.post('/tiempoestandar/estado',{
                    'id': this.identificador
                }).then(function (response) {
                me.cerrarModal('0');
                me.forceRerender();
                me.listarTiempoEstandar(1,'','');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            ocultarDetalle(){
                this.listarTiempoEstandar(1,this.buscar,this.criterio);
                this.forceRerender();
                this.listado=1;
            },
            cerrarModal(variable){
                this.modal=this.variable;
                this.tituloModal='';
                this.detalle='';
                this.idEmpleado='';
                this.numeroPiezas='';
                this.piezasPar='';
                this.tiempo='';
                this.piezas='';
                this.rango='';
                this.porcentaje='',
                this.clasificacion='',
                this.grado='',
                this.porcentajeHombre='',
                this.porcentajeMujer='',
                this.errorTiempoEstandar = 0,
                this.errorCiclos=0,
                this.errorWestingHouse=0,
                this.errorPds=0,
                this.errorMensaje = [],
                this.forceRerender();

            },
            abrirModal(modelo, accion, identificador, data=[]){
            //tres argumentos, el modelo a modificar o crear, la accion como tal y el arreglo del registro en la tabla
            switch(modelo){

                case "tiempoestandar":
                {
                    switch (accion) {
                        case 'crear':{
                            this.modal=1;
                                this.tipoModal=1; //carga tipos de campos y footers
                                this.tituloModal='Crear tiempo estandar';
                                this.tipoAccion= 1; //carga tipos de botón en el footer
                                this.fecha= moment().format('YYYY-MM-DD');
                                break;
                        }
                    }
                    break;
                }

                case "ciclos":
                {
                    switch (accion) {
                        case 'crear':{
                            this.modal=1;
                            this.tipoModal=2;
                            this.idTiempoEstandar=this.identificador;
                            this.tituloModal='Crear nuevo ciclo';
                            this.tipoAccion= 1;
                            break;
                        }
                    }
                    break;
                }
                case "westinghouse":
                {
                    switch (accion) {
                        case 'crear':{
                            this.modal=1;
                            this.tipoModal=3;
                            this.idTiempo=this.identificador;
                            this.tituloModal='Crear nueva westing house';
                            this.desplegable= 1; //carga tipos de botón en el footer
                            this.tipoAccion= 1;
                            break;
                        }
                    }
                    break;
                }
                case "pds":
                {
                    switch (accion) {
                        case 'crear':{
                            this.modal=1;
                            this.tipoModal=4;
                            this.idTiempo=this.identificador;
                            this.tituloModal='Crear nuevo pds';
                            this.desplegable= 2; //carga tipos de botón en el footer
                            this.tipoAccion= 1;
                            break;
                        }
                    }
                    break;
                }
                case "detalle":
                    {
                        switch (accion) {
                            case 'crear':{
                                this.modal=1;
                                this.tipoModal=5; //carga tipos de campos y footers
                                this.tituloModal='Generando, por favor espere...';
                                this.identificador=identificador;
                                break;
                            }
                        }
                        this.generarDetalle(this.identificador);
                        break;
                    }

            }

            },
            listarCiclos(page,buscar,criterio,identificador){
                let me=this;
                var url='/tiempoestandar/listarciclos?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio + '&identificador=' + identificador;
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayCiclos=respuesta.ciclos.data;
                me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            crearCiclos(){
                //valido con el metodo de validacion creado
                if(this.validarCiclos()){
                    return;
                }

                let me=this;
                axios.post('/tiempoestandar/guardarciclos',{
                    'idCiclos': this.idCiclos,
                    'tiempo': this.tiempo,
                    'piezas': this.piezas,
                    'idTiempoEstandar':this.idTiempoEstandar

                }).then(function (response) {
                me.cerrarModal();
                me.forceRerender();
                me.listarCiclos(1,'','ciclos');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            validarCiclos(){
                this.errorCiclos=0;
                this.errorMensaje=[];
                if (!this.tiempo) this.errorMensaje.push("El tiempo en ciclos no puede estar vacio");
                if (!this.piezas) this.errorMensaje.push("las piezas no pueden estar vacias");
                if (this.errorMensaje.length) this.errorCiclos=1;

                return this.errorCiclos;
            },
            listarWestingHouse(page,buscar,criterio,identificador){
                let me=this;
                var url='/tiempoestandar/listarwesting?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio + '&identificador=' + identificador;
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayWesting=respuesta.westinghouse.data;
                me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            crearHabilidades(){
                //valido con el metodo de validacion creado
                if(this.validarHabilidades()){
                    return;
                }
                let me=this;
                axios.post('/tiempoestandar/guardarHabilidad',{
                    'rango': this.rango,
                    'porcentaje': this.porcentaje,
                    'clasificacion':this.clasificacion
                }).then(function (response) {
                me.cerrarModal();
                me.forceRerender();
                me.listarWestingHouse(1,'','westinghouse');
                })
                .catch(function (error) {
                    console.log(error);
                });
            }, 
            validarHabilidades(){
                this.errorWestingHouse=0;
                this.errorMensaje=[];
                if (!this.rango) this.errorMensaje.push("El rango no puede estar vacio");
                if (!this.porcentaje) this.errorMensaje.push("El porcentaje no puede estar vacio");
                if (!this.clasificacion) this.errorMensaje.push("La clasificación no puede estar vacio");
                if (this.errorMensaje.length) this.errorWestingHouse=1;
                
                return this.errorWestingHouse;
            },
            crearEsfuerzo(){
                //valido con el metodo de validacion creado
                if(this.validarEsfuerzo()){
                    return;
                }
                let me=this;
                axios.post('/tiempoestandar/guardarEsfuerzo',{
                    'rango': this.rango,
                    'porcentaje': this.porcentaje,
                    'clasificacion':this.clasificacion
                }).then(function (response) {
                me.cerrarModal();
                me.forceRerender();
                me.listarWestingHouse(1,'','westinghouse');
                })
                .catch(function (error) {
                    console.log(error);
                });
            }, 
            validarEsfuerzo(){
                this.errorWestingHouse=0;
                this.errorMensaje=[];
                if (!this.rango) this.errorMensaje.push("El rango no puede estar vacio");
                if (!this.porcentaje) this.errorMensaje.push("El porcentaje no puede estar vacio");
                if (!this.clasificacion) this.errorMensaje.push("La clasificación no puede estar vacio");
                if (this.errorMensaje.length) this.errorWestingHouse=1;

                return this.errorWestingHouse;
            },     
            crearCondiciones(){
                //valido con el metodo de validacion creado
                if(this.validarCondiciones()){
                    return;
                }
                let me=this;
                axios.post('/tiempoestandar/guardarCondiciones',{
                    'rango': this.rango,
                    'porcentaje': this.porcentaje,
                    'clasificacion':this.clasificacion
                }).then(function (response) {
                me.cerrarModal();
                me.forceRerender();
                me.listarWestingHouse(1,'','westinghouse');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            validarCondiciones(){
                this.errorWestingHouse=0;
                this.errorMensaje=[];
                if (!this.rango) this.errorMensaje.push("El rango no puede estar vacio");
                if (!this.porcentaje) this.errorMensaje.push("El porcentaje no puede estar vacio");
                if (!this.clasificacion) this.errorMensaje.push("La clasificación no puede estar vacio");
                if (this.errorMensaje.length) this.errorWestingHouse=1;

                return this.errorWestingHouse;
            },    
            crearConsistencia(){
                //valido con el metodo de validacion creado
                if(this.validarConsistencia()){
                    return;
                }
                let me=this;
                axios.post('/tiempoestandar/guardarConsistencia',{
                    'rango': this.rango,
                    'porcentaje': this.porcentaje,
                    'clasificacion':this.clasificacion
                }).then(function (response) {
                me.cerrarModal();
                me.forceRerender();
                me.listarWestingHouse(1,'','westinghouse');
                })
                .catch(function (error) {
                    console.log(error);
                });
            }, 
            validarConsistencia(){
                this.errorWestingHouse=0;
                this.errorMensaje=[];
                if (!this.rango) this.errorMensaje.push("El rango no puede estar vacio");
                if (!this.porcentaje) this.errorMensaje.push("El porcentaje no puede estar vacio");
                if (!this.clasificacion) this.errorMensaje.push("La clasificación no puede estar vacio");
                if (this.errorMensaje.length) this.errorWestingHouse=1;

                return this.errorWestingHouse;
            },
            listarPds(page,buscar,criterio,identificador){
                let me=this;
                var url='/tiempoestandar/listarpds?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio + '&identificador=' + identificador;
                axios.get(url).then(function (response) {
                var respuesta=response.data;
                me.arrayPds=respuesta.pds.data;
                me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            crearEsfuerzoMental(){
                //valido con el metodo de validacion creado
                if(this.validarEsfuerzoMental()){
                    return;
                }
                let me=this;
                axios.post('/tiempoestandar/guardarEsfuerzoMental',{
                    'grado': this.grado,
                    'porcentaje': this.porcentaje,
                    'idTiempo':this.idTiempo
                }).then(function (response) {
                me.cerrarModal();
                me.forceRerender();
                me.listarPds(1,'','pds');
                })
                .catch(function (error) {
                    console.log(error);
                });
            }, 
            validarEsfuerzoMental(){
                this.errorPds=0;
                this.errorMensaje=[];
                if (!this.grado) this.errorMensaje.push("El grado no puede estar vacio");
                if (!this.porcentaje) this.errorMensaje.push("El porcentaje no puede estar vacio");
                if (this.errorMensaje.length) this.errorPds=1;
                
                return this.errorPds;
            },
            crearEsfuerzoFisico(){
                //valido con el metodo de validacion creado
                if(this.validarEsfuerzoFisico()){
                    return;
                }
                let me=this;
                axios.post('/tiempoestandar/guardarEsfuerzoFisico',{
                    'grado': this.grado,
                    'porcentaje': this.porcentaje
                }).then(function (response) {
                me.cerrarModal();
                me.forceRerender();
                me.listarPds(1,'','pds');
                })
                .catch(function (error) {
                    console.log(error);
                });
            }, 
            validarEsfuerzoFisico(){
                this.errorPds=0;
                this.errorMensaje=[];
                if (!this.grado) this.errorMensaje.push("El grado no puede estar vacio");
                if (!this.porcentaje) this.errorMensaje.push("El porcentaje no puede estar vacio");
                if (this.errorMensaje.length) this.errorPds=1;
                
                return this.errorPds;
            },
            crearSuplementarios(){
                //valido con el metodo de validacion creado
                if(this.validarSuplementarios()){
                    return;
                }
                let me=this;
                axios.post('/tiempoestandar/guardarSuplementarios',{
                    'grado': this.grado,
                    'porcentaje': this.porcentaje
                }).then(function (response) {
                me.cerrarModal();
                me.forceRerender();
                me.listarPds(1,'','pds');
                })
                .catch(function (error) {
                    console.log(error);
                });
            }, 
           validarSuplementarios(){
                this.errorPds=0;
                this.errorMensaje=[];
                if (!this.grado) this.errorMensaje.push("El grado no puede estar vacio");
                if (!this.porcentaje) this.errorMensaje.push("El porcentaje no puede estar vacio");
                if (this.errorMensaje.length) this.errorPds=1;
                
                return this.errorPds;
            },
            crearPersonales(){
                //valido con el metodo de validacion creado
                if(this.validarPersonales()){
                    return;
                }
                let me=this;
                axios.post('/tiempoestandar/guardarPersonales',{
                    'rango': this.rango,
                    'porcentajeHombre': this.porcentajeHombre,
                    'porcentajeMujer':this.porcentajeMujer
                }).then(function (response) {
                me.cerrarModal();
                me.forceRerender();
                me.listarPds(1,'','pds');
                })
                .catch(function (error) {
                    console.log(error);
                });
            }, 
            validarPersonales(){
                this.errorPds=0;
                this.errorMensaje=[];
                if (!this.rango) this.errorMensaje.push("El rango no puede estar vacio");
                if (!this.porcentajeHombre) this.errorMensaje.push("El porcentaje hombre no puede estar vacio");
                if (!this.porcentajeMujer) this.errorMensaje.push("El porcentaje mujer no puede estar vacio");
                if (this.errorMensaje.length) this.errorPds=1;
                
                return this.errorPds;
            },            
        },
        mounted() {
            this.listarTiempoEstandar(1,this.buscar,this.criterio),
            this.listarEmpleados();
        }
    }
</script>
<style>
    .fadebox {
	display: none;
	position: absolute;
	top: 0%;
	left: 0%;
	width: 100%;
	height: 100%;
	background-color: black;
	z-index:3001;
	-moz-opacity: 0.8;
	opacity:.80;
	filter: alpha(opacity=80);
    }
    .overbox {
        display: none;
        position: absolute;
        top: 5%;
        left: 5%;
        width: 90%;
        height: 90%;
        z-index:3002;
        overflow: auto;
    }
    #content {
        background: transparent;
        border: solid 3px transparent;
        padding: 10px;
    }
    .cierre {
        font-weight: 9rem;
        color:#FFFFFF;
    }
    .imglight{
        max-height:500px;
    }
    .cursor{
        cursor: pointer;
    }
</style>
