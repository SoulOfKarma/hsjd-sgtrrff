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
                        Modificar Usuario Cargo Jefatura Existente
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
                <vx-card title="1. Seleccionar Usuario">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-full mt-5">
                            <h6>1.1 - Seleccione Al usuario</h6>
                            <br />
                            <v-select
                                v-model="seleccionJefatura"
                                placeholder="Seleccione al Usuario"
                                class="w-full select-large"
                                label="nombreUsuario"
                                :options="listadoJefatura"
                                @input="cargarJefaturaSeleccionada"
                            ></v-select>
                        </div>
                    </div>
                </vx-card>
            </div>
            <!-- Usuario -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="1. Ingrese Datos del Usuario">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-1/2 mt-5">
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
                            <h6>1.6 Contraseña del Usuario</h6>
                            <vs-input
                                type="password"
                                class="vx-col w-full mt-5"
                                v-model="passUsuario"
                            />
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
            listadoServiciosData: [],
            listadoJefatura: [],
            val_run: false,

            seleccionJefatura: [
                {
                    id: 0,
                    nombreUsuario: ""
                }
            ],
            seleccionCargo: [
                {
                    id: 0,
                    descripcionCargo: "Seleccione Cargo"
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
        formatear_run() {
            if (this.rutUsuario == "" || this.rutUsuario == null) {
                console.log("Sin Rut");
                this.val_run = false;
            } else {
                this.rutUsuario = format(this.rutUsuario);
                this.val_run = !validate(this.rutUsuario);
            }
        },
        cargarJefaturaSeleccionada() {
            let id = this.seleccionJefatura.id;
            let b = [];
            let c = this.listadoJefatura;
            let a = 0;
            c.forEach((value, index) => {
                a = value.id;
                if (a == id) {
                    b.push(value);
                }
            });

            this.seleccionJefatura = b;
            this.rutUsuario = b[0].run;
            this.nombreUsuario = b[0].nombre;
            this.apellidoUsuario = b[0].apellido;
            this.anexoUsuario = b[0].anexo;
            this.correoUsuario = b[0].email;

            let idEdificio = b[0].id_edificio;
            let idServicio = b[0].id_servicio;

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
            this.modificarUsuario.id_unidadEspecifica = 42;
            this.modificarUsuario.password = "";
            this.modificarUsuario.run_usuario = "";

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
            this.seleccionJefatura = [
                {
                    id: 0,
                    nombreUsuario: ""
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
                this.seleccionJefatura[0] == null ||
                this.seleccionJefatura[0].id == 0 ||
                this.seleccionJefatura[0].id == null
            ) {
                this.$vs.notify({
                    title: "Error al seleccionar el usuario a modificar",
                    text: "Debe seleccionar un usuario para continuar",
                    color: "danger",
                    position: "top-right"
                });
            } else if (
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
            } else {
                this.modificarUsuario.run = this.rutUsuario;
                this.modificarUsuario.email = this.correoUsuario;
                this.modificarUsuario.nombre = this.nombreUsuario;
                this.modificarUsuario.apellido = this.apellidoUsuario;
                this.modificarUsuario.anexo = this.anexoUsuario;
                this.modificarUsuario.id_cargo = 1;
                this.modificarUsuario.id_edificio = this.seleccionEdificio[0].id;
                this.modificarUsuario.id_servicio = this.seleccionServicio[0].id;
                this.modificarUsuario.password = this.passUsuario;
                this.modificarUsuario.run_usuario = this.rutUsuario;
                this.modificarUsuario.id = this.seleccionJefatura[0].id;
                this.rutUsuario = format(this.rutUsuario);

                if (
                    this.rutUsuario == 0 ||
                    this.rutUsuario == null ||
                    this.rutUsuario == ""
                ) {
                    this.modificarUsuario.idvalRut = 0;
                } else {
                    this.modificarUsuario.idvalRut = 1;
                }
                if (
                    this.correoUsuario == 0 ||
                    this.correoUsuario == null ||
                    this.correoUsuario == ""
                ) {
                    this.modificarUsuario.idvalmail = 0;
                } else {
                    this.modificarUsuario.idvalmail = 1;
                }
                /* if (
                    this.modificarUsuario.run == null ||
                    this.modificarUsuario.run < 9 ||
                    !validate(this.rutUsuario)
                ) {
                    this.$vs.notify({
                        title: "Error en rut",
                        text:
                            "Debe Escribir un rut valido,que no este el campo vacio y que sea mayor a 9 caracteres",
                        color: "danger",
                        position: "top-right"
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
                        position: "top-right"
                    });
                } else */ if (
                    this.modificarUsuario.nombre == null ||
                    this.modificarUsuario.nombre < 3
                ) {
                    this.$vs.notify({
                        title: "Error en Nombre",
                        text:
                            "Debe Escribir un Nombre valido y que no este el campo vacio",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.modificarUsuario.apellido == null ||
                    this.modificarUsuario.apellido < 3
                ) {
                    this.$vs.notify({
                        title: "Error en Apellido",
                        text:
                            "Debe Escribir un Apellido valido y que no este el campo vacio",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.modificarUsuario.anexo == null ||
                    this.modificarUsuario.anexo < 6
                ) {
                    this.$vs.notify({
                        title: "Error en Anexo",
                        text:
                            "Debe Escribir un Anexo valido y que no este el campo vacio",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.modificarUsuario.password == null ||
                    this.modificarUsuario.password < 4
                ) {
                    this.$vs.notify({
                        title: "Error en la Contraseña",
                        text:
                            "Debe Escribir una contraseña valida y que no este el campo vacio",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    const registro = this.modificarUsuario;
                    axios
                        .post(
                            this.localVal + "/api/Agente/ModificarUsuarioJefe",
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
                                    title: "Error al modificar al usuario",
                                    text:
                                        "Chequee los campos e intente nuevamente",
                                    color: "danger",
                                    position: "top-right"
                                });
                            } else {
                                const ticketServer = res.data;
                                this.$vs.notify({
                                    time: 3000,
                                    title:
                                        "Modificacion Realizada Correctamente",
                                    text: "Se vaciaran los campos",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.limpiar();
                                this.cargarJefatura();
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
            axios
                .get(this.localVal + "/api/Agente/GetCargos", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoCargo = res.data;
                    let b = [];
                    let c = this.listadoCargo;
                    c.forEach((value, index) => {
                        b.push(value);
                    });
                    this.listadoCargo = b;
                });
        },
        cargarEdificios() {
            axios
                .get(this.localVal + "/api/Usuario/GetEdificios", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
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
                    let b = [];
                    let c = this.listadoServicios;
                    c.forEach((value, index) => {
                        b.push(value);
                    });
                    this.listadoServicios = b;
                });
        },
        cargarJefatura() {
            axios
                .get(this.localVal + "/api/Agente/getUsuariosJefatura", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoJefatura = res.data;
                    let b = [];
                    let c = this.listadoJefatura;
                    c.forEach((value, index) => {
                        b.push(value);
                    });
                    this.listadoJefatura = b;
                });
        }
    },
    created() {
        this.cargarEdificios();
        this.cargarServicios();
        this.cargarJefatura();
        this.cargarCargoUsuario();
    },
    components: {
        "v-select": vSelect,
        quillEditor
    }
};
</script>
