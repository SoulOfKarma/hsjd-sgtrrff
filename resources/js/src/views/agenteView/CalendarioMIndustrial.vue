<template>
    <div>
        <vx-card>
            <vs-alert active="true" color="success">
                Agente:
                {{ nombre }} - {{ run }}
            </vs-alert>
        </vx-card>
        <br />
        <vx-card :title="nombreTitulo">
            <div class="vx-row" alignment="center">
                <div class="vx-col w-1/2">
                    <vs-button
                        color="primary"
                        type="filled"
                        class="w-full m-2"
                        @click="PopFormularioMantencion()"
                        >Nuevo Calendario Mantencion</vs-button
                    >
                </div>
                <div class="vx-col w-1/2">
                    <vs-button
                        color="primary"
                        type="filled"
                        class="w-full m-2"
                        @click="PopCalAnio()"
                        >Nuevo Año</vs-button
                    >
                </div>
            </div>
            <div class="vx-row" alignment="center">
                <div class="vx-col w-full">
                    <br />
                    <h6>Seleccione Año</h6>
                    <v-select
                        v-model="seleccionFechaMantencion"
                        placeholder="Seleccione Año"
                        class="w-full select-large"
                        label="anio"
                        :options="listadoAnios"
                        @input="cargarListadoPorAnio()"
                    ></v-select>
                    <br />
                </div>
            </div>
            <br />
            <vue-good-table
                :columns="columns"
                :rows="mantenciones"
                @on-cell-click="RowMantencion"
                :pagination-options="{
                    enabled: true,
                    perPage: 10
                }"
            >
                <template slot="table-row" slot-scope="props">
                    <!-- Column: Name -->
                    <span
                        v-if="props.column.field === 'fullName'"
                        class="text-nowrap"
                    >
                    </span>

                    <!-- Column: Action -->

                    <!-- Column: Common -->
                    <span v-else>
                        {{ props.formattedRow[props.column.field] }}
                    </span>
                </template></vue-good-table
            >
        </vx-card>

        <!-- KPI Industrial -->
        <div class="vx-col w-full mb-base">
            <vx-card
                title="Porcentaje Avance Mantenciones por Equipo"
                :key="resetI"
            >
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
        <vs-popup
            classContent="popup-example"
            title="Ingresar Datos Tabla Mantencion Industrial"
            :active.sync="popFormMantencionInd"
        >
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row">
                    <div class="vx-col w-1/2">
                        <h6>Seleccione el Edificio</h6>
                        <v-select
                            v-model="seleccionEdificio"
                            placeholder="Edificio"
                            class="w-full select-large"
                            label="descripcionEdificio"
                            :options="listadoEdificios"
                        ></v-select>
                    </div>
                    <div class="vx-col w-1/2 mb-base">
                        <h6>Equipo</h6>
                        <vs-input
                            v-model="descripcion_mantencion"
                            class="w-full"
                        />
                    </div>
                    <div class="vx-col w-1/2 mb-base">
                        <h6>Codigo Enero</h6>
                        <vs-input
                            v-model="codManEne"
                            class="w-full"
                            type="number"
                        />
                    </div>
                    <div class="vx-col w-1/2 mb-base">
                        <h6>Codigo Febrero</h6>
                        <vs-input
                            v-model="codManFeb"
                            class="w-full"
                            type="number"
                        />
                    </div>
                    <div class="vx-col w-1/2 mb-base">
                        <h6>Codigo Marzo</h6>
                        <vs-input
                            v-model="codManMar"
                            class="w-full"
                            type="number"
                        />
                    </div>
                    <div class="vx-col w-1/2 mb-base">
                        <h6>Codigo Abril</h6>
                        <vs-input
                            v-model="codManAbr"
                            class="w-full"
                            type="number"
                        />
                    </div>
                    <div class="vx-col w-1/2 mb-base">
                        <h6>Codigo Mayo</h6>
                        <vs-input
                            v-model="codManMay"
                            class="w-full"
                            type="number"
                        />
                    </div>
                    <div class="vx-col w-1/2 mb-base">
                        <h6>Codigo Junio</h6>
                        <vs-input
                            v-model="codManJun"
                            class="w-full"
                            type="number"
                        />
                    </div>
                    <div class="vx-col w-1/2 mb-base">
                        <h6>Codigo Julio</h6>
                        <vs-input
                            v-model="codManJul"
                            class="w-full"
                            type="number"
                        />
                    </div>
                    <div class="vx-col w-1/2 mb-base">
                        <h6>Codigo Agosto</h6>
                        <vs-input
                            v-model="codManAgo"
                            class="w-full"
                            type="number"
                        />
                    </div>
                    <div class="vx-col w-1/2 mb-base">
                        <h6>Codigo Septiembre</h6>
                        <vs-input
                            v-model="codManSep"
                            class="w-full"
                            type="number"
                        />
                    </div>
                    <div class="vx-col w-1/2 mb-base">
                        <h6>Codigo Octubre</h6>
                        <vs-input
                            v-model="codManOct"
                            class="w-full"
                            type="number"
                        />
                    </div>
                    <div class="vx-col w-1/2 mb-base">
                        <h6>Codigo Noviembre</h6>
                        <vs-input
                            v-model="codManNov"
                            class="w-full"
                            type="number"
                        />
                    </div>
                    <div class="vx-col w-1/2 mb-base">
                        <h6>Codigo Diciembre</h6>
                        <vs-input
                            v-model="codManDic"
                            class="w-full"
                            type="number"
                        />
                    </div>
                    <div class="vx-col w-1/2 mb-base">
                        <h6>Frecuencia</h6>
                        <vs-input v-model="desFrecuencia" class="w-full" />
                    </div>
                    <div class="vx-col w-1/2">
                        <h6>Año</h6>
                        <v-select
                            v-model="seleccionAnio"
                            placeholder="año"
                            class="w-full select-large"
                            label="anio"
                            :options="listadoAnios"
                        ></v-select>
                    </div>
                    <div class="vx-col w-1/2">
                        <h6>Tipo Mantencion</h6>
                        <v-select
                            v-model="seleccionTMantencion"
                            placeholder="Correctiva"
                            class="w-full select-large"
                            label="descripcionTMantencion"
                            :options="listadoTMantencion"
                        ></v-select>
                        <br />
                    </div>
                    <div class="vx-col w-1/2">
                        <h6>Estado Mantencion</h6>
                        <v-select
                            v-model="seleccionEstadoMIndustrial"
                            placeholder="No Asignado"
                            class="w-full select-large"
                            label="descripcion_estadoI"
                            :options="listadoEstadoMIndustrial"
                        ></v-select>
                        <br />
                    </div>

                    <div class="vx-col w-1/2">
                        <vs-button
                            color="warning"
                            type="filled"
                            class="w-full m-2"
                            @click="PostMantencion()"
                            >Guardar</vs-button
                        >
                    </div>
                    <div class="vx-col w-1/2">
                        <vs-button
                            class="w-full m-2"
                            @click="popFormMantencionInd = false"
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
            title="Ingresar Datos Tabla Mantencion Industrial"
            :active.sync="popFormCalAnio"
        >
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row">
                    <div class="vx-col w-full mb-base">
                        <h6>Ingrese Año</h6>
                        <vs-input v-model="anio" class="w-full" type="number" />
                    </div>

                    <div class="vx-col w-1/2">
                        <vs-button
                            color="warning"
                            type="filled"
                            class="w-full m-2"
                            @click="guardarAnio()"
                            >Guardar</vs-button
                        >
                    </div>
                    <div class="vx-col w-1/2">
                        <vs-button
                            class="w-full m-2"
                            @click="popFormCalAnio = false"
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
            :title="descripcionDoc"
            :active.sync="popFormDoc"
        >
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row">
                    <div class="vx-col w-1/2">
                        <h6>Estado Mantencion</h6>
                        <v-select
                            v-model="seleccionEstadoMIndustrial"
                            placeholder="No Asignado"
                            class="w-full select-large"
                            label="descripcion_estadoI"
                            :options="listadoEstadoMIndustrial"
                        ></v-select>
                        <br />
                    </div>
                    <div class="vx-col w-1/2">
                        <h6>Estado Mantencion</h6>
                        <vs-button
                            color="warning"
                            type="filled"
                            class="w-full select-large"
                            @click="guardarEstadoM()"
                            >Guardar Estado</vs-button
                        >
                    </div>
                    <div class="vx-col w-full mt-5">
                        <vs-input
                            type="file"
                            @change="getImage"
                            class="form-control w-full"
                        />
                    </div>
                    <vue-good-table
                        class="w-full m-2"
                        :columns="columnasDoc"
                        :rows="Documentos"
                        :pagination-options="{
                            enabled: true,
                            perPage: 10
                        }"
                    >
                        <template slot="table-row" slot-scope="props">
                            <!-- Column: Name -->
                            <span
                                v-if="props.column.field === 'fullName'"
                                class="text-nowrap"
                            >
                            </span>

                            <!-- Column: Action -->
                            <span v-else-if="props.column.field === 'action'">
                                <plus-circle-icon
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        abrirDocumento(
                                            props.row.nombreDocumento
                                        )
                                    "
                                ></plus-circle-icon>
                            </span>
                            <!-- Column: Common -->
                            <span v-else>
                                {{ props.formattedRow[props.column.field] }}
                            </span>
                        </template></vue-good-table
                    >
                    <div class="vx-col w-full">
                        <vs-button
                            color="danger"
                            type="filled"
                            class="w-full m-2"
                            @click="uploadImage"
                            >Guardar Documento</vs-button
                        >

                        <vs-button
                            class="w-full m-2"
                            @click="popFormDoc = false"
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
            title="Ingresar Datos Tabla Mantencion Industrial"
            :active.sync="popFormAgregarSCod"
        >
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row">
                    <div class="vx-col w-full">
                        <h6>Ingrese N° Mantencion</h6>
                        <vs-input
                            v-model="codMantencionNuevo"
                            class="w-full"
                            type="number"
                        />
                    </div>
                    <div class="vx-col w-1/2">
                        <vs-button
                            color="warning"
                            type="filled"
                            class="w-full m-2"
                            @click="guardarCodMantencionN()"
                            >Guardar</vs-button
                        >
                    </div>
                    <div class="vx-col w-1/2">
                        <vs-button
                            class="w-full m-2"
                            @click="popFormAgregarSCod = false"
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
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import moment from "moment";
import router from "@/router";
import axios from "axios";
import Vue from "vue";
import "vue-good-table/dist/vue-good-table.css";
import { PlusCircleIcon } from "vue-feather-icons";
import VueGoodTablePlugin from "vue-good-table";
import VueApexCharts from "vue-apexcharts";
import StatisticsCardLine from "@/components/statistics-cards/StatisticsCardLine.vue";
import analyticsData from "../ui-elements/card/analyticsData.js";
import ChangeTimeDurationDropdown from "@/components/ChangeTimeDurationDropdown.vue";
import VxTimeline from "@/components/timeline/VxTimeline";
Vue.use(VueGoodTablePlugin);
import vSelect from "vue-select";
export default {
    components: {
        flatPickr,
        "v-select": vSelect,
        PlusCircleIcon,
        VxTimeline,
        VueApexCharts,
        StatisticsCardLine,
        ChangeTimeDurationDropdown
    },
    data() {
        return {
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
            nombre:
                sessionStorage.getItem("nombre") +
                " " +
                sessionStorage.getItem("apellido"),
            run: sessionStorage.getItem("run"),
            columnasDoc: [
                {
                    label: "ID",
                    field: "id",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Documento",
                    field: "descripcionDocumento",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Opciones",
                    field: "action"
                }
            ],
            Documentos: [],
            mantenciones: [],
            columns: [],
            seleccionFechaMantencion: {
                id: 0,
                anio: 0
            },
            seleccionAnio: {
                id: 1,
                anio: 2021
            },
            seleccionTMantencion: {
                id: 1,
                descripcionTMantencion: "Correctiva"
            },
            nombreTitulo: "",
            popFormMantencionInd: false,
            popFormCalAnio: false,
            descripcion_mantencion: "",
            listadoEdificios: [],
            listadoAnios: [],
            listadoTMantencion: [],
            listadoEstadoMIndustrial: [],
            seleccionEdificio: {
                id: 0,
                descripcionEdificio: "Seleccione Edificio"
            },
            seleccionEstadoMIndustrial: {
                id: 0,
                descripcion_estadoI: "Seleccione Estado Mantencion"
            },
            codManEne: 0,
            codManFeb: 0,
            codManMar: 0,
            codManAbr: 0,
            codManMay: 0,
            codManJun: 0,
            codManJul: 0,
            codManAgo: 0,
            codManSep: 0,
            codManOct: 0,
            codManNov: 0,
            codManDic: 0,
            anio: 0,
            desFrecuencia: "",
            descripcionDoc: "",
            codMantencionNuevo: 0,
            codMan: "",
            idRowModificar: 0,
            popFormDoc: false,
            popFormAgregarSCod: false,
            image: "",
            desDoc: "",
            idParam: 0,
            resetI: 0,
            supportTracker: {},
            productsOrder: {},
            salesBarSession: {},
            analyticsData,
            productOrdersRadialBar: {
                chartOptions: {
                    labels: [
                        "No Asignado",
                        "En Proceso",
                        "Pendiente",
                        "Realizado"
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
                    colors: ["#7961F9", "#FF9F43", "#EA5455", "#1fcd39"],
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
                                "#1fcd39"
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
            localVal: process.env.MIX_APP_URL,
            urlDocumentos: process.env.MIX_APP_URL_DOCUMENTOS
        };
    },
    methods: {
        RowMantencion(params) {
            try {
                if (params.column.field == "codManEne") {
                    if (params.row.codManEne == 0) {
                        this.idRowModificar = params.row.id;
                        this.codMan = "codManEne";
                        this.popFormAgregarSCod = true;
                    } else {
                        this.descripcionDoc =
                            "Datos Documentacion N°" + params.row.codManEne;
                        this.popFormDoc = true;
                        this.idRowModificar = params.row.id;
                        this.codMan = "codManEne";
                        this.idParam = params.row.codManEne;
                        let obj = { id: params.row.codManEne };
                        axios
                            .post(
                                this.localVal + "/api/Agente/GetDocumentosMIND",
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
                                this.Documentos = res.data;
                            });
                    }
                } else if (params.column.field == "codManFeb") {
                    if (params.row.codManFeb == 0) {
                        this.idRowModificar = params.row.id;
                        this.codMan = "codManFeb";
                        this.popFormAgregarSCod = true;
                    } else {
                        this.descripcionDoc =
                            "Datos Documentacion N°" + params.row.codManFeb;
                        this.popFormDoc = true;
                        this.idRowModificar = params.row.id;
                        this.codMan = "codManFeb";
                        this.idParam = params.row.codManFeb;
                        let obj = { id: params.row.codManFeb };
                        axios
                            .post(
                                this.localVal + "/api/Agente/GetDocumentosMIND",
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
                                this.Documentos = res.data;
                            });
                    }
                } else if (params.column.field == "codManMar") {
                    if (params.row.codManMar == 0) {
                        this.idRowModificar = params.row.id;
                        this.codMan = "codManMar";
                        this.popFormAgregarSCod = true;
                    } else {
                        this.descripcionDoc =
                            "Datos Documentacion N°" + params.row.codManMar;
                        this.popFormDoc = true;
                        this.idRowModificar = params.row.id;
                        this.codMan = "codManMar";
                        this.idParam = params.row.codManMar;
                        let obj = { id: params.row.codManMar };
                        axios
                            .post(
                                this.localVal + "/api/Agente/GetDocumentosMIND",
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
                                this.Documentos = res.data;
                            });
                    }
                } else if (params.column.field == "codManAbr") {
                    if (params.row.codManAbr == 0) {
                        this.idRowModificar = params.row.id;
                        this.codMan = "codManAbr";
                        this.popFormAgregarSCod = true;
                    } else {
                        this.descripcionDoc =
                            "Datos Documentacion N°" + params.row.codManAbr;
                        this.popFormDoc = true;
                        this.idRowModificar = params.row.id;
                        this.codMan = "codManAbr";
                        this.idParam = params.row.codManAbr;
                        let obj = { id: params.row.codManAbr };
                        axios
                            .post(
                                this.localVal + "/api/Agente/GetDocumentosMIND",
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
                                this.Documentos = res.data;
                            });
                    }
                } else if (params.column.field == "codManMay") {
                    if (params.row.codManMay == 0) {
                        this.idRowModificar = params.row.id;
                        this.codMan = "codManMay";
                        this.popFormAgregarSCod = true;
                    } else {
                        this.descripcionDoc =
                            "Datos Documentacion N°" + params.row.codManMay;
                        this.popFormDoc = true;
                        this.idRowModificar = params.row.id;
                        this.codMan = "codManMay";
                        this.idParam = params.row.codManMay;
                        let obj = { id: params.row.codManMay };
                        axios
                            .post(
                                this.localVal + "/api/Agente/GetDocumentosMIND",
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
                                this.Documentos = res.data;
                            });
                    }
                } else if (params.column.field == "codManJun") {
                    if (params.row.codManJun == 0) {
                        this.idRowModificar = params.row.id;
                        this.codMan = "codManJun";
                        this.popFormAgregarSCod = true;
                    } else {
                        this.descripcionDoc =
                            "Datos Documentacion N°" + params.row.codManJun;
                        this.popFormDoc = true;
                        this.idRowModificar = params.row.id;
                        this.codMan = "codManJun";
                        this.idParam = params.row.codManJun;
                        let obj = { id: params.row.codManJun };
                        axios
                            .post(
                                this.localVal + "/api/Agente/GetDocumentosMIND",
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
                                this.Documentos = res.data;
                            });
                    }
                } else if (params.column.field == "codManJul") {
                    if (params.row.codManJul == 0) {
                        this.idRowModificar = params.row.id;
                        this.codMan = "codManJul";
                        this.popFormAgregarSCod = true;
                    } else {
                        this.descripcionDoc =
                            "Datos Documentacion N°" + params.row.codManJul;
                        this.popFormDoc = true;
                        this.idRowModificar = params.row.id;
                        this.codMan = "codManJul";
                        this.idParam = params.row.codManJul;
                        let obj = { id: params.row.codManJul };
                        axios
                            .post(
                                this.localVal + "/api/Agente/GetDocumentosMIND",
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
                                this.Documentos = res.data;
                            });
                    }
                } else if (params.column.field == "codManAgo") {
                    if (params.row.codManAgo == 0) {
                        this.idRowModificar = params.row.id;
                        this.codMan = "codManAgo";
                        this.popFormAgregarSCod = true;
                    } else {
                        this.descripcionDoc =
                            "Datos Documentacion N°" + params.row.codManAgo;
                        this.popFormDoc = true;
                        this.idRowModificar = params.row.id;
                        this.codMan = "codManAgo";
                        this.idParam = params.row.codManAgo;
                        let obj = { id: params.row.codManAgo };
                        axios
                            .post(
                                this.localVal + "/api/Agente/GetDocumentosMIND",
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
                                this.Documentos = res.data;
                            });
                    }
                } else if (params.column.field == "codManSep") {
                    if (params.row.codManSep == 0) {
                        this.idRowModificar = params.row.id;
                        this.codMan = "codManSep";
                        this.popFormAgregarSCod = true;
                    } else {
                        this.descripcionDoc =
                            "Datos Documentacion N°" + params.row.codManSep;
                        this.popFormDoc = true;
                        this.idRowModificar = params.row.id;
                        this.codMan = "codManSep";
                        this.idParam = params.row.codManSep;
                        let obj = { id: params.row.codManSep };
                        axios
                            .post(
                                this.localVal + "/api/Agente/GetDocumentosMIND",
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
                                this.Documentos = res.data;
                            });
                    }
                } else if (params.column.field == "codManOct") {
                    if (params.row.codManOct == 0) {
                        this.idRowModificar = params.row.id;
                        this.codMan = "codManOct";
                        this.popFormAgregarSCod = true;
                    } else {
                        this.descripcionDoc =
                            "Datos Documentacion N°" + params.row.codManOct;
                        this.popFormDoc = true;
                        this.idRowModificar = params.row.id;
                        this.codMan = "codManOct";
                        this.idParam = params.row.codManOct;
                        let obj = { id: params.row.codManOct };
                        axios
                            .post(
                                this.localVal + "/api/Agente/GetDocumentosMIND",
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
                                this.Documentos = res.data;
                            });
                    }
                } else if (params.column.field == "codManNov") {
                    if (params.row.codManNov == 0) {
                        this.idRowModificar = params.row.id;
                        this.codMan = "codManNov";
                        this.popFormAgregarSCod = true;
                    } else {
                        this.descripcionDoc =
                            "Datos Documentacion N°" + params.row.codManNov;
                        this.popFormDoc = true;
                        this.idRowModificar = params.row.id;
                        this.codMan = "codManNov";
                        this.idParam = params.row.codManNov;
                        let obj = { id: params.row.codManNov };
                        axios
                            .post(
                                this.localVal + "/api/Agente/GetDocumentosMIND",
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
                                this.Documentos = res.data;
                            });
                    }
                } else if (params.column.field == "codManDic") {
                    if (params.row.codManDic == 0) {
                        this.idRowModificar = params.row.id;
                        this.codMan = "codManDic";
                        this.popFormAgregarSCod = true;
                    } else {
                        this.descripcionDoc =
                            "Datos Documentacion N°" + params.row.codManDic;
                        this.popFormDoc = true;
                        this.idRowModificar = params.row.id;
                        this.codMan = "codManDic";
                        this.idParam = params.row.codManDic;
                        let obj = { id: params.row.codManDic };
                        axios
                            .post(
                                this.localVal + "/api/Agente/GetDocumentosMIND",
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
                                this.Documentos = res.data;
                            });
                    }
                }
            } catch (error) {
                console.log(error);
            }
        },
        guardarEstadoM() {
            try {
                let obj = {
                    id: this.idRowModificar,
                    codMan: this.codMan,
                    CodMantencionN: this.idParam,
                    idEstado: this.seleccionEstadoMIndustrial.id
                };
                console.log(obj);
                axios
                    .post(this.localVal + "/api/Agente/PostEstadoM", obj, {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        let dato = res.data;
                        console.log(dato);
                    });
            } catch (error) {
                console.log(error);
            }
        },
        guardarCodMantencionN() {
            try {
                let obj = {
                    id: this.idRowModificar,
                    codMan: this.codMan,
                    codMantencionNuevo: this.codMantencionNuevo
                };

                axios
                    .post(this.localVal + "/api/Agente/PutCodMantencion", obj, {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        let response = res.data;
                        if (response == true) {
                            this.$vs.notify({
                                title: "Correcto",
                                text: "N° guardado correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.popFormAgregarSCod = false;
                            this.codMantencionNuevo = 0;
                            this.cargarListadoPorAnio();
                        } else {
                            this.$vs.notify({
                                title: "Error al guardar N° ",
                                text:
                                    "Verifique los datos y intente nuevamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        abrirDocumento(link) {
            try {
                const url = this.urlDocumentos + link;
                window.open(url, "_blank");
            } catch (error) {
                console.log(error);
            }
        },
        getImage(event) {
            //Asignamos la imagen a  nuestra data
            this.image = event.target.files[0];
            this.desDoc = this.image.name;
        },
        uploadImage() {
            //Creamos el formData
            var data = new FormData();
            //Añadimos la imagen seleccionada
            data.append("avatar", this.image);
            data.append("id", this.idParam);
            data.append("nombreDoc", this.desDoc);
            axios
                .post(this.localVal + "/api/Agente/PostDocumentoF", data, {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(response => {
                    let resp = response.data;
                    if (resp == true) {
                        this.$vs.notify({
                            title: "Documento Guardado ",
                            text:
                                "Podra Visualizarlo en el menu del costado para descargarlo o visualizarlo en el navegador ",
                            color: "success",
                            position: "top-right"
                        });
                        this.popGuardarDoc = false;
                        this.recargaDocumentacion();
                    } else {
                        this.$vs.notify({
                            title: "Error al subir el documento ",
                            text:
                                "Intente nuevamente con el formato PDF o alguna Imagen ",
                            color: "danger",
                            position: "top-right"
                        });
                    }
                });
        },
        recargaDocumentacion() {
            try {
                let obj = { id: this.idParam };
                axios
                    .post(
                        this.localVal + "/api/Agente/GetDocumentosMIND",
                        obj,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.Documentos = res.data;
                    });
            } catch (error) {
                console.log(error);
            }
        },
        cargaColumnas() {
            try {
                this.nombreTitulo =
                    "PROGRAMACIÓN MANTENCIÓN GRUPO ELECTRÓGENO HOSPITAL, CDT Y CHACABUCO 430  HSJD" +
                    " " +
                    this.seleccionFechaMantencion.anio;
                this.columns = [
                    {
                        label: "Edificio",
                        field: "descripcionEdificio",
                        filterOptions: {
                            enabled: true
                        }
                    },
                    {
                        label: "Equipo",
                        field: "descripcion_mantencion",
                        filterOptions: {
                            enabled: true
                        }
                    },
                    {
                        label:
                            "Ene." + " " + this.seleccionFechaMantencion.anio,
                        field: "codManEne",
                        filterOptions: {
                            enabled: true
                        }
                    },
                    {
                        label:
                            "Feb." + " " + this.seleccionFechaMantencion.anio,
                        field: "codManFeb",
                        filterOptions: {
                            enabled: true
                        }
                    },
                    {
                        label:
                            "Mar." + " " + this.seleccionFechaMantencion.anio,
                        field: "codManMar",
                        html: true,
                        filterOptions: {
                            enabled: true
                        }
                    },
                    {
                        label:
                            "Abr." + " " + this.seleccionFechaMantencion.anio,
                        field: "codManAbr",
                        filterOptions: {
                            enabled: true
                        }
                    },
                    {
                        label:
                            "May." + " " + this.seleccionFechaMantencion.anio,
                        field: "codManMay",
                        filterOptions: {
                            enabled: true
                        }
                    },
                    {
                        label:
                            "Jun." + " " + this.seleccionFechaMantencion.anio,
                        field: "codManJun",
                        // type: "date",
                        // dateInputFormat: "dd/MM/yyyy",
                        // dateOutputFormat: "dd/MM/yyyy",
                        filterOptions: {
                            enabled: true
                        }
                    },
                    {
                        label:
                            "Jul." + " " + this.seleccionFechaMantencion.anio,
                        field: "codManJul",
                        filterOptions: {
                            enabled: true
                        }
                    },
                    {
                        label:
                            "Ago." + " " + this.seleccionFechaMantencion.anio,
                        field: "codManAgo",
                        filterOptions: {
                            enabled: true
                        }
                    },
                    {
                        label:
                            "Sep." + " " + this.seleccionFechaMantencion.anio,
                        field: "codManSep",
                        html: true,
                        filterOptions: {
                            enabled: true
                        }
                    },
                    {
                        label:
                            "Oct." + " " + this.seleccionFechaMantencion.anio,
                        field: "codManOct",
                        filterOptions: {
                            enabled: true
                        }
                    },
                    {
                        label:
                            "Nov." + " " + this.seleccionFechaMantencion.anio,
                        field: "codManNov",
                        filterOptions: {
                            enabled: true
                        }
                    },
                    {
                        label:
                            "Dic." + " " + this.seleccionFechaMantencion.anio,
                        field: "codManDic",
                        // type: "date",
                        // dateInputFormat: "dd/MM/yyyy",
                        // dateOutputFormat: "dd/MM/yyyy",
                        filterOptions: {
                            enabled: true
                        }
                    },
                    {
                        label: "Frecuencia.",
                        field: "desFrecuencia",
                        // type: "date",
                        // dateInputFormat: "dd/MM/yyyy",
                        // dateOutputFormat: "dd/MM/yyyy",
                        filterOptions: {
                            enabled: true
                        }
                    },
                    {
                        label: "Tipo Mantencion.",
                        field: "descripcionTMantencion",
                        // type: "date",
                        // dateInputFormat: "dd/MM/yyyy",
                        // dateOutputFormat: "dd/MM/yyyy",
                        filterOptions: {
                            enabled: true
                        }
                    }
                ];
            } catch (error) {
                console.log(error);
            }
        },
        PopFormularioMantencion() {
            this.popFormMantencionInd = true;
        },
        PopCalAnio() {
            this.popFormCalAnio = true;
        },
        PostMantencion() {
            try {
                let obj = {
                    id_edificio: this.seleccionEdificio.id,
                    descripcion_mantencion: this.descripcion_mantencion,
                    codManEne: parseInt(this.codManEne),
                    codManFeb: parseInt(this.codManFeb),
                    codManMar: parseInt(this.codManMar),
                    codManAbr: parseInt(this.codManAbr),
                    codManMay: parseInt(this.codManMay),
                    codManJun: parseInt(this.codManJun),
                    codManJul: parseInt(this.codManJul),
                    codManAgo: parseInt(this.codManAgo),
                    codManSep: parseInt(this.codManSep),
                    codManOct: parseInt(this.codManOct),
                    codManNov: parseInt(this.codManNov),
                    codManDic: parseInt(this.codManDic),
                    desFrecuencia: this.desFrecuencia,
                    id_anio: this.seleccionAnio.id,
                    id_tmantencion: this.seleccionTMantencion.id,
                    idEstadoManI: this.seleccionEstadoMIndustrial.id
                };
                axios
                    .post(
                        this.localVal + "/api/Agente/PostCalendarioMIndustrial",
                        obj,
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
                                title: "Calendario Ingregado Correctamente",
                                text: "Se Recargara Listado",
                                color: "success",
                                position: "top-right"
                            });
                        } else {
                            this.$vs.notify({
                                time: 3000,
                                title: "Error",
                                text: "Hubo una falla al agregar el Calendario",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
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
        cargarEstadoMIndustrial() {
            axios
                .get(this.localVal + "/api/Agente/GetEstadoMIndustrial", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoEstadoMIndustrial = res.data;
                });
        },
        cargarTMantencion() {
            axios
                .get(this.localVal + "/api/Agente/GetTMantencion", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoTMantencion = res.data;
                });
        },
        cargarAnios() {
            try {
                axios
                    .get(this.localVal + "/api/Agente/GetAnios", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listadoAnios = res.data;
                    });
            } catch (error) {
                console.log(error);
            }
        },
        cargarListadoPorAnio() {
            try {
                let obj = { id_anio: this.seleccionFechaMantencion.id };
                axios
                    .post(
                        this.localVal + "/api/Agente/GetMantencionesAnio",
                        obj,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.cargaColumnas();
                        this.mantenciones = res.data;
                    });
            } catch (error) {
                console.log(error);
            }
        },
        guardarAnio() {
            try {
                let obj = { anio: this.anio };
                axios
                    .post(this.localVal + "/api/Agente/PostAnios", obj, {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        if (res.data == true) {
                            this.$vs.notify({
                                time: 3000,
                                title: "Año Ingregado Correctamente",
                                text: "Se Recargara Listado",
                                color: "success",
                                position: "top-right"
                            });
                        } else {
                            this.$vs.notify({
                                time: 3000,
                                title: "Error",
                                text: "Hubo una falla al agregar el Año",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        //KPI
        cargaSO() {
            try {
                axios
                    .get(this.localVal + "/api/Agente/TraerKPIMProgramada", {
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
                        if (list.length > 0) {
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
                        }

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
        }
    },
    created() {
        this.cargaColumnas();
        this.cargarAnios();
        this.cargarEdificios();
        this.cargarTMantencion();
        this.cargaSO();
        this.cargarEstadoMIndustrial();
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
