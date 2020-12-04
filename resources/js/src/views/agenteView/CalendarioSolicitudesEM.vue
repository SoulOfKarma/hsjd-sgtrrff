<template>
    <div id="app">
        <vs-row>
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="1. Calendario de tickets Asignados">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-full mt-5">
                            <div v-if="valc">
                                <div class="flex mb-4">
                                    <div
                                        class="w-1/6 bg-grid-color-secondary h-12"
                                    ></div>
                                    <div
                                        class="w-1/2 bg-grid-color-secondary h-12"
                                    >
                                        <v-select
                                            v-model="trabajadorSeleccionado"
                                            label="tra_nombre_apellido"
                                            :options="
                                                listadoTrabajadoresFiltrado
                                            "
                                            @input="cambioByTrabajador()"
                                        />
                                    </div>
                                    <div
                                        class="w-1/6 bg-grid-color-secondary h-12"
                                    ></div>
                                    <div class="w-1/2 bg-grid-color h-12">
                                        <v-select
                                            v-model="horaSeleccionada"
                                            label="descripcionHora"
                                            :options="horas"
                                            @input="
                                                cambioCalendario(
                                                    horaSeleccionada.hora
                                                )
                                            "
                                        />
                                    </div>
                                    <div
                                        class="w-1/6 bg-grid-color-secondary h-12"
                                    ></div>
                                    <div
                                        class="w-1/2 bg-grid-color-secondary h-12"
                                    >
                                        <v-select
                                            v-model="turnoSeleccionado"
                                            label="descripcionTurno"
                                            :options="listadoTurnos"
                                            @input="cambioByTurno()"
                                        />
                                    </div>
                                    <div
                                        class="w-1/6 bg-grid-color-secondary h-12"
                                    ></div>
                                    <div
                                        class="w-1/2 bg-grid-color-secondary h-12"
                                    >
                                        <vs-button
                                            color="success"
                                            type="filled"
                                            class="w-full"
                                            @click="cargarTodo()"
                                            >Cargar Todo</vs-button
                                        >
                                    </div>
                                    <div
                                        class="w-1/6 bg-grid-color-secondary h-12"
                                    ></div>
                                </div>

                                <GSTC
                                    :key="componentKey"
                                    :config="config"
                                    @state="onState"
                                    :v-text="config.chart.items.label"
                                />
                            </div>
                        </div>
                    </div>
                </vx-card>
            </div>
            <vs-popup
                class="holamundo"
                :title="infoGeneral.titulo"
                :active.sync="popupActive"
                v-model="infoGeneral"
            >
                <p>N°Ticket: {{ infoGeneral.nticket }}</p>
                <p>Usuario Solicitante: {{ infoGeneral.usuario }}</p>
                <p>Fecha Creacion Ticket: {{ infoGeneral.fechaCreacion }}</p>
                <p>
                    Fecha Asignacion Ticket: {{ infoGeneral.fechaAsignacion }}
                </p>
                <p>Fecha Termino Ticket: {{ infoGeneral.fechaTermino }}</p>
                <p>Titulo Problema: {{ infoGeneral.titulo }}</p>
                <p>Descripcion: {{ infoGeneral.descripcion }}</p>
                <p>Edificio: {{ infoGeneral.edificio }}</p>
                <p>Servicio: {{ infoGeneral.servicio }}</p>
                <p>Unidad Especifica: {{ infoGeneral.unidadEsp }}</p>
            </vs-popup>
        </vs-row>
    </div>
</template>

<script>
import GSTC from "vue-gantt-schedule-timeline-calendar";
import axios from "axios";
import router from "@/router";
import moment from "moment";
import vSelect from "vue-select";
import { html, render } from "lit-html";

let subs = [];

export default {
    name: "app",
    components: {
        "v-select": vSelect,
        GSTC
    },
    data() {
        return {
            componentKey: 0,
            colorLoading: "#ff8000",
            infoGeneral: {
                titulo: "",
                nticket: "",
                descripcion: "",
                fechaAsignacion: "",
                fechaCreacion: "",
                fechaTermino: "",
                titulo: "",
                usuario: "",
                edificio: "",
                servicio: "",
                unidadEsp: ""
            },
            value1: 50,
            valc: false,
            popupActive: false,
            listadoTrabajadores: [],
            listadoTrabajadoresFiltrado: [],
            listadoHoraFecha: [],
            listadoTickets: [],
            listadoTurnos: [],
            localVal: "http://10.66.248.51:8000",
            horaSeleccionada: {
                id: 2,
                hora: "day",
                descripcionHora: "Dias"
            },
            turnoSeleccionado: {
                id: 0,
                descripcionTurno: "Seleccione Turno"
            },
            trabajadorSeleccionado: {
                id: 0,
                tra_nombre_apellido: "Seleccione Trabajador"
            },
            horas: [
                {
                    id: 1,
                    hora: "hour",
                    descripcionHora: "Horas"
                },
                {
                    id: 2,
                    hora: "day",
                    descripcionHora: "Dias"
                },
                {
                    id: 3,
                    hora: "week",
                    descripcionHora: "Semana"
                },
                {
                    id: 4,
                    hora: "month",
                    descripcionHora: "Meses"
                },
                {
                    id: 5,
                    hora: "year",
                    descripcionHora: "Año"
                }
            ],
            config: {
                height: 400,
                plugins: [],
                locale: {
                    name: "es-Cl",
                    Now: "Justo Ahora",
                    weekdays: [
                        "Domingo",
                        "Lunes",
                        "Martes",
                        "Miercoles",
                        "Jueves",
                        "Viernes",
                        "Sabado"
                    ],
                    months: [
                        "Enero",
                        "Febrero",
                        "Marzo",
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
                },
                list: {
                    rows: {},

                    columns: {
                        percent: 100,
                        resizer: {
                            inRealTime: true
                        },
                        minWidth: 50,
                        data: {
                            id: {
                                id: "id",
                                data: "id",
                                width: 50,
                                header: {
                                    content: "ID"
                                }
                            },
                            label: {
                                id: "label",
                                data: "label",
                                width: 230,
                                expander: true,
                                isHTML: false,
                                header: {
                                    content: "Trabajador"
                                }
                            }
                        }
                    },
                    expander: {
                        padding: 18,
                        size: 20,
                        icon: {
                            width: 16,
                            height: 16
                        },
                        icons: {
                            child:
                                '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><ellipse ry="4" rx="4" id="svg_1" cy="12" cx="12" fill="#000000B0"/></svg>',
                            open:
                                '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/><path fill="none" d="M0 0h24v24H0V0z"/></svg>',
                            closed:
                                '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/><path fill="none" d="M0 0h24v24H0V0z"/></svg>'
                        }
                    },
                    toggle: {
                        display: true,
                        icons: {
                            open: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path stroke="null" d="m16.406954,16.012672l4.00393,-4.012673l-4.00393,-4.012673l1.232651,-1.232651l5.245324,5.245324l-5.245324,5.245324l-1.232651,-1.232651z"/><path stroke="null" d="m-0.343497,12.97734zm1.620144,0l11.341011,0l0,-1.954681l-11.341011,0l0,1.954681zm0,3.909362l11.341011,0l0,-1.954681l-11.341011,0l0,1.954681zm0,-9.773404l0,1.95468l11.341011,0l0,-1.95468l-11.341011,0z"/></svg>`,
                            close: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path transform="rotate(-180 4.392796516418457,12) " stroke="null" d="m1.153809,16.012672l4.00393,-4.012673l-4.00393,-4.012673l1.232651,-1.232651l5.245324,5.245324l-5.245324,5.245324l-1.232651,-1.232651z"/><path stroke="null" d="m9.773297,12.97734zm1.620144,0l11.341011,0l0,-1.954681l-11.341011,0l0,1.954681zm0,3.909362l11.341011,0l0,-1.954681l-11.341011,0l0,1.954681zm0,-9.773404l0,1.95468l11.341011,0l0,-1.95468l-11.341011,0z"/></svg>`
                        }
                    }
                },
                scroll: {
                    propagate: true,
                    smooth: false,
                    top: 0,
                    left: 0,
                    xMultiplier: 3,
                    yMultiplier: 3,
                    percent: {
                        top: 0,
                        left: 0
                    },
                    compensation: {
                        x: 0,
                        y: 0
                    }
                },
                chart: {
                    items: {},
                    time: {
                        period: "day",
                        additionalSpaces: {
                            hour: { before: 24, after: 24, period: "hour" },
                            day: { before: 1, after: 1, period: "month" },
                            week: { before: 1, after: 1, period: "year" },
                            month: { before: 6, after: 6, period: "year" },
                            year: { before: 12, after: 12, period: "year" }
                        }
                    },
                    calendar: {
                        expand: true,
                        levels: [
                            {
                                formats: [
                                    {
                                        zoomTo: 17,
                                        period: "day",
                                        className:
                                            "gstc-date-medium gstc-date-left",
                                        format({ timeStart }) {
                                            return timeStart.format(
                                                "DD MMMM YYYY (dddd)"
                                            );
                                        }
                                    },
                                    {
                                        zoomTo: 23,
                                        period: "month",
                                        format({ timeStart }) {
                                            return timeStart.format(
                                                "MMMM YYYY"
                                            );
                                        }
                                    },
                                    {
                                        zoomTo: 24,
                                        period: "month",
                                        format({ timeStart, className, vido }) {
                                            return timeStart.format("MMMM 'YY");
                                        }
                                    },
                                    {
                                        zoomTo: 25,
                                        period: "month",
                                        format({ timeStart }) {
                                            return timeStart.format("MMM YYYY");
                                        }
                                    },
                                    {
                                        zoomTo: 27,
                                        period: "year",
                                        format({ timeStart }) {
                                            return timeStart.format("YYYY");
                                        }
                                    },
                                    {
                                        zoomTo: 100,
                                        period: "year",
                                        default: true,
                                        format() {
                                            return null;
                                        }
                                    }
                                ]
                            },
                            {
                                main: true,
                                formats: [
                                    {
                                        zoomTo: 16,
                                        period: "hour",
                                        format({ timeStart }) {
                                            return timeStart.format("HH:mm");
                                        }
                                    },
                                    {
                                        zoomTo: 17,
                                        period: "hour",
                                        default: true,
                                        format({ timeStart }) {
                                            return timeStart.format("HH");
                                        }
                                    },
                                    {
                                        zoomTo: 19,
                                        period: "day",
                                        className: "gstc-date-medium",
                                        format({ timeStart, className, vido }) {
                                            return vido.html`<span class="${className}-content gstc-date-bold">${timeStart.format(
                                                "DD"
                                            )}</span> <span class="${className}-content gstc-date-thin">${timeStart.format(
                                                "dddd"
                                            )}</span>`;
                                        }
                                    },
                                    {
                                        zoomTo: 20,
                                        period: "day",
                                        default: true,
                                        format({ timeStart, vido, className }) {
                                            return vido.html`<div class="${className}-content gstc-date-top">${timeStart.format(
                                                "DD"
                                            )}</div><div class="${className}-content gstc-date-small">${timeStart.format(
                                                "dddd"
                                            )}</div>`;
                                        }
                                    },
                                    {
                                        zoomTo: 21,
                                        period: "day",
                                        format({ timeStart, vido, className }) {
                                            return vido.html`<div class="${className}-content gstc-date-top">${timeStart.format(
                                                "DD"
                                            )}</div><div class="${className}-content gstc-date-small">${timeStart.format(
                                                "ddd"
                                            )}</div>`;
                                        }
                                    },
                                    {
                                        zoomTo: 22,
                                        period: "day",
                                        className: "gstc-date-vertical",
                                        format({ timeStart, className, vido }) {
                                            return vido.html`<div class="${className}-content gstc-date-top">${timeStart.format(
                                                "DD"
                                            )}</div><div class="${className}-content gstc-date-extra-small">${timeStart.format(
                                                "ddd"
                                            )}</div>`;
                                        }
                                    },
                                    {
                                        zoomTo: 23,
                                        period: "week",
                                        default: true,
                                        format({
                                            timeStart,
                                            timeEnd,
                                            className,
                                            vido
                                        }) {
                                            return vido.html`<div class="${className}-content gstc-date-top">${timeStart.format(
                                                "DD"
                                            )} - ${timeEnd.format(
                                                "DD"
                                            )}</div><div class="${className}-content gstc-date-small gstc-date-thin">${timeStart.format(
                                                "ddd"
                                            )} - ${timeEnd.format("dd")}</div>`;
                                        }
                                    },
                                    {
                                        zoomTo: 25,
                                        period: "week",
                                        className: "gstc-date-vertical",
                                        format({
                                            timeStart,
                                            timeEnd,
                                            className,
                                            vido
                                        }) {
                                            return vido.html`<div class="${className}-content gstc-date-top gstc-date-small gstc-date-normal">${timeStart.format(
                                                "DD"
                                            )}</div><div class="gstc-dash gstc-date-small">-</div><div class="${className}-content gstc-date-small gstc-date-normal">${timeEnd.format(
                                                "DD"
                                            )}</div>`;
                                        }
                                    },
                                    {
                                        zoomTo: 26,
                                        period: "month",
                                        default: true,
                                        className: "gstc-date-month-level-1",
                                        format({ timeStart, vido, className }) {
                                            return vido.html`<div class="${className}-content gstc-date-top">${timeStart.format(
                                                "MMM"
                                            )}</div><div class="${className}-content gstc-date-small gstc-date-bottom">${timeStart.format(
                                                "MM"
                                            )}</div>`;
                                        }
                                    },
                                    {
                                        zoomTo: 27,
                                        period: "month",
                                        className: "gstc-date-vertical",
                                        format({ timeStart, className, vido }) {
                                            return vido.html`<div class="${className}-content gstc-date-top">${timeStart.format(
                                                "MM"
                                            )}</div><div class="${className}-content gstc-date-extra-small">${timeStart.format(
                                                "MMM"
                                            )}</div>`;
                                        }
                                    },
                                    {
                                        zoomTo: 28,
                                        period: "year",
                                        default: true,
                                        className: "gstc-date-big",
                                        format({ timeStart }) {
                                            return timeStart.format("YYYY");
                                        }
                                    },
                                    {
                                        zoomTo: 29,
                                        period: "year",
                                        className: "gstc-date-medium",
                                        format({ timeStart }) {
                                            return timeStart.format("YYYY");
                                        }
                                    },
                                    {
                                        zoomTo: 30,
                                        period: "year",
                                        className: "gstc-date-medium",
                                        format({ timeStart }) {
                                            return timeStart.format("YY");
                                        }
                                    }
                                ]
                            }
                        ]
                    },
                    grid: {
                        block: {
                            onCreate: []
                        }
                    },
                    items: {},
                    spacing: 1
                },
                actions: {}
            }
        };
    },
    methods: {
        forceRerender() {
            this.componentKey += 1;
            let action = {
                "chart-timeline-items-row-item": [this.mensaje]
            };

            this.config.actions = action;
        },
        cargarTodo() {
            this.cargarTTrabajadores();
        },
        cargarTTrabajadores() {
            //this.listadoTrabajadores = res.data;
            let c = this.listadoTrabajadores;

            let arregloTra = [];
            let listadoFiltrado = [];
            var va = {};
            arregloTra.push(va);
            // console.log(c);
            arregloTra.push(va);
            c.forEach((value, index) => {
                if (value.id != 1) {
                    let objeto = {
                        id: 0,
                        label: "",
                        expanded: true
                    };

                    objeto.id = value.id;
                    objeto.label = value.tra_nombre + " " + value.tra_apellido;
                    arregloTra.push(objeto);
                    listadoFiltrado.push(value);
                }
            });
            this.listadoTrabajadoresFiltrado = listadoFiltrado;

            this.config.list.rows = arregloTra;
            this.cargaTListadoTickets();
        },

        cargaTListadoTickets() {
            let listadoRow = this.config.list.rows;
            let c = this.listadoTickets;
            let contador = listadoRow.length;
            let objeto = {
                id: 0,
                label: "",
                parentId: 0,
                expanded: false,
                id_solicitud: 0
            };
            listadoRow.push(objeto);

            c.forEach((value, index) => {
                objeto = {
                    id: 0,
                    label: "",
                    parentId: 0,
                    expanded: false,
                    id_solicitud: 0
                };
                contador = contador + 1;
                objeto.id = contador;

                objeto.label = value.tra_nombre + " " + value.tra_apellido;
                objeto.parentId = value.id_trabajador;
                objeto.id_solicitud = value.id_solicitud;
                listadoRow.push(objeto);
            });
            var cont = listadoRow.length;

            this.config.height = 45 * cont;
            this.config.list.rows = listadoRow;
            this.cargarTHoraFechaCalendario();
        },
        cargarTHoraFechaCalendario() {
            let c = this.listadoHoraFecha;
            let listadoRow = this.config.list.rows;

            var f = {
                id: "",
                rowId: "",
                nticket: "",
                label: "",
                titulo: "",
                descripcion: "",
                usuario: "",
                edificio: "",
                servicio: "",
                unidadEsp: "",
                fechaCreacion: moment(),
                time: {
                    start: new Date().getTime(),
                    end: new Date().getTime() + 24 * 60 * 60 * 1000
                },
                style: {
                    background: "#30B2F6",
                    "border-radius": "1px"
                }
            };
            var fecha = {
                start: moment(),
                end: moment()
            };
            let b = [];

            let a = 0;
            b.push(f);
            c.forEach((value, index) => {
                listadoRow.forEach((element, indexv2) => {
                    if (
                        element.parentId == value.id_trabajador &&
                        element.id_solicitud == value.id
                    ) {
                        f = {
                            id: "",
                            rowId: "",
                            nticket: "",
                            label: "",
                            titulo: "",
                            descripcion: "",
                            usuario: "",
                            edificio: "",
                            servicio: "",
                            unidadEsp: "",
                            fechaCreacion: moment(),

                            time: {
                                start: new Date().getTime(),
                                end: new Date().getTime() + 24 * 60 * 60 * 1000
                            },
                            style: {
                                background:
                                    "#" +
                                    ((Math.random() * 0xffffff) << 0).toString(
                                        16
                                    )
                            }
                        };
                        fecha = {
                            start: moment(),
                            end: moment()
                        };

                        f.id = value.id;
                        f.rowId = element.id;
                        f.titulo = value.tituloP;
                        f.nticket = value.nticket;
                        f.label = "N°Ticket " + value.nticket;
                        f.fechaCreacion = new Date(value.created_at).getTime();

                        //f.label = value.descripcionP;
                        var newElement = document.createElement("div");
                        newElement.innerHTML = value.descripcionP;
                        f.descripcion = newElement.textContent;
                        f.usuario = value.nombrecompleto;
                        f.edificio = value.descripcionEdificio;
                        f.servicio = value.descripcionServicio;
                        f.unidadEsp = value.descripcionUnidadEsp;
                        fecha.start = new Date(
                            value.fechaInicio + " " + value.horaInicio
                        ).getTime();
                        fecha.end =
                            new Date(
                                value.fechaTermino + " " + value.horaTermino
                            ).getTime() +
                            24 * 60 * 60 * 1000;

                        f.time = fecha;

                        b.push(f);
                    }
                });
            });

            this.config.chart.items = b;
            this.forceRerender();
            this.valc = true;
        },
        cambioByTrabajador() {
            let arregloTra = [];

            var va = {};

            let objeto = {
                id: 0,
                label: "",
                expanded: true
            };
            let count = 0;
            for (count = 0; count < this.trabajadorSeleccionado.id; count++) {
                arregloTra.push(va);
            }

            objeto.id = this.trabajadorSeleccionado.id;
            objeto.label =
                this.trabajadorSeleccionado.tra_nombre +
                " " +
                this.trabajadorSeleccionado.tra_apellido;
            arregloTra.push(objeto);

            this.config.list.rows = arregloTra;

            this.recargaListadoTicketsByTrabajador();
        },
        recargaListadoTicketsByTrabajador() {
            let listadoRow = this.config.list.rows;
            let c = this.listadoTickets;
            let contador = listadoRow.length;
            let objeto = {
                id: 0,
                label: "",
                parentId: 0,
                expanded: false,
                id_solicitud: 0
            };
            listadoRow.push(objeto);

            let contadorEsp = 3;

            c.forEach((value, index) => {
                objeto = {
                    id: 0,
                    label: "",
                    parentId: 0,
                    expanded: false,
                    id_solicitud: 0
                };
                contador = contador + 1;
                objeto.id = contador;
                contadorEsp = contadorEsp + 1;

                objeto.label = value.tra_nombre + " " + value.tra_apellido;
                objeto.parentId = value.id_trabajador;
                objeto.id_solicitud = value.id_solicitud;
                listadoRow.push(objeto);
            });

            var cont = listadoRow.length;

            this.config.height = 45 * contadorEsp;
            this.config.list.rows = listadoRow;
            this.recargarHoraFechaCalendarioByTrabajador();
        },
        recargarHoraFechaCalendarioByTrabajador() {
            let c = this.listadoHoraFecha;
            let listadoRow = this.config.list.rows;

            var f = {
                id: "",
                rowId: "",
                nticket: "",
                label: "",
                titulo: "",
                descripcion: "",
                usuario: "",
                edificio: "",
                servicio: "",
                unidadEsp: "",
                fechaCreacion: moment(),
                time: {
                    start: new Date().getTime(),
                    end: new Date().getTime() + 24 * 60 * 60 * 1000
                },
                style: {
                    background: "#30B2F6",
                    "border-radius": "1px"
                }
            };
            var fecha = {
                start: moment(),
                end: moment()
            };
            let b = [];

            let a = 0;
            b.push(f);

            c.forEach((value, index) => {
                listadoRow.forEach((element, indexv2) => {
                    if (
                        element.parentId == value.id_trabajador &&
                        element.id_solicitud == value.id
                    ) {
                        f = {
                            id: "",
                            rowId: "",
                            nticket: "",
                            label: "",
                            titulo: "",
                            descripcion: "",
                            usuario: "",
                            edificio: "",
                            servicio: "",
                            unidadEsp: "",
                            fechaCreacion: moment(),

                            time: {
                                start: new Date().getTime(),
                                end: new Date().getTime() + 24 * 60 * 60 * 1000
                            },
                            style: {
                                background:
                                    "#" +
                                    ((Math.random() * 0xffffff) << 0).toString(
                                        16
                                    )
                            }
                        };
                        fecha = {
                            start: moment(),
                            end: moment()
                        };

                        f.id = value.id;
                        f.rowId = element.id;
                        f.titulo = value.tituloP;
                        f.nticket = value.nticket;
                        f.label = "N°Ticket " + value.nticket;
                        f.fechaCreacion = new Date(value.created_at).getTime();

                        //f.label = value.descripcionP;
                        var newElement = document.createElement("div");
                        newElement.innerHTML = value.descripcionP;
                        f.descripcion = newElement.textContent;
                        f.usuario = value.nombrecompleto;
                        f.edificio = value.descripcionEdificio;
                        f.servicio = value.descripcionServicio;
                        f.unidadEsp = value.descripcionUnidadEsp;
                        fecha.start = new Date(
                            value.fechaInicio + " " + value.horaInicio
                        ).getTime();
                        fecha.end =
                            new Date(
                                value.fechaTermino + " " + value.horaTermino
                            ).getTime() +
                            24 * 60 * 60 * 1000;

                        f.time = fecha;

                        b.push(f);
                    }
                });
            });

            this.config.chart.items = b;

            this.valc = true;
            this.forceRerender();
        },
        cambioByTurno() {
            let c = this.listadoTrabajadores;

            let arregloTra = [];
            let listadoFiltrado = [];
            var va = {};
            arregloTra.push(va);
            // console.log(c);
            arregloTra.push(va);
            c.forEach((value, index) => {
                if (value.id != 1) {
                    let objeto = {
                        id: 0,
                        label: "",
                        expanded: true
                    };

                    objeto.id = value.id;
                    objeto.label = value.tra_nombre + " " + value.tra_apellido;
                    arregloTra.push(objeto);
                    listadoFiltrado.push(value);
                }
            });
            this.listadoTrabajadoresFiltrado = listadoFiltrado;

            this.config.list.rows = arregloTra;
            this.recargaListadoTicketsByTurno();
        },
        recargaListadoTicketsByTurno() {
            let listadoRow = this.config.list.rows;
            let c = this.listadoTickets;
            let contador = listadoRow.length;
            let objeto = {
                id: 0,
                label: "",
                parentId: 0,
                expanded: false,
                id_solicitud: 0
            };
            listadoRow.push(objeto);

            let contadorEsp = 3;

            c.forEach((value, index) => {
                if (this.turnoSeleccionado.id == value.idTurno) {
                    objeto = {
                        id: 0,
                        label: "",
                        parentId: 0,
                        expanded: false,
                        id_solicitud: 0
                    };
                    contador = contador + 1;
                    objeto.id = contador;

                    objeto.label = value.tra_nombre + " " + value.tra_apellido;
                    objeto.parentId = value.id_trabajador;
                    objeto.id_solicitud = value.id_solicitud;
                    listadoRow.push(objeto);
                }
            });

            var cont = listadoRow.length;

            this.config.height = 45 * cont;
            this.config.list.rows = listadoRow;
            this.recargarHoraFechaCalendarioByTurno();
        },
        recargarHoraFechaCalendarioByTurno() {
            let c = this.listadoHoraFecha;
            let listadoRow = this.config.list.rows;

            var f = {
                id: "",
                rowId: "",
                nticket: "",
                label: "",
                titulo: "",
                descripcion: "",
                usuario: "",
                edificio: "",
                servicio: "",
                unidadEsp: "",
                fechaCreacion: moment(),
                time: {
                    start: new Date().getTime(),
                    end: new Date().getTime() + 24 * 60 * 60 * 1000
                },
                style: {
                    background: "#30B2F6",
                    "border-radius": "1px"
                }
            };
            var fecha = {
                start: moment(),
                end: moment()
            };
            let b = [];

            let a = 0;
            b.push(f);

            c.forEach((value, index) => {
                listadoRow.forEach((element, indexv2) => {
                    if (
                        element.parentId == value.id_trabajador &&
                        element.id_solicitud == value.id
                    ) {
                        f = {
                            id: "",
                            rowId: "",
                            nticket: "",
                            label: "",
                            titulo: "",
                            descripcion: "",
                            usuario: "",
                            edificio: "",
                            servicio: "",
                            unidadEsp: "",
                            fechaCreacion: moment(),

                            time: {
                                start: new Date().getTime(),
                                end: new Date().getTime() + 24 * 60 * 60 * 1000
                            },
                            style: {
                                background:
                                    "#" +
                                    ((Math.random() * 0xffffff) << 0).toString(
                                        16
                                    )
                            }
                        };
                        fecha = {
                            start: moment(),
                            end: moment()
                        };

                        f.id = value.id;
                        f.rowId = element.id;
                        f.titulo = value.tituloP;
                        f.nticket = value.nticket;
                        f.label = "N°Ticket " + value.nticket;
                        f.fechaCreacion = new Date(value.created_at).getTime();

                        //f.label = value.descripcionP;
                        var newElement = document.createElement("div");
                        newElement.innerHTML = value.descripcionP;
                        f.descripcion = newElement.textContent;
                        f.usuario = value.nombrecompleto;
                        f.edificio = value.descripcionEdificio;
                        f.servicio = value.descripcionServicio;
                        f.unidadEsp = value.descripcionUnidadEsp;
                        fecha.start = new Date(
                            value.fechaInicio + " " + value.horaInicio
                        ).getTime();
                        fecha.end =
                            new Date(
                                value.fechaTermino + " " + value.horaTermino
                            ).getTime() +
                            24 * 60 * 60 * 1000;

                        f.time = fecha;

                        b.push(f);
                    }
                });
            });

            this.config.chart.items = b;

            this.valc = true;
            this.forceRerender();
        },
        mensaje(element, data) {
            var dato = {
                id: data.item.id,
                label: data.item.label,
                nticket: data.item.nticket,
                descripcion: data.item.descripcion,
                row: data.item.rowId,
                fechaAsignacion: data.item.time.start,
                fechaCreacion: data.item.fechaCreacion,
                tituloProblema: data.item.titulo,
                fechaTermino: data.item.time.end,
                usuario: data.item.usuario,
                edificio: data.item.edificio,
                servicio: data.item.servicio,
                unidadEsp: data.item.unidadEsp
            };

            element.addEventListener("click", this.mensaje2.bind(null, dato));
        },
        openLoadingColor() {
            this.$vs.loading({ color: this.colorLoading });
            setTimeout(() => {
                this.$vs.loading.close();
            }, 2000);
        },
        onState(state) {
            this.state = state;
            let GSTCState = GSTC;
        },
        cambioCalendario(tipoHora) {
            console.log(tipoHora);
            this.config.chart.time.period = tipoHora;
        },
        cargarTrabajadores() {
            axios
                .get(this.localVal + "/api/Agente/GetTrabajadoresEX", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoTrabajadores = res.data;
                    let c = this.listadoTrabajadores;

                    let arregloTra = [];
                    let listadoFiltrado = [];
                    var va = {};
                    arregloTra.push(va);
                    // console.log(c);
                    arregloTra.push(va);
                    c.forEach((value, index) => {
                        if (value.id != 1) {
                            let objeto = {
                                id: 0,
                                label: "",
                                expanded: true
                            };

                            objeto.id = value.id;
                            objeto.label =
                                value.tra_nombre + " " + value.tra_apellido;
                            arregloTra.push(objeto);
                            listadoFiltrado.push(value);
                        }
                    });
                    this.listadoTrabajadoresFiltrado = listadoFiltrado;

                    this.config.list.rows = arregloTra;
                    // this.cargaListadoTickets(this.listadoTrabajadores);
                });
        },
        cargaListadoTickets() {
            axios
                .get(this.localVal + "/api/Agente/GetTicketAsignadosEM", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoTickets = res.data;
                    let listadoRow = this.config.list.rows;
                    let c = this.listadoTickets;
                    let contador = listadoRow.length;
                    let objeto = {
                        id: 0,
                        label: "",
                        parentId: 0,
                        expanded: false,
                        id_solicitud: 0
                    };
                    listadoRow.push(objeto);

                    c.forEach((value, index) => {
                        objeto = {
                            id: 0,
                            label: "",
                            parentId: 0,
                            expanded: false,
                            id_solicitud: 0
                        };
                        contador = contador + 1;
                        objeto.id = contador;

                        objeto.label =
                            value.tra_nombre + " " + value.tra_apellido;
                        objeto.parentId = value.id_trabajador;
                        objeto.id_solicitud = value.id_solicitud;
                        listadoRow.push(objeto);
                    });

                    this.config.list.rows = listadoRow;
                });
        },
        cargarHoraFechaCalendario() {
            axios
                .get(this.localVal + "/api/Agente/getDatoCalendarioEM", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoHoraFecha = res.data;

                    let c = this.listadoHoraFecha;
                    let listadoRow = this.config.list.rows;

                    var f = {
                        id: "",
                        rowId: "",
                        nticket: "",
                        label: "",
                        titulo: "",
                        descripcion: "",
                        usuario: "",
                        edificio: "",
                        servicio: "",
                        unidadEsp: "",
                        fechaCreacion: moment(),
                        time: {
                            start: new Date().getTime(),
                            end: new Date().getTime() + 24 * 60 * 60 * 1000
                        },
                        style: {
                            background: "#30B2F6",
                            "border-radius": "1px"
                        }
                    };
                    var fecha = {
                        start: moment(),
                        end: moment()
                    };
                    let b = [];

                    let a = 0;
                    b.push(f);
                    c.forEach((value, index) => {
                        listadoRow.forEach((element, indexv2) => {
                            if (
                                element.parentId == value.id_trabajador &&
                                element.id_solicitud == value.id
                            ) {
                                f = {
                                    id: "",
                                    rowId: "",
                                    nticket: "",
                                    label: "",
                                    titulo: "",
                                    descripcion: "",
                                    usuario: "",
                                    edificio: "",
                                    servicio: "",
                                    unidadEsp: "",
                                    fechaCreacion: moment(),

                                    time: {
                                        start: new Date().getTime(),
                                        end:
                                            new Date().getTime() +
                                            24 * 60 * 60 * 1000
                                    },
                                    style: {
                                        background:
                                            "#" +
                                            (
                                                (Math.random() * 0xffffff) <<
                                                0
                                            ).toString(16)
                                    }
                                };
                                fecha = {
                                    start: moment(),
                                    end: moment()
                                };

                                f.id = value.id;
                                f.rowId = element.id;
                                f.titulo = value.tituloP;
                                f.nticket = value.nticket;
                                f.label = "N°Ticket " + value.nticket;
                                f.fechaCreacion = new Date(
                                    value.created_at
                                ).getTime();

                                //f.label = value.descripcionP;
                                var newElement = document.createElement("div");
                                newElement.innerHTML = value.descripcionP;
                                f.descripcion = newElement.textContent;
                                f.usuario = value.nombrecompleto;
                                f.edificio = value.descripcionEdificio;
                                f.servicio = value.descripcionServicio;
                                f.unidadEsp = value.descripcionUnidadEsp;
                                fecha.start = new Date(
                                    value.fechaInicio + " " + value.horaInicio
                                ).getTime();
                                fecha.end =
                                    new Date(
                                        value.fechaTermino +
                                            " " +
                                            value.horaTermino
                                    ).getTime() +
                                    24 * 60 * 60 * 1000;

                                f.time = fecha;

                                b.push(f);
                            }
                        });
                    });
                    var cont = listadoRow.length;

                    this.config.height = 45 * cont;

                    this.config.chart.items = b;

                    this.valc = true;
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
                    this.listadoTurnos = res.data;
                });
        },
        mensaje2(dato) {
            this.infoGeneral.titulo = "Numero de ticket: " + dato.id;
            this.infoGeneral.nticket = dato.nticket;
            this.infoGeneral.descripcion = dato.descripcion;

            this.infoGeneral.fechaAsignacion = moment(
                dato.fechaAsignacion
            ).format("DD-MM-YYYY, HH:mm:ss");

            this.infoGeneral.fechaTermino = moment(dato.fechaTermino).format(
                "DD-MM-YYYY , HH:mm:ss"
            );

            this.infoGeneral.fechaCreacion = moment(dato.fechaCreacion).format(
                "DD-MM-YYYY , HH:mm:ss"
            );
            this.infoGeneral.titulo = dato.tituloProblema;
            this.infoGeneral.usuario = dato.usuario;
            this.infoGeneral.edificio = dato.edificio;
            this.infoGeneral.servicio = dato.servicio;
            this.infoGeneral.unidadEsp = dato.unidadEsp;

            this.popupActive = true;
        }
    },
    created() {
        this.cargarTrabajadores();
        this.cargarTurnos();
        this.cargaListadoTickets();
    },
    beforeMount() {
        setTimeout(() => {
            this.cargarHoraFechaCalendario();
        }, 2000);
        this.openLoadingColor();
    },
    mounted() {
        setTimeout(() => {
            let action = {
                "chart-timeline-items-row-item": [this.mensaje]
            };

            this.config.actions = action;
        }, 2000);
    },
    beforeDestroy() {
        subs.forEach(unsub => unsub());
    }
};
</script>
