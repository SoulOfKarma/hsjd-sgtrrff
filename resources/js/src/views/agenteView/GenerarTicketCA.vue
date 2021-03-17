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
                    <h2 class="mb-1">Registrar nuevo Ticket</h2>
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
            <!-- Usuario -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card
                    title="1. Seleccionar Usuario Solicitante"
                    code-toggler
                >
                    <div class="vx-row mb-12">
                        <div class="vx-col w-full mt-5">
                            <h6>1.1 - Seleccione Al usuario</h6>
                            <br />
                            <v-select
                                taggable
                                v-model="seleccionUsuario"
                                placeholder="Seleccione al Usuario"
                                class="w-full select-large"
                                label="nombre"
                                :options="listadoUsuarios"
                                @input="agregarNuevoUsuario()"
                            ></v-select>
                        </div>
                    </div>
                </vx-card>
            </div>
            <!-- Ubicacion -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="2. Lugar del problema">
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
                <vx-card title="3. Asignar Supervisor y Tecnico">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-1/2 mt-5">
                            <h6>3.1 - Seleccione al Supervisor</h6>
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
                            <h6>3.2 - Seleccione al Trabajador</h6>
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
                            <h6>3.3 - Seleccione al Apoyo 1</h6>
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
                            <h6>3.4 - Seleccione al Apoyo 2</h6>
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
                            <h6>3.5 - Seleccione al Apoyo 3</h6>
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
                            <h6>3.6 - Seleccione Turno</h6>
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
                <vx-card title="4. Asignar Hora y Fecha">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-1/2 mt-5">
                            <h6>4.1 - Hora y Fecha de inicio</h6>
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
                            <h6>4.2 - Hora y Fecha de termino</h6>
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
                <vx-card title="5. Informacion del problema" code-toggler>
                    <div class="vx-row mb-12">
                        <div class="vx-col w-full mt-5">
                            <h6>5.1 - Tipo de Reparacion</h6>
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
                            <h6>5.2 - Estado Ticket</h6>
                            <br />
                            <v-select
                                v-model="seleccionEstado"
                                placeholder="Seleccione el Estado"
                                class="w-full select-large"
                                label="descripcionEstado"
                                :options="listadoEstado"
                                @input="arrayEstado(seleccionEstado.id)"
                            ></v-select>
                            <br />
                            <h6>5.3 - Duracion</h6>
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
                            <!-- <h6>5.4 - Titulo del problema</h6>
                            <br />
                            <vs-input
                                placeholder="Ej. Falla de red en equipo x"
                                v-model="gestionTicket.tituloP"
                                class="w-full"
                            />
                            <br /> -->
                            <h6>5.4 - Descripcion del problema</h6>
                            <br />
                            <quill-editor
                                v-model="gestionTicket.descripcionP"
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
                                @keypress="isNumber($event)"
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
            title="Guardar Nuevo Usuario?"
            :active.sync="popCrearUsuario"
        >
            <vs-input
                class="inputx mb-3"
                placeholder="Placeholder"
                v-model="value2"
                hidden
            />
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row">
                    <div class="vx-col md:w-1/1 w-full mb-base">
                        <vx-card title="1. Ingrese Datos del Usuario">
                            <div class="vx-row mb-12">
                                <div class="vx-col w-1/2 mt-5">
                                    <h6>1.1 Rut del Usuario</h6>
                                    <vs-input
                                        class="vx-col w-full mt-5"
                                        v-model="rutUsuarioU"
                                    />
                                    <span
                                        style="font-size: 10px; color: red; margin-left: 10px"
                                        v-if="val_runU"
                                        >Run incorrecto</span
                                    >
                                </div>
                                <div class="vx-col w-1/2 mt-5">
                                    <h6>1.2 Nombre del Usuario</h6>
                                    <vs-input
                                        class="vx-col w-full mt-5"
                                        v-model="nombreUsuarioU"
                                    />
                                </div>
                                <div class="vx-col w-1/2 mt-5">
                                    <h6>1.3 Apellido del Usuario</h6>
                                    <vs-input
                                        class="vx-col w-full mt-5"
                                        v-model="apellidoUsuarioU"
                                    />
                                </div>
                                <div class="vx-col w-1/2 mt-5">
                                    <h6>1.4 Anexo del Usuario</h6>
                                    <vs-input
                                        type="number"
                                        class="vx-col w-full mt-5"
                                        v-model="anexoUsuarioU"
                                        @keypress="isNumber($event)"
                                    />
                                </div>
                                <div class="vx-col w-1/2 mt-5">
                                    <h6>1.5 Correo del Usuario</h6>
                                    <vs-input
                                        type="email"
                                        class="vx-col w-full mt-5"
                                        v-model="correoUsuarioU"
                                    />
                                </div>
                                <div class="vx-col w-1/2 mt-5">
                                    <h6>1.6 Contraseña del Usuario</h6>
                                    <vs-input
                                        type="password"
                                        class="vx-col w-full mt-5"
                                        v-model="passUsuarioU"
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
                                        v-model="seleccionEdificioU"
                                        placeholder="Edificio"
                                        class="w-full select-large"
                                        label="descripcionEdificio"
                                        :options="listadoEdificiosU"
                                        @input="filtroSegunEdificioU()"
                                    ></v-select>
                                </div>
                                <div class="vx-col w-1/2 mt-5">
                                    <h6>2.2 - Seleccione el Servicio</h6>
                                    <br />
                                    <v-select
                                        taggable
                                        v-model="seleccionServicioU"
                                        placeholder="Servicio"
                                        class="w-full select-large"
                                        label="descripcionServicio"
                                        :options="listadoServiciosU"
                                        @input="cargaSegunServicioU()"
                                    ></v-select>
                                </div>
                            </div>
                        </vx-card>
                    </div>
                    <vx-card title="">
                        <div class="vx-row mb-4">
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    class="w-full"
                                    @click="popCrearUsuario = false"
                                    color="primary"
                                    type="filled"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    class="w-full"
                                    color="warning"
                                    @click="guardarUsuarioU"
                                    >Enviar</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
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
                            @click="guardarServicio()"
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
        <vs-popup
            classContent="popup-example"
            title="Guardar Nuevo Servicio?"
            :active.sync="popAServicioU"
        >
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row">
                    <div class="vx-col sm:w-full w-full">
                        <vs-button
                            color="warning"
                            type="filled"
                            class="w-full m-2"
                            @click="guardarServicioU()"
                            >Guardar</vs-button
                        >
                    </div>
                    <div class="vx-col sm:w-full w-full">
                        <vs-button
                            class="w-full m-2"
                            @click="
                                (popAServicioU = false),
                                    (popCrearUsuario = true)
                            "
                            color="primary"
                            type="filled"
                        >
                            Volver</vs-button
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
import VxCard from "../../components/vx-card/VxCard.vue";

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
        diaCalculado: 0,
        format: "d MMMM yyyy",
        nombre:
            sessionStorage.getItem("nombre") +
            " " +
            sessionStorage.getItem("apellido"),
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
        popCrearTrabajador: false,
        popCrearUsuario: false,
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
        listadoTrabajadoresData: [],
        listadoEstado: [],
        listadoCorreo: [],
        listadoCategoria: [],
        listadoUsuarios: [],
        listadoServiciosData: [],
        gestionTicket: {
            id_user: 0,
            uuid: "",
            id_solicitud: 0,
            id_edificio: 2,
            id_servicio: 2,
            id_ubicacionEx: 42,
            id_tipoReparacion: 3,
            id_estado: 4,
            id_supervisor: 4,
            id_trabajador: 5,
            idApoyo1: 5,
            idApoyo2: 5,
            idApoyo3: 5,
            idTurno: 0,
            fechaInicio: null,
            fechaTermino: null,
            horaInicio: null,
            horaTermino: null,
            horasEjecucion: 0,
            diasEjecucion: 0,
            tituloP: ".",
            descripcionP: "",
            id_categoria: 0,
            descripcionCorreo: "",
            nombre: "",
            idDuracion: 0
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
            id: 0,
            descripcionTurno: "Seleccione Turno"
        },
        seleccionEdificio: {
            id: 0,
            descripcionEdificio: "Seleccione Edificio"
        },
        seleccionUsuario: {
            id: 0,
            nombre: "Seleccione Usuario"
        },
        seleccionServicio: {
            id: 0,
            descripcionServicio: "Seleccione Servicio"
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
        seleccionCategoria: {
            id: 0,
            des_categoria: "Seleccione Categoria"
        },
        seleccionDuracion: [
            {
                id: 1,
                descripcion_duracion: "Chequeo"
            }
        ],
        listadoDuracion: [],
        variablePrueba: 0,
        mensajeError: "",
        colorLoading: "#ff8000",
        localVal: process.env.MIX_APP_URL,
        value1: "",
        validaEliminar: false,
        popupActive2: false,
        popupActive3: false,
        popAServicio: false,
        popAServicioU: false,
        value2: "",
        value3: "",
        value4: "",
        componentKey: 0,
        //Lado data crear nuevo usuario
        nombreUsuarioU: "",
        apellidoUsuarioU: "",
        anexoUsuarioU: 0,
        correoUsuarioU: "mantencion.hsjd@edsalud.gov.cl",
        rutUsuarioU: null,
        passUsuarioU: "",
        listadoCargoU: [],
        listadoEdificiosU: [],
        listadoServiciosU: [],
        listadoServiciosDataU: [],
        validaEliminar2: false,
        val_runU: false,
        seleccionCargoU: [
            {
                id: 0,
                descripcionCargo: "Seleccione Cargo"
            }
        ],
        seleccionEdificioU: [
            {
                id: 0,
                descripcionEdificio: "Seleccione Edificio"
            }
        ],
        seleccionServicioU: [
            {
                id: 0,
                descripcionServicio: "Seleccione Servicio"
            }
        ],
        dataUsuarioCreadorU: {
            nombre:
                sessionStorage.getItem("nombre") +
                " " +
                sessionStorage.getItem("apellido"),
            id_user: sessionStorage.getItem("id")
        },
        registroUsuarioU: {
            run: null,
            email: "mantencion.hsjd@edsalud.gov.cl",
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
        }
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
        volverTra() {
            this.popCrearTrabajador = false;
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
        agregarNuevoUsuario() {
            try {
                if (
                    this.seleccionUsuario.id == 0 ||
                    this.seleccionUsuario.id == null ||
                    this.seleccionUsuario == 0 ||
                    this.seleccionUsuario == null
                ) {
                    this.popCrearUsuario = true;
                }
            } catch (error) {
                console.log(error);
            }
        },
        volver() {
            router.back();
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
                    this.rutUsuario == ""
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
                this.rutUsuario = format(this.rutUsuario);
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
        limpiar() {
            this.gestionTicket = {
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
                fechaInicio: moment().format("YYYY-MM-DD"),
                fechaTermino: null,
                horaInicio: moment().format("H:mm"),
                horaTermino: null,
                horasEjecucion: 0,
                diasEjecucion: 0,
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
                id: 0,
                descripcionEstado: "Seleccione Estado"
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
        guardarServicio() {
            try {
                let servicio = {
                    id_edificio: 0,
                    descripcionServicio: ""
                };

                if (
                    this.seleccionEdificio.id > 0 ||
                    this.seleccionEdificio.id != 0 ||
                    this.seleccionEdificio.id !== null
                ) {
                    servicio = {
                        id_edificio: this.seleccionEdificio.id,
                        descripcionServicio: this.value3
                    };
                } else {
                    servicio = {
                        id_edificio: this.seleccionEdificio[0].id,
                        descripcionServicio: this.value3
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
        guardarServicioU() {
            try {
                let servicioU = {
                    id_edificio: 0,
                    descripcionServicio: ""
                };

                servicioU = {
                    id_edificio: this.seleccionEdificioU[0].id,
                    descripcionServicio: this.value4
                };

                axios
                    .post(
                        this.localVal + "/api/Agente/PostServicios",
                        servicioU,
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
                            this.value4 = "";
                            this.cargarEdificios();
                            this.cargarServicios();
                            this.popAServicio = false;
                            this.popCrearUsuario = true;
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
        cargarCategoria() {
            this.csrf_token;

            axios
                .get(this.localVal + "/api/Agente/GetCategoria", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoCategoria = res.data;
                });
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
                if (id == 1) {
                    this.seleccionApoyo3 = value;
                    b.push(value);
                } else if (a == id) {
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
                    this.listadoEdificiosU = JSON.parse(
                        JSON.stringify(this.listadoEdificios)
                    );
                });
        },
        cargarUsuarios() {
            axios
                .get(this.localVal + "/api/Agente/getUsuarios", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoUsuarios = res.data;
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
                    this.listadoTemporalServicios = res.data;
                    this.listadoServiciosData = res.data;
                    this.listadoServiciosU = JSON.parse(
                        JSON.stringify(this.listadoServicios)
                    );
                    this.listadoServiciosDataU = JSON.parse(
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
            this.listadoTrabajadoresData = listadoApoyo;
            let c = listadoApoyo;

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
                .get(this.localVal + "/api/Agente/GetEstado", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoEstado = res.data;
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
        errorTitulo(mensajeError) {
            this.$vs.notify({
                title: mensajeError,
                text: "Debe escribir un titulo superior a 10 caracteres",
                color: "danger",
                position: "top-right"
            });
        },
        errorDescripcion(mensajeError) {
            this.$vs.notify({
                title: mensajeError,
                text: "Debe escribir una descripcion superior a 15 caracteres",
                color: "danger",
                position: "top-right"
            });
        },
        mensajeGuardado() {
            this.$vs.notify({
                time: 5000,
                title: "Ticket Creado",
                text: "Ticket creado correctamente",
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
                } else if (this.seleccionUsuario.id == 0) {
                    this.mensajeError = "el usuario";
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
                    this.gestionTicket.tituloP.trim() === "" ||
                    this.gestionTicket.tituloP.length < 10
                ) {
                    this.mensajeError =
                        "El titulo no puede ser menor a 10 caracteres";
                    this.errorTitulo(this.mensajeError);
                } else if (
                    this.gestionTicket.descripcionP.trim() === "" ||
                    this.gestionTicket.descripcionP.length < 15
                ) {
                    this.mensajeError =
                        "La descripcion no puede ser menor a 15 caracteres";
                    this.errorDescripcion(this.mensajeError);
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
                } else if (this.seleccionUsuario.id == 0) {
                    this.mensajeError = "el usuario";
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
                    this.gestionTicket.descripcionP.trim() === "" ||
                    this.gestionTicket.descripcionP.length < 15
                ) {
                    this.mensajeError =
                        "La descripcion no puede ser menor a 15 caracteres";
                    this.errorDescripcion(this.mensajeError);
                } else {
                    this.guardarFormulario();
                }
            }
        },
        guardarFormulario() {
            this.gestionTicket.id_user = this.seleccionUsuario.id;
            this.gestionTicket.id_edificio = this.seleccionEdificio[0].id;
            this.gestionTicket.id_servicio = this.seleccionServicio[0].id;
            this.gestionTicket.id_tipoReparacion = this.seleccionReparacion[0].id;
            this.gestionTicket.id_estado = this.seleccionEstado[0].id;
            this.gestionTicket.id_supervisor = this.seleccionSupervisor[0].id;
            this.gestionTicket.id_trabajador = this.seleccionTrabajador[0].id;
            this.gestionTicket.idApoyo1 = this.seleccionApoyo1[0].id;
            this.gestionTicket.idApoyo2 = this.seleccionApoyo2[0].id;
            this.gestionTicket.idApoyo3 = this.seleccionApoyo3[0].id;
            this.gestionTicket.idTurno = this.seleccionTurno.id;
            this.gestionTicket.idDuracion = this.seleccionDuracion[0].id;
            //this.gestionTicket.id_categoria = this.seleccionCategoria[0].id;
            var newElement = document.createElement("div");
            newElement.innerHTML = this.gestionTicket.descripcionP;
            this.gestionTicket.descripcionCorreo = newElement.textContent;
            this.gestionTicket.tituloP = newElement.textContent;
            this.gestionTicket.id_categoria = 4;
            this.gestionTicket.nombre = this.seleccionUsuario.nombre;

            const ticket = this.gestionTicket;
            this.openLoadingColor();
            axios
                .post(this.localVal + "/api/Agente/PostNuevoTicketCA", ticket, {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    const ticketServer = res.data;
                    this.mensajeGuardado();
                });
        },
        limpiar() {
            this.gestionTicket = {
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
                fechaInicio: moment().format("YYYY-MM-DD"),
                fechaTermino: null,
                horaInicio: moment().format("H:mm"),
                horaTermino: null,
                horasEjecucion: 0,
                diasEjecucion: 0,
                idDuracion: 0
            };
            this.seleccionTurno = {
                id: 0,
                descripcionTurno: "Seleccione Turno"
            };
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
            this.seleccionReparacion = [
                {
                    id: 0,
                    descripcionTipoReparacion: "Seleccione Tipo de Reparacion"
                }
            ];
            this.seleccionEstado = [
                {
                    id: 0,
                    descripcionEstado: "Seleccione Estado"
                }
            ];
            this.seleccionSupervisor = [
                {
                    id: 0,
                    sup_nombre_apellido: "Seleccione al Supervisor"
                }
            ];
            this.seleccionTrabajador = [
                {
                    id: 0,
                    tra_nombre_apellido: "Seleccione al Trabajador"
                }
            ];
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
        openLoadingColor() {
            this.$vs.loading({ color: this.colorLoading });
            setTimeout(() => {
                this.$vs.loading.close();
            }, 2000);
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
        // Lado Crear Usuarios
        limpiar2() {
            this.registroUsuarioU.run = null;
            this.registroUsuarioU.email = "";
            this.registroUsuarioU.nombre = "";
            this.registroUsuarioU.apellido = "";
            this.registroUsuarioU.anexo = 0;
            this.registroUsuarioU.id_cargo = 0;
            this.registroUsuarioU.id_edificio = 0;
            this.registroUsuarioU.id_servicio = 0;
            this.registroUsuarioU.id_unidadEspecifica = 42;
            this.registroUsuarioU.password = "";
            this.registroUsuarioU.run_usuario = "";

            this.seleccionCargoU = [
                {
                    id: 0,
                    descripcionCargo: "Seleccione Cargo"
                }
            ];
            this.seleccionEdificioU = [
                {
                    id: 0,
                    descripcionEdificio: "Seleccione Edificio"
                }
            ];
            this.seleccionServicioU = [
                {
                    id: 0,
                    descripcionServicio: "Seleccione Servicio"
                }
            ];
            this.nombreUsuarioU = "";
            this.apellidoUsuarioU = "";
            this.anexoUsuarioU = 0;
            this.correoUsuarioU = "";
            this.rutUsuarioU = null;
            this.passUsuarioU = "";
        },
        formatear_runU() {
            if (this.rutUsuarioU == "" || this.rutUsuarioU == null) {
                console.log("Sin Rut");
                this.val_runU = false;
            } else {
                this.rutUsuarioU = format(this.rutUsuarioU);
                this.val_runU = !validate(this.rutUsuarioU);
            }
        },
        cargaSegunServicioU() {
            try {
                if (
                    this.seleccionServicioU.id == 0 ||
                    this.seleccionServicioU.id == null
                ) {
                    if (
                        this.seleccionEdificioU.id == 0 ||
                        this.seleccionEdificioU[0].id == 0
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
                            this.seleccionServicioU.descripcionServicio ===
                                undefined ||
                            this.seleccionServicioU.descripcionServicio ===
                                "" ||
                            this.seleccionServicioU.descripcionServicio === null
                        ) {
                            this.value4 = this.seleccionServicioU;
                        } else {
                            this.value4 = this.seleccionServicioU.descripcionServicio;
                        }
                        this.popCrearUsuario = false;
                        this.popAServicioU = true;
                    }
                } else {
                    if (
                        this.seleccionServicioU == null ||
                        this.seleccionServicioU.id == 0
                    ) {
                        this.listadoServiciosU = JSON.parse(
                            JSON.stringify(this.listadoServiciosDataU)
                        );
                    } else {
                        var idGeneral = this.seleccionServicioU.id;

                        let c = JSON.parse(
                            JSON.stringify(this.listadoServiciosDataU)
                        );
                        let b = [];
                        var a = 0;

                        c.forEach((value, index) => {
                            a = value.id;
                            if (a == idGeneral) {
                                b.push(value);
                            }
                        });
                        this.seleccionServicioU = b;
                        idGeneral = 0;
                        idGeneral = this.seleccionServicioU[0].id_edificio;
                        b = [];

                        c = this.listadoEdificiosU;

                        c.forEach((value, index) => {
                            a = value.id;
                            if (a == idGeneral) {
                                b.push(value);
                            }
                        });

                        this.seleccionEdificioU = b;
                    }
                }
            } catch (error) {
                console.log("Error en Servicio");
                console.error(error);
            }
        },
        guardarUsuarioU() {
            if (
                this.seleccionEdificioU[0] == null ||
                this.seleccionEdificioU[0].id == 0 ||
                this.seleccionEdificioU[0].id == null
            ) {
                this.$vs.notify({
                    title: "Error al seleccionar el edificio",
                    text: "Debe seleccionar un edificio para continuar",
                    color: "danger",
                    position: "top-right"
                });
            } else if (
                this.seleccionServicioU[0] == null ||
                this.seleccionServicioU[0].id == 0 ||
                this.seleccionServicioU[0].id == null
            ) {
                this.$vs.notify({
                    title: "Error al seleccionar el servicio",
                    text: "Debe seleccionar un servicio para continuar",
                    color: "danger",
                    position: "top-right"
                });
            } else {
                this.registroUsuarioU.run = this.rutUsuarioU;
                this.registroUsuarioU.email = this.correoUsuarioU;
                this.registroUsuarioU.nombre = this.nombreUsuarioU;
                this.registroUsuarioU.apellido = this.apellidoUsuarioU;
                this.registroUsuarioU.anexo = this.anexoUsuarioU;
                this.registroUsuarioU.id_cargo = 1;
                this.registroUsuarioU.id_edificio = this.seleccionEdificioU[0].id;
                this.registroUsuarioU.id_servicio = this.seleccionServicioU[0].id;
                this.registroUsuarioU.password = this.passUsuarioU;
                this.registroUsuarioU.run_usuario = this.rutUsuarioU;

                if (
                    this.rutUsuarioU == 0 ||
                    this.rutUsuarioU == null ||
                    this.rutUsuarioU == ""
                ) {
                    this.registroUsuarioU.run = null;
                    this.rutUsuarioU = null;
                    this.registroUsuarioU.idvalRut = 0;
                } else {
                    this.rutUsuarioU = format(this.rutUsuarioU);
                    this.registroUsuarioU.idvalRut = 1;
                }
                if (
                    this.correoUsuarioU == 0 ||
                    this.correoUsuarioU == null ||
                    this.correoUsuarioU == ""
                ) {
                    this.registroUsuarioU.idvalmail = 0;
                } else {
                    this.registroUsuarioU.idvalmail = 1;
                }
                /*  if (
          this.registroUsuarioU.run == null ||
          this.registroUsuarioU.run < 9 ||
          !validate(this.rutUsuarioU)
        ) {
          this.$vs.notify({
            title: "Error en rut",
            text:
              "Debe Escribir un rut valido,que no este el campo vacio y que sea mayor a 9 caracteres",
            color: "danger",
            position: "top-right",
          });
        } else if (
          this.registroUsuarioU.email == null ||
          this.registroUsuarioU.email < 10
        ) {
          this.$vs.notify({
            title: "Error en correo",
            text: "Debe Escribir un correo valido y que no este el campo vacio",
            color: "danger",
            position: "top-right",
          });
        } else */ if (
                    this.registroUsuarioU.nombre == null ||
                    this.registroUsuarioU.nombre < 3
                ) {
                    this.$vs.notify({
                        title: "Error en Nombre",
                        text:
                            "Debe Escribir un Nombre valido y que no este el campo vacio",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.registroUsuarioU.apellido == null ||
                    this.registroUsuarioU.apellido < 3
                ) {
                    this.$vs.notify({
                        title: "Error en Apellido",
                        text:
                            "Debe Escribir un Apellido valido y que no este el campo vacio",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.registroUsuarioU.anexo == null ||
                    this.registroUsuarioU.anexo < 6
                ) {
                    this.$vs.notify({
                        title: "Error en Anexo",
                        text:
                            "Debe Escribir un Anexo valido y que no este el campo vacio",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.registroUsuarioU.password == null ||
                    this.registroUsuarioU.password < 4
                ) {
                    this.$vs.notify({
                        title: "Error en la Contraseña",
                        text:
                            "Debe Escribir una contraseña valida y que no este el campo vacio",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    const registro = this.registroUsuarioU;
                    axios
                        .post(
                            this.localVal + "/api/Agente/GuardarUsuarioJefe",
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
                                this.limpiar2();
                                this.popCrearUsuario = false;
                                this.cargarUsuarios();
                            }
                        });
                }
            }
        },
        cargarCargoUsuarioU() {
            axios
                .get(this.localVal + "/api/Agente/GetCargos", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoCargoU = res.data;
                    let b = [];
                    let c = this.listadoCargoU;
                    c.forEach((value, index) => {
                        b.push(value);
                    });
                    this.listadoCargoU = b;
                });
        },
        filtroSegunEdificioU() {
            if (
                this.seleccionEdificioU == null ||
                this.seleccionEdificioU == 0
            ) {
                this.listadoServiciosU = this.listadoServiciosDataU;
            } else {
                var idGeneral = this.seleccionEdificioU.id;
                let c = this.listadoServiciosDataU;
                let b = [];
                var a = 0;
                c.forEach((value, index) => {
                    a = value.id_edificio;
                    if (a == idGeneral) {
                        b.push(value);
                    }
                });

                this.listadoServiciosU = b;

                //Dejando como Array la seleccion de edificio
                c = this.listadoEdificiosU;
                b = [];
                c.forEach((value, index) => {
                    a = value.id;
                    if (a == idGeneral) {
                        b.push(value);
                    }
                });

                this.seleccionEdificioU = b;
            }
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
        this.cargarEdificios();
        this.cargarServicios();
        this.cargarTipoRep();
        this.cargarSupervisores();
        this.cargarTrabajadores();
        this.cargarEstado();
        this.cargarUsuarios();
        this.cargarCategoria();
        this.cargarTurnos();
        this.cargarDuracion();
        this.cargarEspecialidad();
        this.cargarCargoUsuarioU();
        this.cargarHoras();
    },
    async beforeMount() {},
    components: {
        flatPickr,
        "v-select": vSelect,
        quillEditor,
        VxCard
    }
};
</script>

<style lang="stylus">
.con-vs-popup .vs-popup {
  width: 1000px;
}
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
