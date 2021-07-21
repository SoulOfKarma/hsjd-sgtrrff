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
            <div class="vx-col w-full mb-base">
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
            <div class="vx-col w-full mb-base">
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
            try {
                axios
                    .get(this.localVal + "/api/Agente/TraerKPITicketsTotal", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        //this.productsOrder = res.data;
                        let list = res.data;

                        this.supportTracker = {
                            analyticsData: {
                                openTickets: list[0].openTickets,
                                meta: {
                                    "Tickets Nuevos": list[0].NewTickets,
                                    "Tickets Abiertos": list[0].OpenTickets,
                                    "Tickets Finalizados": list[0].FinalTicket
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
        },
        cargaSO() {
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
                                                        background: "#ebebeb",
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
        },
        cargaMas() {
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
                            this.serviciom = dat1.data[0].descripcionServicio;
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
