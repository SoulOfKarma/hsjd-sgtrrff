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
                    <h2 class="mb-1">Generar Reporte</h2>
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
            <!-- Ubicacion -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="Categoria">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-full mt-5">
                            <h6>
                                Seleccione Categoria Para Generar el Reporte
                            </h6>
                            <br />
                            <v-select
                                taggable
                                v-model="seleccionCategoria"
                                placeholder="Seleccione Categoria"
                                class="w-full select-large"
                                label="des_categoria"
                                :options="listadoCategoria"
                            ></v-select>
                        </div>
                    </div>
                </vx-card>
            </div>
            <!-- Ubicacion -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="1. Seleccione Fechas">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.1 - Hora y Fecha de inicio</h6>
                            <br />
                            <flat-pickr
                                :config="configFromdateTimePicker"
                                v-model="fechas.fechaInicio"
                                class="w-full select-large"
                                placeholder="Fecha Inicio"
                                @on-change="onFromChange"
                                :language="language"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.2 - Hora y Fecha de termino</h6>
                            <br />
                            <flat-pickr
                                :config="configTodateTimePicker"
                                v-model="fechas.fechaTermino"
                                class="w-full select-large"
                                placeholder="Fecha Termino"
                                @on-change="onToChange"
                                :language="language"
                            />
                        </div>
                    </div>
                </vx-card>
            </div>

            <!-- Enviar o Limpiar Formulario -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row mb-12">
                    <div class="vx-col w-1/4 mt-5">
                        <vs-button
                            color="warning"
                            class="mb-2 w-full"
                            @click="volver"
                            >Volver</vs-button
                        >
                    </div>
                    <div class="vx-col w-1/4 mt-5">
                        <vs-button
                            class="mb-2 w-full"
                            color="success"
                            @click="GenerarExcel"
                            >Generar Reporte Por Fechas</vs-button
                        >
                    </div>
                    <div class="vx-col w-1/4 mt-5">
                        <vs-button
                            class="mb-2 w-full"
                            color="success"
                            @click="GenerarExcelTodo"
                            >Generar Reporte Completo</vs-button
                        >
                    </div>
                    <div class="vx-col w-1/4 mt-5">
                        <vs-button
                            class="mb-2 w-full"
                            color="success"
                            @click="GenerarExcelTodasCategorias"
                            >Generar Reporte Completo Todas las
                            Categorias</vs-button
                        >
                    </div>
                </div>
            </div>
        </vs-row>
    </div>
</template>
<script>
import axios from "axios";
import moment from "moment";
import router from "@/router";
import { InfoIcon } from "vue-feather-icons";
import { PlusCircleIcon } from "vue-feather-icons";
import { Trash2Icon } from "vue-feather-icons";
import { UploadIcon } from "vue-feather-icons";
import { CornerDownRightIcon } from "vue-feather-icons";
import { ArchiveIcon } from "vue-feather-icons";
import Datepicker from "vuejs-datepicker";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import vSelect from "vue-select";

export default {
    components: {
        ArchiveIcon,
        InfoIcon,
        PlusCircleIcon,
        Trash2Icon,
        UploadIcon,
        CornerDownRightIcon,
        flatPickr,
        "v-select": vSelect
    },
    data() {
        return {
            language: "es",
            nombre: sessionStorage.getItem("nombre"),
            run: sessionStorage.getItem("run"),
            format: "d MMMM yyyy",
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

            fechas: {
                fechaInicio: null,
                fechaTermino: null
            },
            seleccionCategoria: {
                id: 1,
                des_categoria: "Infraestructura"
            },
            listadoCategoria: [],
            localVal: process.env.MIX_APP_URL
        };
    },
    methods: {
        volver() {
            router.back();
        },
        GenerarExcelTodo() {
            let newWindow = window.open();
            if (this.seleccionCategoria.id == 1) {
                newWindow.location =
                    this.localVal + "/api/Agente/generarExcelTodoJ";
            } else if (this.seleccionCategoria.id == 2) {
                newWindow.location =
                    this.localVal + "/api/Agente/generarExcelTodoEMJ";
            } else if (this.seleccionCategoria.id == 3) {
                newWindow.location =
                    this.localVal + "/api/Agente/generarExcelTodoIJ";
            } else if (this.seleccionCategoria.id == 4) {
                newWindow.location =
                    this.localVal + "/api/Agente/generarExcelTodoAPJ";
            }
        },
        GenerarExcelTodasCategorias() {
            let newWindow = window.open();
            newWindow.location =
                this.localVal + "/api/Agente/generarExcelTodasCategorias";
        },
        GenerarExcel() {
            if (this.seleccionCategoria.id == 1) {
                const url =
                    this.localVal +
                    "/api/Agente/generarExcelByFechaJ/" +
                    this.fechas.fechaInicio +
                    "/" +
                    this.fechas.fechaTermino;
                window.open(url, "_blank");
            } else if (this.seleccionCategoria.id == 2) {
                const url =
                    this.localVal +
                    "/api/Agente/generarExcelByFechaEMJ/" +
                    this.fechas.fechaInicio +
                    "/" +
                    this.fechas.fechaTermino;
                window.open(url, "_blank");
            } else if (this.seleccionCategoria.id == 3) {
                const url =
                    this.localVal +
                    "/api/Agente/generarExcelByFechaIJ/" +
                    this.fechas.fechaInicio +
                    "/" +
                    this.fechas.fechaTermino;
                window.open(url, "_blank");
            } else if (this.seleccionCategoria.id == 4) {
                const url =
                    this.localVal +
                    "/api/Agente/generarExcelByFechaAPJ/" +
                    this.fechas.fechaInicio +
                    "/" +
                    this.fechas.fechaTermino;
                window.open(url, "_blank");
            }
        },
        cargarCategoria() {
            this.csrf_token;

            axios
                .get(this.localVal + "/api/Usuario/getCategoriaSI", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoCategoria = res.data;
                })
                .catch(error => {
                    if (error.response.status === 401) {
                        this.$vs.notify({
                            title: "Token Invalido ",
                            text: "Debe iniciar sesion nuevamente",
                            color: "danger",
                            position: "top-right",
                            time: 3000
                        });
                    }
                });
        },
        onFromChange(selectedDates, dateStr, instance) {
            this.$set(this.configTodateTimePicker, "minDate", dateStr);
        },
        onToChange(selectedDates, dateStr, instance) {
            this.$set(this.configFromdateTimePicker, "maxDate", dateStr);
        }
    },
    created() {
        this.cargarCategoria();
    }
};
</script>
