<template>
    <div>
        <div class="vx-row">
            <vx-card>
                <div class="vx-col w-full" :key="resetI">
                    <FullCalendar
                        :options="calendarOptions"
                        v-if="valCalendar"
                    />
                </div>
            </vx-card>
        </div>
        <!-- Pop Up Para Agregar Nuevas Obras -->
        <vs-popup
            classContent="popup-example"
            title=" "
            :active.sync="popCrearNObra"
        >
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="1. Ingrese Datos de Obra">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-full mt-3">
                            <h6>1.1 Nombre Obra</h6>
                            <vs-input
                                class="vx-col w-full mt-3"
                                v-model="title"
                            />
                        </div>
                        <br />
                    </div>
                </vx-card>
                <vx-card title="2. Ingrese Fechas de Obra">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-1/2 mt-3">
                            <h6>2.1 Fecha Inicio</h6>
                            <flat-pickr
                                class="vx-col w-1/3 mt-5"
                                :config="configFromdateTimePicker"
                                v-model="start"
                                placeholder="Fecha Inicio"
                                @on-change="onFromChange"
                            />
                            <flat-pickr
                                class="vx-col w-1/3 mt-5"
                                :config="configdateTimePicker"
                                v-model="startHour"
                                placeholder="Seleccione Hora"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>2.2 Fecha Termino</h6>
                            <flat-pickr
                                class="vx-col w-1/3 mt-5"
                                :config="configTodateTimePicker"
                                v-model="end"
                                placeholder="Fecha Termino"
                                @on-change="onToChange"
                            />
                            <flat-pickr
                                class="vx-col w-1/3 mt-5"
                                :config="configdateTimePicker"
                                v-model="endHour"
                                placeholder="Seleccione Hora"
                            />
                        </div>
                    </div>
                    <div class="vx-col md:w-full w-full mb-base">
                        <div class="vx-row mb-12">
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    class="mb-2 w-full"
                                    @click="volver"
                                    color="primary"
                                    >Volver
                                </vs-button>
                            </div>

                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    class="mb-2 w-full"
                                    @click="guardarObra"
                                    color="success"
                                    >Enviar</vs-button
                                >
                            </div>
                        </div>
                    </div>
                </vx-card>
            </div>
        </vs-popup>
        <!-- Pop Up Para Agregar Nuevas Categorias a las Obras -->
        <vs-popup
            classContent="popup-example"
            title=" "
            :active.sync="popCrearSubCatObra"
        >
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="1. Seleccione Obra">
                    <vue-good-table
                        :columns="columns"
                        :rows="listadoObras"
                        :pagination-options="{
                            enabled: true,
                            perPage: 10
                        }"
                        @on-selected-rows-change="selectionChanged"
                        :select-options="{ enabled: true }"
                        :search-options="{ enabled: true }"
                    >
                        >
                    </vue-good-table>
                </vx-card>
                <vx-card title="2. Ingrese Datos Sub Categoria">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-full mt-3">
                            <h6>2.1 Nombre Categoria</h6>
                            <vs-input
                                class="vx-col w-full mt-3"
                                v-model="title"
                            />
                        </div>
                        <br />
                    </div>
                </vx-card>
                <vx-card title="3. Ingrese Fechas Sub Categoria">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-1/2 mt-3">
                            <h6>3.1 Fecha Inicio</h6>
                            <flat-pickr
                                class="vx-col w-1/3 mt-5"
                                :config="configFromdateTimePicker"
                                v-model="start"
                                placeholder="Fecha Inicio"
                                @on-change="onFromChange"
                            />
                            <flat-pickr
                                class="vx-col w-1/3 mt-5"
                                :config="configdateTimePicker"
                                v-model="startHour"
                                placeholder="Seleccione Hora"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>3.2 Fecha Termino</h6>
                            <flat-pickr
                                class="vx-col w-1/3 mt-5"
                                :config="configTodateTimePicker"
                                v-model="end"
                                placeholder="Fecha Termino"
                                @on-change="onToChange"
                            />
                            <flat-pickr
                                class="vx-col w-1/3 mt-5"
                                :config="configdateTimePicker"
                                v-model="endHour"
                                placeholder="Seleccione Hora"
                            />
                        </div>
                    </div>
                    <div class="vx-col md:w-full w-full mb-base">
                        <div class="vx-row mb-12">
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    class="mb-2 w-full"
                                    @click="volver"
                                    color="primary"
                                    >Volver
                                </vs-button>
                            </div>

                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    class="mb-2 w-full"
                                    @click="guardarSubObra"
                                    color="success"
                                    >Enviar</vs-button
                                >
                            </div>
                        </div>
                    </div>
                </vx-card>
            </div>
        </vs-popup>
    </div>
</template>
<script>
import "@fullcalendar/core/vdom"; // solves problem with Vite
import FullCalendar from "@fullcalendar/vue";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import resourceTimelinePlugin from "@fullcalendar/resource-timeline";
import esLocale from "@fullcalendar/core/locales/es";
import Datepicker from "vuejs-datepicker";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import moment from "moment";
import router from "@/router";
import axios from "axios";
import Vue from "vue";
import "vue-good-table/dist/vue-good-table.css";
import VueGoodTablePlugin from "vue-good-table";
Vue.use(VueGoodTablePlugin);

export default {
    components: {
        FullCalendar, // make the <FullCalendar> tag available,
        flatPickr
    },
    data() {
        return {
            format: "d MMMM yyyy",
            resetI: 0,
            listadoObras: [],
            columns: [
                {
                    label: "Obra",
                    field: "title",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Fecha Inicio",
                    field: "starts",
                    type: "date",
                    dateInputFormat: "dd/MM/yyyy",
                    dateOutputFormat: "dd/MM/yyyy",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Fecha Termino",
                    field: "ends",
                    type: "date",
                    dateInputFormat: "dd/MM/yyyy",
                    dateOutputFormat: "dd/MM/yyyy",
                    filterOptions: {
                        enabled: true
                    }
                }
            ],
            idObraSeleccionada: 0,
            UltimoIDObra: 0,
            listadoObUl: [],
            popCrearNObra: false,
            valCalendar: false,
            popCrearSubCatObra: false,
            title: "",
            resourceAsociado: "",
            calendarOptions: {
                customButtons: {
                    NObra: {
                        text: "Nueva Obra",
                        click: () => this.$set(this, "popCrearNObra", true)
                    },
                    NSubObra: {
                        text: "Asignar Sub-Categoria Obras",
                        click: () => this.$set(this, "popCrearSubCatObra", true)
                    }
                },
                plugins: [
                    dayGridPlugin,
                    interactionPlugin,
                    resourceTimelinePlugin
                ],
                headerToolbar: {
                    left: "today prev,next NObra NSubObra",
                    center: "title",
                    right:
                        "resourceTimelineDay,resourceTimelineWeek,resourceTimelineMonth"
                },
                //dateClick: this.handleDateClick,
                locale: esLocale,
                //selectable: true,
                resourceAreaHeaderContent: "Calendario de Obras",
                resources: {},
                events: {},
                initialView: "resourceTimelineDay",
                schedulerLicenseKey:
                    "CC-Attribution-NonCommercial-NoDerivatives"
            },
            start: moment(new Date()).format("YYYY-MM-DD"),
            end: moment(new Date()).format("YYYY-MM-DD"),
            startHour: moment(new Date()).format("H:mm"),
            endHour: moment(new Date()).format("H:mm"),
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
            localVal: process.env.MIX_APP_URL
        };
    },
    methods: {
        selectionChanged(params) {
            this.idObraSeleccionada = params.selectedRows[0].id;
        },
        onFromChange(selectedDates, dateStr, instance) {
            this.$set(this.configTodateTimePicker, "minDate", dateStr);
        },
        onToChange(selectedDates, dateStr, instance) {
            this.$set(this.configFromdateTimePicker, "maxDate", dateStr);
        },
        volver() {
            this.popCrearNObra = false;
            this.popCrearSubCatObra = false;
        },
        guardarObra() {
            try {
                if (this.title == "" || this.title <= 4) {
                    this.$vs.notify({
                        time: 3000,
                        title: "Error",
                        text: "Campo Titulo Vacio o Menor a 4 Caracteres",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.start == null) {
                    this.$vs.notify({
                        time: 3000,
                        title: "Error",
                        text: "Fecha Inicial No Seleccionada",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.end == null) {
                    this.$vs.notify({
                        time: 3000,
                        title: "Error",
                        text: "Fecha Termino No Seleccionada",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let fechaInicio = moment(
                        this.start + " " + this.startHour
                    ).format("YYYY-MM-DD H:mm");
                    let fechaTermino = moment(
                        this.end + " " + this.endHour
                    ).format("YYYY-MM-DD H:mm");
                    let obj = {
                        title: this.title,
                        start: fechaInicio,
                        end: fechaTermino,
                        eventcolor: "green",
                        resourceId: this.UltimoIDObra,
                        resourceAsociado: null
                    };

                    axios
                        .post(this.localVal + "/api/Agente/GuardarNObra", obj, {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        })
                        .then(res => {
                            let data = res.data;
                            if (data == true) {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Guardado correctamente",
                                    text: "Se Recargara Listado",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.popCrearNObra = false;
                                this.popCrearSubCatObra = false;
                                this.cargarRecursos();
                            } else {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error",
                                    text: "No se pudieron guardar los datos",
                                    color: "success",
                                    position: "top-right"
                                });
                            }
                        });
                }
            } catch (error) {
                console.log("Error al Guardar datos");
            }
        },
        guardarSubObra() {
            try {
                if (this.title == "" || this.title <= 4) {
                    this.$vs.notify({
                        time: 3000,
                        title: "Error",
                        text: "Campo Titulo Vacio o Menor a 4 Caracteres",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.start == null) {
                    this.$vs.notify({
                        time: 3000,
                        title: "Error",
                        text: "Fecha Inicial No Seleccionada",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.end == null) {
                    this.$vs.notify({
                        time: 3000,
                        title: "Error",
                        text: "Fecha Termino No Seleccionada",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let fechaInicio = moment(
                        this.start + " " + this.startHour
                    ).format("YYYY-MM-DD H:mm");
                    let fechaTermino = moment(
                        this.end + " " + this.endHour
                    ).format("YYYY-MM-DD H:mm");
                    let obj = {
                        title: this.title,
                        start: fechaInicio,
                        end: fechaTermino,
                        eventcolor: "blue",
                        resourceId: this.resourceAsociado,
                        resourceAsociado: this.idObraSeleccionada
                    };

                    axios
                        .post(
                            this.localVal + "/api/Agente/GuardarNSubObra",
                            obj,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            let data = res.data;
                            if (data == true) {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Guardado correctamente",
                                    text: "Se Recargara Listado",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.popCrearNObra = false;
                                this.popCrearSubCatObra = false;
                                this.cargarRecursos();
                            } else {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error",
                                    text: "No se pudieron guardar los datos",
                                    color: "success",
                                    position: "top-right"
                                });
                            }
                        });
                }
            } catch (error) {
                console.log("Error al Guardar datos");
            }
        },
        cargarRecursos() {
            try {
                axios
                    .all([
                        axios.get(
                            this.localVal + "/api/Agente/BuscarObraRANull",
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        ),
                        axios.get(
                            this.localVal + "/api/Agente/BuscarObraRActiva",
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        ),
                        axios.get(this.localVal + "/api/Agente/ListadoObras", {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }),
                        axios.get(this.localVal + "/api/Agente/UltimoIDObra", {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        })
                    ])
                    .then(
                        axios.spread((dat1, dat2, dat3, dat4) => {
                            let listNull = dat1.data;
                            let listRA = dat2.data;
                            let dat = dat3.data;
                            let listObraU = dat4.data;
                            let d = [];
                            let b = [];
                            let c = [];
                            let a = 0;
                            listNull.forEach((values, index) => {
                                a = values.id;
                                listRA.forEach((value, index) => {
                                    if (a == value.resourceAsociado) {
                                        let obj = {};
                                        obj = {
                                            id: value.resourceId,
                                            title: value.title,
                                            eventColor: value.eventcolor
                                        };
                                        b.push(obj);
                                    }
                                });
                                values.children = b;
                                c.push(values);
                            });
                            if (listObraU.length <= 0) {
                                this.UltimoIDObra = 1;
                            } else {
                                listObraU.forEach((value, index) => {
                                    d.push(value.id);
                                });
                                this.UltimoIDObra = d[0] + 1;
                            }

                            this.listadoObras = dat1.data;
                            this.calendarOptions.resources = c;
                            this.calendarOptions.events = dat;
                            this.$vs.notify({
                                time: 3000,
                                title: "Carga de Datos",
                                text: "Se llenara Listado",
                                color: "primary",
                                position: "top-right"
                            });
                            this.valCalendar = true;
                            this.resetI += 1;
                        })
                    );
            } catch (error) {
                this.$vs.notify({
                    time: 3000,
                    title: "Error",
                    text: "No se pudieron cargar Datos",
                    color: "danger",
                    position: "top-right"
                });
                console.log("Error al recuperar los datos externos");
            }
        }
    },
    created() {
        this.cargarRecursos();
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
