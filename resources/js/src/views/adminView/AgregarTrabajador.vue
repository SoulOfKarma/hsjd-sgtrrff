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
                        Registrar nuevo Trabajador
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
                            <h6>1.1 Rut del Trabajador</h6>
                            <vs-input
                                class="vx-col w-full mt-5"
                                v-model="rutUsuario"
                                v-on:blur="formatear_run"
                            />
                            <span
                                style="font-size: 10px; color: red; margin-left: 10px;"
                                v-if="val_run"
                                >Run incorrecto</span
                            >
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.2 Nombre del Trabajador</h6>
                            <vs-input
                                class="vx-col w-full mt-5"
                                v-model="nombreUsuario"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.3 Apellido del Trabajador</h6>
                            <vs-input
                                class="vx-col w-full mt-5"
                                v-model="apellidoUsuario"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.4 Anexo del Trabajador</h6>
                            <vs-input
                                type="number"
                                class="vx-col w-full mt-5"
                                v-model="anexoUsuario"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.5 Correo del Trabajador</h6>
                            <vs-input
                                type="email"
                                class="vx-col w-full mt-5"
                                v-model="correoUsuario"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.6 Contraseña del Trabajador</h6>
                            <vs-input
                                type="password"
                                class="vx-col w-full mt-5"
                                v-model="passUsuario"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.7 - Seleccione Supervisor</h6>
                            <br />
                            <v-select
                                v-model="seleccionSupervisor"
                                placeholder="Supervisor"
                                class="w-full select-large"
                                label="nombreSupervisor"
                                :options="listadoSupervisores"
                                @input="arraySupervisor"
                            ></v-select>
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.8 - Seleccione Especialidad</h6>
                            <br />
                            <v-select
                                v-model="seleccionEspecialidad"
                                placeholder="Especialidad"
                                class="w-full select-large"
                                label="descripcionEspecialidad"
                                :options="listadoEspecialidad"
                                @input="arrayEspecialidad"
                            ></v-select>
                        </div>
                    </div>
                </vx-card>
            </div>
            <!-- Ubicacion -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="2. Ubicacion del Usuario">
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
                                @input="filtroSegunEdificio"
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
import { validate, clean, format } from "rut.js";
export default {
    data() {
        return {
            localVal: "http://127.0.0.1:8000",
            nombreUsuario: "",
            apellidoUsuario: "",
            anexoUsuario: 0,
            correoUsuario: "",
            rutUsuario: "",
            passUsuario: "",
            listadoSupervisores: [],
            listadoEdificios: [],
            listadoServicios: [],
            listadoUnidadEsp: [],
            listadoServiciosData: [],
            listadoUnidadEspData: [],
            listadoEspecialidad: [],
            seleccionEspecialidad: {
                id: 0,
                descripcionEspecialidad: "Seleccion Especialidad"
            },
            seleccionSupervisor: {
                id: 0,
                nombreSupervisor: "Seleccione Supervisor"
            },
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
                nombre:
                    localStorage.getItem("nombre") +
                    " " +
                    localStorage.getItem("apellido"),
                id_user: localStorage.getItem("id")
            },
            val_run: false,
            registroUsuario: {
                run: "",
                email: "",
                nombre: "",
                apellido: "",
                anexo: "",
                id_cargo: 0,
                id_cargo_asociado: 0,
                id_edificio: 0,
                id_servicio: 0,
                id_unidadEspecifica: 0,
                password: "",
                run_usuario: "",
                permiso_usuario: 3,
                estado_login: 1,
                tra_run: "",
                tra_nombre: "",
                tra_apellido: "",
                id_especialidad1: 0
            }
        };
    },
    methods: {
        formatear_run() {
            this.rutUsuario = format(this.rutUsuario);
            this.val_run = !validate(this.rutUsuario);
        },
        limpiar() {
            this.registroUsuario.run = "";
            this.registroUsuario.email = "";
            this.registroUsuario.nombre = "";
            this.registroUsuario.apellido = "";
            this.registroUsuario.anexo = 0;
            this.registroUsuario.id_cargo = 0;
            this.registroUsuario.id_edificio = 0;
            this.registroUsuario.id_servicio = 0;
            this.registroUsuario.id_unidadEspecifica = 0;
            this.registroUsuario.password = "";
            this.registroUsuario.run_usuario = "";
            this.registroUsuario.tra_run = "";
            this.registroUsuario.tra_nombre = "";
            this.registroUsuario.tra_apellido = "";
            this.registroUsuario.id_especialidad1 = 0;

            this.seleccionCargo = [
                {
                    id: 0,
                    descripcionCargo: "Seleccione Cargo"
                }
            ];
            this.seleccionEdificio = [
                {
                    id: 0,
                    descripcionEdificio: "Seleccione Edificio"
                }
            ];
            this.seleccionServicio = [
                {
                    id: 0,
                    descripcionServicio: "Seleccione Servicio"
                }
            ];
            this.seleccionUnidadEsp = [
                {
                    id: 0,
                    descripcionUnidadEsp: "Seleccion Unidad Especifica"
                }
            ];
            this.seleccionEspecialidad = [
                {
                    id: 0,
                    descripcionEspecialidad: "Seleccion Especialidad"
                }
            ];
            this.nombreUsuario = "";
            this.apellidoUsuario = "";
            this.anexoUsuario = 0;
            this.correoUsuario = "";
            this.rutUsuario = "";
            this.passUsuario = "";
        },
        guardar() {
            if (
                this.seleccionSupervisor[0] == null ||
                this.seleccionSupervisor[0].id == 0
            ) {
                this.$vs.notify({
                    title: "Error en Seleccionar al supervisor",
                    text: "Debe seleccionar a un supervisor para continuar",
                    color: "danger",
                    position: "top-right",
                    time: 3000
                });
            } else if (
                this.seleccionEspecialidad[0] == null ||
                this.seleccionEspecialidad[0].id == 0
            ) {
                this.$vs.notify({
                    title: "Error en Seleccionar la especialidad",
                    text: "Debe seleccionar a una especialidad para continuar",
                    color: "danger",
                    position: "top-right",
                    time: 3000
                });
            } else if (
                this.seleccionEdificio[0] == null ||
                this.seleccionEdificio[0].id == null
            ) {
                this.$vs.notify({
                    title: "Error en Seleccionar el edificio",
                    text: "Debe seleccionar a un edificio para continuar",
                    color: "danger",
                    position: "top-right",
                    time: 3000
                });
            } else if (
                this.seleccionServicio[0] == null ||
                this.seleccionServicio[0].id == 0
            ) {
                this.$vs.notify({
                    title: "Error en Seleccionar el servicio",
                    text: "Debe seleccionar a un servicio para continuar",
                    color: "danger",
                    position: "top-right",
                    time: 3000
                });
            } else if (
                this.seleccionUnidadEsp[0] == null ||
                this.seleccionUnidadEsp[0].id == 0
            ) {
                this.$vs.notify({
                    title: "Error en Seleccionar la ubicacion especifica",
                    text:
                        "Debe seleccionar a una ubicacion especifica para continuar",
                    color: "danger",
                    position: "top-right",
                    time: 3000
                });
            } else {
                this.registroUsuario.run = this.rutUsuario;
                this.registroUsuario.email = this.correoUsuario;
                this.registroUsuario.nombre = this.nombreUsuario;
                this.registroUsuario.apellido = this.apellidoUsuario;
                this.registroUsuario.anexo = this.anexoUsuario;
                this.registroUsuario.id_cargo = 6;
                this.registroUsuario.id_cargo_asociado = this.seleccionSupervisor[0].id;
                this.registroUsuario.id_edificio = this.seleccionEdificio[0].id;
                this.registroUsuario.id_servicio = this.seleccionServicio[0].id;
                this.registroUsuario.id_unidadEspecifica = this.seleccionUnidadEsp[0].id;
                this.registroUsuario.password = this.passUsuario;
                this.registroUsuario.run_usuario = this.rutUsuario;
                this.registroUsuario.tra_run = this.rutUsuario;
                this.registroUsuario.tra_nombre = this.nombreUsuario;
                this.registroUsuario.tra_apellido = this.apellidoUsuario;
                this.registroUsuario.id_especialidad1 = this.seleccionEspecialidad[0].id;
                this.rutUsuario = format(this.rutUsuario);
                if (
                    this.registroUsuario.run == null ||
                    this.registroUsuario.run < 9 ||
                    !validate(this.rutUsuario)
                ) {
                    this.$vs.notify({
                        title: "Error en rut",
                        text:
                            "Debe Escribir un rut valido,que no este el campo vacio y que sea mayor a 9 caracteres",
                        color: "danger",
                        position: "top-right",
                        time: 3000
                    });
                } else if (
                    this.registroUsuario.email == null ||
                    this.registroUsuario.email < 10
                ) {
                    this.$vs.notify({
                        title: "Error en correo",
                        text:
                            "Debe Escribir un correo valido y que no este el campo vacio",
                        color: "danger",
                        position: "top-right",
                        time: 3000
                    });
                } else {
                    const registro = this.registroUsuario;

                    axios
                        .post(
                            this.localVal + "/api/Agente/GuardarTrabajador",
                            registro
                        )
                        .then(res => {
                            this.limpiar();
                            const ticketServer = res.data;
                            this.$vs.notify({
                                title: "Trabajador Agregado Correctamente",
                                text: "Se recargaran los campos",
                                color: "success",
                                position: "top-right",
                                time: 3000
                            });
                        });
                }
            }
        },
        filtroSegunEdificio() {
            if (this.seleccionEdificio == null || this.seleccionEdificio == 0) {
                this.listadoServicios = this.listadoServiciosData;
                this.listadoUnidadEsp = this.listadoUnidadEspData;
            } else {
                var idGeneral = this.seleccionEdificio.id;
                let c = this.listadoServiciosData;
                let b = [];
                var a = 0;
                c.forEach((value, index) => {
                    a = value.id_edificio;
                    if (a == idGeneral) {
                        b.push(value);
                    }
                });

                this.listadoServicios = b;
                //Dejando como Array la seleccion de edificio
                c = this.listadoEdificios;
                b = [];
                c.forEach((value, index) => {
                    a = value.id;
                    if (a == idGeneral) {
                        b.push(value);
                    }
                });

                this.seleccionEdificio = b;
            }
        },
        cargaSegunUnidadEsp() {
            if (
                this.seleccionUnidadEsp == null ||
                this.seleccionUnidadEsp.id == 0
            ) {
                //this.listadoServicios = this.listadoServiciosData;
                this.listadoUnidadEsp = this.listadoUnidadEspData;
            } else {
                var idGeneral = this.seleccionUnidadEsp.id;

                let c = this.listadoUnidadEspData;
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
            }
        },
        arrayEspecialidad() {
            let id = this.seleccionEspecialidad.id;
            let c = this.listadoEspecialidad;
            let b = [];
            let a = 0;
            c.forEach((value, index) => {
                a = value.id;
                if (a == id) {
                    b.push(value);
                }
            });
            this.seleccionEspecialidad = b;
        },
        arraySupervisor() {
            let id = this.seleccionSupervisor.id;
            let c = this.listadoSupervisores;
            let b = [];
            let a = 0;
            c.forEach((value, index) => {
                a = value.id;
                if (a == id) {
                    b.push(value);
                }
            });
            this.seleccionSupervisor = b;
        },
        cargaSegunServicio() {
            if (
                this.seleccionServicio == null ||
                this.seleccionServicio.id == 0
            ) {
                this.listadoServicios = this.listadoServiciosData;
                this.listadoUnidadEsp = this.listadoUnidadEspData;
            } else {
                var idGeneral = this.seleccionServicio.id;

                let d = this.listadoUnidadEspData;
                let e = [];
                var f = 0;

                d.forEach((value, index) => {
                    a = value.id_servicio;
                    if (a == idGeneral) {
                        e.push(value);
                    }
                });

                this.listadoUnidadEsp = e;

                let c = this.listadoServiciosData;
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
            }
        },
        cargarSupervisores() {
            axios
                .get(this.localVal + "/api/Agente/getSupervisores")
                .then(res => {
                    this.listadoSupervisores = res.data;
                    let b = [];
                    let c = this.listadoSupervisores;
                    c.forEach((value, index) => {
                        b.push(value);
                    });
                    this.listadoSupervisores = b;
                });
        },
        cargarEspecialidad() {
            axios
                .get(this.localVal + "/api/Agente/getEspecialidad")
                .then(res => {
                    this.listadoEspecialidad = res.data;
                    let b = [];
                    let c = this.listadoEspecialidad;
                    c.forEach((value, index) => {
                        b.push(value);
                    });
                    this.listadoEspecialidad = b;
                });
        },
        cargarEdificios() {
            axios.get(this.localVal + "/api/Usuario/GetEdificios").then(res => {
                this.listadoEdificios = res.data;
                let b = [];
                let c = this.listadoEdificios;
                c.forEach((value, index) => {
                    b.push(value);
                });
                this.listadoEdificios = b;
            });
        },

        cargarServicios() {
            axios.get(this.localVal + "/api/Usuario/GetServicios").then(res => {
                this.listadoServicios = res.data;
                this.listadoServiciosData = res.data;
                let b = [];
                let c = this.listadoServicios;
                c.forEach((value, index) => {
                    b.push(value);
                });
                this.listadoServicios = b;
            });
        },
        cargarUnidadEsp() {
            axios.get(this.localVal + "/api/Usuario/GetUnidadEsp").then(res => {
                this.listadoUnidadEsp = res.data;
                this.listadoUnidadEspData = res.data;
                let b = [];
                let c = this.listadoUnidadEsp;
                c.forEach((value, index) => {
                    b.push(value);
                });
                this.listadoUnidadEsp = b;
            });
        }
    },
    created() {
        this.cargarEdificios();
        this.cargarServicios();
        this.cargarUnidadEsp();
        this.cargarEspecialidad();
        this.cargarSupervisores();
    },
    components: {
        "v-select": vSelect,
        quillEditor
    }
};
</script>
