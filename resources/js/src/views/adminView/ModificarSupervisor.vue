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
                        Modificar Supervisor Existente
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
                <vx-card title="1. Seleccionar al Supervisor" c>
                    <div class="vx-row mb-12">
                        <div class="vx-col w-full mt-5">
                            <h6>1.1 - Seleccione Al Usuario</h6>
                            <br />
                            <v-select
                                v-model="seleccionSupervisor"
                                placeholder="Seleccione al Supervisor"
                                class="w-full select-large"
                                label="nombreSupervisor"
                                :options="listadoSupervisor"
                                @input="cargarSupervisorSeleccionado"
                            ></v-select>
                        </div>
                    </div>
                </vx-card>
            </div>
            <!-- Usuario -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="2. Ingrese Datos del Usuario">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-full mt-5">
                            <h6>2.1 Rut del Supervisor</h6>
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
                            <h6>2.2 Nombre del Supervisor</h6>
                            <vs-input
                                class="vx-col w-full mt-5"
                                v-model="nombreUsuario"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>2.3 Apellido del Supervisor</h6>
                            <vs-input
                                class="vx-col w-full mt-5"
                                v-model="apellidoUsuario"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>2.4 Anexo del Supervisor</h6>
                            <vs-input
                                class="vx-col w-full mt-5"
                                v-model="anexoUsuario"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>2.5 Correo del Supervisor</h6>
                            <vs-input
                                type="email"
                                class="vx-col w-full mt-5"
                                v-model="correoUsuario"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>2.6 Contraseña del Supervisor</h6>
                            <vs-input
                                type="password"
                                class="vx-col w-full mt-5"
                                v-model="passUsuario"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>2.7 - Seleccione Jefe de Unidad</h6>
                            <br />
                            <v-select
                                v-model="seleccionUsuariosCargo"
                                placeholder="Jefe"
                                class="w-full select-large"
                                label="nombrecompleto"
                                :options="listadoUsuariosCargo"
                                @input="arrayCargoAsociado"
                            ></v-select>
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>2.8 - Seleccione 1° Especialidad</h6>
                            <br />
                            <v-select
                                v-model="seleccionEspecialidad1"
                                placeholder="Especialidad"
                                class="w-full select-large"
                                label="descripcionEspecialidad"
                                :options="listadoEspecialidad"
                                @input="arrayEspecialidad1"
                            ></v-select>
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>2.9 - Seleccione 2° Especialidad</h6>
                            <br />
                            <v-select
                                v-model="seleccionEspecialidad2"
                                placeholder="Especialidad"
                                class="w-full select-large"
                                label="descripcionEspecialidad"
                                :options="listadoEspecialidad"
                                @input="arrayEspecialidad2"
                            ></v-select>
                        </div>
                    </div>
                </vx-card>
            </div>
            <!-- Ubicacion -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="3. Ubicacion del Usuario">
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
            localVal: "http://10.66.248.51:8000",
            nombreUsuario: "",
            apellidoUsuario: "",
            anexoUsuario: 0,
            correoUsuario: "",
            rutUsuario: "",
            passUsuario: "",
            listadoEdificios: [],
            listadoServicios: [],
            listadoUnidadEsp: [],
            listadoUsuariosCargo: [],
            listadoServiciosData: [],
            listadoUnidadEspData: [],
            listadoEspecialidad: [],
            listadoSupervisor: [],
            seleccionSupervisor: {
                id: 0,
                nombreSupervisor: "Seleccione Supervisor"
            },
            seleccionEspecialidad1: {
                id: 0,
                descripcionEspecialidad: "Seleccione Especialidad 1"
            },
            seleccionEspecialidad2: {
                id: 0,
                descripcionEspecialidad: "Seleccione Especialidad 2"
            },
            seleccionUsuariosCargo: {
                id: 0,
                nombrecompleto: "Seleccione Usuario Jefe"
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
            modificarSupervisor: {
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
                permiso_usuario: 1,
                estado_login: 1,
                sup_run: "",
                sup_nombre: "",
                sup_apellido: "",
                id_especialidad1: 0,
                id_especialidad2: 0,
                id: 0
            }
        };
    },
    methods: {
        cargarSupervisorSeleccionado() {
            let id = this.seleccionSupervisor.id;
            let c = this.listadoSupervisor;
            let b = [];
            let a = 0;
            c.forEach((value, index) => {
                a = value.id;
                if (a == id) {
                    b.push(value);
                }
            });

            this.seleccionSupervisor = b;

            this.nombreUsuario = b[0].nombre;
            this.rutUsuario = b[0].run;
            this.apellidoUsuario = b[0].apellido;
            this.anexoUsuario = b[0].anexo;
            this.correoUsuario = b[0].email;

            let idEspecialidad1 = b[0].id_especialidad1;
            let idEspecialidad2 = b[0].id_especialidad2;
            let idCargoAsociado = b[0].id_cargo_asociado;
            let idEdificio = b[0].id_edificio;
            let idServicio = b[0].id_servicio;
            let idUnidadEsp = b[0].id_unidadEspecifica;

            b = [];
            c = this.listadoEspecialidad;
            c.forEach((value, index) => {
                a = value.id;
                if (a == idEspecialidad1) {
                    b.push(value);
                }
            });

            this.seleccionEspecialidad1 = b;

            b = [];
            c.forEach((value, index) => {
                a = value.id;
                if (a == idEspecialidad2) {
                    b.push(value);
                }
            });

            this.seleccionEspecialidad2 = b;

            b = [];
            c = this.listadoUsuariosCargo;
            c.forEach((value, index) => {
                a = value.id;
                if (a == idCargoAsociado) {
                    b.push(value);
                }
            });

            this.seleccionUsuariosCargo = b;

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
        formatear_run() {
            this.rutUsuario = format(this.rutUsuario);
            this.val_run = !validate(this.rutUsuario);
        },
        arrayEspecialidad1() {
            let id = this.seleccionEspecialidad1.id;
            let c = this.listadoEspecialidad;
            let b = [];
            let a = 0;
            c.forEach((value, index) => {
                a = value.id;
                if (a == id) {
                    b.push(value);
                }
            });
            this.seleccionEspecialidad1 = b;
        },
        arrayEspecialidad2() {
            let id = this.seleccionEspecialidad2.id;
            let c = this.listadoEspecialidad;
            let b = [];
            let a = 0;
            c.forEach((value, index) => {
                a = value.id;
                if (a == id) {
                    b.push(value);
                }
            });
            this.seleccionEspecialidad2 = b;
        },
        arrayCargoAsociado() {
            let id = this.seleccionUsuariosCargo.id;
            let c = this.listadoUsuariosCargo;
            let b = [];
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
            this.modificarSupervisor.run = "";
            this.modificarSupervisor.email = "";
            this.modificarSupervisor.nombre = "";
            this.modificarSupervisor.apellido = "";
            this.modificarSupervisor.anexo = 0;
            this.modificarSupervisor.id_cargo = 0;
            this.modificarSupervisor.id_edificio = 0;
            this.modificarSupervisor.id_servicio = 0;
            this.modificarSupervisor.id_unidadEspecifica = 0;
            this.modificarSupervisor.password = "";
            this.modificarSupervisor.run_usuario = "";
            this.modificarSupervisor.sup_run = "";
            this.modificarSupervisor.sup_nombre = "";
            this.modificarSupervisor.sup_apellido = "";
            this.modificarSupervisor.id_especialidad1 = 0;
            this.modificarSupervisor.id_especialidad2 = 0;

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
            this.seleccionServicio = {
                id: 0,
                descripcionServicio: "Seleccione Servicio"
            };
            this.seleccionUnidadEsp = [
                {
                    id: 0,
                    descripcionUnidadEsp: "Seleccion Unidad Especifica"
                }
            ];
            this.seleccionEspecialidad1 = [
                {
                    id: 0,
                    descripcionEspecialidad: "Seleccione Especialidad 1"
                }
            ];
            this.seleccionEspecialidad2 = [
                {
                    id: 0,
                    descripcionEspecialidad: "Seleccione Especialidad 2"
                }
            ];
            this.seleccionSupervisor = [
                {
                    id: 0,
                    nombreSupervisor: "Seleccione Supervisor"
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
                this.seleccionSupervisor[0] == null ||
                this.seleccionSupervisor[0].id == null ||
                this.seleccionSupervisor[0].id == 0
            ) {
                this.$vs.notify({
                    title: "Error en Seleccionar el supervisor a modificar",
                    text:
                        "Debe seleccionar a un supervisor para realizar cambios",
                    color: "danger",
                    position: "top-right",
                    time: 3000
                });
            } else {
                this.modificarSupervisor.run = this.rutUsuario;
                this.modificarSupervisor.email = this.correoUsuario;
                this.modificarSupervisor.nombre = this.nombreUsuario;
                this.modificarSupervisor.apellido = this.apellidoUsuario;
                this.modificarSupervisor.anexo = this.anexoUsuario;
                this.modificarSupervisor.id_cargo = 5;
                this.modificarSupervisor.id_cargo_asociado = this.seleccionUsuariosCargo[0].id;
                this.modificarSupervisor.id_edificio = this.seleccionEdificio[0].id;
                this.modificarSupervisor.id_servicio = this.seleccionServicio[0].id;
                this.modificarSupervisor.id_unidadEspecifica = this.seleccionUnidadEsp[0].id;
                this.modificarSupervisor.password = this.passUsuario;
                this.modificarSupervisor.run_usuario = this.rutUsuario;
                this.modificarSupervisor.sup_run = this.rutUsuario;
                this.modificarSupervisor.sup_nombre = this.nombreUsuario;
                this.modificarSupervisor.sup_apellido = this.apellidoUsuario;
                this.modificarSupervisor.id_especialidad1 = this.seleccionEspecialidad1[0].id;
                this.modificarSupervisor.id_especialidad2 = this.seleccionEspecialidad2[0].id;

                this.modificarSupervisor.id = this.seleccionSupervisor[0].id;
                this.rutUsuario = format(this.rutUsuario);

                if (
                    this.modificarSupervisor.run == null ||
                    this.modificarSupervisor.run < 9 ||
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
                    this.modificarSupervisor.email == null ||
                    this.modificarSupervisor.email < 10
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
                    this.modificarSupervisor.nombre == "" ||
                    this.modificarSupervisor.nombre == null
                ) {
                    this.$vs.notify({
                        title: "Error en Nombre de Supervisor",
                        text:
                            "Debe Escribir un nombre valido y que no este el campo vacio",
                        color: "danger",
                        position: "top-right",
                        time: 3000
                    });
                } else if (
                    this.modificarSupervisor.apellido == "" ||
                    this.modificarSupervisor.apellido == null
                ) {
                    this.$vs.notify({
                        title: "Error en apellido de Supervisor",
                        text:
                            "Debe Escribir un apellido valido y que no este el campo vacio",
                        color: "danger",
                        position: "top-right",
                        time: 3000
                    });
                } else if (
                    this.modificarSupervisor.anexo == 0 ||
                    this.modificarSupervisor.anexo == null
                ) {
                    this.$vs.notify({
                        title: "Error en Anexo de Supervisor",
                        text:
                            "Debe Escribir un Anexo valido y que no este el campo vacio",
                        color: "danger",
                        position: "top-right",
                        time: 3000
                    });
                } else if (
                    this.modificarSupervisor.id_cargo_asociado == 0 ||
                    this.modificarSupervisor.id_cargo_asociado == null
                ) {
                    this.$vs.notify({
                        title: "Error en Asignar Jefatura del Supervisor",
                        text:
                            "Debe Seleccionar una de las jefaturas que pertenece",
                        color: "danger",
                        position: "top-right",
                        time: 3000
                    });
                } else if (
                    this.modificarSupervisor.id_edificio == 0 ||
                    this.modificarSupervisor.id_edificio == null
                ) {
                    this.$vs.notify({
                        title:
                            "Error en el edificio de la ubicacion del Supervisor",
                        text:
                            "Debe Seleccionar uno de los edificios al cual pertenece",
                        color: "danger",
                        position: "top-right",
                        time: 3000
                    });
                } else if (
                    this.modificarSupervisor.id_servicio == 0 ||
                    this.modificarSupervisor.id_servicio == null
                ) {
                    this.$vs.notify({
                        title:
                            "Error en el servicio de la ubicacion del Supervisor",
                        text:
                            "Debe Seleccionar uno de los servicios al cual pertenece",
                        color: "danger",
                        position: "top-right",
                        time: 3000
                    });
                } else if (
                    this.modificarSupervisor.id_unidadEspecifica == 0 ||
                    this.modificarSupervisor.id_unidadEspecifica == null
                ) {
                    this.$vs.notify({
                        title:
                            "Error en la ubicacion especifica del Supervisor",
                        text:
                            "Debe Seleccionar una ubicacion especifica al cual pertenece",
                        color: "danger",
                        position: "top-right",
                        time: 3000
                    });
                } else if (
                    this.modificarSupervisor.password == null ||
                    this.modificarSupervisor.password == "" ||
                    this.modificarSupervisor.password.length < 4
                ) {
                    this.$vs.notify({
                        title: "Error en la contraseña del Supervisor",
                        text:
                            "Debe escribir una contraseña valida y no dejar el campo vacio",
                        color: "danger",
                        position: "top-right",
                        time: 3000
                    });
                } else if (
                    this.modificarSupervisor.run_usuario == "" ||
                    this.modificarSupervisor.run_usuario == null ||
                    this.modificarSupervisor.run_usuario.length < 9
                ) {
                    this.$vs.notify({
                        title: "Error en el rut del Supervisor",
                        text:
                            "Debe escribir un rut valido y no dejar el campo vacio",
                        color: "danger",
                        position: "top-right",
                        time: 3000
                    });
                } else {
                    const registro = this.modificarSupervisor;

                    axios
                        .post(
                            this.localVal + "/api/Agente/PutSupervisor",
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
                                    title:
                                        "Error al modificar datos del supervisor",
                                    text:
                                        "Chequee los campos e intente nuevamente",
                                    color: "danger",
                                    position: "top-right",
                                    time: 3000
                                });
                            } else {
                                this.limpiar();
                                const ticketServer = res.data;
                                this.$vs.notify({
                                    title:
                                        "Supervisor Modificado Correctamente",
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
                .get(this.localVal + "/api/Agente/getSupervisoresRRFF", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoSupervisor = res.data;
                    let b = [];
                    let c = this.listadoSupervisor;
                    c.forEach((value, index) => {
                        b.push(value);
                    });
                    this.listadoSupervisor = b;
                });
        },
        cargarListadoUsuarios() {
            axios
                .get(this.localVal + "/api/Agente/GetUsuariosCargo", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoUsuariosCargo = res.data;
                    let b = [];
                    let c = this.listadoUsuariosCargo;
                    c.forEach((value, index) => {
                        b.push(value);
                    });
                    this.listadoUsuariosCargo = b;
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
        cargarEspecialidad() {
            axios
                .get(this.localVal + "/api/Agente/getEspecialidad", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
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
        cargarUnidadEsp() {
            this.csrf_token;

            axios
                .get(this.localVal + "/api/Usuario/GetUnidadEsp", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
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
        this.cargarListadoUsuarios();
    },
    components: {
        "v-select": vSelect,
        quillEditor
    }
};
</script>
