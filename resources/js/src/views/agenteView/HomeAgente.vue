<template>
    <div>
        <div class="vx-row">
            <div
                class="router-header flex flex-wrap items-center mb-6"
                style="margin-left:10px;"
            ></div>
        </div>
        <div class="vx-row">
            <!-- <div class="vx-col w-full lg:w-1/4 mb-base"></div> -->
            <div class="vx-col w-full  mb-base">
                <vx-card
                    slot="no-body"
                    class="text-center bg-primary-gradient greet-user"
                >
                    <feather-icon
                        icon="SunIcon"
                        class="p-6 mb-8 bg-primary inline-flex rounded-full text-white shadow"
                        svgClasses="h-8 w-8"
                    ></feather-icon>
                    <h1 class="mb-6 text-white">Bienvenido!</h1>
                    <p
                        class="xl:w-3/4 lg:w-4/5 md:w-2/3 w-4/5 mx-auto text-white"
                    >
                        Sistema de Gestion de Tickets de RRFF-
                        <strong>Hospital San Juan de Dios</strong>.
                    </p>
                </vx-card>
            </div>
            <!-- <div class="vx-col w-full lg:w-1/4 mb-base"></div> -->
        </div>

        <div class="vx-row">
            <!-- <div class="vx-col w-full lg:w-1/4 mb-base"></div> -->
            <!-- <div class="vx-col w-full lg:w-1/2 mb-base"> -->
            <div class="vx-col w-full lg:w-full mb-base">
                <vx-card title="Informacion del Perfil">
                    <vx-timeline :data="timelineData" />
                </vx-card>
            </div>
            <!-- </div> -->
            <!-- <div class="vx-col w-full lg:w-1/4 mb-base"></div> -->
        </div>

        <div class="vx-row">
            <div
                class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base"
            >
                <statistics-card-line
                    icon="UsersIcon"
                    :statistic="serviciom"
                    statisticTitle="Servicio Mas Solicitante"
                    color="primary"
                    type="area"
                ></statistics-card-line>
            </div>
            <div
                class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base"
            >
                <statistics-card-line
                    icon="UsersIcon"
                    :statistic="usuariom"
                    statisticTitle="Usuario Mas Solicitante"
                    color="warning"
                    type="area"
                ></statistics-card-line>
            </div>

            <div
                class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base"
            >
                <statistics-card-line
                    icon="UsersIcon"
                    :statistic="categoriam"
                    statisticTitle="Categoria Mas Solicitada"
                    color="danger"
                    type="area"
                ></statistics-card-line>
            </div>

            <div
                class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base"
            >
                <statistics-card-line
                    icon="UsersIcon"
                    :statistic="tmantencionm"
                    statisticTitle="Tipo de Reparacion Mas Solicitada"
                    color="success"
                    type="area"
                ></statistics-card-line>
            </div>
        </div>
        <br />
        <div class="vx-row">
            <!--<div class="vx-col w-full lg:w-1/4 mb-base"></div>-->
            <div class="vx-col w-1/2 mb-base">
                <vx-card title="Seguimiento Tickets" :key="resetI">
                    <!-- CARD ACTION -->
                    <!-- <template slot="actions">
                        <change-time-duration-dropdown />
                    </template> -->

                    <div slot="no-body" v-if="supportTracker.analyticsData">
                        <div class="vx-row text-center">
                            <!-- Open Tickets Heading -->
                            <div
                                class="vx-col w-full lg:w-1/5 md:w-full sm:w-1/5 flex flex-col justify-between mb-4 lg:order-first md:order-last sm:order-first order-last"
                            >
                                <div
                                    class="lg:ml-6 lg:mt-6 md:mt-0 md:ml-0 sm:ml-6 sm:mt-6"
                                >
                                    <h1 class="font-bold text-5xl">
                                        {{
                                            supportTracker.analyticsData
                                                .openTickets
                                        }}
                                    </h1>
                                    <small>Total de Tickets</small>
                                </div>
                            </div>

                            <!-- Chart -->
                            <div
                                class="vx-col w-full lg:w-4/5 md:w-full sm:w-4/5 justify-center mx-auto lg:mt-0 md:mt-6 sm:mt-0 mt-6"
                            >
                                <vue-apex-charts
                                    type="radialBar"
                                    height="385"
                                    :options="
                                        analyticsData.supportTrackerRadialBar
                                            .chartOptions
                                    "
                                    :series="supportTracker.series"
                                />
                            </div>
                        </div>

                        <!-- Support Tracker Meta Data -->
                        <div
                            class="flex flex-row justify-between px-8 pb-4 mt-4"
                        >
                            <p
                                class="text-center"
                                v-for="(val, key) in supportTracker
                                    .analyticsData.meta"
                                :key="key"
                            >
                                <span class="block">{{ key }}</span>
                                <span class="text-2xl font-semibold">{{
                                    val
                                }}</span>
                            </p>
                        </div>
                    </div>
                </vx-card>
            </div>
            <div class="vx-col w-1/2 mb-base">
                <vx-card title="Porcentaje Avance Tickets" :key="resetI">
                    <!-- CARD ACTION -->
                    <!-- <template slot="actions">
                        <change-time-duration-dropdown />
                    </template> -->

                    <!-- Chart -->
                    <div slot="no-body">
                        <vue-apex-charts
                            type="radialBar"
                            height="420"
                            :options="productOrdersRadialBar.chartOptions"
                            :series="productsOrder.series"
                        />
                    </div>

                    <ul>
                        <li
                            v-for="orderData in productsOrder.analyticsData"
                            :key="orderData.orderType"
                            class="flex mb-3 justify-between"
                        >
                            <span class="flex items-center">
                                <span
                                    class="inline-block h-4 w-4 rounded-full mr-2 bg-white border-3 border-solid"
                                    :class="`border-${orderData.color}`"
                                ></span>
                                <span class="font-semibold">{{
                                    orderData.orderType
                                }}</span>
                            </span>
                            <span>{{ orderData.counts }}</span>
                        </li>
                    </ul>
                </vx-card>
            </div>
        </div>
        <br />
        <div class="vx-row" v-if="esJefatura">
            <!--<div class="vx-col w-full lg:w-1/4 mb-base"></div>-->
            <div class="vx-col w-1/2 mb-base">
                <vx-card
                    title="Seguimiento Tickets Equipos Medicos"
                    :key="resetIEM"
                >
                    <!-- CARD ACTION -->
                    <!-- <template slot="actions">
                        <change-time-duration-dropdown />
                    </template> -->

                    <div slot="no-body" v-if="supportTrackerEM.analyticsData">
                        <div class="vx-row text-center">
                            <!-- Open Tickets Heading -->
                            <div
                                class="vx-col w-full lg:w-1/5 md:w-full sm:w-1/5 flex flex-col justify-between mb-4 lg:order-first md:order-last sm:order-first order-last"
                            >
                                <div
                                    class="lg:ml-6 lg:mt-6 md:mt-0 md:ml-0 sm:ml-6 sm:mt-6"
                                >
                                    <h1 class="font-bold text-5xl">
                                        {{
                                            supportTrackerEM.analyticsData
                                                .openTickets
                                        }}
                                    </h1>
                                    <small>Total de Tickets</small>
                                </div>
                            </div>

                            <!-- Chart -->
                            <div
                                class="vx-col w-full lg:w-4/5 md:w-full sm:w-4/5 justify-center mx-auto lg:mt-0 md:mt-6 sm:mt-0 mt-6"
                            >
                                <vue-apex-charts
                                    type="radialBar"
                                    height="385"
                                    :options="
                                        analyticsData.supportTrackerRadialBar
                                            .chartOptions
                                    "
                                    :series="supportTrackerEM.series"
                                />
                            </div>
                        </div>

                        <!-- Support Tracker Meta Data -->
                        <div
                            class="flex flex-row justify-between px-8 pb-4 mt-4"
                        >
                            <p
                                class="text-center"
                                v-for="(val, key) in supportTrackerEM
                                    .analyticsData.meta"
                                :key="key"
                            >
                                <span class="block">{{ key }}</span>
                                <span class="text-2xl font-semibold">{{
                                    val
                                }}</span>
                            </p>
                        </div>
                    </div>
                </vx-card>
            </div>
            <div class="vx-col w-1/2 mb-base">
                <vx-card title="Porcentaje Avance Tickets" :key="resetIEM">
                    <!-- CARD ACTION -->
                    <!-- <template slot="actions">
                        <change-time-duration-dropdown />
                    </template> -->

                    <!-- Chart -->
                    <div slot="no-body">
                        <vue-apex-charts
                            type="radialBar"
                            height="420"
                            :options="productOrdersRadialBarEM.chartOptions"
                            :series="productsOrderEM.series"
                        />
                    </div>

                    <ul>
                        <li
                            v-for="orderDataEM in productsOrderEM.analyticsData"
                            :key="orderDataEM.orderType"
                            class="flex mb-3 justify-between"
                        >
                            <span class="flex items-center">
                                <span
                                    class="inline-block h-4 w-4 rounded-full mr-2 bg-white border-3 border-solid"
                                    :class="`border-${orderDataEM.color}`"
                                ></span>
                                <span class="font-semibold">{{
                                    orderDataEM.orderType
                                }}</span>
                            </span>
                            <span>{{ orderDataEM.counts }}</span>
                        </li>
                    </ul>
                </vx-card>
            </div>
        </div>
        <br />
        <div class="vx-row" v-if="esJefatura">
            <!--<div class="vx-col w-full lg:w-1/4 mb-base"></div>-->
            <div class="vx-col w-1/2 mb-base">
                <vx-card title="Seguimiento Tickets Industrial" :key="resetI">
                    <!-- CARD ACTION -->
                    <!-- <template slot="actions">
                        <change-time-duration-dropdown />
                    </template> -->

                    <div slot="no-body" v-if="supportTrackerIND.analyticsData">
                        <div class="vx-row text-center">
                            <!-- Open Tickets Heading -->
                            <div
                                class="vx-col w-full lg:w-1/5 md:w-full sm:w-1/5 flex flex-col justify-between mb-4 lg:order-first md:order-last sm:order-first order-last"
                            >
                                <div
                                    class="lg:ml-6 lg:mt-6 md:mt-0 md:ml-0 sm:ml-6 sm:mt-6"
                                >
                                    <h1 class="font-bold text-5xl">
                                        {{
                                            supportTrackerIND.analyticsData
                                                .openTickets
                                        }}
                                    </h1>
                                    <small>Total de Tickets</small>
                                </div>
                            </div>

                            <!-- Chart -->
                            <div
                                class="vx-col w-full lg:w-4/5 md:w-full sm:w-4/5 justify-center mx-auto lg:mt-0 md:mt-6 sm:mt-0 mt-6"
                            >
                                <vue-apex-charts
                                    type="radialBar"
                                    height="385"
                                    :options="
                                        analyticsData.supportTrackerRadialBar
                                            .chartOptions
                                    "
                                    :series="supportTrackerIND.series"
                                />
                            </div>
                        </div>

                        <!-- Support Tracker Meta Data -->
                        <div
                            class="flex flex-row justify-between px-8 pb-4 mt-4"
                        >
                            <p
                                class="text-center"
                                v-for="(val, key) in supportTrackerIND
                                    .analyticsData.meta"
                                :key="key"
                            >
                                <span class="block">{{ key }}</span>
                                <span class="text-2xl font-semibold">{{
                                    val
                                }}</span>
                            </p>
                        </div>
                    </div>
                </vx-card>
            </div>
            <div class="vx-col w-1/2 mb-base">
                <vx-card title="Porcentaje Avance Tickets" :key="resetI">
                    <!-- CARD ACTION -->
                    <!-- <template slot="actions">
                        <change-time-duration-dropdown />
                    </template> -->

                    <!-- Chart -->
                    <div slot="no-body">
                        <vue-apex-charts
                            type="radialBar"
                            height="420"
                            :options="productOrdersRadialBarIND.chartOptions"
                            :series="productsOrderIND.series"
                        />
                    </div>

                    <ul>
                        <li
                            v-for="orderData in productsOrderIND.analyticsData"
                            :key="orderData.orderType"
                            class="flex mb-3 justify-between"
                        >
                            <span class="flex items-center">
                                <span
                                    class="inline-block h-4 w-4 rounded-full mr-2 bg-white border-3 border-solid"
                                    :class="`border-${orderData.color}`"
                                ></span>
                                <span class="font-semibold">{{
                                    orderData.orderType
                                }}</span>
                            </span>
                            <span>{{ orderData.counts }}</span>
                        </li>
                    </ul>
                </vx-card>
            </div>
        </div>
        <br />
        <div class="vx-row" v-if="esJefatura">
            <!--<div class="vx-col w-full lg:w-1/4 mb-base"></div>-->
            <div class="vx-col w-1/2 mb-base">
                <vx-card
                    title="Seguimiento Tickets Apoyo Clinico"
                    :key="resetI"
                >
                    <!-- CARD ACTION -->
                    <!-- <template slot="actions">
                        <change-time-duration-dropdown />
                    </template> -->

                    <div slot="no-body" v-if="supportTrackerAP.analyticsData">
                        <div class="vx-row text-center">
                            <!-- Open Tickets Heading -->
                            <div
                                class="vx-col w-full lg:w-1/5 md:w-full sm:w-1/5 flex flex-col justify-between mb-4 lg:order-first md:order-last sm:order-first order-last"
                            >
                                <div
                                    class="lg:ml-6 lg:mt-6 md:mt-0 md:ml-0 sm:ml-6 sm:mt-6"
                                >
                                    <h1 class="font-bold text-5xl">
                                        {{
                                            supportTrackerAP.analyticsData
                                                .openTickets
                                        }}
                                    </h1>
                                    <small>Total de Tickets</small>
                                </div>
                            </div>

                            <!-- Chart -->
                            <div
                                class="vx-col w-full lg:w-4/5 md:w-full sm:w-4/5 justify-center mx-auto lg:mt-0 md:mt-6 sm:mt-0 mt-6"
                            >
                                <vue-apex-charts
                                    type="radialBar"
                                    height="420"
                                    :options="
                                        analyticsData.supportTrackerRadialBar
                                            .chartOptions
                                    "
                                    :series="supportTrackerAP.series"
                                />
                            </div>
                        </div>

                        <!-- Support Tracker Meta Data -->
                        <div
                            class="flex flex-row justify-between px-8 pb-4 mt-4"
                        >
                            <p
                                class="text-center"
                                v-for="(val, key) in supportTrackerAP
                                    .analyticsData.meta"
                                :key="key"
                            >
                                <span class="block">{{ key }}</span>
                                <span class="text-2xl font-semibold">{{
                                    val
                                }}</span>
                            </p>
                        </div>
                    </div>
                </vx-card>
            </div>
            <div class="vx-col w-1/2 mb-base">
                <vx-card title="Porcentaje Avance Tickets" :key="resetI">
                    <!-- CARD ACTION -->
                    <!-- <template slot="actions">
                        <change-time-duration-dropdown />
                    </template> -->

                    <!-- Chart -->
                    <div slot="no-body">
                        <vue-apex-charts
                            type="radialBar"
                            height="420"
                            :options="productOrdersRadialBarAP.chartOptions"
                            :series="productsOrderAP.series"
                        />
                    </div>

                    <ul>
                        <li
                            v-for="orderData in productsOrderAP.analyticsData"
                            :key="orderData.orderType"
                            class="flex mb-3 justify-between"
                        >
                            <span class="flex items-center">
                                <span
                                    class="inline-block h-4 w-4 rounded-full mr-2 bg-white border-3 border-solid"
                                    :class="`border-${orderData.color}`"
                                ></span>
                                <span class="font-semibold">{{
                                    orderData.orderType
                                }}</span>
                            </span>
                            <span>{{ orderData.counts }}</span>
                        </li>
                    </ul>
                </vx-card>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import router from "@/router";
import VueApexCharts from "vue-apexcharts";
import StatisticsCardLine from "@/components/statistics-cards/StatisticsCardLine.vue";
import analyticsData from "../ui-elements/card/analyticsData.js";
import ChangeTimeDurationDropdown from "@/components/ChangeTimeDurationDropdown.vue";
import VxTimeline from "@/components/timeline/VxTimeline";
export default {
    components: {
        VxTimeline,
        VueApexCharts,
        StatisticsCardLine,
        ChangeTimeDurationDropdown
    },
    data() {
        return {
            localVal: process.env.MIX_APP_URL,
            resetI: 0,
            resetIEM: 0,
            resetIIND: 0,
            resetIAP: 0,
            supportTracker: {},
            supportTrackerEM: {},
            supportTrackerIND: {},
            supportTrackerAP: {},
            productsOrder: {},
            productsOrderEM: {},
            productsOrderIND: {},
            productsOrderAP: {},
            salesBarSession: {},
            analyticsData,
            timelineData: [
                {
                    color: "danger",
                    icon: "UsersIcon",
                    title: "Inicio",
                    desc:
                        "Encontrarás el acceso a la pantalla de Inicio, el menu de los supervisores y administradores y los calendarios de turnos de los ascensoristas y central telefonica"
                },
                {
                    color: "success",
                    icon: "LayoutIcon",
                    title: "Supervisores",
                    desc:
                        "En esta seccion podras ver el submenu de los tipos de trabajos que se realizan diariamente, en el cual dentro de estos menus podras encontrar el calendario de solicitudes pendientes asignadas, listado de solicitudes, generar nuevas solicitudes mas completa que los usuarios y reporte de tickets mensuales o generar todos los realizados en excel"
                },
                {
                    color: "success",
                    icon: "LayoutIcon",
                    title: "Administradores",
                    desc:
                        "En esta seccion podras agregar y modificar nuevos servicios, trabajadores, supervisores, usuarios, etc., para asi tener actualizada la informacion general de la aplicacion"
                },
                {
                    color: "primary",
                    icon: "TvIcon",
                    title: "Calendario Ascensoristas",
                    desc:
                        "En este menu podras ver el calendario de turnos de los ascensoristas, podras visualizar los turnos y asignar nuevos turnos para los siguientes meses, ademas podras asignar solicitudes especiales las cuales son: dia administrativo, vacaciones, reemplazos y turno extra"
                },
                {
                    color: "warning",
                    icon: "TvIcon",
                    title: "Calendario Central Telefonica",
                    desc:
                        "En este menu podras ver el calendario de turnos de la central telefonica, podras visualizar los turnos y asignar nuevos turnos para los siguientes meses, ademas podras asignar solicitudes especiales las cuales son: dia administrativo, vacaciones, reemplazos y turno extra"
                }
            ],
            productOrdersRadialBar: {
                chartOptions: {
                    labels: [
                        "Enviado",
                        "En Proceso",
                        "Pendiente",
                        "Finalizado",
                        "Eliminado"
                    ],
                    plotOptions: {
                        radialBar: {
                            size: 165,
                            offsetY: -5,
                            hollow: {
                                size: "20%"
                            },
                            track: {
                                background: "#ebebeb",
                                strokeWidth: "100%",
                                margin: 15
                            },
                            dataLabels: {
                                show: true,
                                name: {
                                    fontSize: "18px"
                                },
                                value: {
                                    fontSize: "16px",
                                    color: "#636a71",
                                    offsetY: 11
                                },
                                total: {
                                    show: true,
                                    label: "Total",
                                    formatter() {
                                        return 36;
                                    }
                                }
                            }
                        }
                    },
                    responsive: [
                        {
                            breakpoint: 576,
                            options: {
                                plotOptions: {
                                    radialBar: {
                                        size: 150,
                                        hollow: {
                                            size: "20%"
                                        },
                                        track: {
                                            background: "#ebebeb",
                                            strokeWidth: "100%",
                                            margin: 15
                                        }
                                    }
                                }
                            }
                        }
                    ],
                    colors: [
                        "#7961F9",
                        "#FF9F43",
                        "#EA5455",
                        "#1fcd39",
                        "#000000"
                    ],
                    fill: {
                        type: "gradient",
                        gradient: {
                            // enabled: true,
                            shade: "dark",
                            type: "vertical",
                            shadeIntensity: 0.5,
                            gradientToColors: [
                                "#9c8cfc",
                                "#FFC085",
                                "#f29292",
                                "#1fcd39",
                                "#000000"
                            ],
                            inverseColors: false,
                            opacityFrom: 1,
                            opacityTo: 1,
                            stops: [0, 100]
                        }
                    },
                    stroke: {
                        lineCap: "round"
                    },
                    chart: {
                        height: 355,
                        dropShadow: {
                            enabled: true,
                            blur: 3,
                            left: 1,
                            top: 1,
                            opacity: 0.1
                        }
                    }
                }
            },
            productOrdersRadialBarEM: {
                chartOptions: {
                    labels: [
                        "Enviado",
                        "En Proceso",
                        "Pendiente",
                        "Finalizado",
                        "Eliminado"
                    ],
                    plotOptions: {
                        radialBar: {
                            size: 165,
                            offsetY: -5,
                            hollow: {
                                size: "20%"
                            },
                            track: {
                                background: "#ebebeb",
                                strokeWidth: "100%",
                                margin: 15
                            },
                            dataLabels: {
                                show: true,
                                name: {
                                    fontSize: "18px"
                                },
                                value: {
                                    fontSize: "16px",
                                    color: "#636a71",
                                    offsetY: 11
                                },
                                total: {
                                    show: true,
                                    label: "Total",
                                    formatter() {
                                        return 36;
                                    }
                                }
                            }
                        }
                    },
                    responsive: [
                        {
                            breakpoint: 576,
                            options: {
                                plotOptions: {
                                    radialBar: {
                                        size: 150,
                                        hollow: {
                                            size: "20%"
                                        },
                                        track: {
                                            background: "#ebebeb",
                                            strokeWidth: "100%",
                                            margin: 15
                                        }
                                    }
                                }
                            }
                        }
                    ],
                    colors: [
                        "#7961F9",
                        "#FF9F43",
                        "#EA5455",
                        "#1fcd39",
                        "#000000"
                    ],
                    fill: {
                        type: "gradient",
                        gradient: {
                            // enabled: true,
                            shade: "dark",
                            type: "vertical",
                            shadeIntensity: 0.5,
                            gradientToColors: [
                                "#9c8cfc",
                                "#FFC085",
                                "#f29292",
                                "#1fcd39",
                                "#000000"
                            ],
                            inverseColors: false,
                            opacityFrom: 1,
                            opacityTo: 1,
                            stops: [0, 100]
                        }
                    },
                    stroke: {
                        lineCap: "round"
                    },
                    chart: {
                        height: 355,
                        dropShadow: {
                            enabled: true,
                            blur: 3,
                            left: 1,
                            top: 1,
                            opacity: 0.1
                        }
                    }
                }
            },
            productOrdersRadialBarIND: {
                chartOptions: {
                    labels: [
                        "Enviado",
                        "En Proceso",
                        "Pendiente",
                        "Finalizado",
                        "Eliminado"
                    ],
                    plotOptions: {
                        radialBar: {
                            size: 165,
                            offsetY: -5,
                            hollow: {
                                size: "20%"
                            },
                            track: {
                                background: "#ebebeb",
                                strokeWidth: "100%",
                                margin: 15
                            },
                            dataLabels: {
                                show: true,
                                name: {
                                    fontSize: "18px"
                                },
                                value: {
                                    fontSize: "16px",
                                    color: "#636a71",
                                    offsetY: 11
                                },
                                total: {
                                    show: true,
                                    label: "Total",
                                    formatter() {
                                        return 36;
                                    }
                                }
                            }
                        }
                    },
                    responsive: [
                        {
                            breakpoint: 576,
                            options: {
                                plotOptions: {
                                    radialBar: {
                                        size: 150,
                                        hollow: {
                                            size: "20%"
                                        },
                                        track: {
                                            background: "#ebebeb",
                                            strokeWidth: "100%",
                                            margin: 15
                                        }
                                    }
                                }
                            }
                        }
                    ],
                    colors: [
                        "#7961F9",
                        "#FF9F43",
                        "#EA5455",
                        "#1fcd39",
                        "#000000"
                    ],
                    fill: {
                        type: "gradient",
                        gradient: {
                            // enabled: true,
                            shade: "dark",
                            type: "vertical",
                            shadeIntensity: 0.5,
                            gradientToColors: [
                                "#9c8cfc",
                                "#FFC085",
                                "#f29292",
                                "#1fcd39",
                                "#000000"
                            ],
                            inverseColors: false,
                            opacityFrom: 1,
                            opacityTo: 1,
                            stops: [0, 100]
                        }
                    },
                    stroke: {
                        lineCap: "round"
                    },
                    chart: {
                        height: 355,
                        dropShadow: {
                            enabled: true,
                            blur: 3,
                            left: 1,
                            top: 1,
                            opacity: 0.1
                        }
                    }
                }
            },
            productOrdersRadialBarAP: {
                chartOptions: {
                    labels: [
                        "Enviado",
                        "En Proceso",
                        "Pendiente",
                        "Finalizado",
                        "Eliminado"
                    ],
                    plotOptions: {
                        radialBar: {
                            size: 165,
                            offsetY: -5,
                            hollow: {
                                size: "20%"
                            },
                            track: {
                                background: "#ebebeb",
                                strokeWidth: "100%",
                                margin: 15
                            },
                            dataLabels: {
                                show: true,
                                name: {
                                    fontSize: "18px"
                                },
                                value: {
                                    fontSize: "16px",
                                    color: "#636a71",
                                    offsetY: 11
                                },
                                total: {
                                    show: true,
                                    label: "Total",
                                    formatter() {
                                        return 36;
                                    }
                                }
                            }
                        }
                    },
                    responsive: [
                        {
                            breakpoint: 576,
                            options: {
                                plotOptions: {
                                    radialBar: {
                                        size: 150,
                                        hollow: {
                                            size: "20%"
                                        },
                                        track: {
                                            background: "#ebebeb",
                                            strokeWidth: "100%",
                                            margin: 15
                                        }
                                    }
                                }
                            }
                        }
                    ],
                    colors: [
                        "#7961F9",
                        "#FF9F43",
                        "#EA5455",
                        "#1fcd39",
                        "#000000"
                    ],
                    fill: {
                        type: "gradient",
                        gradient: {
                            // enabled: true,
                            shade: "dark",
                            type: "vertical",
                            shadeIntensity: 0.5,
                            gradientToColors: [
                                "#9c8cfc",
                                "#FFC085",
                                "#f29292",
                                "#1fcd39",
                                "#000000"
                            ],
                            inverseColors: false,
                            opacityFrom: 1,
                            opacityTo: 1,
                            stops: [0, 100]
                        }
                    },
                    stroke: {
                        lineCap: "round"
                    },
                    chart: {
                        height: 355,
                        dropShadow: {
                            enabled: true,
                            blur: 3,
                            left: 1,
                            top: 1,
                            opacity: 0.1
                        }
                    }
                }
            },
            esJefatura: false,
            serviciom: "",
            usuariom: "",
            categoriam: "",
            tmantencionm: "",
            subscribersGained: {},
            ordersRecevied: {},
            quarterlySales: {},
            revenueGenerated: {}
        };
    },
    methods: {
        cargaST() {
            if (sessionStorage.getItem("permiso_usuario") == 1) {
                try {
                    axios
                        .all([
                            axios.get(
                                this.localVal +
                                    "/api/Agente/TraerKPITicketsTotal",
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            ),
                            axios.get(
                                this.localVal +
                                    "/api/Agente/TraerKPITicketsTotalEM",
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            ),
                            axios.get(
                                this.localVal +
                                    "/api/Agente/TraerKPITicketsTotalIND",
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            ),
                            axios.get(
                                this.localVal +
                                    "/api/Agente/TraerKPITicketsTotalAP",
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
                            axios.spread((dat1, dat2, dat3, dat4) => {
                                let list = dat1.data;
                                let listEM = dat2.data;
                                let listIND = dat3.data;
                                let listAP = dat4.data;
                                this.esJefatura = true;
                                //Tracker Infraestructura
                                this.supportTracker = {
                                    analyticsData: {
                                        openTickets: list[0].openTickets,
                                        meta: {
                                            "Tickets Nuevos":
                                                list[0].NewTickets,
                                            "Tickets Abiertos":
                                                list[0].OpenTickets,
                                            "Tickets Finalizados":
                                                list[0].FinalTicket
                                        }
                                    },
                                    series: [parseInt(list[0].Porcentaje)]
                                };
                                //Tracker Equipos Medicos
                                this.supportTrackerEM = {
                                    analyticsData: {
                                        openTickets: listEM[0].openTickets,
                                        meta: {
                                            "Tickets Nuevos":
                                                listEM[0].NewTickets,
                                            "Tickets Abiertos":
                                                listEM[0].OpenTickets,
                                            "Tickets Finalizados":
                                                listEM[0].FinalTicket
                                        }
                                    },
                                    series: [parseInt(listEM[0].Porcentaje)]
                                };
                                //Tracker Industrial
                                this.supportTrackerIND = {
                                    analyticsData: {
                                        openTickets: listIND[0].openTickets,
                                        meta: {
                                            "Tickets Nuevos":
                                                listIND[0].NewTickets,
                                            "Tickets Abiertos":
                                                listIND[0].OpenTickets,
                                            "Tickets Finalizados":
                                                listIND[0].FinalTicket
                                        }
                                    },
                                    series: [parseInt(listIND[0].Porcentaje)]
                                };
                                //Tracker Apoyo Clinico
                                this.supportTrackerAP = {
                                    analyticsData: {
                                        openTickets: listAP[0].openTickets,
                                        meta: {
                                            "Tickets Nuevos":
                                                listAP[0].NewTickets,
                                            "Tickets Abiertos":
                                                listAP[0].OpenTickets,
                                            "Tickets Finalizados":
                                                listAP[0].FinalTicket
                                        }
                                    },
                                    series: [parseInt(listAP[0].Porcentaje)]
                                };
                            })
                        );
                } catch (error) {
                    console.log("Error al cargar datos");
                }
            } else if (sessionStorage.getItem("permiso_usuario") == 5) {
                try {
                    axios
                        .get(
                            this.localVal + "/api/Agente/TraerKPITicketsTotal",
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            //this.productsOrder = res.data;
                            let list = res.data;

                            this.supportTracker = {
                                analyticsData: {
                                    openTickets: list[0].openTickets,
                                    meta: {
                                        "Tickets Nuevos": list[0].NewTickets,
                                        "Tickets Abiertos": list[0].OpenTickets,
                                        "Tickets Finalizados":
                                            list[0].FinalTicket
                                    }
                                },
                                series: [parseInt(list[0].Porcentaje)]
                            };

                            //this.productsOrder = dat;
                            // this.resetI += 1;
                        });
                } catch (error) {
                    console.log("Error al cargar datos");
                }
            } else if (sessionStorage.getItem("permiso_usuario") == 6) {
                try {
                    axios
                        .get(
                            this.localVal +
                                "/api/Agente/TraerKPITicketsTotalEM",
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            //this.productsOrder = res.data;
                            let list = res.data;

                            this.supportTracker = {
                                analyticsData: {
                                    openTickets: list[0].openTickets,
                                    meta: {
                                        "Tickets Nuevos": list[0].NewTickets,
                                        "Tickets Abiertos": list[0].OpenTickets,
                                        "Tickets Finalizados":
                                            list[0].FinalTicket
                                    }
                                },
                                series: [parseInt(list[0].Porcentaje)]
                            };

                            //this.productsOrder = dat;
                            // this.resetI += 1;
                        });
                } catch (error) {
                    console.log("Error al cargar datos");
                }
            } else if (sessionStorage.getItem("permiso_usuario") == 7) {
                try {
                    axios
                        .get(
                            this.localVal +
                                "/api/Agente/TraerKPITicketsTotalIND",
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            //this.productsOrder = res.data;
                            let list = res.data;

                            this.supportTracker = {
                                analyticsData: {
                                    openTickets: list[0].openTickets,
                                    meta: {
                                        "Tickets Nuevos": list[0].NewTickets,
                                        "Tickets Abiertos": list[0].OpenTickets,
                                        "Tickets Finalizados":
                                            list[0].FinalTicket
                                    }
                                },
                                series: [parseInt(list[0].Porcentaje)]
                            };

                            //this.productsOrder = dat;
                            // this.resetI += 1;
                        });
                } catch (error) {
                    console.log("Error al cargar datos");
                }
            } else if (sessionStorage.getItem("permiso_usuario") == 8) {
                try {
                    axios
                        .get(
                            this.localVal +
                                "/api/Agente/TraerKPITicketsTotalAP",
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            //this.productsOrder = res.data;
                            let list = res.data;

                            this.supportTracker = {
                                analyticsData: {
                                    openTickets: list[0].openTickets,
                                    meta: {
                                        "Tickets Nuevos": list[0].NewTickets,
                                        "Tickets Abiertos": list[0].OpenTickets,
                                        "Tickets Finalizados":
                                            list[0].FinalTicket
                                    }
                                },
                                series: [parseInt(list[0].Porcentaje)]
                            };

                            //this.productsOrder = dat;
                            // this.resetI += 1;
                        });
                } catch (error) {
                    console.log("Error al cargar datos");
                }
            }
        },
        cargaSO() {
            if (sessionStorage.getItem("permiso_usuario") == 1) {
                try {
                    axios
                        .all([
                            axios.get(
                                this.localVal + "/api/Agente/TraerKPITickets",
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            ),
                            axios.get(
                                this.localVal + "/api/Agente/TraerKPITicketsEM",
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            ),
                            axios.get(
                                this.localVal +
                                    "/api/Agente/TraerKPITicketsIND",
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            ),
                            axios.get(
                                this.localVal + "/api/Agente/TraerKPITicketsAP",
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
                            axios.spread((dat1, dat2, dat3, dat4) => {
                                //this.productsOrder = res.data;
                                let list = dat1.data;
                                let list2 = dat2.data;
                                let list3 = dat3.data;
                                let list4 = dat4.data;
                                // console.log(list);
                                let b = [];
                                let c = [];
                                let d = [];
                                let f = [];
                                let obj = {};
                                let label = [];
                                let contador = 0;
                                let objData = {};
                                let codcolors = [];
                                let objcolor = {};
                                let gradcolors = [];
                                let objgragcolor = {};
                                //List Infraestructura
                                list.forEach((value, index) => {
                                    obj = {};
                                    obj = parseInt(value.porcentaje);
                                    if (value.porcentaje < 1) {
                                        if (value.porcentaje > 0) {
                                            obj = 1;
                                        }
                                    }
                                    objData = {};
                                    objData = value.orderType;
                                    label.push(objData);
                                    objcolor = {};
                                    objcolor = value.codcolor;
                                    codcolors.push(objcolor);
                                    objgragcolor = {};
                                    objgragcolor = value.codcolor;
                                    gradcolors.push(objgragcolor);
                                    contador = contador + value.counts;
                                    b.push(obj);
                                });
                                //List Equipos Medicos
                                let objEM = {};
                                let labelEM = [];
                                let contadorEM = 0;
                                let objDataEM = {};
                                let codcolorsEM = [];
                                let objcolorEM = {};
                                let gradcolorsEM = [];
                                let objgragcolorEM = {};
                                list2.forEach((value, index) => {
                                    objEM = {};
                                    objEM = parseInt(value.porcentaje);
                                    if (value.porcentaje < 1) {
                                        if (value.porcentaje > 0) {
                                            objEM = 1;
                                        }
                                    }
                                    objDataEM = {};
                                    objDataEM = value.orderType;
                                    labelEM.push(objDataEM);
                                    objcolorEM = {};
                                    objcolorEM = value.codcolor;
                                    codcolorsEM.push(objcolorEM);
                                    objgragcolorEM = {};
                                    objgragcolorEM = value.codcolor;
                                    gradcolorsEM.push(objgragcolorEM);
                                    contadorEM = contadorEM + value.counts;
                                    c.push(objEM);
                                });
                                //List Industrial
                                let objIND = {};
                                let labelIND = [];
                                let contadorIND = 0;
                                let objDataIND = {};
                                let codcolorsIND = [];
                                let objcolorIND = {};
                                let gradcolorsIND = [];
                                let objgragcolorIND = {};
                                list3.forEach((value, index) => {
                                    objIND = {};
                                    objIND = parseInt(value.porcentaje);
                                    if (value.porcentaje < 1) {
                                        if (value.porcentaje > 0) {
                                            objIND = 1;
                                        }
                                    }
                                    objDataIND = {};
                                    objDataIND = value.orderType;
                                    labelIND.push(objDataIND);
                                    objcolorIND = {};
                                    objcolorIND = value.codcolor;
                                    codcolorsIND.push(objcolorIND);
                                    objgragcolorIND = {};
                                    objgragcolorIND = value.codcolor;
                                    gradcolorsIND.push(objgragcolorIND);
                                    contadorIND = contadorIND + value.counts;
                                    d.push(objIND);
                                });
                                //List Apoyo Clinico
                                let objAP = {};
                                let labelAP = [];
                                let contadorAP = 0;
                                let objDataAP = {};
                                let codcolorsAP = [];
                                let objcolorAP = {};
                                let gradcolorsAP = [];
                                let objgragcolorAP = {};
                                list4.forEach((value, index) => {
                                    objAP = {};
                                    objAP = parseInt(value.porcentaje);
                                    if (value.porcentaje < 1) {
                                        if (value.porcentaje > 0) {
                                            objAP = 1;
                                        }
                                    }
                                    objDataAP = {};
                                    objDataAP = value.orderType;
                                    labelAP.push(objDataAP);
                                    objcolorAP = {};
                                    objcolorAP = value.codcolor;
                                    codcolorsAP.push(objcolorAP);
                                    objgragcolorAP = {};
                                    objgragcolorAP = value.codcolor;
                                    gradcolorsAP.push(objgragcolorAP);
                                    contadorAP = contadorAP + value.counts;
                                    f.push(objAP);
                                });
                                //Radial Infraestructura
                                this.productOrdersRadialBar = {
                                    chartOptions: {
                                        labels: label,
                                        plotOptions: {
                                            radialBar: {
                                                size: 165,
                                                offsetY: -5,
                                                hollow: {
                                                    size: "20%"
                                                },
                                                track: {
                                                    background: "#ebebeb",
                                                    strokeWidth: "100%",
                                                    margin: 15
                                                },
                                                dataLabels: {
                                                    show: true,
                                                    name: {
                                                        fontSize: "18px"
                                                    },
                                                    value: {
                                                        fontSize: "16px",
                                                        color: "#636a71",
                                                        offsetY: 11
                                                    },
                                                    total: {
                                                        show: true,
                                                        label: "Total",
                                                        formatter() {
                                                            return contador;
                                                        }
                                                    }
                                                }
                                            }
                                        },
                                        responsive: [
                                            {
                                                breakpoint: 576,
                                                options: {
                                                    plotOptions: {
                                                        radialBar: {
                                                            size: 150,
                                                            hollow: {
                                                                size: "20%"
                                                            },
                                                            track: {
                                                                background:
                                                                    "#ebebeb",
                                                                strokeWidth:
                                                                    "100%",
                                                                margin: 15
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        ],
                                        colors: codcolors,
                                        fill: {
                                            type: "gradient",
                                            gradient: {
                                                // enabled: true,
                                                shade: "dark",
                                                type: "vertical",
                                                shadeIntensity: 0.5,
                                                gradientToColors: gradcolors,
                                                inverseColors: false,
                                                opacityFrom: 1,
                                                opacityTo: 1,
                                                stops: [0, 100]
                                            }
                                        },
                                        stroke: {
                                            lineCap: "round"
                                        },
                                        chart: {
                                            height: 355,
                                            dropShadow: {
                                                enabled: true,
                                                blur: 3,
                                                left: 1,
                                                top: 1,
                                                opacity: 0.1
                                            }
                                        }
                                    }
                                };
                                //Radial Equipos Medicos
                                this.productOrdersRadialBarEM = {
                                    chartOptions: {
                                        labels: labelEM,
                                        plotOptions: {
                                            radialBar: {
                                                size: 165,
                                                offsetY: -5,
                                                hollow: {
                                                    size: "20%"
                                                },
                                                track: {
                                                    background: "#ebebeb",
                                                    strokeWidth: "100%",
                                                    margin: 15
                                                },
                                                dataLabels: {
                                                    show: true,
                                                    name: {
                                                        fontSize: "18px"
                                                    },
                                                    value: {
                                                        fontSize: "16px",
                                                        color: "#636a71",
                                                        offsetY: 11
                                                    },
                                                    total: {
                                                        show: true,
                                                        label: "Total",
                                                        formatter() {
                                                            return contadorEM;
                                                        }
                                                    }
                                                }
                                            }
                                        },
                                        responsive: [
                                            {
                                                breakpoint: 576,
                                                options: {
                                                    plotOptions: {
                                                        radialBar: {
                                                            size: 150,
                                                            hollow: {
                                                                size: "20%"
                                                            },
                                                            track: {
                                                                background:
                                                                    "#ebebeb",
                                                                strokeWidth:
                                                                    "100%",
                                                                margin: 15
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        ],
                                        colors: codcolorsEM,
                                        fill: {
                                            type: "gradient",
                                            gradient: {
                                                // enabled: true,
                                                shade: "dark",
                                                type: "vertical",
                                                shadeIntensity: 0.5,
                                                gradientToColors: gradcolorsEM,
                                                inverseColors: false,
                                                opacityFrom: 1,
                                                opacityTo: 1,
                                                stops: [0, 100]
                                            }
                                        },
                                        stroke: {
                                            lineCap: "round"
                                        },
                                        chart: {
                                            height: 355,
                                            dropShadow: {
                                                enabled: true,
                                                blur: 3,
                                                left: 1,
                                                top: 1,
                                                opacity: 0.1
                                            }
                                        }
                                    }
                                };
                                //Radial Industrial
                                this.productOrdersRadialBarIND = {
                                    chartOptions: {
                                        labels: labelIND,
                                        plotOptions: {
                                            radialBar: {
                                                size: 165,
                                                offsetY: -5,
                                                hollow: {
                                                    size: "20%"
                                                },
                                                track: {
                                                    background: "#ebebeb",
                                                    strokeWidth: "100%",
                                                    margin: 15
                                                },
                                                dataLabels: {
                                                    show: true,
                                                    name: {
                                                        fontSize: "18px"
                                                    },
                                                    value: {
                                                        fontSize: "16px",
                                                        color: "#636a71",
                                                        offsetY: 11
                                                    },
                                                    total: {
                                                        show: true,
                                                        label: "Total",
                                                        formatter() {
                                                            return contadorIND;
                                                        }
                                                    }
                                                }
                                            }
                                        },
                                        responsive: [
                                            {
                                                breakpoint: 576,
                                                options: {
                                                    plotOptions: {
                                                        radialBar: {
                                                            size: 150,
                                                            hollow: {
                                                                size: "20%"
                                                            },
                                                            track: {
                                                                background:
                                                                    "#ebebeb",
                                                                strokeWidth:
                                                                    "100%",
                                                                margin: 15
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        ],
                                        colors: codcolorsIND,
                                        fill: {
                                            type: "gradient",
                                            gradient: {
                                                // enabled: true,
                                                shade: "dark",
                                                type: "vertical",
                                                shadeIntensity: 0.5,
                                                gradientToColors: gradcolorsIND,
                                                inverseColors: false,
                                                opacityFrom: 1,
                                                opacityTo: 1,
                                                stops: [0, 100]
                                            }
                                        },
                                        stroke: {
                                            lineCap: "round"
                                        },
                                        chart: {
                                            height: 355,
                                            dropShadow: {
                                                enabled: true,
                                                blur: 3,
                                                left: 1,
                                                top: 1,
                                                opacity: 0.1
                                            }
                                        }
                                    }
                                };
                                //Radial Apoyo Clinico
                                this.productOrdersRadialBarAP = {
                                    chartOptions: {
                                        labels: labelAP,
                                        plotOptions: {
                                            radialBar: {
                                                size: 165,
                                                offsetY: -5,
                                                hollow: {
                                                    size: "20%"
                                                },
                                                track: {
                                                    background: "#ebebeb",
                                                    strokeWidth: "100%",
                                                    margin: 15
                                                },
                                                dataLabels: {
                                                    show: true,
                                                    name: {
                                                        fontSize: "18px"
                                                    },
                                                    value: {
                                                        fontSize: "16px",
                                                        color: "#636a71",
                                                        offsetY: 11
                                                    },
                                                    total: {
                                                        show: true,
                                                        label: "Total",
                                                        formatter() {
                                                            return contadorAP;
                                                        }
                                                    }
                                                }
                                            }
                                        },
                                        responsive: [
                                            {
                                                breakpoint: 576,
                                                options: {
                                                    plotOptions: {
                                                        radialBar: {
                                                            size: 150,
                                                            hollow: {
                                                                size: "20%"
                                                            },
                                                            track: {
                                                                background:
                                                                    "#ebebeb",
                                                                strokeWidth:
                                                                    "100%",
                                                                margin: 15
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        ],
                                        colors: codcolorsAP,
                                        fill: {
                                            type: "gradient",
                                            gradient: {
                                                // enabled: true,
                                                shade: "dark",
                                                type: "vertical",
                                                shadeIntensity: 0.5,
                                                gradientToColors: gradcolorsAP,
                                                inverseColors: false,
                                                opacityFrom: 1,
                                                opacityTo: 1,
                                                stops: [0, 100]
                                            }
                                        },
                                        stroke: {
                                            lineCap: "round"
                                        },
                                        chart: {
                                            height: 355,
                                            dropShadow: {
                                                enabled: true,
                                                blur: 3,
                                                left: 1,
                                                top: 1,
                                                opacity: 0.1
                                            }
                                        }
                                    }
                                };
                                let dat = {
                                    analyticsData: list,
                                    series: b
                                };
                                let datEM = {
                                    analyticsData: list2,
                                    series: c
                                };
                                let datIND = {
                                    analyticsData: list3,
                                    series: d
                                };
                                let datAP = {
                                    analyticsData: list4,
                                    series: f
                                };
                                this.productsOrder = dat;
                                this.productsOrderEM = datEM;
                                this.productsOrderIND = datIND;
                                this.productsOrderAP = datAP;
                                this.resetI += 1;
                                this.resetIEM += 1;
                                this.resetIIND += 1;
                                this.resetIAP += 1;
                            })
                        );
                } catch (error) {
                    console.log("Error al cargar datos");
                }
            } else if (sessionStorage.getItem("permiso_usuario") == 5) {
                try {
                    axios
                        .get(this.localVal + "/api/Agente/TraerKPITickets", {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        })
                        .then(res => {
                            //this.productsOrder = res.data;
                            let list = res.data;
                            // console.log(list);
                            let b = [];
                            let obj = {};
                            let label = [];
                            let contador = 0;
                            let objData = {};
                            let codcolors = [];
                            let objcolor = {};
                            let gradcolors = [];
                            let objgragcolor = {};
                            list.forEach((value, index) => {
                                obj = {};
                                obj = parseInt(value.porcentaje);
                                objData = {};
                                objData = value.orderType;
                                label.push(objData);
                                objcolor = {};
                                objcolor = value.codcolor;
                                codcolors.push(objcolor);
                                objgragcolor = {};
                                objgragcolor = value.codcolor;
                                gradcolors.push(objgragcolor);
                                contador = contador + value.counts;
                                b.push(obj);
                            });
                            this.productOrdersRadialBar = {
                                chartOptions: {
                                    labels: label,
                                    plotOptions: {
                                        radialBar: {
                                            size: 165,
                                            offsetY: -5,
                                            hollow: {
                                                size: "20%"
                                            },
                                            track: {
                                                background: "#ebebeb",
                                                strokeWidth: "100%",
                                                margin: 15
                                            },
                                            dataLabels: {
                                                show: true,
                                                name: {
                                                    fontSize: "18px"
                                                },
                                                value: {
                                                    fontSize: "16px",
                                                    color: "#636a71",
                                                    offsetY: 11
                                                },
                                                total: {
                                                    show: true,
                                                    label: "Total",
                                                    formatter() {
                                                        return contador;
                                                    }
                                                }
                                            }
                                        }
                                    },
                                    responsive: [
                                        {
                                            breakpoint: 576,
                                            options: {
                                                plotOptions: {
                                                    radialBar: {
                                                        size: 150,
                                                        hollow: {
                                                            size: "20%"
                                                        },
                                                        track: {
                                                            background:
                                                                "#ebebeb",
                                                            strokeWidth: "100%",
                                                            margin: 15
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    ],
                                    colors: codcolors,
                                    fill: {
                                        type: "gradient",
                                        gradient: {
                                            // enabled: true,
                                            shade: "dark",
                                            type: "vertical",
                                            shadeIntensity: 0.5,
                                            gradientToColors: gradcolors,
                                            inverseColors: false,
                                            opacityFrom: 1,
                                            opacityTo: 1,
                                            stops: [0, 100]
                                        }
                                    },
                                    stroke: {
                                        lineCap: "round"
                                    },
                                    chart: {
                                        height: 355,
                                        dropShadow: {
                                            enabled: true,
                                            blur: 3,
                                            left: 1,
                                            top: 1,
                                            opacity: 0.1
                                        }
                                    }
                                }
                            };
                            let dat = {
                                analyticsData: list,
                                series: b
                            };
                            this.productsOrder = dat;
                            this.resetI += 1;
                        });
                } catch (error) {
                    console.log("Error al cargar datos");
                }
            } else if (sessionStorage.getItem("permiso_usuario") == 6) {
                try {
                    axios
                        .get(this.localVal + "/api/Agente/TraerKPITicketsEM", {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        })
                        .then(res => {
                            //this.productsOrder = res.data;
                            let list = res.data;
                            // console.log(list);
                            let b = [];
                            let obj = {};
                            let label = [];
                            let contador = 0;
                            let objData = {};
                            let codcolors = [];
                            let objcolor = {};
                            let gradcolors = [];
                            let objgragcolor = {};
                            list.forEach((value, index) => {
                                obj = {};
                                obj = parseInt(value.porcentaje);
                                objData = {};
                                objData = value.orderType;
                                label.push(objData);
                                objcolor = {};
                                objcolor = value.codcolor;
                                codcolors.push(objcolor);
                                objgragcolor = {};
                                objgragcolor = value.codcolor;
                                gradcolors.push(objgragcolor);
                                contador = contador + value.counts;
                                b.push(obj);
                            });
                            this.productOrdersRadialBarEM = {
                                chartOptions: {
                                    labels: label,
                                    plotOptions: {
                                        radialBar: {
                                            size: 165,
                                            offsetY: -5,
                                            hollow: {
                                                size: "20%"
                                            },
                                            track: {
                                                background: "#ebebeb",
                                                strokeWidth: "100%",
                                                margin: 15
                                            },
                                            dataLabels: {
                                                show: true,
                                                name: {
                                                    fontSize: "18px"
                                                },
                                                value: {
                                                    fontSize: "16px",
                                                    color: "#636a71",
                                                    offsetY: 11
                                                },
                                                total: {
                                                    show: true,
                                                    label: "Total",
                                                    formatter() {
                                                        return contador;
                                                    }
                                                }
                                            }
                                        }
                                    },
                                    responsive: [
                                        {
                                            breakpoint: 576,
                                            options: {
                                                plotOptions: {
                                                    radialBar: {
                                                        size: 150,
                                                        hollow: {
                                                            size: "20%"
                                                        },
                                                        track: {
                                                            background:
                                                                "#ebebeb",
                                                            strokeWidth: "100%",
                                                            margin: 15
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    ],
                                    colors: codcolors,
                                    fill: {
                                        type: "gradient",
                                        gradient: {
                                            // enabled: true,
                                            shade: "dark",
                                            type: "vertical",
                                            shadeIntensity: 0.5,
                                            gradientToColors: gradcolors,
                                            inverseColors: false,
                                            opacityFrom: 1,
                                            opacityTo: 1,
                                            stops: [0, 100]
                                        }
                                    },
                                    stroke: {
                                        lineCap: "round"
                                    },
                                    chart: {
                                        height: 355,
                                        dropShadow: {
                                            enabled: true,
                                            blur: 3,
                                            left: 1,
                                            top: 1,
                                            opacity: 0.1
                                        }
                                    }
                                }
                            };
                            let dat = {
                                analyticsData: list,
                                series: b
                            };
                            this.productsOrder = dat;
                            this.resetI += 1;
                        });
                } catch (error) {
                    console.log("Error al cargar datos");
                }
            } else if (sessionStorage.getItem("permiso_usuario") == 7) {
                try {
                    axios
                        .get(this.localVal + "/api/Agente/TraerKPITicketsIND", {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        })
                        .then(res => {
                            //this.productsOrder = res.data;
                            let list = res.data;
                            // console.log(list);
                            let b = [];
                            let obj = {};
                            let label = [];
                            let contador = 0;
                            let objData = {};
                            let codcolors = [];
                            let objcolor = {};
                            let gradcolors = [];
                            let objgragcolor = {};
                            list.forEach((value, index) => {
                                obj = {};
                                obj = parseInt(value.porcentaje);
                                objData = {};
                                objData = value.orderType;
                                label.push(objData);
                                objcolor = {};
                                objcolor = value.codcolor;
                                codcolors.push(objcolor);
                                objgragcolor = {};
                                objgragcolor = value.codcolor;
                                gradcolors.push(objgragcolor);
                                contador = contador + value.counts;
                                b.push(obj);
                            });
                            this.productOrdersRadialBarIND = {
                                chartOptions: {
                                    labels: label,
                                    plotOptions: {
                                        radialBar: {
                                            size: 165,
                                            offsetY: -5,
                                            hollow: {
                                                size: "20%"
                                            },
                                            track: {
                                                background: "#ebebeb",
                                                strokeWidth: "100%",
                                                margin: 15
                                            },
                                            dataLabels: {
                                                show: true,
                                                name: {
                                                    fontSize: "18px"
                                                },
                                                value: {
                                                    fontSize: "16px",
                                                    color: "#636a71",
                                                    offsetY: 11
                                                },
                                                total: {
                                                    show: true,
                                                    label: "Total",
                                                    formatter() {
                                                        return contador;
                                                    }
                                                }
                                            }
                                        }
                                    },
                                    responsive: [
                                        {
                                            breakpoint: 576,
                                            options: {
                                                plotOptions: {
                                                    radialBar: {
                                                        size: 150,
                                                        hollow: {
                                                            size: "20%"
                                                        },
                                                        track: {
                                                            background:
                                                                "#ebebeb",
                                                            strokeWidth: "100%",
                                                            margin: 15
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    ],
                                    colors: codcolors,
                                    fill: {
                                        type: "gradient",
                                        gradient: {
                                            // enabled: true,
                                            shade: "dark",
                                            type: "vertical",
                                            shadeIntensity: 0.5,
                                            gradientToColors: gradcolors,
                                            inverseColors: false,
                                            opacityFrom: 1,
                                            opacityTo: 1,
                                            stops: [0, 100]
                                        }
                                    },
                                    stroke: {
                                        lineCap: "round"
                                    },
                                    chart: {
                                        height: 355,
                                        dropShadow: {
                                            enabled: true,
                                            blur: 3,
                                            left: 1,
                                            top: 1,
                                            opacity: 0.1
                                        }
                                    }
                                }
                            };
                            let dat = {
                                analyticsData: list,
                                series: b
                            };
                            this.productsOrder = dat;
                            this.resetI += 1;
                        });
                } catch (error) {
                    console.log("Error al cargar datos");
                }
            } else if (sessionStorage.getItem("permiso_usuario") == 8) {
                try {
                    axios
                        .get(this.localVal + "/api/Agente/TraerKPITicketsAP", {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        })
                        .then(res => {
                            //this.productsOrder = res.data;
                            let list = res.data;
                            // console.log(list);
                            let b = [];
                            let obj = {};
                            let label = [];
                            let contador = 0;
                            let objData = {};
                            let codcolors = [];
                            let objcolor = {};
                            let gradcolors = [];
                            let objgragcolor = {};
                            list.forEach((value, index) => {
                                obj = {};
                                obj = parseInt(value.porcentaje);
                                objData = {};
                                objData = value.orderType;
                                label.push(objData);
                                objcolor = {};
                                objcolor = value.codcolor;
                                codcolors.push(objcolor);
                                objgragcolor = {};
                                objgragcolor = value.codcolor;
                                gradcolors.push(objgragcolor);
                                contador = contador + value.counts;
                                b.push(obj);
                            });
                            this.productOrdersRadialBarAP = {
                                chartOptions: {
                                    labels: label,
                                    plotOptions: {
                                        radialBar: {
                                            size: 165,
                                            offsetY: -5,
                                            hollow: {
                                                size: "20%"
                                            },
                                            track: {
                                                background: "#ebebeb",
                                                strokeWidth: "100%",
                                                margin: 15
                                            },
                                            dataLabels: {
                                                show: true,
                                                name: {
                                                    fontSize: "18px"
                                                },
                                                value: {
                                                    fontSize: "16px",
                                                    color: "#636a71",
                                                    offsetY: 11
                                                },
                                                total: {
                                                    show: true,
                                                    label: "Total",
                                                    formatter() {
                                                        return contador;
                                                    }
                                                }
                                            }
                                        }
                                    },
                                    responsive: [
                                        {
                                            breakpoint: 576,
                                            options: {
                                                plotOptions: {
                                                    radialBar: {
                                                        size: 150,
                                                        hollow: {
                                                            size: "20%"
                                                        },
                                                        track: {
                                                            background:
                                                                "#ebebeb",
                                                            strokeWidth: "100%",
                                                            margin: 15
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    ],
                                    colors: codcolors,
                                    fill: {
                                        type: "gradient",
                                        gradient: {
                                            // enabled: true,
                                            shade: "dark",
                                            type: "vertical",
                                            shadeIntensity: 0.5,
                                            gradientToColors: gradcolors,
                                            inverseColors: false,
                                            opacityFrom: 1,
                                            opacityTo: 1,
                                            stops: [0, 100]
                                        }
                                    },
                                    stroke: {
                                        lineCap: "round"
                                    },
                                    chart: {
                                        height: 355,
                                        dropShadow: {
                                            enabled: true,
                                            blur: 3,
                                            left: 1,
                                            top: 1,
                                            opacity: 0.1
                                        }
                                    }
                                }
                            };
                            let dat = {
                                analyticsData: list,
                                series: b
                            };
                            this.productsOrder = dat;
                            this.resetI += 1;
                        });
                } catch (error) {
                    console.log("Error al cargar datos");
                }
            }
        },
        cargaMas() {
            if (sessionStorage.getItem("permiso_usuario") == 1) {
                try {
                    axios
                        .all([
                            axios.get(
                                this.localVal + "/api/Agente/TraerServicioKPI",
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            ),
                            axios.get(
                                this.localVal + "/api/Agente/TraerUsuarioKPI",
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            ),
                            axios.get(
                                this.localVal + "/api/Agente/TraerCategoriaKPI",
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            ),
                            axios.get(
                                this.localVal +
                                    "/api/Agente/TraerTipoMantencionKPI",
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
                            axios.spread((dat1, dat2, dat3, dat4) => {
                                this.serviciom =
                                    dat1.data[0].descripcionServicio;
                                this.usuariom = dat2.data[0].usuariosolicitante;
                                this.categoriam = dat3.data[0].des_categoria;
                                this.tmantencionm =
                                    dat4.data[0].descripcionTipoReparacion;
                            })
                        );
                } catch (error) {
                    console.log("Error de carga de datos");
                }
            } else if (sessionStorage.getItem("permiso_usuario") == 5) {
                try {
                    axios
                        .all([
                            axios.get(
                                this.localVal + "/api/Agente/TraerServicioKPI",
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            ),
                            axios.get(
                                this.localVal + "/api/Agente/TraerUsuarioKPI",
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            ),
                            axios.get(
                                this.localVal + "/api/Agente/TraerCategoriaKPI",
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            ),
                            axios.get(
                                this.localVal +
                                    "/api/Agente/TraerTipoMantencionKPI",
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
                            axios.spread((dat1, dat2, dat3, dat4) => {
                                this.serviciom =
                                    dat1.data[0].descripcionServicio;
                                this.usuariom = dat2.data[0].usuariosolicitante;
                                this.categoriam = dat3.data[0].des_categoria;
                                this.tmantencionm =
                                    dat4.data[0].descripcionTipoReparacion;
                            })
                        );
                } catch (error) {
                    console.log("Error de carga de datos");
                }
            } else if (sessionStorage.getItem("permiso_usuario") == 6) {
                try {
                    axios
                        .all([
                            axios.get(
                                this.localVal +
                                    "/api/Agente/TraerServicioKPIEM",
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            ),
                            axios.get(
                                this.localVal + "/api/Agente/TraerUsuarioKPIEM",
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            ),
                            axios.get(
                                this.localVal +
                                    "/api/Agente/TraerCategoriaKPIEM",
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            ),
                            axios.get(
                                this.localVal +
                                    "/api/Agente/TraerTipoMantencionKPIEM",
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
                            axios.spread((dat1, dat2, dat3, dat4) => {
                                this.serviciom =
                                    dat1.data[0].descripcionServicio;
                                this.usuariom = dat2.data[0].usuariosolicitante;
                                this.categoriam = dat3.data[0].des_categoria;
                                this.tmantencionm =
                                    dat4.data[0].descripcionTipoReparacion;
                            })
                        );
                } catch (error) {
                    console.log("Error de carga de datos");
                }
            } else if (sessionStorage.getItem("permiso_usuario") == 7) {
                try {
                    axios
                        .all([
                            axios.get(
                                this.localVal +
                                    "/api/Agente/TraerServicioKPIIND",
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            ),
                            axios.get(
                                this.localVal +
                                    "/api/Agente/TraerUsuarioKPIIND",
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            ),
                            axios.get(
                                this.localVal +
                                    "/api/Agente/TraerCategoriaKPIIND",
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            ),
                            axios.get(
                                this.localVal +
                                    "/api/Agente/TraerTipoMantencionKPIIND",
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
                            axios.spread((dat1, dat2, dat3, dat4) => {
                                this.serviciom =
                                    dat1.data[0].descripcionServicio;
                                this.usuariom = dat2.data[0].usuariosolicitante;
                                this.categoriam = dat3.data[0].des_categoria;
                                this.tmantencionm =
                                    dat4.data[0].descripcionTipoReparacion;
                            })
                        );
                } catch (error) {
                    console.log("Error de carga de datos");
                }
            } else if (sessionStorage.getItem("permiso_usuario") == 8) {
                try {
                    axios
                        .all([
                            axios.get(
                                this.localVal +
                                    "/api/Agente/TraerServicioKPIAP",
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            ),
                            axios.get(
                                this.localVal + "/api/Agente/TraerUsuarioKPIAP",
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            ),
                            axios.get(
                                this.localVal +
                                    "/api/Agente/TraerCategoriaKPIAP",
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            ),
                            axios.get(
                                this.localVal +
                                    "/api/Agente/TraerTipoMantencionKPIAP",
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
                            axios.spread((dat1, dat2, dat3, dat4) => {
                                this.serviciom =
                                    dat1.data[0].descripcionServicio;
                                this.usuariom = dat2.data[0].usuariosolicitante;
                                this.categoriam = dat3.data[0].des_categoria;
                                this.tmantencionm =
                                    dat4.data[0].descripcionTipoReparacion;
                            })
                        );
                } catch (error) {
                    console.log("Error de carga de datos");
                }
            }
        }
    },
    created() {
        this.cargaST();
        this.cargaSO();
        this.cargaMas();
    }
};
</script>
<style lang="scss">
@import "@sass/vuexy/components/vxTimeline.scss";
/*! rtl:begin:ignore */
#dashboard-analytics {
    .greet-user {
        position: relative;

        .decore-left {
            position: absolute;
            left: 0;
            top: 0;
        }
        .decore-right {
            position: absolute;
            right: 0;
            top: 0;
        }
    }

    @media (max-width: 576px) {
        .decore-left,
        .decore-right {
            width: 140px;
        }
    }
}
/*! rtl:end:ignore */
</style>
