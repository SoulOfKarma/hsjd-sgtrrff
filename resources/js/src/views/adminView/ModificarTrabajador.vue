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
                        Modificar datos de trabajadores existentes
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
            <!-- Seleccion del trabajador -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="1. Seleccionar Usuario Solicitante" c>
                    <div class="vx-row mb-12">
                        <div class="vx-col w-full mt-5">
                            <h6>1.1 - Seleccione Al usuario</h6>
                            <br />
                            <v-select
                                v-model="seleccionTrabajador"
                                placeholder="Seleccione al Usuario"
                                class="w-full select-large"
                                label="nombreTrabajador"
                                :options="listadoTrabajadores"
                                @input="cargarTrabajadorSeleccionado"
                            ></v-select>
                        </div>
                    </div>
                </vx-card>
            </div>
            <!-- Trabajador -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="2. Ingrese Datos del Trabajador">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-1/2 mt-5">
                            <h6>2.1 Rut del Trabajador</h6>
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
                            <h6>2.2 Nombre del Trabajador</h6>
                            <vs-input
                                class="vx-col w-full mt-5"
                                v-model="nombreUsuario"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>2.3 Apellido del Trabajador</h6>
                            <vs-input
                                class="vx-col w-full mt-5"
                                v-model="apellidoUsuario"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>2.4 Anexo del Trabajador</h6>
                            <vs-input
                                class="vx-col w-full mt-5"
                                v-model="anexoUsuario"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>2.5 Correo del Trabajador</h6>
                            <vs-input
                                type="email"
                                class="vx-col w-full mt-5"
                                v-model="correoUsuario"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>2.6 Contraseña del Trabajador</h6>
                            <vs-input
                                type="password"
                                class="vx-col w-full mt-5"
                                v-model="passUsuario"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>2.7 - Seleccione Supervisor</h6>
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
                            <h6>2.8 - Seleccione Especialidad</h6>
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
                <vx-card title="3. Ubicacion del Trabajador">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-1/3 mt-5">
                            <h6>3.1 - Seleccione el Edificio</h6>
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
                            <h6>3.2 - Seleccione el Servicio</h6>
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
                            <h6>3.3 - Seleccione la Unidad Especifica</h6>
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
                        <vs-button class="mb-2" @click="modificar"
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
            listadoTrabajadores: [],
            listadoSupervisores: [],
            listadoEdificios: [],
            listadoServicios: [],
            listadoUnidadEsp: [],
            listadoServiciosData: [],
            listadoUnidadEspData: [],
            listadoEspecialidad: [],
            seleccionTrabajador: {
                id: 0,
                nombreTrabajador: "Seleccione Trabajador"
            },
            seleccionEspecialidad: {
                id: 0,
                descripcionEspecialidad: "Seleccione Especialidad "
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
                    sessionStorage.getItem("nombre") +
                    " " +
                    sessionStorage.getItem("apellido"),
                id_user: sessionStorage.getItem("id")
            },
            val_run: false,
            modificarUsuario: {
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
                id_especialidad1: 0,
                id: 0
            }
        };
    },
    methods: {
        formatear_run() {
            this.rutUsuario = format(this.rutUsuario);
            this.val_run = !validate(this.rutUsuario);
        },
        cargarTrabajadorSeleccionado() {
            let id = this.seleccionTrabajador.id;
            let c = this.listadoTrabajadores;
            let b = [];
            let a = 0;
            c.forEach((value, index) => {
                a = value.id;
                if (a == id) {
                    b.push(value);
                }
            });

            this.seleccionTrabajador = b;

            this.nombreUsuario = b[0].nombre;
            this.rutUsuario = b[0].run;
            this.apellidoUsuario = b[0].apellido;
            this.anexoUsuario = b[0].anexo;
            this.correoUsuario = b[0].email;

            let idEspecialidad = b[0].id_especialidad1;
            let idSupervisor = b[0].id_cargo_asociado;
            let idEdificio = b[0].id_edificio;
            let idServicio = b[0].id_servicio;
            let idUnidadEsp = b[0].id_unidadEspecifica;

            b = [];
            c = this.listadoEspecialidad;
            c.forEach((value, index) => {
                a = value.id;
                if (a == idEspecialidad) {
                    b.push(value);
                }
            });

            this.seleccionEspecialidad = b;

            b = [];
            c = this.listadoSupervisores;
            c.forEach((value, index) => {
                a = value.id_user;
                if (a == idSupervisor) {
                    b.push(value);
                }
            });

            this.seleccionSupervisor = b;
            b = [];
            c = this.listadoEdificios;
            c.forEach((value, index) => {
                a = value.id;
                if (a == idEdificio) {
                    b.push(value);
                }
            });

            this.seleccionEdificio = b;

            b = [];
            c = this.listadoServicios;
            c.forEach((value, index) => {
                a = value.id;
                if (a == idServicio) {
                    b.push(value);
                }
            });

            this.seleccionServicio = b;

            b = [];
            c = this.listadoUnidadEsp;
            c.forEach((value, index) => {
                a = value.id;
                if (a == idUnidadEsp) {
                    b.push(value);
                }
            });

            this.seleccionUnidadEsp = b;
        },
        limpiar() {
            this.modificarUsuario.run = "";
            this.modificarUsuario.email = "";
            this.modificarUsuario.nombre = "";
            this.modificarUsuario.apellido = "";
            this.modificarUsuario.anexo = 0;
            this.modificarUsuario.id_cargo = 0;
            this.modificarUsuario.id_edificio = 0;
            this.modificarUsuario.id_servicio = 0;
            this.modificarUsuario.id_unidadEspecifica = 0;
            this.modificarUsuario.password = "";
            this.modificarUsuario.run_usuario = "";
            this.modificarUsuario.tra_run = "";
            this.modificarUsuario.tra_nombre = "";
            this.modificarUsuario.tra_apellido = "";
            this.modificarUsuario.id_especialidad1 = 0;

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
                    descripcionEspecialidad: "Seleccione Especialidad"
                }
            ];
            this.seleccionTrabajador = [
                {
                    id: 0,
                    nombreTrabajador: "Seleccione Trabajador"
                }
            ];
            this.nombreUsuario = "";
            this.apellidoUsuario = "";
            this.anexoUsuario = 0;
            this.correoUsuario = "";
            this.rutUsuario = "";
            this.passUsuario = "";
        },
        modificar() {
            if (
                this.seleccionTrabajador[0] == null ||
                this.seleccionTrabajador[0].id == 0 ||
                this.seleccionTrabajador[0].id == null
            ) {
                this.$vs.notify({
                    title: "Error en Seleccionar el trabajador a modificar",
                    text:
                        "Debe seleccionar a un trabajador para realizar cambios",
                    color: "danger",
                    position: "top-right",
                    time: 3000
                });
            } else {
                this.modificarUsuario.run = this.rutUsuario;
                this.modificarUsuario.email = this.correoUsuario;
                this.modificarUsuario.nombre = this.nombreUsuario;
                this.modificarUsuario.apellido = this.apellidoUsuario;
                this.modificarUsuario.anexo = this.anexoUsuario;
                this.modificarUsuario.id_cargo = 6;
                this.modificarUsuario.id_cargo_asociado = this.seleccionSupervisor[0].id;
                this.modificarUsuario.id_edificio = this.seleccionEdificio[0].id;
                this.modificarUsuario.id_servicio = this.seleccionServicio[0].id;
                this.modificarUsuario.id_unidadEspecifica = this.seleccionUnidadEsp[0].id;
                this.modificarUsuario.password = this.passUsuario;
                this.modificarUsuario.run_usuario = this.rutUsuario;
                this.modificarUsuario.tra_run = this.rutUsuario;
                this.modificarUsuario.tra_nombre = this.nombreUsuario;
                this.modificarUsuario.tra_apellido = this.apellidoUsuario;
                this.modificarUsuario.id_especialidad1 = this.seleccionEspecialidad[0].id;
                this.modificarUsuario.id = this.seleccionTrabajador[0].id;
                this.rutUsuario = format(this.rutUsuario);
                if (
                    this.modificarUsuario.run == null ||
                    this.modificarUsuario.run < 9 ||
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
                    this.modificarUsuario.email == null ||
                    this.modificarUsuario.email < 10
                ) {
                    this.$vs.notify({
                        title: "Error en correo",
                        text:
                            "Debe Escribir un correo valido y que no este el campo vacio",
                        color: "danger",
                        position: "top-right",
                        time: 3000
                    });
                } else if (
                    this.modificarUsuario.nombre == null ||
                    this.modificarUsuario.nombre == ""
                ) {
                    this.$vs.notify({
                        title: "Error en Nombre",
                        text:
                            "Debe Escribir un Nombre valido y que no este el campo vacio",
                        color: "danger",
                        position: "top-right",
                        time: 3000
                    });
                } else if (
                    this.modificarUsuario.apellido == null ||
                    this.modificarUsuario.apellido == ""
                ) {
                    this.$vs.notify({
                        title: "Error en Apellido",
                        text:
                            "Debe Escribir un Apellido valido y que no este el campo vacio",
                        color: "danger",
                        position: "top-right",
                        time: 3000
                    });
                } else if (
                    this.modificarUsuario.anexo.length < 1 ||
                    this.modificarUsuario.anexo == null
                ) {
                    this.$vs.notify({
                        title: "Error en Anexo del trabajador",
                        text:
                            "Debe Escribir un Anexo valido y que no este el campo vacio",
                        color: "danger",
                        position: "top-right",
                        time: 3000
                    });
                } else if (
                    this.modificarUsuario.id_cargo_asociado == 0 ||
                    this.modificarUsuario.id_cargo_asociado == null
                ) {
                    this.$vs.notify({
                        title: "Error en el supervisor del trabajador",
                        text: "Debe seleccionar un supervisor para continuar",
                        color: "danger",
                        position: "top-right",
                        time: 3000
                    });
                } else if (
                    this.modificarUsuario.id_edificio == 0 ||
                    this.modificarUsuario.id_edificio == null
                ) {
                    this.$vs.notify({
                        title:
                            "Error en edificio de la ubicacion del trabajador",
                        text:
                            "Debe seleccionar un edificio valido para continuar",
                        color: "danger",
                        position: "top-right",
                        time: 3000
                    });
                } else if (
                    this.modificarUsuario.id_servicio == 0 ||
                    this.modificarUsuario.id_servicio == null
                ) {
                    this.$vs.notify({
                        title:
                            "Error en servicio de la ubicacion del trabajador",
                        text:
                            "Debe seleccionar un servicio valido para continuar",
                        color: "danger",
                        position: "top-right",
                        time: 3000
                    });
                } else if (
                    this.modificarUsuario.id_unidadEspecifica == 0 ||
                    this.modificarUsuario.id_unidadEspecifica == null
                ) {
                    this.$vs.notify({
                        title: "Error ubicacion especifica del trabajador",
                        text:
                            "Debe seleccionar una ubicacion valida para continuar",
                        color: "danger",
                        position: "top-right",
                        time: 3000
                    });
                } else if (
                    this.modificarUsuario.password == "" ||
                    this.modificarUsuario.password.length < 4 ||
                    this.modificarUsuario.password == null
                ) {
                    this.$vs.notify({
                        title: "Error en la contraseña del trabajador",
                        text:
                            "Debe escribir una contraseña valida y no dejar el campo vacio",
                        color: "danger",
                        position: "top-right",
                        time: 3000
                    });
                } else {
                    const registro = this.modificarUsuario;

                    axios
                        .post(
                            this.localVal + "/api/Agente/PutTrabajador",
                            registro
                        )
                        .then(res => {
                            if (res.data == false) {
                                this.$vs.notify({
                                    title:
                                        "Error al tratar de modificar datos del trabajador",
                                    text:
                                        "Verifique los campos e intente nuevamente",
                                    color: "danger",
                                    position: "top-right",
                                    time: 3000
                                });
                            } else {
                                this.limpiar();
                                const ticketServer = res.data;
                                this.$vs.notify({
                                    title:
                                        "Trabajador Modificado Correctamente",
                                    text: "Se recargaran los campos",
                                    color: "success",
                                    position: "top-right",
                                    time: 3000
                                });
                            }
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
        cargarTrabajadores() {
            axios
                .get(this.localVal + "/api/Agente/getTrabajadores")
                .then(res => {
                    this.listadoTrabajadores = res.data;
                    let b = [];
                    let c = this.listadoTrabajadores;
                    c.forEach((value, index) => {
                        b.push(value);
                    });
                    this.listadoTrabajadores = b;
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
        this.cargarTrabajadores();
    },
    components: {
        "v-select": vSelect,
        quillEditor
    }
};
</script>
