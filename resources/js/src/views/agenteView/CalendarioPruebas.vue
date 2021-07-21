<template>
    <div>
        <div class="vx-row">
            <vx-card>
                <div class="vx-col w-full" :key="resetI">
                    <FullCalendar :options="calendarOptions" />
                </div>
            </vx-card>
        </div>
        <vs-popup
            classContent="popup-example"
            title="Crear Nueva Obra"
            :active.sync="popCrearNObra"
        >
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="1. Ingrese Datos">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.1 Titulo Obra</h6>
                            <vs-input
                                class="vx-col w-full mt-5"
                                v-model="title"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.2 Fecha Inicio</h6>
                            <vs-input
                                class="vx-col w-full mt-5"
                                v-model="start"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.3 Fecha Termino</h6>
                            <vs-input
                                class="vx-col w-full mt-5"
                                v-model="end"
                            />
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

export default {
    components: {
        FullCalendar // make the <FullCalendar> tag available
    },
    data() {
        return {
            resetI: 0,
            popCrearNObra: false,
            title: "",
            start: "",
            end: "",
            calendarOptions: {
                plugins: [
                    dayGridPlugin,
                    interactionPlugin,
                    resourceTimelinePlugin
                ],
                headerToolbar: {
                    left: "today prev,next",
                    center: "title",
                    right:
                        "resourceTimelineDay,resourceTimelineWeek,resourceTimelineMonth"
                },
                dateClick: this.handleDateClick,
                locale: esLocale,
                selectable: true,
                resourceAreaHeaderContent: "Calendario de Obras",
                resources: {},
                events: {},
                initialView: "resourceTimelineDay",
                schedulerLicenseKey:
                    "CC-Attribution-NonCommercial-NoDerivatives"
            }
        };
    },
    methods: {
        handleDateClick: function(arg) {
            this.popCrearNObra = true;
        },
        cargarRecursos() {
            try {
                let obj = [
                    {
                        resourceId: "d",
                        start: "2021-07-20",
                        end: "2021-07-22"
                    },
                    {
                        resourceId: "d1",
                        start: "2021-07-22",
                        end: "2021-07-23"
                    },
                    {
                        resourceId: "d2",
                        start: "2021-07-23",
                        end: "2021-07-24"
                    },
                    {
                        resourceId: "d3",
                        start: "2021-07-24",
                        end: "2021-07-26"
                    },
                    {
                        resourceId: "c",
                        start: "2021-07-21T12:00:00+00:00",
                        end: "2021-07-22T06:00:00+00:00"
                    }
                ];
                let data = [
                    { id: "a", title: "Obra A" },
                    { id: "b", title: "Obra B", eventColor: "green" },
                    { id: "c", title: "Obra C", eventColor: "#e41ff5" },
                    {
                        id: "d",
                        title: "Obra D",
                        children: [
                            {
                                id: "d1",
                                title: "Redaccion Proyecto",
                                eventColor: "#e41ff0"
                            },
                            {
                                id: "d2",
                                title: "Diseño Proyecto",
                                eventColor: "yellow"
                            },
                            {
                                id: "d3",
                                title: "Cotizacion Proyecto",
                                eventColor: "red"
                            }
                        ]
                    },
                    { id: "e", title: "Obra E" },
                    { id: "f", title: "Obra F", eventColor: "red" },
                    { id: "g", title: "Obra G" }
                ];

                this.calendarOptions.resources = data;
                this.calendarOptions.events = obj;
                this.resetI += 1;

                /*  axios
                    .all([
                        axios.get(
                            "https://fullcalendar.io/demo-resources.json?with-nesting&with-colors"  ,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            } 
                        ),
                        axios.get(
                            "https://fullcalendar.io/demo-events.json?single-day&for-resource-timeline"  ,
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
                        axios.spread((dat1, dat2) => {
                            console.log(dat1.data);
                            console.log(dat2.data);
                        })
                    ); */
            } catch (error) {
                console.log("Error al recuperar los datos externos");
            }
        }
    },
    created() {
        this.cargarRecursos();
    }
};
</script>
