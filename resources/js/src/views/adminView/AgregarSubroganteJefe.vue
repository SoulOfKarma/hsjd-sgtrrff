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
                        Registrar nuevo Usuario Subrogante
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
                        <div class="vx-col w-full mt-5">
                            <h6>1.1 Rut del Usuario</h6>
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
                            <h6>1.2 Nombre del Usuario</h6>
                            <vs-input
                                class="vx-col w-full mt-5"
                                v-model="nombreUsuario"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.3 Apellido del Usuario</h6>
                            <vs-input
                                class="vx-col w-full mt-5"
                                v-model="apellidoUsuario"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.4 Anexo del Usuario</h6>
                            <vs-input
                                type="number"
                                class="vx-col w-full mt-5"
                                v-model="anexoUsuario"
                                @keypress="isNumber($event)"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.5 Correo del Usuario</h6>
                            <vs-input
                                type="email"
                                class="vx-col w-full mt-5"
                                v-model="correoUsuario"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.6 - Seleccione el Cargo</h6>
                            <br />
                            <v-select
                                v-model="seleccionCargo"
                                placeholder="Edificio"
                                class="w-full select-large"
                                label="descripcionCargo"
                                :options="listadoCargo"
                                @input="arrayCargo"
                            ></v-select>
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.7 Contraseña del Usuario</h6>
                            <vs-input
                                type="password"
                                class="vx-col w-full mt-5"
                                v-model="passUsuario"
                            />
                        </div>
                        <div class="vx-col w-full mt-5">
                            <h6>1.8 - Seleccione Jefe de Unidad</h6>
                            <br />
                            <v-select
                                v-model="seleccionUsuariosCargo"
                                placeholder="Jefe"
                                class="w-full select-large"
                                label="nombrecompleto"
                                :options="listadoUsuariosCargo"
                                @input="arrayJefatura"
                            ></v-select>
                        </div>
                    </div>
                </vx-card>
            </div>
            <!-- Ubicacion -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="2. Ubicacion del Usuario">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-1/2 mt-5">
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
                        <div class="vx-col w-1/2 mt-5">
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
            localVal: process.env.MIX_APP_URL,
            nombreUsuario: "",
            apellidoUsuario: "",
            anexoUsuario: 0,
            correoUsuario: "",
            rutUsuario: "",
            passUsuario: "",
            listadoCargo: [],
            listadoEdificios: [],
            listadoServicios: [],
            listadoUsuariosCargo: [],
            listadoServiciosData: [],
            val_run: false,
            seleccionCargo: [
                {
                    id: 0,
                    descripcionCargo: "Seleccione Cargo"
                }
            ],
            seleccionUsuariosCargo: [
                {
                    id: 0,
                    nombrecompleto: "Seleccione Usuario Jefe"
                }
            ],
            seleccionEdificio: [
                {
                    id: 0,
                    descripcionEdificio: "Seleccione Edificio"
                }
            ],

            seleccionServicio: [
                {
                    id: 0,
                    descripcionServicio: "Seleccione Servicio"
                }
            ],
            dataUsuarioCreador: {
                nombre:
                    sessionStorage.getItem("nombre") +
                    " " +
                    sessionStorage.getItem("apellido"),
                id_user: sessionStorage.getItem("id")
            },
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
                id_unidadEspecifica: 42,
                password: "",
                run_usuario: "",
                permiso_usuario: 2,
                estado_login: 1,
                idvalRut: 0,
                idvalmail: 0
            },
            value1: "",
            validaEliminar: false,
            popupActive2: false,
            componentKey: 0
        };
    },
    methods: {
        isNumber: function(evt) {
            evt = evt ? evt : window.event;
            var charCode = evt.which ? evt.which : evt.keyCode;
            if (
                charCode > 31 &&
                (charCode < 48 || charCode > 57) &&
                charCode !== 46
            ) {
                evt.preventDefault();
            } else {
                return true;
            }
        },
        formatear_run() {
            if (this.rutUsuario == "" || this.rutUsuario == null) {
                console.log("Sin Rut");
                this.val_run = false;
            } else {
                this.rutUsuario = format(this.rutUsuario);
                this.val_run = !validate(this.rutUsuario);
            }
        },
        arrayCargo() {
            let id = this.seleccionCargo.id;
            let b = [];
            let c = this.listadoCargo;
            let a = 0;
            c.forEach((value, index) => {
                a = value.id;
                if (a == id) {
                    b.push(value);
                }
            });

            this.seleccionCargo = b;
        },
        arrayJefatura() {
            let id = this.seleccionUsuariosCargo.id;
            let b = [];
            let c = this.listadoUsuariosCargo;
            let a = 0;
            c.forEach((value, index) => {
                a = value.id;
                if (a == id) {
                    b.push(value);
                }
            });

            this.seleccionUsuariosCargo = b;
        },
        limpiar() {
            this.registroUsuario.run = "";
            this.registroUsuario.email = "";
            this.registroUsuario.nombre = "";
            this.registroUsuario.apellido = "";
            this.registroUsuario.anexo = 0;
            this.registroUsuario.id_cargo = 0;
            this.registroUsuario.id_cargo_asociado = 0;
            this.registroUsuario.id_edificio = 0;
            this.registroUsuario.id_servicio = 0;
            this.registroUsuario.id_unidadEspecifica = 42;
            this.registroUsuario.password = "";
            this.registroUsuario.run_usuario = "";

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
            this.nombreUsuario = "";
            this.apellidoUsuario = "";
            this.anexoUsuario = 0;
            this.correoUsuario = "";
            this.rutUsuario = "";
            this.passUsuario = "";
        },
        guardar() {
            if (
                this.seleccionEdificio[0] == null ||
                this.seleccionEdificio[0].id == 0 ||
                this.seleccionEdificio[0].id == null
            ) {
                this.$vs.notify({
                    title: "Error al seleccionar el edificio",
                    text: "Debe seleccionar un edificio para continuar",
                    color: "danger",
                    position: "top-right"
                });
            } else if (
                this.seleccionServicio[0] == null ||
                this.seleccionServicio[0].id == 0 ||
                this.seleccionServicio[0].id == null
            ) {
                this.$vs.notify({
                    title: "Error al seleccionar el servicio",
                    text: "Debe seleccionar un servicio para continuar",
                    color: "danger",
                    position: "top-right"
                });
            } else if (
                this.seleccionCargo[0] == null ||
                this.seleccionCargo[0].id == 0 ||
                this.seleccionCargo[0].id == null
            ) {
                this.$vs.notify({
                    title: "Error al seleccionar el cargo",
                    text: "Debe seleccionar un cargo para continuar",
                    color: "danger",
                    position: "top-right"
                });
            } else if (
                this.seleccionUsuariosCargo[0] == null ||
                this.seleccionUsuariosCargo[0].id == 0 ||
                this.seleccionUsuariosCargo[0].id == null
            ) {
                this.$vs.notify({
                    title: "Error al seleccionar la jefatura",
                    text:
                        "Debe seleccionar una jefatura a cargo para continuar",
                    color: "danger",
                    position: "top-right"
                });
            } else {
                this.registroUsuario.run = this.rutUsuario;
                this.registroUsuario.email = this.correoUsuario;
                this.registroUsuario.nombre = this.nombreUsuario;
                this.registroUsuario.apellido = this.apellidoUsuario;
                this.registroUsuario.anexo = this.anexoUsuario;
                this.registroUsuario.id_cargo = this.seleccionCargo[0].id;
                this.registroUsuario.id_cargo_asociado = this.seleccionUsuariosCargo[0].id;
                this.registroUsuario.id_edificio = this.seleccionEdificio[0].id;
                this.registroUsuario.id_servicio = this.seleccionServicio[0].id;
                this.registroUsuario.password = this.passUsuario;
                this.registroUsuario.run_usuario = this.rutUsuario;
                this.rutUsuario = format(this.rutUsuario);
                if (
                    this.rutUsuario == 0 ||
                    this.rutUsuario == null ||
                    this.rutUsuario == ""
                ) {
                    this.registroUsuario.idvalRut = 0;
                } else {
                    this.registroUsuario.idvalRut = 1;
                }
                if (
                    this.correoUsuario == 0 ||
                    this.correoUsuario == null ||
                    this.correoUsuario == ""
                ) {
                    this.registroUsuario.idvalmail = 0;
                } else {
                    this.registroUsuario.idvalmail = 1;
                }

                if (
                    this.registroUsuario.nombre == null ||
                    this.registroUsuario.nombre < 3
                ) {
                    this.$vs.notify({
                        title: "Error en Nombre",
                        text:
                            "Debe Escribir un Nombre valido y que no este el campo vacio",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.registroUsuario.apellido == null ||
                    this.registroUsuario.apellido < 3
                ) {
                    this.$vs.notify({
                        title: "Error en Apellido",
                        text:
                            "Debe Escribir un Apellido valido y que no este el campo vacio",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.registroUsuario.anexo == null ||
                    this.registroUsuario.anexo < 6
                ) {
                    this.$vs.notify({
                        title: "Error en Anexo",
                        text:
                            "Debe Escribir un Anexo valido y que no este el campo vacio",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.registroUsuario.password == null ||
                    this.registroUsuario.password < 4
                ) {
                    this.$vs.notify({
                        title: "Error en la Contraseña",
                        text:
                            "Debe Escribir una contraseña valida y que no este el campo vacio",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    const registro = this.registroUsuario;

                    axios
                        .post(
                            this.localVal + "/api/Agente/GuardarUsuarioSub",
                            registro,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            if (res.data == false) {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error al registrar usuario",
                                    text:
                                        "Usuario ya existente, debe registrar uno nuevo o modificar el existente",
                                    color: "danger",
                                    position: "top-right"
                                });
                            } else {
                                const ticketServer = res.data;
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Registro Realizado Correctamente",
                                    text: "Se vaciaran los campos",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.limpiar();
                            }
                        })
                        .catch(error => {
                            if (error.response.status === 401) {
                                this.$vs.notify({
                                    title: "Token Invalido ",
                                    text: "Debe iniciar sesion nuevamente",
                                    color: "danger",
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
        cargaSegunServicio() {
            if (
                this.seleccionServicio == null ||
                this.seleccionServicio.id == 0
            ) {
                this.listadoServicios = this.listadoServiciosData;
            } else {
                var idGeneral = this.seleccionServicio.id;

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
        cargarCargoUsuario() {
            this.csrf_token;

            axios
                .get(this.localVal + "/api/Agente/GetCargoNoJefatura", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoCargo = res.data;
                })
                .catch(error => {
                    if (error.response.status === 401) {
                        this.$vs.notify({
                            title: "Token Invalido ",
                            text: "Debe iniciar sesion nuevamente",
                            color: "danger",
                            position: "top-right",
                            time: 3000
                        });
                    }
                });
        },
        cargarListadoUsuarios() {
            this.csrf_token;

            axios
                .get(this.localVal + "/api/Agente/GetUsuariosCargo", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoUsuariosCargo = res.data;
                })
                .catch(error => {
                    if (error.response.status === 401) {
                        this.$vs.notify({
                            title: "Token Invalido ",
                            text: "Debe iniciar sesion nuevamente",
                            color: "danger",
                            position: "top-right",
                            time: 3000
                        });
                    }
                });
        },
        cargarEdificios() {
            this.csrf_token;

            axios
                .get(this.localVal + "/api/Usuario/GetEdificios", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoEdificios = res.data;
                })
                .catch(error => {
                    if (error.response.status === 401) {
                        this.$vs.notify({
                            title: "Token Invalido ",
                            text: "Debe iniciar sesion nuevamente",
                            color: "danger",
                            position: "top-right",
                            time: 3000
                        });
                    }
                });
        },

        cargarServicios() {
            this.csrf_token;

            axios
                .get(this.localVal + "/api/Usuario/GetServicios", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoServicios = res.data;
                    this.listadoServiciosData = res.data;
                })
                .catch(error => {
                    if (error.response.status === 401) {
                        this.$vs.notify({
                            title: "Token Invalido ",
                            text: "Debe iniciar sesion nuevamente",
                            color: "danger",
                            position: "top-right",
                            time: 3000
                        });
                    }
                });
        }
    },
    created() {
        this.cargarEdificios();
        this.cargarServicios();
        this.cargarCargoUsuario();
        this.cargarListadoUsuarios();
    },
    components: {
        "v-select": vSelect,
        quillEditor
    }
};
</script>
