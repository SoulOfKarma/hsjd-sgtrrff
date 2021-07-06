<template>
    <div>
        <div class="vx-row">
            <div
                class="router-header flex flex-wrap items-center mb-6"
                style="margin-left:10px;"
            ></div>
        </div>
        <div class="vx-row">
            <div class="vx-col w-full lg:w-1/4 mb-base"></div>
            <div class="vx-col w-full lg:w-1/2 mb-base">
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
            <div class="vx-col w-full lg:w-1/4 mb-base"></div>
        </div>

        <div class="vx-row">
            <div class="vx-col w-full lg:w-1/4 mb-base"></div>
            <div class="vx-col w-full lg:w-1/2 mb-base">
                <div class="vx-col w-full lg:w-full mb-base">
                    <vx-card title="Informacion del Perfil">
                        <vx-timeline :data="timelineData" />
                    </vx-card>
                </div>
            </div>
            <div class="vx-col w-full lg:w-1/4 mb-base"></div>
        </div>
        <div class="vx-row">
            <div class="vx-col w-full">
                <vx-card>
                    <div
                        class="vx-row flex-col-reverse md:flex-col-reverse sm:flex-row lg:flex-row"
                    >
                        <!-- LEFT COL -->
                        <div
                            class="vx-col w-full md:w-full sm:w-1/2 lg:w-1/2 xl:w-1/2 flex flex-col justify-between"
                            v-if="salesBarSession.analyticsData"
                        >
                            <div>
                                <h2 class="mb-1 font-bold">
                                    {{
                                        salesBarSession.analyticsData.session
                                            | k_formatter
                                    }}
                                </h2>
                                <span class="font-medium">Avg Sessions</span>

                                <!-- Previous Data Comparison -->
                                <p class="mt-2 text-xl font-medium">
                                    <span
                                        :class="
                                            salesBarSession.analyticsData
                                                .comparison.result >= 0
                                                ? 'text-success'
                                                : 'text-danger'
                                        "
                                    >
                                        <span
                                            v-if="
                                                salesBarSession.analyticsData
                                                    .comparison.result > 0
                                            "
                                            >+</span
                                        >
                                        <span>{{
                                            salesBarSession.analyticsData
                                                .comparison.result
                                        }}</span>
                                    </span>
                                    <span> vs </span>
                                    <span>{{
                                        salesBarSession.analyticsData.comparison
                                            .str
                                    }}</span>
                                </p>
                            </div>
                            <vs-button
                                icon-pack="feather"
                                icon="icon-chevrons-right"
                                icon-after
                                class="shadow-md w-full lg:mt-0 mt-4"
                                >View Details</vs-button
                            >
                        </div>

                        <!-- RIGHT COL -->
                        <div
                            class="vx-col w-full md:w-full sm:w-1/2 lg:w-1/2 xl:w-1/2 flex flex-col lg:mb-0 md:mb-base sm:mb-0 mb-base"
                        >
                            <change-time-duration-dropdown class="self-end" />
                            <vue-apex-charts
                                type="bar"
                                height="200"
                                :options="analyticsData.salesBar.chartOptions"
                                :series="salesBarSession.series"
                                v-if="salesBarSession.series"
                            />
                        </div>
                    </div>
                    <vs-divider class="my-6"></vs-divider>
                    <div class="vx-row">
                        <div class="vx-col w-1/2 mb-3">
                            <p>Goal: $100000</p>
                            <vs-progress
                                class="block mt-1"
                                :percent="50"
                                color="primary"
                            ></vs-progress>
                        </div>
                        <div class="vx-col w-1/2 mb-3">
                            <p>Users: 100K</p>
                            <vs-progress
                                class="block mt-1"
                                :percent="60"
                                color="warning"
                            ></vs-progress>
                        </div>
                        <div class="vx-col w-1/2 mb-3">
                            <p>Retention: 90%</p>
                            <vs-progress
                                class="block mt-1"
                                :percent="70"
                                color="danger"
                            ></vs-progress>
                        </div>
                        <div class="vx-col w-1/2 mb-3">
                            <p>Duration: 1yr</p>
                            <vs-progress
                                class="block mt-1"
                                :percent="90"
                                color="success"
                            ></vs-progress>
                        </div>
                    </div>
                </vx-card>
            </div>
        </div>
        <div class="vx-row">
            <!--<div class="vx-col w-full lg:w-1/4 mb-base"></div>-->
            <div class="vx-col w-1/2 mb-base">
                <vx-card title="Support Tracker">
                    <!-- CARD ACTION -->
                    <template slot="actions">
                        <change-time-duration-dropdown />
                    </template>

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
                                    <small>Tickets</small>
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
                <vx-card title="Product Orders">
                    <!-- CARD ACTION -->
                    <template slot="actions">
                        <change-time-duration-dropdown />
                    </template>

                    <!-- Chart -->
                    <div slot="no-body">
                        <vue-apex-charts
                            type="radialBar"
                            height="420"
                            :options="
                                analyticsData.productOrdersRadialBar
                                    .chartOptions
                            "
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
            supportTracker: {},
            productsOrder: {},
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
            ]
        };
    },
    methods: {
        cargaST() {
            this.supportTracker = {
                analyticsData: {
                    openTickets: 163,
                    meta: {
                        "New Tickets": 29,
                        "Open Tickets": 63,
                        "Response Time": "1d"
                    }
                },
                series: [83]
            };
        },
        cargaSO() {
            this.productsOrder = {
                analyticsData: [
                    {
                        orderType: "Finished",
                        counts: 23043,
                        color: "primary"
                    },
                    {
                        orderType: "Pending",
                        counts: 14658,
                        color: "warning"
                    },
                    {
                        orderType: "Rejected ",
                        counts: 4758,
                        color: "danger"
                    }
                ],
                series: [70, 52, 26]
            };
        }
    },
    created() {
        this.cargaST();
        this.cargaSO();
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
