<template>
    <div>
        <vs-row>
            <div
                class="router-header flex flex-wrap items-center mb-8"
                style="margin-left:10px;"
            >
                <div
                    class="content-area__heading pr-4 border-0 md:border-r border-solid border-grey-light"
                >
                    <h2 class="mb-1">Asignar Ticket</h2>
                </div>
                <div class="vx-breadcrumb ml-4 md:block hidden">
                    <div
                        class="content-area__heading pr-4 border-0 md:border-r border-solid border-grey-light"
                    >
                        <h3 class="mb-1">
                            Agente:
                            <p>{{ nombre }} - {{ run }}</p>
                        </h3>
                    </div>
                </div>
            </div>
            <vs-alert
                color="primary"
                icon="new_releases"
                active="true"
                style="margin-bottom: 10px;"
            >
                <p>Recuerda que todos los campos son obligatorios!</p>
            </vs-alert>
            <!-- Ubicacion -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="1. Lugar del problema">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-1/3 mt-5">
                            <h6>1.1 - Seleccione el Edificio</h6>
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
                            <h6>1.2 - Seleccione el Servicio</h6>
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
                            <h6>1.3 - Seleccione la Unidad Especifica</h6>
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
            <!-- Personal -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="2. Asignar Supervisor y Tecnico">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-1/2 mt-5">
                            <h6>2.1 - Seleccione al Supervisor</h6>
                            <br />
                            <v-select
                                v-model="seleccionSupervisor"
                                placeholder="Seleccione al Supervisor"
                                class="w-full select-large"
                                label="sup_nombre_apellido"
                                :options="listadoSupervisores"
                                @input="
                                    arraySupervisores(seleccionSupervisor.id)
                                "
                            ></v-select>
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>2.2 - Seleccione al Trabajador</h6>
                            <br />
                            <v-select
                                v-model="seleccionTrabajador"
                                placeholder="Seleccione al Trabajador"
                                class="w-full select-large"
                                label="tra_nombre_apellido"
                                :options="listadoTrabajadores"
                                @input="
                                    arrayTrabajadores(seleccionTrabajador.id)
                                "
                            ></v-select>
                        </div>
                        <div class="vx-col w-full mt-5">
                            <h6>2.3 - Seleccione al Apoyo 1</h6>
                            <br />
                            <v-select
                                v-model="seleccionApoyo1"
                                placeholder="Seleccione al Apoyo"
                                class="w-full select-large"
                                label="tra_nombre_apellido"
                                :options="listadoApoyo1"
                                @input="arrayApoyo1(seleccionApoyo1.id)"
                            ></v-select>
                        </div>
                        <div class="vx-col w-full mt-5">
                            <h6>2.4 - Seleccione al Apoyo 2</h6>
                            <br />
                            <v-select
                                v-model="seleccionApoyo2"
                                placeholder="Seleccione al Apoyo"
                                class="w-full select-large"
                                label="tra_nombre_apellido"
                                :options="listadoApoyo2"
                                @input="arrayApoyo2(seleccionApoyo2.id)"
                            ></v-select>
                        </div>
                        <div class="vx-col w-full mt-5">
                            <h6>2.5 - Seleccione al Apoyo 3</h6>
                            <br />
                            <v-select
                                v-model="seleccionApoyo3"
                                placeholder="Seleccione al Apoyo"
                                class="w-full select-large"
                                label="tra_nombre_apellido"
                                :options="listadoApoyo3"
                                @input="arrayApoyo3(seleccionApoyo3.id)"
                            ></v-select>
                        </div>
                        <div class="vx-col w-full mt-5">
                            <h6>2.6 - Seleccione Turno</h6>
                            <br />
                            <v-select
                                v-model="seleccionTurno"
                                placeholder="Seleccione al Apoyo"
                                class="w-full select-large"
                                label="descripcionTurno"
                                :options="listadoTurno"
                            ></v-select>
                        </div>
                    </div>
                </vx-card>
            </div>
            <!-- Hora y Fecha -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="3. Asignar Hora y Fecha">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-1/2 mt-5">
                            <h6>3.1 - Hora y Fecha de inicio</h6>
                            <br />
                            <flat-pickr
                                :config="configFromdateTimePicker"
                                v-model="gestionTicket.fechaInicio"
                                placeholder="Fecha Inicio"
                                @on-change="onFromChange"
                            />
                            <flat-pickr
                                :config="configdateTimePicker"
                                v-model="gestionTicket.horaInicio"
                                placeholder="Seleccione Hora"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>3.2 - Hora y Fecha de termino</h6>
                            <br />
                            <flat-pickr
                                :config="configTodateTimePicker"
                                v-model="gestionTicket.fechaTermino"
                                placeholder="Fecha Termino"
                                @on-change="onToChange"
                            />
                            <flat-pickr
                                :config="configdateTimePicker"
                                v-model="gestionTicket.horaTermino"
                                placeholder="Seleccione Hora"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <vs-input
                                disabled="true"
                                label-placeholder="Dias Ejecucion"
                                v-model="diasCalculados"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <vs-input
                                disabled="true"
                                label-placeholder="Horas Ejecucion"
                                v-model="calcularHorasTrabajo"
                            />
                        </div>
                    </div>
                </vx-card>
            </div>
            <!-- Informacion del problema -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="4. Problema a Resolver">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-full mt-5">
                            <h6>4.2 - Seleccione Tipo de Reparacion</h6>
                            <br />
                            <v-select
                                v-model="seleccionReparacion"
                                placeholder="Seleccione Tipo de Reparacion"
                                class="w-full select-large"
                                label="descripcionTipoReparacion"
                                :options="listadoTipoRep"
                                @input="
                                    arrayTipoReparacion(seleccionReparacion.id)
                                "
                            ></v-select>
                            <br />
                            <h6>4.2 - Seleccione Estado</h6>
                            <br />
                            <v-select
                                v-model="seleccionEstado"
                                placeholder="Seleccione el Estado"
                                class="w-full select-large"
                                label="descripcionEstado"
                                :options="listadoEstado"
                                @input="arrayEstado(seleccionEstado.id)"
                            ></v-select>
                        </div>
                    </div>
                </vx-card>
            </div>
            <!-- Enviar o Limpiar Formulario -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row">
                    <div class="vx-col sm:w-2/3 w-full ml-auto">
                        <vs-button color="primary" class="mb-2" @click="volver"
                            >Volver</vs-button
                        >
                        <vs-button
                            color="warning"
                            class="mb-2"
                            @click="probando"
                            >Limpiar</vs-button
                        >
                        <vs-button
                            class="mr-3 mb-2"
                            color="success"
                            @click="validarFormulario"
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
import moment from "moment";
import axios from "axios";
import vSelect from "vue-select";
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import { quillEditor } from "vue-quill-editor";
import router from "@/router";

export default {
    data: () => ({
        horasCalculadas: 0,
        colorLoading: "#ff8000",
        diaCalculado: 0,
        format: "d MMMM yyyy",
        nombre: localStorage.getItem("nombre"),
        run: localStorage.getItem("run"),
        fecha1: moment()
            .startOf("day")
            .fromNow(),
        fecha2: moment()
            .endOf("day")
            .fromNow(),
        hora1: moment("8:32", "HH:mm"),
        hora2: moment("12:32", "HH:mm"),
        configFromdateTimePicker: {
            minDate: new Date(),
            maxDate: null
        },
        configTodateTimePicker: {
            minDate: null
        },

        configdateTimePicker: {
            enableTime: true,
            enableSeconds: true,
            noCalendar: true
        },
        listadoEdificios: [],
        datosSolicitud: [],
        listadoServicios: [],
        listadoUnidadEsp: [],
        listadoTemporalServicios: [],
        listadoTemporalUnidadEsp: [],
        listadoTipoRep: [],
        listadoSupervisores: [],
        listadoTrabajadores: [],
        listadoApoyo1: [],
        listadoApoyo2: [],
        listadoApoyo3: [],
        listadoEstado: [],
        listadoCorreo: [],
        listadoServiciosData: [],
        listadoUnidadEspData: [],
        listadoTrabajadoresData: [],
        selectEstado: [],
        gestionTicket: {
            uuid: "",
            id_solicitud: 0,
            id_edificio: 0,
            id_servicio: 0,
            id_ubicacionEx: 0,
            id_tipoReparacion: 0,
            id_estado: 1,
            id_supervisor: 0,
            id_trabajador: 0,
            idApoyo1: 999,
            idApoyo2: 999,
            idApoyo3: 999,
            idTurno: 0,
            fechaInicio: null,
            fechaTermino: null,
            horaInicio: null,
            horaTermino: null,
            horasEjecucion: 0,
            diasEjecucion: 0,
            desTrabajador: "",
            desSupervisor: "",
            desEdificio: "",
            desServicio: "",
            desUbicacion: "",
            desReparacion: "",
            desEstado: "",
            desApoyo1: "",
            desApoyo2: "",
            desApoyo3: "",
            nombre: "",
            tituloP: "",
            descripcionP: "",
            fechaInicioFormateada: null,
            fechaCreacion: null,
            id_user: 0,
            descripcionSeguimiento: ""
        },
        listadoTurno: [],
        seleccionTurno: {
            id: 0,
            descripcionTurno: "Seleccione Turno"
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
            descripcionUnidadEsp: "Seleccione Unidad Especifica"
        },
        seleccionReparacion: {
            id: 0,
            descripcionTipoReparacion: "Seleccione Tipo de Reparacion"
        },
        seleccionEstado: {
            id: 0,
            descripcionEstado: "Seleccione Estado"
        },
        seleccionSupervisor: {
            id: 0,
            sup_nombre_apellido: "Seleccione al Supervisor"
        },
        seleccionTrabajador: {
            id: 0,
            tra_nombre_apellido: "Seleccione al Trabajador"
        },
        seleccionApoyo1: {
            id: 0,
            tra_nombre_apellido: "Seleccione Apoyo 1"
        },
        seleccionApoyo2: {
            id: 0,
            tra_nombre_apellido: "Seleccione Apoyo 2"
        },
        seleccionApoyo3: {
            id: 0,
            tra_nombre_apellido: "Seleccione Apoyo 3"
        },
        variablePrueba: 0,
        mensajeError: "",

        localVal: "http://127.0.0.1:8000"
    }),
    computed: {
        calcularHorasTrabajo() {
            if (
                this.gestionTicket.fechaInicio != null &&
                this.gestionTicket.horaInicio != null &&
                this.gestionTicket.fechaTermino != null &&
                this.gestionTicket.horaTermino != null
            ) {
                this.hora1 = moment(
                    this.gestionTicket.fechaInicio +
                        " " +
                        this.gestionTicket.horaInicio
                );

                this.hora2 = moment(
                    this.gestionTicket.fechaTermino +
                        " " +
                        this.gestionTicket.horaTermino
                );
                var mili = this.hora2.diff(this.hora1);
                var duracion = moment.duration(mili);

                this.gestionTicket.horasEjecucion = duracion.asHours();
                return this.gestionTicket.horasEjecucion;
            }
        },
        diasCalculados() {
            this.fecha1 = moment(this.gestionTicket.fechaInicio);
            this.fecha2 = moment(this.gestionTicket.fechaTermino);
            this.gestionTicket.diasEjecucion = this.fecha2.diff(
                this.fecha1,
                "days"
            );

            if (this.fecha1.isSame(this.fecha2)) {
                this.gestionTicket.diasEjecucion = 1;
            }
            return this.gestionTicket.diasEjecucion;
            // this.diaCalculado = this.fromDate - this.toDate;
        }
    },
    methods: {
        volver() {
            router.back();
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
        arrayEstado(id) {
            let c = this.listadoEstado;
            let b = [];
            var a = 0;

            c.forEach((value, index) => {
                a = value.id;
                if (a == id) {
                    b.push(value);
                }
            });
            this.seleccionEstado = b;
        },
        arrayTipoReparacion(id) {
            let c = this.listadoTipoRep;
            let b = [];
            var a = 0;

            c.forEach((value, index) => {
                a = value.id;
                if (a == id) {
                    b.push(value);
                }
            });
            this.seleccionReparacion = b;
        },
        arraySupervisores(id) {
            let c = this.listadoSupervisores;
            let b = [];
            var a = 0;

            c.forEach((value, index) => {
                a = value.id;
                if (a == id) {
                    b.push(value);
                }
            });
            this.seleccionSupervisor = b;
        },
        arrayTrabajadores(id) {
            let c = this.listadoTrabajadoresData;
            let b = [];
            var a = 0;

            c.forEach((value, index) => {
                a = value.id;
                if (a == id) {
                    b.push(value);
                }
            });
            this.seleccionTrabajador = b;

            b = [];
            a = 0;

            c.forEach((value, index) => {
                a = value.id;
                if (a == 999) {
                    b.push(value);
                } else if (a != id) {
                    b.push(value);
                }
            });

            this.listadoApoyo1 = b;
        },
        arrayApoyo1(id) {
            let c = this.listadoApoyo1;
            let b = [];
            var a = 0;

            c.forEach((value, index) => {
                a = value.id;
                if (a == id) {
                    b.push(value);
                }
            });
            this.seleccionApoyo1 = b;

            b = [];
            a = 0;

            c.forEach((value, index) => {
                a = value.id;
                if (id == 999) {
                    b.push(value);
                } else if (a != id) {
                    b.push(value);
                }
            });

            this.listadoApoyo2 = b;
        },

        arrayApoyo2(id) {
            let c = this.listadoApoyo2;
            let b = [];
            var a = 0;

            c.forEach((value, index) => {
                a = value.id;
                if (a == id) {
                    b.push(value);
                }
            });
            this.seleccionApoyo2 = b;

            b = [];
            a = 0;

            c.forEach((value, index) => {
                a = value.id;
                if (id == 999) {
                    b.push(value);
                } else if (a != id) {
                    b.push(value);
                }
            });

            this.listadoApoyo3 = b;
        },
        arrayApoyo3(id) {
            let c = this.listadoApoyo3;
            let b = [];
            var a = 0;

            c.forEach((value, index) => {
                a = value.id;
                if (a == id) {
                    b.push(value);
                }
            });
            this.seleccionApoyo3 = b;
        },
        onFromChange(selectedDates, dateStr, instance) {
            this.$set(this.configTodateTimePicker, "minDate", dateStr);
        },
        onToChange(selectedDates, dateStr, instance) {
            this.$set(this.configFromdateTimePicker, "maxDate", dateStr);
        },
        cargarEdificios() {
            axios.get(this.localVal + "/api/Usuario/GetEdificios").then(res => {
                this.listadoEdificios = res.data;
            });
        },
        cargarServicios() {
            axios.get(this.localVal + "/api/Usuario/GetServicios").then(res => {
                this.listadoServicios = res.data;
                this.listadoTemporalServicios = res.data;
                this.listadoServiciosData = res.data;
            });
        },
        cargarUnidadEsp() {
            axios.get(this.localVal + "/api/Usuario/GetUnidadEsp").then(res => {
                this.listadoUnidadEsp = res.data;
                this.listadoTemporalUnidadEsp = res.data;
                this.listadoUnidadEspData = res.data;
            });
        },
        cargarTipoRep() {
            axios.get(this.localVal + "/api/Usuario/GetTipoRep").then(res => {
                this.listadoTipoRep = res.data;
            });
        },
        cargarSupervisores() {
            axios
                .get(this.localVal + "/api/Agente/GetSupervisores")
                .then(res => {
                    this.listadoSupervisores = res.data;
                });
        },
        cargarTurnos() {
            axios.get(this.localVal + "/api/Agente/GetTurnos").then(res => {
                this.listadoTurno = res.data;
            });
        },
        cargarTrabajadores() {
            axios
                .get(this.localVal + "/api/Agente/GetTrabajadores")
                .then(res => {
                    this.cargarApoyosArray(res.data);
                });
        },
        cargarApoyosArray(listadoApoyo) {
            this.listadoTrabajadoresData = listadoApoyo;
            let c = listadoApoyo;

            let b = [];
            var a = 0;

            c.forEach((value, index) => {
                if (999 != value.id) {
                    b.push(value);
                }
            });

            this.listadoTrabajadores = b;
        },
        cargarEstado() {
            axios.get(this.localVal + "/api/Agente/GetEstado").then(res => {
                this.listadoEstado = res.data;
            });
        },
        cargaTicketAsignado() {
            let id = this.$route.params.id;
            axios
                .get(this.localVal + `/api/Agente/TraerTicket/${id}`)
                .then(res => {
                    this.datosSolicitud = res.data;

                    var datoidServicio = this.datosSolicitud[0].id_servicio;
                    var datoidEdificio = this.datosSolicitud[0].id_edificio;
                    var datoidUbicacion = this.datosSolicitud[0].id_ubicacionEx;
                    var datoidEstado = this.datosSolicitud[0].id_estado;
                    var datoidRep = this.datosSolicitud[0].id_tipoReparacion;
                    this.cargarUSE(
                        datoidServicio,
                        datoidEdificio,
                        datoidUbicacion,
                        datoidEstado,
                        datoidRep
                    );
                });
        },
        errorDrop(mensajeError) {
            this.$vs.notify({
                title: "Falto seleccionar " + mensajeError,
                text: "Seleccione " + mensajeError,
                color: "danger",
                position: "top-right"
            });
        },
        errorEstado(mensajeError) {
            this.$vs.notify({
                title: "Debe cambiar " + mensajeError,
                text: "Debe cambiar el estado a 'en proceso' ",
                color: "danger",
                position: "top-right"
            });
        },
        mensajeGuardado() {
            this.$vs.notify({
                time: 5000,
                title: "Ticket Asignado",
                text:
                    "Ticket Asignado correctamente, Retornara a la pagina anterior",
                color: "success",
                position: "top-right"
            });
        },
        validarFormulario() {
            var hoy = new Date();
            try {
                if (this.seleccionEdificio[0].id == 0) {
                    this.mensajeError = "el Edificio";
                    this.errorDrop(this.mensajeError);
                } else if (this.seleccionServicio[0].id == 0) {
                    this.mensajeError = "el servicio";
                    this.errorDrop(this.mensajeError);
                } else if (this.seleccionUnidadEsp[0].id == 0) {
                    this.mensajeError = "la Unidad especifica";
                    this.errorDrop(this.mensajeError);
                } else if (this.seleccionReparacion[0].id == 0) {
                    this.mensajeError = "el tipo de reparacion";
                    this.errorDrop(this.mensajeError);
                } else if (this.seleccionEstado[0].id == 0) {
                    this.mensajeError = "el estado";
                    this.errorDrop(this.mensajeError);
                } else if (this.seleccionSupervisor[0].id == 0) {
                    this.mensajeError = "el supervisor";
                    this.errorDrop(this.mensajeError);
                } else if (this.seleccionTrabajador[0].id == 0) {
                    this.mensajeError = "el trabajador";
                    this.errorDrop(this.mensajeError);
                } else if (this.seleccionApoyo1[0].id == 0) {
                    this.mensajeError = "el apoyo 1";
                    this.errorDrop(this.mensajeError);
                } else if (this.seleccionApoyo2[0].id == 0) {
                    this.mensajeError = "el apoyo 2";
                    this.errorDrop(this.mensajeError);
                } else if (this.seleccionApoyo3[0].id == 0) {
                    this.mensajeError = "el apoyo 3";
                    this.errorDrop(this.mensajeError);
                } else if (
                    this.gestionTicket.fechaInicio == null ||
                    this.gestionTicket.fechaInicio < hoy.getDate()
                ) {
                    this.mensajeError = "la fecha de inicio ";
                    this.errorDrop(this.mensajeError);
                } else if (
                    this.gestionTicket.fechaTermino == null ||
                    this.gestionTicket.fechaTermino < hoy.getDate()
                ) {
                    this.mensajeError = "la fecha de termino";
                    this.errorDrop(this.mensajeError);
                } else if (this.gestionTicket.horasEjecucion == 0) {
                    this.mensajeError = "Las horas calculadas no pueden ser 0";
                    this.errorDrop(this.mensajeError);
                } else if (this.gestionTicket.diasEjecucion == 0) {
                    this.mensajeError = "Los dias calculados no pueden ser 0";
                    this.errorDrop(this.mensajeError);
                } else {
                    this.guardarFormulario();
                }
            } catch (error) {
                if (this.seleccionEdificio.id == 0) {
                    this.mensajeError = "el Edificio";
                    this.errorDrop(this.mensajeError);
                } else if (this.seleccionServicio.id == 0) {
                    this.mensajeError = "el servicio";
                    this.errorDrop(this.mensajeError);
                } else if (this.seleccionUnidadEsp.id == 0) {
                    this.mensajeError = "la Unidad especifica";
                    this.errorDrop(this.mensajeError);
                } else if (this.seleccionReparacion.id == 0) {
                    this.mensajeError = "el tipo de reparacion";
                    this.errorDrop(this.mensajeError);
                } else if (this.seleccionEstado.id == 0) {
                    this.mensajeError = "el estado";
                    this.errorDrop(this.mensajeError);
                } else if (this.seleccionSupervisor.id == 0) {
                    this.mensajeError = "el supervisor";
                    this.errorDrop(this.mensajeError);
                } else if (this.seleccionTrabajador.id == 0) {
                    this.mensajeError = "el trabajador";
                    this.errorDrop(this.mensajeError);
                } else if (this.seleccionApoyo1.id == 0) {
                    this.mensajeError = "el apoyo 1";
                    this.errorDrop(this.mensajeError);
                } else if (this.seleccionApoyo2.id == 0) {
                    this.mensajeError = "el apoyo 2";
                    this.errorDrop(this.mensajeError);
                } else if (this.seleccionApoyo3.id == 0) {
                    this.mensajeError = "el apoyo 3";
                    this.errorDrop(this.mensajeError);
                } else if (
                    this.gestionTicket.fechaInicio == null ||
                    this.gestionTicket.fechaInicio < hoy.getDate()
                ) {
                    this.mensajeError = "la fecha de inicio ";
                    this.errorDrop(this.mensajeError);
                } else if (
                    this.gestionTicket.fechaTermino == null ||
                    this.gestionTicket.fechaTermino < hoy.getDate()
                ) {
                    this.mensajeError = "la fecha de termino";
                    this.errorDrop(this.mensajeError);
                } else if (this.gestionTicket.horasEjecucion == 0) {
                    this.mensajeError = "Las horas calculadas no pueden ser 0";
                    this.errorDrop(this.mensajeError);
                } else if (this.gestionTicket.diasEjecucion == 0) {
                    this.mensajeError = "Los dias calculados no pueden ser 0";
                    this.errorDrop(this.mensajeError);
                } else {
                    this.guardarFormulario();
                }
            }
        },
        guardarFormulario() {
            var hoy = new Date();

            if (this.seleccionEdificio[0].id == 0) {
                this.mensajeError = "el Edificio";
                this.errorDrop(this.mensajeError);
            } else if (this.seleccionServicio[0].id == 0) {
                this.mensajeError = "el servicio";
                this.errorDrop(this.mensajeError);
            } else if (this.seleccionUnidadEsp[0].id == 0) {
                this.mensajeError = "la Unidad especifica";
                this.errorDrop(this.mensajeError);
            } else if (this.seleccionReparacion[0].id == 0) {
                this.mensajeError = "el tipo de reparacion";
                this.errorDrop(this.mensajeError);
            } else if (
                this.seleccionEstado[0].id == 0 ||
                this.seleccionEstado[0].id == null ||
                this.seleccionEstado[0].id == 1
            ) {
                this.mensajeError = "el estado";
                this.errorEstado(this.mensajeError);
            } else if (this.seleccionSupervisor.id == 0) {
                this.mensajeError = "el supervisor";
                this.errorDrop(this.mensajeError);
            } else if (this.seleccionTrabajador.id == 0) {
                this.mensajeError = "el trabajador";
                this.errorDrop(this.mensajeError);
            } else if (this.seleccionTurno.id == 0) {
                this.mensajeError = "el turno";
                this.errorDrop(this.mensajeError);
            } else if (this.seleccionApoyo1.id == 0) {
                this.mensajeError = "el apoyo 1";
                this.errorDrop(this.mensajeError);
            } else if (this.seleccionApoyo2.id == 0) {
                this.mensajeError = "el apoyo 2";
                this.errorDrop(this.mensajeError);
            } else if (this.seleccionApoyo3.id == 0) {
                this.mensajeError = "el apoyo 3";
                this.errorDrop(this.mensajeError);
            } else if (
                this.gestionTicket.fechaInicio == null ||
                this.gestionTicket.fechaInicio < hoy.getDate()
            ) {
                this.mensajeError = "la fecha de inicio ";
                this.errorDrop(this.mensajeError);
            } else if (
                this.gestionTicket.fechaTermino == null ||
                this.gestionTicket.fechaTermino < hoy.getDate()
            ) {
                this.mensajeError = "la fecha de termino";
                this.errorDrop(this.mensajeError);
            } else if (this.gestionTicket.horasEjecucion == 0) {
                this.mensajeError = "Las horas calculadas no pueden ser 0";
                this.errorDrop(this.mensajeError);
            } else if (this.gestionTicket.diasEjecucion == 0) {
                this.mensajeError = "Los dias calculados no pueden ser 0";
                this.errorDrop(this.mensajeError);
            } else {
                let uuid = this.$route.params.uuid;
                this.gestionTicket.uuid = uuid;
                let id = this.$route.params.id;

                this.gestionTicket.id_solicitud = id;
                this.gestionTicket.id_edificio = this.seleccionEdificio[0].id;
                this.gestionTicket.id_servicio = this.seleccionServicio[0].id;
                this.gestionTicket.id_ubicacionEx = this.seleccionUnidadEsp[0].id;
                this.gestionTicket.id_tipoReparacion = this.seleccionReparacion[0].id;
                this.gestionTicket.id_estado = this.seleccionEstado[0].id;
                this.gestionTicket.id_supervisor = this.seleccionSupervisor[0].id;
                this.gestionTicket.id_trabajador = this.seleccionTrabajador[0].id;
                this.gestionTicket.idApoyo1 = this.seleccionApoyo1[0].id;
                this.gestionTicket.idApoyo2 = this.seleccionApoyo2[0].id;
                this.gestionTicket.idApoyo3 = this.seleccionApoyo3[0].id;
                this.gestionTicket.idTurno = this.seleccionTurno.id;
                this.gestionTicket.desEdificio = this.seleccionEdificio[0].descripcionEdificio;
                this.gestionTicket.desServicio = this.seleccionServicio[0].descripcionServicio;
                this.gestionTicket.desUbicacion = this.seleccionUnidadEsp[0].descripcionUnidadEsp;
                this.gestionTicket.desReparacion = this.seleccionReparacion[0].descripcionTipoReparacion;
                this.gestionTicket.desEstado = this.seleccionEstado[0].descripcionEstado;
                this.gestionTicket.desTrabajador = this.seleccionTrabajador.tra_nombre_apellido;
                this.gestionTicket.desSupervisor = this.seleccionSupervisor.sup_nombre_apellido;
                this.gestionTicket.desApoyo1 = this.seleccionApoyo1[0].tra_nombre_apellido;
                this.gestionTicket.desApoyo2 = this.seleccionApoyo2[0].tra_nombre_apellido;
                this.gestionTicket.desApoyo3 = this.seleccionApoyo3[0].tra_nombre_apellido;
                this.gestionTicket.idTurno = this.seleccionTurno.id;
                this.gestionTicket.tituloP = this.datosSolicitud[0].tituloP;
                var newElement = document.createElement("div");
                newElement.innerHTML = this.datosSolicitud[0].descripcionP;
                this.gestionTicket.descripcionP = newElement.textContent;
                this.gestionTicket.nombre = this.nombre;
                var fechaCreacionT = moment(this.datosSolicitud[0].created_at)
                    .locale("es")
                    .format("Do MMMM YYYY, HH:mm:ss");
                this.gestionTicket.fechaCreacion = fechaCreacionT;

                var fechaInicioT = moment(this.hora1)
                    .locale("es")
                    .format("Do MMMM YYYY, HH:mm:ss");

                this.gestionTicket.fechaInicioFormateada = fechaInicioT;
                this.gestionTicket.id_user = localStorage.getItem("id");
                this.gestionTicket.descripcionSeguimiento =
                    "El Agente " +
                    this.nombre +
                    " a asignado un ticket a " +
                    this.gestionTicket.desTrabajador +
                    " en el Ticket N°" +
                    id;

                const ticket = this.gestionTicket;
                this.openLoadingColor();

                axios
                    .post(this.localVal + "/api/Agente/PostTicket", ticket)
                    .then(res => {
                        const ticketServer = res.data;
                        this.mensajeGuardado();
                        setTimeout(() => {
                            router.back();
                        }, 4000);
                    });
            }
        },
        openLoadingColor() {
            this.$vs.loading({ color: this.colorLoading });
            setTimeout(() => {
                this.$vs.loading.close();
            }, 2000);
        },
        cargarUSE(
            datoidServicio,
            datoidEdificio,
            datoidUbicacion,
            datoidEstado,
            datoidRep
        ) {
            let c = this.listadoUnidadEsp;
            let b = [];
            var a = 0;
            c.forEach((value, index) => {
                a = value.id;

                if (a == datoidUbicacion) {
                    b.push(value);
                }
            });

            this.seleccionUnidadEsp = b;

            b = [];
            c = this.listadoServicios;

            c.forEach((value, index) => {
                a = value.id;
                if (a == datoidServicio) {
                    b.push(value);
                }
            });

            this.seleccionServicio = b;

            c = this.listadoEdificios;
            b = [];
            c.forEach((value, index) => {
                a = value.id;
                if (a == datoidEdificio) {
                    b.push(value);
                }
            });

            this.seleccionEdificio = b;

            c = this.listadoEstado;
            b = [];
            c.forEach((value, index) => {
                a = value.id;
                if (a == datoidEstado) {
                    b.push(value);
                }
            });
            this.seleccionEstado = b;

            c = this.listadoTipoRep;
            b = [];
            c.forEach((value, index) => {
                a = value.id;
                if (a == datoidRep) {
                    b.push(value);
                }
            });
            this.seleccionReparacion = b;
        },

        cargarInicial() {
            this.cargarEstado();
            this.cargarTipoRep();
            this.cargarEdificios();
            this.cargarServicios();
            this.cargarUnidadEsp();
            this.cargarTipoRep();
            this.cargarSupervisores();
            this.cargarTrabajadores();
            this.cargarTurnos();
        },
        probando() {
            console.log(this.seleccionEdificio);
        }
    },
    created: function() {
        this.cargarInicial();
        this.cargaTicketAsignado();
    },
    components: {
        flatPickr,
        "v-select": vSelect,
        quillEditor
    }
};
</script>

<style lang="stylus">
.examplex {
  display: flex;
  align-items: center;
  justify-content: center;

  button {
    margin: 0px !important;

    &.btnx {
      margin-left: 10px !important;
      border-radius: 5px 0px 0px 5px;
    }

    &.btn-drop {
      border-radius: 0px 5px 5px 0px;
      border-left: 1px solid rgba(255, 255, 255, 0.2);

      .cardx {
        margin: 15px;
      }
    }
  }
}
</style>
