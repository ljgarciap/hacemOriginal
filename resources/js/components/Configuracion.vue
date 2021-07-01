<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Variables de Configuración</li>
                </ol>

                    <!-- Ejemplo de tabla Listado -->

                    <!-- Detalle -->
                    <template>
                        <div class="container-fluid">
                            <div class="card">

                                <vs-tabs :color="colorx">

                                <vs-tab label="Variables Globales" icon="open_with" @click="colorx = '#CB3234'">

                                    <div class="card-body">

                                    </div>

                                </vs-tab>

                                <vs-tab label="Variables Empleado" icon="account_balance" @click="colorx = '#F84E13'">

                                    <div class="card-body">

                                    </div>

                                </vs-tab>

                                <vs-tab label="Variables Adicionales" icon="pan_tool" @click="colorx = '#4611DC'">

                                    <div class="card-body">

                                    </div>

                                </vs-tab>

                                <vs-tab label="Cerrar" icon="cancel_schedule_send" @click="ocultarDetalle()">
                                </vs-tab>

                                </vs-tabs>
                            </div>
                        </div>
                    </template>
                    <!-- Fin Detalle -->

        </main>
</template>

<script>
    export default {
        data(){
            return{
                colorx:'#8B0000',
            }
        },
        methods : {
            indexChange: function(args) {
                let newIndex = args.value
                console.log('Current tab index: ' + newIndex)
                },
            ocultarDetalle(){
                this.listado=1;
                this.identificador=0;
            }
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
