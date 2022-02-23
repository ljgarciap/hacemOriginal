<template>
        <main class="main">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Variables de Configuración</li>
                </ol>

                    <!-- Detalle -->
                    <template>
                        <div class="container-fluid">
                            <div class="card">

                                <vs-tabs :color="colorx">

                                <vs-tab label="Configuración Básica" icon="open_with" @click="colorx = '#CB3234'">

                                    <div class="card-body">
                                        <globales></globales>
                                    </div>

                                </vs-tab>

                                <vs-tab label="Variables Globales" icon="account_balance" @click="colorx = '#F84E13'">

                                    <div class="card-body">
                                         <financieras></financieras>
                                    </div>

                                </vs-tab>

                                <vs-tab label="Factores de Nómina" icon="pan_tool" @click="colorx = '#4611DC'">

                                    <div class="card-body">
                                         <factores></factores>
                                    </div>

                                </vs-tab>

                                </vs-tabs>
                            </div>
                        </div>
                    </template>
                    <!-- Fin Detalle -->

        </main>
</template>

<script>
    import Financieras from './Financieras.vue';
    import Globales from './Globales.vue';
    export default {
        components: {
            Financieras,
            Globales
        },
        data(){
            return{
                colorx:'#8B0000',
            }
        },
        methods : {
            indexChange: function(args) {
                let newIndex = args.value
                console.log('Current tab index: ' + newIndex)
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
