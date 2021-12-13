<template>
    <div>
        <vs-row>
            <div
                class="router-header flex flex-wrap items-center mb-8"
                style="margin-left: 10px"
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
                style="margin-bottom: 10px"
            >
                <p>Recuerda que todos los campos son obligatorios!</p>
            </vs-alert>
            <!-- Usuario -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="1. Seleccionar Usuario Solicitante" c>
                    <div class="vx-row mb-12">
                        <div class="vx-col w-full mt-5">
                            <h6>1.1 - Seleccione Al usuario</h6>
                            <br />
                            <multiselect
                                :taggable="true"
                                v-model="seleccionUsuario"
                                placeholder="Seleccione Usuario"
                                class="w-full select-large"
                                label="nombre"
                                :options="listadoUsuarios"
                                @tag="agregarNuevoUsuario()"
                            ></multiselect>
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
                                :config="configdateToTimePicker"
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
                <vx-card title="5. Informacion del problema">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-full mt-5">
                            <h6>Turno?</h6>
                            <h6>
                                <vs-checkbox v-model="esturno"
                                    >Marque si es un turno, Sino desmarquelo
                                </vs-checkbox>
                            </h6>
                            <br />
                            <h6 v-show="esturno">
                                Seleccione Categoria del turno
                            </h6>
                            <v-select
                                v-show="esturno"
                                v-model="SeleccionTipoTurnoCal"
                                placeholder="Seleccione Categoria Turno"
                                class="w-full select-large"
                                label="descripcionTurCal"
                                :options="listadoTipoCal"
                                @input="textoTurno(seleccionTurno.id)"
                            ></v-select
                            ><br />
                            <h6>5.1 - Tipo de Reparacion</h6>
                            <br />
                            <v-select
                                v-model="seleccionReparacion"
                                placeholder="Seleccione Tipo de Reparacion"
                                class="w-full select-large"
                                label="descripcionTipoReparacion"
                                :options="listadoTipoRep"
                            ></v-select>
                            <br />
                            <h6>5.2 - Seleccione Estado</h6>
                            <br />
                            <v-select
                                v-model="seleccionEstado"
                                placeholder="Seleccione el Estado"
                                class="w-full select-large"
                                label="descripcionEstado"
                                :options="listadoEstado"
                            ></v-select>
                            <br />
                            <h6>5.3 - Seleccione Prioridad</h6>
                            <br />
                            <v-select
                                v-model="seleccionPrioridad"
                                placeholder="Seleccione la Prioridad"
                                class="w-full select-large"
                                label="descripcion_prioridad"
                                :options="listadoPrioridad"
                            ></v-select>
                            <br />
                            <h6>5.4 - Duracion</h6>
                            <br />
                            <v-select
                                v-model="seleccionDuracion"
                                placeholder="Seleccione el Estado"
                                class="w-full select-large"
                                label="descripcion_duracion"
                                :options="listadoDuracion"
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
                            <h6>5.5 - Descripcion del problema</h6>
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
                                style="font-size: 10px; color: red; margin-left: 10px"
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
        <!-- Lado del nuevo usuario -->
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
                                        @input="filtroSegunEdificioU"
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
import Fuse from "fuse.js";
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import { quillEditor } from "vue-quill-editor";
import router from "@/router";
import { validate, clean, format } from "rut.js";
import VxCard from "../../components/vx-card/VxCard.vue";
import Vue from "vue";
import Multiselect from "vue-multiselect";
Vue.component("multiselect", Multiselect);

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
            defaultDate: moment().format("YYYY-MM-DD"),
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
        esturno: false,
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
        listadoTurno: [],
        listadoServiciosData: [],
        listadoPrioridad: [],
        seleccionTurno: {
            id: 1,
            descripcionTurno: "Dia"
        },
        listadoUsuarios: [null],
        gestionTicket: {
            id_user: 0,
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
            tituloP: ".",
            descripcionP: "",
            id_categoria: 1,
            nombre: "",
            descripcionCorreo: "",
            idDuracion: 0,
            id_prioridad: 0
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
        seleccionPrioridad: {
            id: 2,
            descripcion_prioridad: "Normal"
        },
        seleccionReparacion: {
            id: 0,
            descripcionTipoReparacion: "Seleccione Tipo de Reparacion"
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
        seleccionApoyo1: {
            id: 1,
            tra_nombre_apellido: "Sin Asignar"
        },
        seleccionApoyo2: {
            id: 1,
            tra_nombre_apellido: "Sin Asignar"
        },
        seleccionApoyo3: {
            id: 1,
            tra_nombre_apellido: "Sin Asignar"
        },
        seleccionDuracion: {
            id: 2,
            descripcion_duracion: "Trabajo Diario"
        },
        listadoDuracion: [],
        variablePrueba: 0,
        mensajeError: "",
        colorLoading: "#ff8000",
        localVal: process.env.MIX_APP_URL,
        value1: "",
        value2: "",
        value3: "",
        value4: "",
        validaEliminar: false,
        popupActive2: false,
        popupActive3: false,
        popAServicio: false,
        popAServicioU: false,
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
        seleccionCargoU: {
            id: 0,
            descripcionCargo: "Seleccione Cargo"
        },
        seleccionEdificioU: {
            id: 0,
            descripcionEdificio: "Seleccione Edificio"
        },
        seleccionServicioU: {
            id: 0,
            descripcionServicio: "Seleccione Servicio"
        },
        dataUsuarioCreadorU: {
            nombre:
                sessionStorage.getItem("nombre") +
                " " +
                sessionStorage.getItem("apellido"),
            id_user: sessionStorage.getItem("id")
        },
        registroUsuarioU: {
            run: null,
            email: "mantencion.hsjd@redsalud.gov.cl",
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
        SeleccionTipoTurnoCal: { id: 1, descripcionTurCal: "Electrico" },
        listadoTipoCal: [
            { id: 1, descripcionTurCal: "Electrico" },
            { id: 2, descripcionTurCal: "Gasfiter" }
        ]
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
            if (
                this.gestionTicket.fechaInicio != null &&
                this.gestionTicket.horaInicio != null &&
                this.gestionTicket.fechaTermino != null &&
                this.gestionTicket.horaTermino != null
            ) {
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
        labelColor() {
            return label => {
                if (label === "sadicionales") return "dark";
                else if (label === "tnoche") return "warning";
                else if (label === "tdia") return "success";
                else if (label === "libre") return "danger";
                else if (label === "none") return "primary";
            };
        }
    },
    methods: {
        fuseSearch(options, search) {
            const fuse = new Fuse(options, {
                keys: ["id", "nombre"],
                shouldSort: true
            });
            return search.length
                ? fuse.search(search).map(({ item }) => item)
                : fuse.list;
        },
        textoTurno(id) {
            try {
                if (this.SeleccionTipoTurnoCal.id == 1) {
                    if (id == 1) {
                        this.gestionTicket.descripcionP = "Cubrir Turno Dia";
                        this.arrayTipoReparacion(1);
                    } else if (id == 2) {
                        this.gestionTicket.descripcionP = "Cubrir Turno Noche";
                        this.arrayTipoReparacion(1);
                    }
                } else if (this.SeleccionTipoTurnoCal.id == 2) {
                    if (id == 1) {
                        this.gestionTicket.descripcionP = "Cubrir Turno Dia";
                        this.arrayTipoReparacion(4);
                    } else if (id == 2) {
                        this.gestionTicket.descripcionP = "Cubrir Turno Noche";
                        this.arrayTipoReparacion(4);
                    }
                }
            } catch (error) {
                console.log(error);
            }
        },
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
        agregarNuevoUsuario() {
            try {
                this.seleccionUsuario = {
                    id: 0,
                    nombre: "Seleccione Usuario"
                };

                if (
                    this.seleccionUsuario.id == null ||
                    this.seleccionUsuario == null ||
                    this.seleccionUsuario == 0 ||
                    this.seleccionUsuario.id == 0
                ) {
                    this.popCrearUsuario = true;
                }
            } catch (error) {
                console.log(error);
            }
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
                this.seleccionSupervisor == null ||
                this.seleccionSupervisor.id == 0
            ) {
                this.$vs.notify({
                    title: "Error en Seleccionar al supervisor",
                    text: "Debe seleccionar a un supervisor para continuar",
                    color: "danger",
                    position: "top-right",
                    time: 3000
                });
            } else if (
                this.seleccionEspecialidad == null ||
                this.seleccionEspecialidad.id == 0
            ) {
                this.$vs.notify({
                    title: "Error en Seleccionar la especialidad",
                    text: "Debe seleccionar a una especialidad para continuar",
                    color: "danger",
                    position: "top-right",
                    time: 3000
                });
            } else if (
                this.seleccionEdificio == null ||
                this.seleccionEdificio.id == null
            ) {
                this.$vs.notify({
                    title: "Error en Seleccionar el edificio",
                    text: "Debe seleccionar a un edificio para continuar",
                    color: "danger",
                    position: "top-right",
                    time: 3000
                });
            } else if (
                this.seleccionServicio == null ||
                this.seleccionServicio.id == 0
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
                this.registroUsuario.id_cargo_asociado = this.seleccionSupervisor.id;
                this.registroUsuario.id_edificio = this.seleccionEdificio.id;
                this.registroUsuario.id_servicio = this.seleccionServicio.id;
                this.registroUsuario.password = this.passUsuario;
                this.registroUsuario.run_usuario = this.rutUsuario;
                this.registroUsuario.tra_run = this.rutUsuario;
                this.registroUsuario.tra_nombre = this.nombreUsuario;
                this.registroUsuario.tra_apellido = this.apellidoUsuario;
                this.registroUsuario.id_especialidad1 = this.seleccionEspecialidad.id;

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
            this.seleccionEdificio = {
                id: 0,
                descripcionEdificio: "Seleccione Edificio"
            };
            this.seleccionServicio = {
                id: 0,
                descripcionServicio: "Seleccione Servicio"
            };
            this.seleccionEspecialidad = {
                id: 0,
                descripcionEspecialidad: "Seleccion Especialidad"
            };
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

                let idEdificio = b[0].id;
                let desEdificio = b[0].descripcionEdificio;

                this.seleccionEdificio.id = idEdificio;
                this.seleccionEdificio.descripcionEdificio = desEdificio;
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
                    id_edificio: this.seleccionEdificioU.id,
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
                    if (this.seleccionEdificio.id == 0) {
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

                        let idServicio = b[0].id;
                        let desServicio = b[0].descripcionServicio;

                        this.seleccionServicio.id = idServicio;
                        this.seleccionServicio.descripcionServicio = desServicio;

                        idGeneral = 0;
                        idGeneral = b[0].id_edificio;
                        b = [];

                        c = JSON.parse(JSON.stringify(this.listadoEdificios));

                        c.forEach((value, index) => {
                            a = value.id;
                            if (a == idGeneral) {
                                b.push(value);
                            }
                        });
                        let idEdificio = b[0].id;
                        let desEdificio = b[0].descripcionEdificio;

                        this.seleccionEdificio.id = idEdificio;
                        this.seleccionEdificio.descripcionEdificio = desEdificio;
                    }
                }
            } catch (error) {
                console.log("Error en servicio");
                console.log(error);
            }
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

            let idTipoRep = b[0].id;
            let desTipoRep = b[0].descripcionTipoReparacion;

            this.seleccionReparacion.id = idTipoRep;
            this.seleccionReparacion.descripcionTipoReparacion = desTipoRep;
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

                let idTra = b[0].id;
                let desTra = b[0].tra_nombre_apellido;
                this.seleccionTrabajador.id = idTra;
                this.seleccionTrabajador.tra_nombre_apellido = desTra;

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

            let idSA1 = b[0].id;
            let desSA1 = b[0].tra_nombre_apellido;

            this.seleccionApoyo1.id = idSA1;
            this.seleccionApoyo1.tra_nombre_apellido = desSA1;

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

            let idSA2 = b[0].id;
            let desSA2 = b[0].tra_nombre_apellido;

            this.seleccionApoyo2.id = idSA2;
            this.seleccionApoyo2.tra_nombre_apellido = desSA2;

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

            let idSA3 = b[0].id;
            let desSA3 = b[0].tra_nombre_apellido;

            this.seleccionApoyo3.id = idSA3;
            this.seleccionApoyo3.tra_nombre_apellido = desSA3;
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
                    this.resetI += 1;
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
                    this.seleccionEstado = {
                        id: 2,
                        descripcionEstado: "En Proceso"
                    };
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
            } else if (this.seleccionPrioridad.id == 0) {
                this.mensajeError = "la prioridad ";
                this.errorDrop(this.mensajeError);
            } else {
                this.guardarFormulario();
            }
        },
        guardarFormulario() {
            this.gestionTicket.id_user = this.seleccionUsuario.id;
            this.gestionTicket.id_edificio = this.seleccionEdificio.id;
            this.gestionTicket.id_servicio = this.seleccionServicio.id;
            this.gestionTicket.id_tipoReparacion = this.seleccionReparacion.id;
            this.gestionTicket.id_estado = this.seleccionEstado.id;
            this.gestionTicket.id_supervisor = this.seleccionSupervisor.id;
            this.gestionTicket.id_trabajador = this.seleccionTrabajador.id;
            this.gestionTicket.idApoyo1 = this.seleccionApoyo1.id;
            this.gestionTicket.idApoyo2 = this.seleccionApoyo2.id;
            this.gestionTicket.idApoyo3 = this.seleccionApoyo3.id;
            this.gestionTicket.idTurno = this.seleccionTurno.id;
            this.gestionTicket.idDuracion = this.seleccionDuracion.id;
            this.gestionTicket.id_prioridad = this.seleccionPrioridad.id;
            //this.gestionTicket.id_categoria = this.seleccionCategoria[0].id;
            var newElement = document.createElement("div");
            newElement.innerHTML = this.gestionTicket.descripcionP;
            this.gestionTicket.descripcionCorreo = newElement.textContent;
            this.gestionTicket.tituloP = "Sin Titulo";
            this.gestionTicket.id_categoria = 1;
            this.gestionTicket.nombre = this.seleccionUsuario.nombre;
            let events = {
                title: "",
                startDate: null,
                endDate: null,
                label: "none",
                descripcion_gasfiters: "",
                descripcion_electricos: "",
                id_trabajador: 0,
                id_turno: 0,
                id_edificio: 0,
                id_val_dia_administrativo: 2,
                id_val_vacaciones: 2,
                id_val_reemplazo: 2,
                id_val_turno_extra: 2,
                id_tipo_dia_administrativo: 0,
                fecha_dia_administrativo: null,
                fecha_inicio_vacaciones: null,
                fecha_termino_vacaciones: null,
                dias_vacaciones: 0,
                id_trabajador_reemplazo: 0,
                fecha_inicio_reemplazo: null,
                fecha_termino_reemplazo: null,
                dias_reemplazo: 0,
                fecha_inicio_turno_extra: null,
                fecha_termino_turno_extra: null,
                dias_ejecucion_turno_extra: null,
                horas_ejecucion_turno_extra: null,
                hora_termino_turno_extra: null,
                hora_inicio_turno_extra: null,
                hora_inicio: null,
                hora_termino: null,
                dias_ejecucion: 0,
                horas_ejecucion: 0,
                id_dia_administrativo: null,
                id_vacaciones: null,
                id_reemplazo: null,
                id_turno_extra: null,
                id_calendario_gasfiter: null,
                classes: "",
                estado_turno_extra: true,
                estado_reemplazo: true,
                estado_dia_administrativo: true,
                estado_vacaciones: true
            };
            const newevent = events;
            const ticket = this.gestionTicket;
            this.openLoadingColor();
            if (this.esturno == true) {
                if (this.SeleccionTipoTurnoCal.id == 1) {
                    events.title = this.gestionTicket.descripcionCorreo;
                    events.descripcion_electricos = this.gestionTicket.descripcionCorreo;
                    events.startDate = this.gestionTicket.fechaInicio;
                    events.endDate = this.gestionTicket.fechaTermino;
                    events.id_turno = this.seleccionTurno.id;
                    events.id_trabajador = this.seleccionTrabajador.id;
                    events.id_edificio = this.seleccionEdificio.id;
                    events.hora_inicio = this.gestionTicket.horaInicio;
                    events.hora_termino = this.gestionTicket.horaTermino;
                    if (this.seleccionTurno.id == 1) {
                        events.label = "tdia";
                    } else if (this.seleccionTurno.id == 2) {
                        events.label = "tnoche";
                    }
                    events.classes = `event-${this.labelColor(events.label)}`;
                    axios
                        .all([
                            axios.post(
                                this.localVal + "/api/Agente/PostNuevoTicket",
                                ticket,
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            ),
                            axios.post(
                                this.localVal +
                                    "/api/Agente/PostCalendarioElec",
                                newevent,
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            )
                        ])
                        .then(
                            axios.spread((res1, res2) => {
                                let ticketServer = res1.data;
                                let calen2 = res2.data;
                                if (ticketServer == true && calen2 == true) {
                                    this.mensajeGuardado();
                                    setTimeout(() => {
                                        router.back();
                                    }, 4000);
                                    this.limpiar();
                                } else {
                                    this.$vs.notify({
                                        time: 5000,
                                        title: "Error",
                                        text:
                                            "No fue posible crear el ticket o agregar al calendario, revise los campos e intente nuevamente",
                                        color: "danger",
                                        position: "top-right"
                                    });
                                }
                            })
                        );
                } else if (this.SeleccionTipoTurnoCal.id == 2) {
                    events.title = this.gestionTicket.descripcionCorreo;
                    events.descripcion_gasfiters = this.gestionTicket.descripcionCorreo;
                    events.startDate = this.gestionTicket.fechaInicio;
                    events.endDate = this.gestionTicket.fechaTermino;
                    events.id_turno = this.seleccionTurno.id;
                    events.id_trabajador = this.seleccionTrabajador.id;
                    events.id_edificio = this.seleccionEdificio.id;
                    events.hora_inicio = this.gestionTicket.horaInicio;
                    events.hora_termino = this.gestionTicket.horaTermino;
                    if (this.seleccionTurno.id == 1) {
                        events.label = "tdia";
                    } else if (this.seleccionTurno.id == 2) {
                        events.label = "tnoche";
                    }
                    events.classes = `event-${this.labelColor(events.label)}`;
                    axios
                        .all([
                            axios.post(
                                this.localVal + "/api/Agente/PostNuevoTicket",
                                ticket,
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            ),
                            axios.post(
                                this.localVal +
                                    "/api/Agente/PostCalendarioGasf",
                                newevent,
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            )
                        ])
                        .then(
                            axios.spread((res1, res2) => {
                                let ticketServer = res1.data;
                                let calen2 = res2.data;
                                if (ticketServer == true && calen2 == true) {
                                    this.mensajeGuardado();
                                    setTimeout(() => {
                                        router.back();
                                    }, 4000);
                                    this.limpiar();
                                } else {
                                    this.$vs.notify({
                                        time: 5000,
                                        title: "Error",
                                        text:
                                            "No fue posible crear el ticket o agregar al calendario, revise los campos e intente nuevamente",
                                        color: "danger",
                                        position: "top-right"
                                    });
                                }
                            })
                        );
                }
            } else {
                axios
                    .post(
                        this.localVal + "/api/Agente/PostNuevoTicket",
                        ticket,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        const ticketServer = res.data;
                        this.mensajeGuardado();
                    });
            }
        },
        openLoadingColor() {
            this.$vs.loading({ color: this.colorLoading });
            setTimeout(() => {
                this.$vs.loading.close();
            }, 2000);
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
            this.seleccionApoyo1 = {
                id: 1,
                tra_nombre_apellido: "Sin Asignar"
            };
            this.seleccionApoyo2 = {
                id: 1,
                tra_nombre_apellido: "Sin Asignar"
            };
            this.seleccionApoyo3 = {
                id: 1,
                tra_nombre_apellido: "Sin Asignar"
            };
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

            this.seleccionCargoU = {
                id: 0,
                descripcionCargo: "Seleccione Cargo"
            };
            this.seleccionEdificioU = {
                id: 0,
                descripcionEdificio: "Seleccione Edificio"
            };
            this.seleccionServicioU = {
                id: 0,
                descripcionServicio: "Seleccione Servicio"
            };
            this.nombreUsuarioU = "";
            this.apellidoUsuarioU = "";
            this.anexoUsuarioU = 0;
            this.correoUsuarioU = "";
            this.rutUsuarioU = null;
            this.passUsuarioU = "";
        },
        formatear_runU() {
            if (this.rutUsuarioU == "" || this.rutUsuarioU == null) {
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
                    if (this.seleccionEdificioU.id == 0) {
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

                        let idServicio = b[0].id;
                        let desServicio = b[0].descripcionServicio;

                        this.seleccionServicioU.id = idServicio;
                        this.seleccionServicioU.descripcionServicio = desServicio;

                        idGeneral = 0;
                        idGeneral = b[0].id_edificio;
                        b = [];

                        c = this.listadoEdificiosU;

                        c.forEach((value, index) => {
                            a = value.id;
                            if (a == idGeneral) {
                                b.push(value);
                            }
                        });

                        let idEdificio = b[0].id;
                        let desEdificio = b[0].descripcionEdificio;

                        this.seleccionEdificioU.id = idEdificio;
                        this.seleccionEdificioU.descripcionEdificio = desEdificio;
                    }
                }
            } catch (error) {
                console.log("Error en Servicio");
                console.error(error);
            }
        },
        guardarUsuarioU() {
            if (
                this.seleccionEdificioU == null ||
                this.seleccionEdificioU.id == 0 ||
                this.seleccionEdificioU.id == null
            ) {
                this.$vs.notify({
                    title: "Error al seleccionar el edificio",
                    text: "Debe seleccionar un edificio para continuar",
                    color: "danger",
                    position: "top-right"
                });
            } else if (
                this.seleccionServicioU == null ||
                this.seleccionServicioU.id == 0 ||
                this.seleccionServicioU.id == null
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
                this.registroUsuarioU.id_edificio = this.seleccionEdificioU.id;
                this.registroUsuarioU.id_servicio = this.seleccionServicioU.id;
                this.registroUsuarioU.password = this.passUsuarioU;
                this.registroUsuarioU.run_usuario = this.rutUsuarioU;
                if (
                    this.rutUsuarioU == 0 ||
                    this.rutUsuarioU == null ||
                    this.rutUsuarioU == "" ||
                    this.rutUsuarioU.length < 7
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
                //this.rutUsuarioU = format(this.rutUsuarioU);
                /* if (
                    this.registroUsuarioU.run == null ||
                    this.registroUsuarioU.run < 9 ||
                    !validate(this.rutUsuarioU)
                ) {
                    this.$vs.notify({
                        title: "Error en rut",
                        text:
                            "Debe Escribir un rut valido,que no este el campo vacio y que sea mayor a 9 caracteres",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.registroUsuarioU.email == null ||
                    this.registroUsuarioU.email < 10
                ) {
                    this.$vs.notify({
                        title: "Error en correo",
                        text:
                            "Debe Escribir un correo valido y que no este el campo vacio",
                        color: "danger",
                        position: "top-right"
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

                let idEdificio = b[0].id;
                let desEdificio = b[0].descripcionEdificio;

                this.seleccionEdificioU.id = idEdificio;
                this.seleccionEdificioU.descripcionEdificio = desEdificio;
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
        this.cargarTurnos();
        this.cargarDuracion();
        this.cargarEspecialidad();
        this.cargarCargoUsuarioU();
        this.cargarHoras();
        setTimeout(() => {
            this.cargarPrioridades();
        }, 2000);
    },
    mounted() {},
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
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
