<template>
    <div>
        <div class="toolbox">
            <button @click="updateFirstRow">Update first row</button>
            <button @click="changeZoomLevel">Change zoom level</button>
        </div>
        <div class="gstc-wrapper" ref="gstc" :key="componentKey"></div>
    </div>
</template>

<script>
import GSTC from "gantt-schedule-timeline-calendar";
import { Plugin as TimelinePointer } from "gantt-schedule-timeline-calendar/dist/plugins/timeline-pointer.esm.min.js";
import { Plugin as Selection } from "gantt-schedule-timeline-calendar/dist/plugins/selection.esm.min.js";
import { Plugin as ItemResizing } from "gantt-schedule-timeline-calendar/dist/plugins/item-resizing.esm.min.js";
import { Plugin as ItemMovement } from "gantt-schedule-timeline-calendar/dist/plugins/item-movement.esm.min.js";
import { Plugin as CalendarScroll } from "gantt-schedule-timeline-calendar/dist/plugins/calendar-scroll.esm.min.js";
import "gantt-schedule-timeline-calendar/dist/style.css";
import axios from "axios";
import router from "@/router";
import moment from "moment";
import vSelect from "vue-select";

let gstc, state;

// helper functions

/* export const actionNames: SlotName[] = [
    "main",
    "scroll-bar",
    "list",
    "list-column",
    "list-column-header",
    "list-column-header-resizer",
    "list-column-header-resizer-dots",
    "list-column-row",
    "list-column-row-expander",
    "list-column-row-expander-toggle",
    "list-toggle",
    "chart",
    "chart-calendar",
    "chart-calendar-date",
    "chart-timeline",
    "chart-timeline-grid",
    "chart-timeline-grid-row",
    "chart-timeline-grid-row-cell",
    "chart-timeline-items",
    "chart-timeline-items-row",
    "chart-timeline-items-row-item"
]; */

/**
 * @returns { import("gantt-schedule-timeline-calendar").Items }
 */
function generateItems() {
    const items = {};
    let start = GSTC.api
        .date()
        .startOf("day")
        .subtract(6, "day");
    for (let i = 0; i < 15; i++) {
        const id = GSTC.api.GSTCID(i.toString());
        const rowId = GSTC.api.GSTCID(
            Math.floor(Math.random() * 10).toString()
        );
        start = start.add(1, "day");
        items[id] = {
            id,
            label: `Item ${i}`,
            rowId,
            time: {
                start: start.valueOf(),
                end: start
                    .add(1, "day")
                    .endOf("day")
                    .valueOf()
            }
        };
    }
    return items;
}

// main component

export default {
    name: "GSTC",
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
            localVal: process.env.MIX_APP_URL,
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
            ]
        };
    },
    methods: {
        forceRerender() {
            this.componentKey += 1;
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
                    let c = res.data;
                    let arregloTra = [];
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
                        }
                    });
                    //this.forceRerender();
                    this.listadoTrabajadores = arregloTra;
                });
        },

        cargaListadoTickets() {
            axios
                .get(this.localVal + "/api/Agente/GetTicketAsignadosInfra", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    let listadoRow = this.listadoTrabajadores;
                    let c = res.data;
                    let contador = listadoRow.length;
                    let b = [];
                    let objeto = {
                        id: 0,
                        label: "",
                        parentId: 0,
                        expanded: false,
                        id_solicitud: 0
                    };
                    /*  listadoRow.push(objeto);  */
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
                        b.push(objeto);
                    });
                    /* var cont = listadoRow.length;
                    this.config.height = 45 * cont; */
                    this.listadoTickets = b;
                });
        },

        cargarHoraFechaCalendario() {
            const GSTCID = GSTC.api.GSTCID;
            axios
                .get(this.localVal + "/api/Agente/getDatoCalendario", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    let c = res.data;
                    let listadoRow = this.listadoTickets;
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
                    //b.push(f);
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
                                f.id = value.id.toString();
                                f.rowId = element.parentId.toString();
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
                    console.log(b);
                    this.listadoHoraFecha = b;
                    //this.valc = true;
                });
        },
        updateFirstRow() {
            state.update(`config.list.rows.${GSTC.api.GSTCID("0")}`, row => {
                row.label = "Changed dynamically";
                return row;
            });
        },

        changeZoomLevel() {
            state.update("config.chart.time.zoom", 21);
        },

        cargaCalendario() {
            /**
             * @type { import("gantt-schedule-timeline-calendar").Config }
             */
            const config = {
                licenseKey:
                    "====BEGIN LICENSE KEY====\nW6sQ3Jl0xyt89q7ICGEOITfMDkXZsFyeejOmrYdQ37as4/dcIiacq5jd6qmR8lSlB6kbiKn9avpJ3h6+M9ia6CIWlPQTk96vqlyJ1mUHj21kjGYBE4VdVyE7so+cL0EvmU/CaeKT/MxLo8vKHOWekTHt00HvdHndv5Rg3C5F5lofeynR4GMiRJe1vkzJxcI3vmerswoTen+QtqNwArEttBJLPL/R+KJFTjpV07TT7Qx+85IsOYRrpgTaBgJH6dYjw6nLmVbIMMu9Na6waHN47Xj81basw3fTvlVDA3Vomg8tM/sEQFM5bN6qgMqJk2upZFRcdmpBll/1LYFDEqnHdQ==||U2FsdGVkX1+wSTGiSSeKc8MAQ70ginLdbTCFW0zLWR6GL9HKyyc+/2rKH/s/9XgULUFoUU3pjOut4cZOyakxsXnyNeNwzQy7ujM7jYrhg5A=\nVRZ38+fvUj9tBa3QD6TdiJZKtl6jdTOQtVdlQ2lQ5NRVCcTNveucwQIbPSLsWI2yN0Awfb3spDTy3XsAH+CRzkcK6J+7SmVCwjz5la5CgvYQGNHEy7vrm4ZBR+cCoDO5u3fFww6QLGuOzKadxF/dbxwmIx8J0jrvUPZ14eoFyV8ZbD0Ndqgtlm1VhuHbXdg5rgTlmvWAAkOhBficNih3mFgZM+duMShsY+IpFaJfqI9jsRymx+f1bdrNUZKKDLXnMedGyRJls29hwXlXDinxZqNxHHcSRCFzSX73k5ZkwjF3WZhhPM7Se6HNRFVdNU7fhMuWuNkuaQF3CBdcKGDFWQ==\n====END LICENSE KEY====",
                debug: false,
                plugins: [
                    TimelinePointer(),
                    Selection(),
                    ItemResizing(),
                    ItemMovement(),
                    CalendarScroll()
                ],
                plugin: {},
                innerHeight: 428,
                headerHeight: 72,
                components: {},
                list: {
                    rows: this.listadoTrabajadores,
                    row: {
                        height: 40,
                        gap: {
                            top: 0,
                            bottom: 0
                        }
                    },
                    columns: {
                        percent: 100,
                        resizer: {
                            width: 10,
                            inRealTime: true,
                            dots: 6
                        },
                        minWidth: 50,
                        data: {
                            [GSTC.api.GSTCID("id")]: {
                                id: GSTC.api.GSTCID("id"),
                                width: 60,
                                data: ({ row }) => GSTC.api.sourceID(row.id),
                                header: {
                                    content: "ID"
                                }
                            },
                            [GSTC.api.GSTCID("label")]: {
                                id: GSTC.api.GSTCID("label"),
                                width: 200,
                                data: "label",
                                header: {
                                    content: "Trabajadores"
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
                            open:
                                '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path stroke="null" d="m16.406954,16.012672l4.00393,-4.012673l-4.00393,-4.012673l1.232651,-1.232651l5.245324,5.245324l-5.245324,5.245324l-1.232651,-1.232651z"/><path stroke="null" d="m-0.343497,12.97734zm1.620144,0l11.341011,0l0,-1.954681l-11.341011,0l0,1.954681zm0,3.909362l11.341011,0l0,-1.954681l-11.341011,0l0,1.954681zm0,-9.773404l0,1.95468l11.341011,0l0,-1.95468l-11.341011,0z"/></svg>',
                            close:
                                '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path transform="rotate(-180 4.392796516418457,12) " stroke="null" d="m1.153809,16.012672l4.00393,-4.012673l-4.00393,-4.012673l1.232651,-1.232651l5.245324,5.245324l-5.245324,5.245324l-1.232651,-1.232651z"/><path stroke="null" d="m9.773297,12.97734zm1.620144,0l11.341011,0l0,-1.954681l-11.341011,0l0,1.954681zm0,3.909362l11.341011,0l0,-1.954681l-11.341011,0l0,1.954681zm0,-9.773404l0,1.95468l11.341011,0l0,-1.95468l-11.341011,0z"/></svg>'
                        }
                    },
                    sort: {
                        compare: null,
                        icons: {
                            up:
                                '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>',
                            down:
                                '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-down"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg>'
                        }
                    }
                },
                scroll: {
                    bodyClassName: "gstc-scrolling",
                    horizontal: {
                        size: 20,
                        minInnerSize: 40,
                        data: null,
                        posPx: 0,
                        maxPosPx: 0,
                        area: 0,
                        multiplier: 3,
                        offset: 0,
                        precise: false
                    },
                    vertical: {
                        size: 20,
                        minInnerSize: 40,
                        data: null,
                        posPx: 0,
                        maxPosPx: 0,
                        area: 0,
                        multiplier: 3,
                        offset: 0,
                        precise: false
                    }
                },
                chart: {
                    items: this.listadoHoraFecha
                },
                //actions: generateEmptyActions(),
                locale: {
                    name: "es",
                    weekdays: "Domingo_Lunes_Martes_Miercoles_Jueves_Viernes_Sabado".split(
                        "_"
                    ),
                    weekdaysShort: "Dom_Lun_Mar_Mie_Jue_Vie_Sab".split("_"),
                    weekdaysMin: "Do_Lu_Ma_Mi_Ju_Vi_Sa".split("_"),
                    months: "Enero_Febrero_Marzo_Abril_Mayo_Junio_Julio_Agosto_Septiembre_Octubre_Noviembre_Diciembre".split(
                        "_"
                    ),
                    monthsShort: "Ene_Feb_Mar_Abr_May_Jun_Jul_Aug_Sep_Oct_Nov_Dec".split(
                        "_"
                    ),
                    weekStart: 1,
                    relativeTime: {
                        future: "En %s",
                        past: "%s Hace",
                        s: "Hace unos Segundos",
                        m: "Un Minuto",
                        mm: "%d Minutos",
                        h: "Una Hora",
                        hh: "%d Horas",
                        d: "Un Dia",
                        dd: "%d Dias",
                        M: "Un Mes",
                        MM: "%d Meses",
                        y: "Un Año",
                        yy: "%d Años"
                    },
                    formats: {
                        LT: "HH:mm",
                        LTS: "HH:mm:ss",
                        L: "DD/MM/YYYY",
                        LL: "D MMMM YYYY",
                        LLL: "D MMMM YYYY HH:mm",
                        LLLL: "dddd, D MMMM YYYY HH:mm"
                    }
                    /* ordinal: (n: number) => {
                        const s = ["th", "st", "nd", "rd"];
                        const v = n % 100;
                        return `[${n}${s[(v - 20) % 10] || s[v] || s[0]}]`;
                    } */
                },
                utcMode: false,
                /* merge(target: object, source: object) {
                    return helpers.mergeDeep({}, target, source);
                }, */
                useLast: true,
                Promise,
                mute: []
            };

            state = GSTC.api.stateFromConfig(config);
            console.log("1");

            gstc = GSTC({
                element: this.$refs.gstc,
                state
            });
        }
    },
    created() {
        this.cargarTrabajadores();
        this.cargaListadoTickets();
        this.cargarHoraFechaCalendario();
        setTimeout(() => {
            this.cargaCalendario();
        }, 2000);
    },
    mounted() {},

    beforeUnmount() {
        if (gstc) gstc.destroy();
    }
};
</script>
<style scoped>
/* .gstc-component {
    margin: 0;
    padding: 0;
}
.toolbox {
    padding: 10px;
} */
</style>
