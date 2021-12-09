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
                        <div class="vx-col w-1/2 mt-5">
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
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.2 - Seleccione el Servicio</h6>
                            <br />
                            <v-select
                                taggable
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
            <!-- Personal -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="2. Asignar Supervisor y Tecnico" code-toggler>
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
                                taggable
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
                            ></v-select>
                            <br />
                            <h6>4.3 - Seleccione Prioridad</h6>
                            <br />
                            <v-select
                                v-model="seleccionPrioridad"
                                placeholder="Seleccione la Prioridad"
                                class="w-full select-large"
                                label="descripcion_prioridad"
                                :options="listadoPrioridad"
                            ></v-select>
                            <br />
                            <h6>4.4 - Duracion</h6>
                            <br />
                            <v-select
                                v-model="seleccionDuracion"
                                placeholder="Seleccione el Estado"
                                class="w-full select-large"
                                label="descripcion_duracion"
                                :options="listadoDuracion"
                                @input="arrayDuracion(seleccionDuracion.id)"
                            ></v-select>
                            <br />
                            <h6>
                                4.5 - Seleccione Tipo Daño Equipamiento Medico
                            </h6>
                            <br />
                            <v-select
                                v-model="seleccionDanios"
                                placeholder="Seleccione Tipo Daño"
                                class="w-full select-large"
                                label="desdanioseq"
                                :options="listadoDaniosEM"
                            ></v-select>
                            <br />
                            <h6>4.6 - Descripcion del problema</h6>
                            <br />
                            <quill-editor
                                v-model="descripcionP"
                                :options="editorOption"
                            >
                                <div id="toolbar" slot="toolbar"></div>
                            </quill-editor>
                            <br />
                            <h6>4.7 - Resolucion y Resultados</h6>
                            <br />
                            <quill-editor
                                v-model="gestionTicket.desresolucionresultados"
                                :options="editorOption"
                            >
                                <div id="toolbar" slot="toolbar"></div>
                            </quill-editor>
                            <br />
                            <h6>4.8 - Observaciones</h6>
                            <br />
                            <quill-editor
                                v-model="gestionTicket.desobservaciones"
                                :options="editorOption"
                            >
                                <div id="toolbar" slot="toolbar"></div>
                            </quill-editor>
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
                        <vs-button color="warning" class="mb-2" @click="limpiar"
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

        <vs-popup
            classContent="popup-example"
            title="Guardar Nuevo Trabajador"
            :active.sync="popCrearTrabajador"
            fullscreen
        >
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
                                label="sup_nombre_apellido"
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
            <div class="vx-col md:w-full w-full mb-base">
                <div class="vx-row mb-12">
                    <div class="vx-col w-1/3 mt-5">
                        <vs-button
                            class="mb-2 w-full"
                            @click="volverTra"
                            color="primary"
                            >Volver
                        </vs-button>
                    </div>
                    <div class="vx-col w-1/3 mt-5">
                        <vs-button
                            class="mb-2 w-full"
                            @click="limpiarTrabajador"
                            color="warning"
                            >Limpiar
                        </vs-button>
                    </div>
                    <div class="vx-col w-1/3 mt-5">
                        <vs-button
                            class="mb-2 w-full"
                            @click="guardarTrabajador"
                            color="success"
                            >Enviar</vs-button
                        >
                    </div>
                </div>
            </div>
        </vs-popup>
        <vs-popup
            classContent="popup-example"
            title="Guardar Nuevo Servicio?"
            :active.sync="popAServicio"
        >
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row">
                    <div class="vx-col sm:w-full w-full">
                        <vs-button
                            color="warning"
                            type="filled"
                            class="w-full m-2"
                            @click="guardarServicio(value3)"
                            >Guardar</vs-button
                        >
                    </div>
                    <div class="vx-col sm:w-full w-full">
                        <vs-button
                            class="w-full m-2"
                            @click="popAServicio = false"
                            color="primary"
                            type="filled"
                            >Volver</vs-button
                        >
                    </div>
                </div>
            </div>
        </vs-popup>
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
import { validate, clean, format } from "rut.js";

export default {
    data: () => ({
        editorOption: {
            modules: {
                toolbar: [
                    ["bold", "italic", "underline", "strike"],
                    ["blockquote", "code-block"],
                    [{ header: 1 }, { header: 2 }],
                    [{ list: "ordered" }, { list: "bullet" }],
                    [{ indent: "-1" }, { indent: "+1" }],
                    [{ direction: "rtl" }],
                    [{ font: [] }],
                    [{ align: [] }],
                    ["clean"]
                ]
            }
        },
        horasCalculadas: 0,
        colorLoading: "#ff8000",
        diaCalculado: 0,
        format: "d MMMM yyyy",
        nombre: sessionStorage.getItem("nombre"),
        run: sessionStorage.getItem("run"),
        fecha1: moment()
            .startOf("day")
            .fromNow(),
        fecha2: moment()
            .endOf("day")
            .fromNow(),
        hora1: moment("8:32", "HH:mm"),
        hora2: moment("12:32", "HH:mm"),
        configFromdateTimePicker: {
            minDate: null,
            maxDate: null,
            locale: {
                firstDayOfWeek: 1,
                weekdays: {
                    shorthand: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                    longhand: [
                        "Domingo",
                        "Lunes",
                        "Martes",
                        "Miércoles",
                        "Jueves",
                        "Viernes",
                        "Sábado"
                    ]
                },
                months: {
                    shorthand: [
                        "Ene",
                        "Feb",
                        "Mar",
                        "Abr",
                        "May",
                        "Jun",
                        "Jul",
                        "Ago",
                        "Sep",
                        "Оct",
                        "Nov",
                        "Dic"
                    ],
                    longhand: [
                        "Enero",
                        "Febrero",
                        "Мarzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre"
                    ]
                }
            }
        },
        configTodateTimePicker: {
            minDate: null,
            locale: {
                firstDayOfWeek: 1,
                weekdays: {
                    shorthand: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                    longhand: [
                        "Domingo",
                        "Lunes",
                        "Martes",
                        "Miércoles",
                        "Jueves",
                        "Viernes",
                        "Sábado"
                    ]
                },
                months: {
                    shorthand: [
                        "Ene",
                        "Feb",
                        "Mar",
                        "Abr",
                        "May",
                        "Jun",
                        "Jul",
                        "Ago",
                        "Sep",
                        "Оct",
                        "Nov",
                        "Dic"
                    ],
                    longhand: [
                        "Enero",
                        "Febrero",
                        "Мarzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre"
                    ]
                }
            }
        },

        configdateTimePicker: {
            enableTime: true,
            //enableSeconds: true,
            noCalendar: true,
            time_24hr: true,
            dateFormat: "H:i"
        },
        configdateToTimePicker: {
            enableTime: true,
            noCalendar: true,
            time_24hr: true,
            dateFormat: "H:i"
        },
        val_run: false,
        nombreUsuario: "",
        apellidoUsuario: "",
        anexoUsuario: 0,
        correoUsuario: "",
        rutUsuario: null,
        passUsuario: "",
        descripcionP: "",
        popCrearTrabajador: false,
        listadoEspecialidad: [],
        seleccionEspecialidad: {
            id: 0,
            descripcionEspecialidad: "Seleccion Especialidad"
        },
        listadoEdificios: [],
        datosSolicitud: [],
        listadoServicios: [],
        listadoTemporalServicios: [],
        listadoTipoRep: [],
        listadoSupervisores: [],
        listadoTrabajadores: [],
        listadoApoyo1: [],
        listadoApoyo2: [],
        listadoApoyo3: [],
        listadoEstado: [],
        listadoCorreo: [],
        selectEstado: [],
        listadoServiciosData: [],
        listadoTrabajadoresData: [],
        listadoPrioridad: [],
        gestionTicket: {
            uuid: "",
            id_solicitud: 0,
            id_edificio: 0,
            id_servicio: 0,
            id_ubicacionEx: 42,
            id_tipoReparacion: 0,
            id_estado: 1,
            id_supervisor: 0,
            id_trabajador: 0,
            idApoyo1: 1,
            idApoyo2: 1,
            idApoyo3: 1,
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
            descripcionSeguimiento: "",
            id_usuarioSolicitante: 0,
            idDuracion: 0,
            id_prioridad: 0,
            id_danoEQ: 0,
            desresolucionresultados: "",
            desobservaciones: ""
        },
        registroUsuario: {
            run: null,
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
            permiso_usuario: 3,
            estado_login: 1,
            tra_run: "",
            tra_nombre: "",
            tra_apellido: "",
            id_especialidad1: 0,
            idvalRut: 0,
            idvalmail: 0
        },
        listadoTurno: [],
        seleccionTurno: {
            id: 1,
            descripcionTurno: "Dia"
        },
        seleccionEdificio: {
            id: 0,
            descripcionEdificio: "Seleccione Edificio"
        },
        seleccionServicio: {
            id: 0,
            descripcionServicio: "Seleccione Servicio"
        },
        seleccionReparacion: {
            id: 0,
            descripcionTipoReparacion: "Seleccione Tipo de Reparacion"
        },
        seleccionPrioridad: {
            id: 2,
            descripcion_prioridad: "Normal"
        },
        seleccionEstado: {
            id: 2,
            descripcionEstado: "En Proceso"
        },
        seleccionSupervisor: {
            id: 0,
            sup_nombre_apellido: "Seleccione al Supervisor"
        },
        seleccionTrabajador: {
            id: 0,
            tra_nombre_apellido: "Seleccione al Trabajador"
        },
        seleccionApoyo1: [
            {
                id: 1,
                tra_nombre_apellido: "Sin Asignar"
            }
        ],
        seleccionApoyo2: [
            {
                id: 1,
                tra_nombre_apellido: "Sin Asignar"
            }
        ],
        seleccionApoyo3: [
            {
                id: 1,
                tra_nombre_apellido: "Sin Asignar"
            }
        ],
        seleccionDuracion: [
            {
                id: 1,
                descripcion_duracion: "Chequeo"
            }
        ],
        seleccionDanios: {
            id: 1,
            desdanioseq: "Deterioro"
        },
        listadoDuracion: [],
        listadoDaniosEM: [],
        variablePrueba: 0,
        mensajeError: "",

        localVal: process.env.MIX_APP_URL,
        value1: "",
        validaEliminar: false,
        popupActive2: false,
        componentKey: 0,
        popAServicio: false,
        value2: "",
        value3: ""
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
        volverTra() {
            this.popCrearTrabajador = false;
        },
        formatear_run() {
            if (this.rutUsuario == "" || this.rutUsuario == null) {
                this.val_run = false;
            } else {
                this.rutUsuario = format(this.rutUsuario);
                this.val_run = !validate(this.rutUsuario);
            }
        },
        volver() {
            router.back();
        },
        cargarPrioridades() {
            axios
                .get(this.localVal + "/api/Usuario/GetPrioridades", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoPrioridad = res.data;
                });
        },
        guardarTrabajador() {
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
                this.registroUsuario.password = this.passUsuario;
                this.registroUsuario.run_usuario = this.rutUsuario;
                this.registroUsuario.tra_run = this.rutUsuario;
                this.registroUsuario.tra_nombre = this.nombreUsuario;
                this.registroUsuario.tra_apellido = this.apellidoUsuario;
                this.registroUsuario.id_especialidad1 = this.seleccionEspecialidad[0].id;

                if (
                    this.rutUsuario == 0 ||
                    this.rutUsuario == null ||
                    this.rutUsuario == "" ||
                    this.rutUsuario.length < 7
                ) {
                    this.registroUsuario.run = null;
                    this.rutUsuario = null;
                    this.registroUsuario.idvalRut = 0;
                } else {
                    this.rutUsuario = format(this.rutUsuario);
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
                //this.rutUsuario = format(this.rutUsuario);
                /* if (
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
                }  else */ if (
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
                            this.localVal + "/api/Agente/GuardarTrabajador",
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
                            this.limpiar();
                            const ticketServer = res.data;
                            this.$vs.notify({
                                title: "Trabajador Agregado Correctamente",
                                text: "Se recargaran los campos",
                                color: "success",
                                position: "top-right",
                                time: 3000
                            });
                            this.cargarSupervisores();
                            this.cargarTrabajadores();
                            this.popCrearTrabajador = false;
                        });
                }
            }
        },
        arrayEspecialidad() {
            let id = this.seleccionEspecialidad.id;
            let c = JSON.parse(JSON.stringify(this.listadoEspecialidad));
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
        limpiarTrabajador() {
            this.registroUsuario.run = null;
            this.registroUsuario.email = "";
            this.registroUsuario.nombre = "";
            this.registroUsuario.apellido = "";
            this.registroUsuario.anexo = 0;
            this.registroUsuario.id_cargo = 0;
            this.registroUsuario.id_edificio = 0;
            this.registroUsuario.id_servicio = 0;
            this.registroUsuario.id_unidadEspecifica = 42;
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
            this.rutUsuario = null;
            this.passUsuario = "";
        },

        filtroSegunEdificio() {
            if (this.seleccionEdificio == null || this.seleccionEdificio == 0) {
                this.listadoServicios = JSON.parse(
                    JSON.stringify(this.listadoServiciosData)
                );
            } else {
                var idGeneral = this.seleccionEdificio.id;
                let c = JSON.parse(JSON.stringify(this.listadoServiciosData));
                let b = [];
                var a = 0;
                c.forEach((value, index) => {
                    a = value.id_edificio;
                    if (a == idGeneral) {
                        b.push(value);
                    }
                });

                this.listadoServicios = b;
                c = JSON.parse(JSON.stringify(this.listadoEdificios));
                b = [];
                a = 0;
                c.forEach((value, index) => {
                    a = value.id;
                    if (a == idGeneral) {
                        b.push(value);
                    }
                });

                this.seleccionEdificio = b;
            }
        },
        guardarServicio(val3) {
            try {
                let servicio = {
                    id_edificio: "",
                    descripcionServicio: 0
                };
                if (
                    this.seleccionEdificio.id > 0 ||
                    this.seleccionEdificio.id != 0 ||
                    this.seleccionEdificio.id !== null
                ) {
                    servicio = {
                        id_edificio: this.seleccionEdificio.id,
                        descripcionServicio: val3
                    };
                } else {
                    servicio = {
                        id_edificio: this.seleccionEdificio[0].id,
                        descripcionServicio: val3
                    };
                }

                axios
                    .post(
                        this.localVal + "/api/Agente/PostServicios",
                        servicio,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        if (res.data == true) {
                            this.$vs.notify({
                                time: 3000,
                                title: "Servicio fue Agregado Correctamente",
                                text: "Se Recargara Listado",
                                color: "success",
                                position: "top-right"
                            });
                            this.value3 = "";
                            this.cargarEdificios();
                            this.cargarServicios();
                            this.popAServicio = false;
                            this.seleccionServicio = {
                                id: 0,
                                descripcionServicio: "Seleccione Servicio"
                            };
                        } else {
                            this.$vs.notify({
                                time: 3000,
                                title: "Error",
                                text: "Hubo una falla al agregar servicio",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(
                    "Hubo un error al guardar el servicio o listar los datos"
                );
            }
        },
        cargaSegunServicio() {
            try {
                if (
                    this.seleccionServicio.id == 0 ||
                    this.seleccionServicio.id == null
                ) {
                    if (
                        this.seleccionEdificio.id == 0 ||
                        this.seleccionEdificio[0].id == 0
                    ) {
                        this.$vs.notify({
                            time: 3000,
                            title: "Error",
                            text:
                                "Debe seleccionar un edificio para poder guardar un nuevo servicio asociado",
                            color: "danger",
                            position: "top-right"
                        });
                    } else {
                        if (
                            this.seleccionServicio.descripcionServicio ===
                                undefined ||
                            this.seleccionServicio.descripcionServicio === "" ||
                            this.seleccionServicio.descripcionServicio === null
                        ) {
                            this.value3 = this.seleccionServicio;
                        } else {
                            this.value3 = this.seleccionServicio.descripcionServicio;
                        }
                        this.popAServicio = true;
                    }
                } else {
                    if (
                        this.seleccionServicio == null ||
                        this.seleccionServicio.id == 0
                    ) {
                        this.listadoServicios = JSON.parse(
                            JSON.stringify(this.listadoServiciosData)
                        );
                    } else {
                        var idGeneral = this.seleccionServicio.id;

                        let c = JSON.parse(
                            JSON.stringify(this.listadoServiciosData)
                        );
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

                        c = JSON.parse(JSON.stringify(this.listadoEdificios));

                        c.forEach((value, index) => {
                            a = value.id;
                            if (a == idGeneral) {
                                b.push(value);
                            }
                        });

                        this.seleccionEdificio = b;
                    }
                }
            } catch (error) {
                console.log("Error en servicio");
                console.log(error);
            }
        },
        arrayEstado(id) {
            let c = JSON.parse(JSON.stringify(this.listadoEstado));
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
        arrayDuracion(id) {
            let c = JSON.parse(JSON.stringify(this.listadoDuracion));
            let b = [];
            var a = 0;

            c.forEach((value, index) => {
                a = value.id;
                if (a == id) {
                    b.push(value);
                }
            });
            this.seleccionDuracion = b;
        },
        arrayTipoReparacion(id) {
            let c = JSON.parse(JSON.stringify(this.listadoTipoRep));
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
            let c = JSON.parse(JSON.stringify(this.listadoSupervisores));
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
        arraySupervisor() {
            let id = this.seleccionSupervisor.id;
            let c = JSON.parse(JSON.stringify(this.listadoSupervisores));
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
        arrayTrabajadores(id) {
            if (id == 0 || id == null) {
                this.popCrearTrabajador = true;
            } else {
                let c = JSON.parse(
                    JSON.stringify(this.listadoTrabajadoresData)
                );
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
                    if (a == 1) {
                        b.push(value);
                    } else if (a != id) {
                        b.push(value);
                    }
                });

                this.listadoApoyo1 = b;
            }
        },
        arrayApoyo1(id) {
            let c = JSON.parse(JSON.stringify(this.listadoApoyo1));
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
                if (id == 1) {
                    this.seleccionApoyo2 = value;
                    this.seleccionApoyo3 = value;
                    b.push(value);
                    id = 0;
                } else if (a != id) {
                    b.push(value);
                }
            });

            this.listadoApoyo2 = b;
        },
        arrayApoyo2(id) {
            let c = JSON.parse(JSON.stringify(this.listadoApoyo2));
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
                if (id == 1) {
                    this.seleccionApoyo3 = value;
                    b.push(value);
                    id = 0;
                } else if (a != id) {
                    b.push(value);
                }
            });

            this.listadoApoyo3 = b;
        },
        arrayApoyo3(id) {
            let c = JSON.parse(JSON.stringify(this.listadoApoyo3));
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
            axios
                .get(this.localVal + "/api/Usuario/GetEdificios", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoEdificios = res.data;
                });
        },
        cargarDaniosEM() {
            axios
                .get(this.localVal + "/api/Agente/GetListadoDanio", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoDaniosEM = res.data;
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
                    this.listadoTemporalServicios = JSON.parse(
                        JSON.stringify(this.listadoServicios)
                    );
                    this.listadoServiciosData = JSON.parse(
                        JSON.stringify(this.listadoServicios)
                    );
                });
        },
        cargarTipoRep() {
            axios
                .get(this.localVal + "/api/Usuario/getTReparacionSI", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoTipoRep = res.data;
                });
        },
        cargarSupervisores() {
            axios
                .get(this.localVal + "/api/Agente/GetSupervisores", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoSupervisores = res.data;
                });
        },
        cargarTurnos() {
            axios
                .get(this.localVal + "/api/Agente/getTurnoSL", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoTurno = res.data;
                });
        },
        cargarTrabajadores() {
            axios
                .get(this.localVal + "/api/Agente/GetTrabajadores", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.cargarApoyosArray(res.data);
                });
        },
        cargarApoyosArray(listadoApoyo) {
            this.listadoTrabajadoresData = JSON.parse(
                JSON.stringify(listadoApoyo)
            );
            this.listadoApoyo1 = JSON.parse(JSON.stringify(listadoApoyo));
            this.listadoApoyo2 = JSON.parse(JSON.stringify(listadoApoyo));
            this.listadoApoyo3 = JSON.parse(JSON.stringify(listadoApoyo));
            let c = JSON.parse(JSON.stringify(listadoApoyo));

            let b = [];
            var a = 0;

            c.forEach((value, index) => {
                if (1 != value.id) {
                    b.push(value);
                }
            });

            this.listadoTrabajadores = b;
        },
        cargarEstado() {
            axios
                .get(this.localVal + "/api/Agente/GetEstadoAsignar", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoEstado = res.data;
                    this.seleccionEstado = {
                        id: 2,
                        descripcionEstado: "En Proceso"
                    };
                });
        },
        cargaTicketAsignado() {
            let id = this.$route.params.id;
            axios
                .get(this.localVal + `/api/Agente/TraerTicketEM/${id}`, {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.datosSolicitud = res.data;

                    var datoidServicio = this.datosSolicitud[0].id_servicio;
                    var datoidEdificio = this.datosSolicitud[0].id_edificio;
                    var datoidEstado = this.datosSolicitud[0].id_estado;
                    var datoidRep = this.datosSolicitud[0].id_tipoReparacion;
                    this.descripcionP = this.datosSolicitud[0].descripcionP;
                    this.cargarUSE(
                        datoidServicio,
                        datoidEdificio,
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
                } else if (this.seleccionReparacion[0].id == 0) {
                    this.mensajeError = "el tipo de reparacion";
                    this.errorDrop(this.mensajeError);
                } else if (this.seleccionEstado.id == 0) {
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
                } else if (this.seleccionPrioridad.id == 0) {
                    this.mensajeError = "la prioridad ";
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
                } else if (this.seleccionPrioridad.id == 0) {
                    this.mensajeError = "la prioridad ";
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
            } else if (this.seleccionReparacion[0].id == 0) {
                this.mensajeError = "el tipo de reparacion";
                this.errorDrop(this.mensajeError);
            } else if (
                this.seleccionEstado.id == 0 ||
                this.seleccionEstado.id == null ||
                this.seleccionEstado.id == 1
            ) {
                this.mensajeError = "el estado";
                this.errorEstado(this.mensajeError);
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
            } else if (this.seleccionPrioridad.id == 0) {
                this.mensajeError = "la prioridad ";
                this.errorDrop(this.mensajeError);
            } else {
                let uuid = this.$route.params.uuid;
                this.gestionTicket.uuid = uuid;
                let id = this.$route.params.id;

                this.gestionTicket.id_solicitud = id;
                this.gestionTicket.id_edificio = this.seleccionEdificio[0].id;
                this.gestionTicket.id_servicio = this.seleccionServicio[0].id;
                this.gestionTicket.id_tipoReparacion = this.seleccionReparacion[0].id;
                this.gestionTicket.id_estado = this.seleccionEstado.id;
                this.gestionTicket.id_supervisor = this.seleccionSupervisor[0].id;
                this.gestionTicket.id_trabajador = this.seleccionTrabajador[0].id;
                this.gestionTicket.idApoyo1 = this.seleccionApoyo1[0].id;
                this.gestionTicket.idApoyo2 = this.seleccionApoyo2[0].id;
                this.gestionTicket.idApoyo3 = this.seleccionApoyo3[0].id;
                this.gestionTicket.idTurno = this.seleccionTurno.id;
                this.gestionTicket.desEdificio = this.seleccionEdificio[0].descripcionEdificio;
                this.gestionTicket.desServicio = this.seleccionServicio[0].descripcionServicio;
                this.gestionTicket.desReparacion = this.seleccionReparacion[0].descripcionTipoReparacion;
                this.gestionTicket.desEstado = this.seleccionEstado.descripcionEstado;
                this.gestionTicket.desTrabajador = this.seleccionTrabajador[0].tra_nombre_apellido;
                this.gestionTicket.desSupervisor = this.seleccionSupervisor[0].sup_nombre_apellido;
                this.gestionTicket.desApoyo1 = this.seleccionApoyo1[0].tra_nombre_apellido;
                this.gestionTicket.desApoyo2 = this.seleccionApoyo2[0].tra_nombre_apellido;
                this.gestionTicket.desApoyo3 = this.seleccionApoyo3[0].tra_nombre_apellido;
                this.gestionTicket.idTurno = this.seleccionTurno.id;
                this.gestionTicket.tituloP = this.datosSolicitud[0].tituloP;
                this.gestionTicket.idDuracion = this.seleccionDuracion[0].id;
                this.gestionTicket.id_prioridad = this.seleccionPrioridad.id;
                this.gestionTicket.id_danoEQ = this.seleccionDanios.id;
                var newElement = document.createElement("div");
                newElement.innerHTML = this.datosSolicitud[0].descripcionP;
                this.gestionTicket.descripcionP = this.descripcionP;
                this.gestionTicket.nombre = this.nombre;
                var fechaCreacionT = moment(this.datosSolicitud[0].created_at)
                    .locale("es")
                    .format("Do MMMM YYYY, HH:mm:ss");
                this.gestionTicket.fechaCreacion = fechaCreacionT;
                var fechaInicioT = moment(this.hora1)
                    .locale("es")
                    .format("Do MMMM YYYY, HH:mm:ss");

                this.gestionTicket.fechaInicioFormateada = fechaInicioT;
                this.gestionTicket.id_usuarioSolicitante = this.datosSolicitud[0].id_user;
                this.gestionTicket.id_user = sessionStorage.getItem("id");
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
                    .post(this.localVal + "/api/Agente/PostTicketEM", ticket, {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        const ticketServer = res.data;
                        this.mensajeGuardado();
                        setTimeout(() => {
                            router.back();
                        }, 5000);
                    });
            }
        },
        openLoadingColor() {
            this.$vs.loading({ color: this.colorLoading });
            setTimeout(() => {
                this.$vs.loading.close();
            }, 2000);
        },
        cargarUSE(datoidServicio, datoidEdificio, datoidEstado, datoidRep) {
            let c = JSON.parse(JSON.stringify(this.listadoServicios));
            let b = [];
            var a = 0;

            c.forEach((value, index) => {
                a = value.id;
                if (a == datoidServicio) {
                    b.push(value);
                }
            });

            this.seleccionServicio = b;

            c = JSON.parse(JSON.stringify(this.listadoEdificios));
            b = [];
            c.forEach((value, index) => {
                a = value.id;
                if (a == datoidEdificio) {
                    b.push(value);
                }
            });

            this.seleccionEdificio = b;

            c = JSON.parse(JSON.stringify(this.listadoTipoRep));
            b = [];
            c.forEach((value, index) => {
                a = value.id;
                if (a == datoidRep) {
                    b.push(value);
                }
            });
            this.seleccionReparacion = b;
        },
        cargarDuracion() {
            axios
                .get(this.localVal + "/api/Agente/GetDuracion", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoDuracion = res.data;
                });
        },
        cargarInicial() {
            this.cargarEstado();
            this.cargarTipoRep();
            this.cargarEdificios();
            this.cargarServicios();
            this.cargarTipoRep();
            this.cargarSupervisores();
            this.cargarTrabajadores();
            this.cargarTurnos();
            this.cargarDuracion();
            this.cargarEspecialidad();
        },
        limpiar() {
            this.gestionTicket = {
                uuid: "",
                id_solicitud: 0,
                id_edificio: 2,
                id_servicio: 2,
                id_ubicacionEx: 42,
                id_tipoReparacion: 3,
                id_estado: 1,
                id_supervisor: 4,
                id_trabajador: 5,
                idApoyo1: 1,
                idApoyo2: 1,
                idApoyo3: 1,
                idTurno: 0,
                fechaInicio: moment().format("YYYY-MM-DD"),
                fechaTermino: null,
                horaInicio: moment().format("H:mm"),
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
                descripcionSeguimiento: "",
                id_usuarioSolicitante: 0,
                idDuracion: 0
            };
            this.seleccionTurno = {
                id: 0,
                descripcionTurno: "Seleccione Turno"
            };
            this.seleccionEdificio = {
                id: 0,
                descripcionEdificio: "Seleccione Edificio"
            };
            this.seleccionServicio = {
                id: 0,
                descripcionServicio: "Seleccione Servicio"
            };
            this.seleccionReparacion = {
                id: 0,
                descripcionTipoReparacion: "Seleccione Tipo de Reparacion"
            };
            this.seleccionEstado = {
                id: 2,
                descripcionEstado: "En Proceso"
            };
            this.seleccionSupervisor = {
                id: 0,
                sup_nombre_apellido: "Seleccione al Supervisor"
            };
            this.seleccionTrabajador = {
                id: 0,
                tra_nombre_apellido: "Seleccione al Trabajador"
            };
            this.seleccionApoyo1 = [
                {
                    id: 1,
                    tra_nombre_apellido: "Sin Asignar"
                }
            ];
            this.seleccionApoyo2 = [
                {
                    id: 1,
                    tra_nombre_apellido: "Sin Asignar"
                }
            ];
            this.seleccionApoyo3 = [
                {
                    id: 1,
                    tra_nombre_apellido: "Sin Asignar"
                }
            ];
        },
        cargarHoras() {
            try {
                this.gestionTicket.fechaInicio = moment(new Date()).format(
                    "YYYY-MM-DD"
                );

                this.gestionTicket.horaInicio = moment(new Date()).format(
                    "H:mm"
                );
            } catch (error) {
                console.log("No se cargo la ISO hora");
                console.log(error);
            }
        }
    },
    created() {
        this.cargarInicial();
        this.cargaTicketAsignado();
        this.cargarHoras();
        this.cargarDaniosEM();
        setTimeout(() => {
            this.cargarPrioridades();
        }, 2000);
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
