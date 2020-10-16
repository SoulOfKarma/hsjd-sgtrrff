<template>
    <div>
        <vs-row>
            <div
                class="router-header flex flex-wrap items-center mb-6"
                style="margin-left:10px;"
            >
                <div
                    class="content-area__heading pr-4 border-0 md:border-r border-solid border-grey-light"
                >
                    <h2 class="mb-1">
                        Registrar nuevo Usuario Cargo Jefatura
                    </h2>
                </div>
                <div class="vx-breadcrumb ml-4 md:block hidden">
                    <div
                        class="content-area__heading pr-4 border-0 md:border-r border-solid border-grey-light"
                    >
                        <h3 class="mb-1">
                            Usuario:
                            <strong>{{ dataUsuarioCreador.nombre }}</strong>
                        </h3>
                    </div>
                </div>
            </div>
            <!-- Usuario -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="1. Ingrese Datos del Usuario">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.1 Nombre del Usuario</h6>
                            <vs-input
                                class="vx-col w-full mt-5"
                                v-model="nombreUsuario"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.2 Apellido del Usuario</h6>
                            <vs-input
                                class="vx-col w-full mt-5"
                                v-model="apellidoUsuario"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.3 Cargo del Usuario</h6>
                            <vs-input
                                class="vx-col w-full mt-5"
                                v-model="nombreUsuario"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.4 Anexo del Usuario</h6>
                            <vs-input
                                class="vx-col w-full mt-5"
                                v-model="nombreUsuario"
                            />
                        </div>
                        <div class="vx-col w-full mt-5">
                            <h6>1.5 Correo del Usuario</h6>
                            <vs-input
                                class="vx-col w-full mt-5"
                                v-model="nombreUsuario"
                            />
                        </div>
                    </div>
                </vx-card>
            </div>
            <!-- Ubicacion -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="2. Lugar del problema">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-1/3 mt-5">
                            <h6>2.1 - Seleccione el Edificio</h6>
                            <br />
                            <v-select
                                v-model="seleccionEdificio"
                                placeholder="Edificio"
                                class="w-full select-large"
                                label="descripcionEdificio"
                                :options="listadoEdificios"
                            ></v-select>
                        </div>
                        <div class="vx-col w-1/3 mt-5">
                            <h6>2.2 - Seleccione el Servicio</h6>
                            <br />
                            <v-select
                                v-model="seleccionServicio"
                                placeholder="Servicio"
                                class="w-full select-large"
                                label="descripcionServicio"
                                :options="listadoServicios"
                                @input="cargaSegunServicio"
                            ></v-select>
                        </div>
                        <div class="vx-col w-1/3 mt-5">
                            <h6>2.3 - Seleccione la Unidad Especifica</h6>
                            <br />
                            <v-select
                                v-model="seleccionUnidadEsp"
                                placeholder="Unidad Especifica"
                                class="w-full select-large"
                                label="descripcionUnidadEsp"
                                :options="listadoUnidadEsp"
                                @input="cargaSegunUnidadEsp"
                            ></v-select>
                        </div>
                    </div>
                </vx-card>
            </div>
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row">
                    <div class="vx-col sm:w-2/3 w-full ml-auto">
                        <vs-button
                            color="warning"
                            class="mr-3 mb-2"
                            @click="limpiar"
                            >Limpiar</vs-button
                        >
                        <vs-button class="mb-2" @click="guardar"
                            >Enviar</vs-button
                        >
                    </div>
                </div>
            </div>
        </vs-row>
    </div>
</template>
<script>
import Datepicker from "vuejs-datepicker";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import { FormWizard, TabContent } from "vue-form-wizard";
import "vue-form-wizard/dist/vue-form-wizard.min.css";
import axios from "axios";
import vSelect from "vue-select";
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import { Validator } from "vee-validate";
import router from "@/router";
import { quillEditor } from "vue-quill-editor";
export default {
    data() {
        return {
            localVal: "http://127.0.0.1:8000",
            nombreUsuario: "",
            apellidoUsuario: "",
            listadoEdificios: [],
            listadoServicios: [],
            listadoUnidadEsp: [],
            seleccionEdificio: {
                id: 0,
                descripcionEdificio: "Seleccione Edificio"
            },
            seleccionServicio: {
                id: 0,
                descripcionServicio: "Seleccione Servicio"
            },
            seleccionUnidadEsp: {
                id: 0,
                descripcionUnidadEsp: "Seleccion Unidad Especifica"
            },
            dataUsuarioCreador: {
                nombre: localStorage.getItem("nombre"),
                id_user: localStorage.getItem("id")
            }
        };
    },
    methods: {
        limpiar() {},
        guardar() {},
        cargaSegunUnidadEsp() {
            var idGeneral = this.seleccionUnidadEsp.id;

            let c = this.listadoUnidadEsp;
            let b = [];
            var a = 0;

            c.forEach((value, index) => {
                a = value.id;
                if (a == idGeneral) {
                    b.push(value);
                }
            });
            this.seleccionUnidadEsp = b;
            idGeneral = 0;
            idGeneral = this.seleccionUnidadEsp[0].id_servicio;
            b = [];

            c = this.listadoServicios;

            c.forEach((value, index) => {
                a = value.id;
                if (a == idGeneral) {
                    b.push(value);
                }
            });

            this.seleccionServicio = b;
            idGeneral = 0;
            idGeneral = this.seleccionServicio[0].id_edificio;
            b = [];
            c = this.listadoEdificios;

            c.forEach((value, index) => {
                a = value.id;
                if (a == idGeneral) {
                    b.push(value);
                }
            });

            this.seleccionEdificio = b;
        },
        cargaSegunServicio() {
            var idGeneral = this.seleccionServicio.id;

            let c = this.listadoServicios;
            let b = [];
            var a = 0;

            c.forEach((value, index) => {
                a = value.id;
                if (a == idGeneral) {
                    b.push(value);
                }
            });
            this.seleccionServicio = b;
            idGeneral = 0;
            idGeneral = this.seleccionServicio[0].id_edificio;
            b = [];

            c = this.listadoEdificios;

            c.forEach((value, index) => {
                a = value.id;
                if (a == idGeneral) {
                    b.push(value);
                }
            });

            this.seleccionEdificio = b;
        },
        cargarEdificios() {
            this.csrf_token;

            axios.get(this.localVal + "/api/Usuario/GetEdificios").then(res => {
                this.listadoEdificios = res.data;
            });
        },
        cargarServicios() {
            this.csrf_token;

            axios.get(this.localVal + "/api/Usuario/GetServicios").then(res => {
                this.listadoServicios = res.data;
            });
        },
        cargarUnidadEsp() {
            this.csrf_token;

            axios.get(this.localVal + "/api/Usuario/GetUnidadEsp").then(res => {
                this.listadoUnidadEsp = res.data;
            });
        }
    },
    created() {
        this.cargarEdificios();
        this.cargarServicios();
        this.cargarUnidadEsp();
    },
    components: {
        "v-select": vSelect,
        quillEditor
    }
};
</script>
