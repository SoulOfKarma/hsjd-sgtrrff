<template>
    <div>
        <vs-row>
            <div
                class="router-header flex flex-wrap items-center mb-8"
                style="margin-left:10px;"
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
                    <div class="vx-col w-1/3 mt-5">
                        <vs-button
                            color="warning"
                            class="mb-2 w-full"
                            @click="volver"
                            >Volver</vs-button
                        >
                    </div>
                    <div class="vx-col w-1/3 mt-5">
                        <vs-button
                            class="mb-2 w-full"
                            color="success"
                            @click="GenerarExcel"
                            >Generar Reporte Por Fechas</vs-button
                        >
                    </div>
                    <div class="vx-col w-1/3 mt-5">
                        <vs-button
                            class="mb-2 w-full"
                            color="success"
                            @click="GenerarExcelTodo"
                            >Generar Reporte Completo</vs-button
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

export default {
    components: {
        ArchiveIcon,
        InfoIcon,
        PlusCircleIcon,
        Trash2Icon,
        UploadIcon,
        CornerDownRightIcon,
        flatPickr
    },
    data() {
        return {
            language: "es",
            nombre: localStorage.getItem("nombre"),
            run: localStorage.getItem("run"),
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
                maxDate: null
            },
            configTodateTimePicker: {
                minDate: null,
                maxDate: null
            },

            fechas: {
                fechaInicio: null,
                fechaTermino: null
            },
            localVal: "http://127.0.0.1:8000"
        };
    },
    methods: {
        volver() {
            router.back();
        },
        GenerarExcelTodo() {
            let newWindow = window.open();

            axios
                .get(this.localVal + "/api/Agente/generarExcelTodo")
                .then(res => {
                    newWindow.location =
                        "http://" +
                        window.location.hostname +
                        ":8000/api/Agente/generarExcelTodo";
                });
        },
        GenerarExcel() {
            const url =
                this.localVal +
                "/api/Agente/generarExcelByFecha/" +
                this.fechas.fechaInicio +
                "/" +
                this.fechas.fechaTermino;
            window.open(url, "_blank");
        },
        onFromChange(selectedDates, dateStr, instance) {
            this.$set(this.configTodateTimePicker, "minDate", dateStr);
        },
        onToChange(selectedDates, dateStr, instance) {
            this.$set(this.configFromdateTimePicker, "maxDate", dateStr);
        }
    }
};
</script>
