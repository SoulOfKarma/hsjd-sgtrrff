<template>
    <div>
        <vx-card title="1. Listado de Tickets">
            <vs-alert active="true" color="success">
                Listado de tickets creados por: {{ nombre }} - {{ run }}
            </vs-alert>
            <br />
            <vx-card>
                <vue-good-table
                    :columns="columns"
                    :rows="solicitudes"
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
                        <span
                            v-if="props.column.field === 'descripcionP'"
                            class="text-nowrap"
                        >
                            <div v-html="props.row.descripcionP"></div>
                        </span>
                        <span
                            v-else-if="
                                props.column.field == 'descripcionEstado'
                            "
                            class="text-nowrap"
                        >
                            <vs-chip
                                v-if="props.row.id_estado == 1"
                                color="primary"
                            >
                                {{ props.row.descripcionEstado }}
                            </vs-chip>

                            <vs-chip
                                v-if="props.row.id_estado == 2"
                                color="success"
                            >
                                {{ props.row.descripcionEstado }}
                            </vs-chip>
                            <vs-chip
                                v-if="props.row.id_estado == 3"
                                color="warning"
                            >
                                {{ props.row.descripcionEstado }}
                            </vs-chip>
                            <vs-chip
                                v-if="props.row.id_estado == 4"
                                color="warning"
                            >
                                {{ props.row.descripcionEstado }}
                            </vs-chip>
                            <vs-chip
                                v-if="props.row.id_estado == 5"
                                color="danger"
                            >
                                {{ props.row.descripcionEstado }}
                            </vs-chip>
                            <vs-chip
                                v-if="props.row.id_estado == 6"
                                color="danger"
                            >
                                {{ props.row.descripcionEstado }}
                            </vs-chip>
                            <vs-chip
                                v-if="props.row.id_estado == 7"
                                color="warning"
                            >
                                {{ props.row.descripcionEstado }}
                            </vs-chip>
                        </span>
                        <!-- Column: Action -->
                        <span v-else-if="props.column.field === 'action'">
                            <div v-if="props.row.Horas < 1">
                                <plus-circle-icon
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        detalleSolicitud(
                                            props.row.id,
                                            props.row.uuid
                                        )
                                    "
                                ></plus-circle-icon>
                                <upload-icon
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        modificarSolicitud(
                                            props.row.id,
                                            props.row.uuid
                                        )
                                    "
                                ></upload-icon>
                                <trash-2-icon
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        abrirPop(props.row.id, props.row.uuid)
                                    "
                                ></trash-2-icon>
                            </div>
                            <div v-else-if="props.row.Horas < 8">
                                <plus-circle-icon
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        detalleSolicitud(
                                            props.row.id,
                                            props.row.uuid
                                        )
                                    "
                                ></plus-circle-icon>
                                <upload-icon
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        modificarSolicitud(
                                            props.row.id,
                                            props.row.uuid
                                        )
                                    "
                                ></upload-icon>
                            </div>
                            <div v-else-if="props.row.id_estado == 5">
                                <plus-circle-icon
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        detalleSolicitud(
                                            props.row.id,
                                            props.row.uuid
                                        )
                                    "
                                ></plus-circle-icon>
                            </div>
                            <div v-else>
                                <plus-circle-icon
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        detalleSolicitud(
                                            props.row.id,
                                            props.row.uuid
                                        )
                                    "
                                ></plus-circle-icon>
                            </div>
                        </span>

                        <!-- Column: Common -->
                        <span v-else>
                            {{ props.formattedRow[props.column.field] }}
                        </span>
                    </template>
                </vue-good-table>
            </vx-card>
        </vx-card>

        <vs-popup
            classContent="popup-example"
            title="Realmente desea eliminar el ticket?"
            :active.sync="popupActive2"
        >
            <vs-input
                class="inputx mb-3"
                placeholder="Placeholder"
                v-model="value1"
                hidden
            />
            <vs-input
                disabled
                class="inputx mb-3"
                placeholder="Disabled"
                v-model="value2"
                hidden
            />
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row">
                    <div class="vx-col sm:w-full w-full ">
                        <vs-button
                            @click="
                                eliminarSolicitud(
                                    value1,
                                    value2,
                                    validaEliminar
                                )
                            "
                            color="danger"
                            type="filled"
                            >Eliminar</vs-button
                        >
                    </div>
                    <div class="vx-col sm:w-full w-full ">
                        <vs-button
                            @click="popupActive2 = false"
                            color="primary"
                            type="filled"
                            >Volver</vs-button
                        >
                    </div>
                </div>
            </div>
        </vs-popup>
        <vs-popup
            classContent="popFinalizar"
            title="Presione Finalizar si esta conforme con la reparacion realizada"
            :active.sync="popupActive3"
        >
            <vs-input
                class="inputx mb-3"
                placeholder="Placeholder"
                v-model="value1"
                hidden
            />
            <vs-input
                disabled
                class="inputx mb-3"
                placeholder="Disabled"
                v-model="value2"
                hidden
            />
            <div class="vx-col md:w-1/1 w-full " alignment="fixed">
                <div class="vx-row ">
                    <div class="vx-col sm:w-1/3 w-full ">
                        <vs-button
                            @click="popupActive3 = false"
                            color="primary"
                            type="filled"
                            >Volver</vs-button
                        >
                    </div>
                    <div class="vx-col sm:w-1/3 w-full ">
                        <vs-button
                            @click="finalizarTicket(value1, value2)"
                            color="success"
                            type="filled"
                            >Finalizar</vs-button
                        >
                    </div>
                    <div class="vx-col sm:w-1/3 w-full">
                        <vs-button
                            @click="Redirigir(value1, value2)"
                            color="warning"
                            type="filled"
                            >Re-Abrir Solicitud</vs-button
                        >
                    </div>
                </div>
            </div>
        </vs-popup>
    </div>
</template>

<script>
import axios from "axios";
import router from "../router";
import { InfoIcon } from "vue-feather-icons";
import { PlusCircleIcon } from "vue-feather-icons";
import { Trash2Icon } from "vue-feather-icons";
import { UploadIcon } from "vue-feather-icons";
import { CheckIcon } from "vue-feather-icons";
import moment from "moment";
// import the styles
import Vue from "vue";
import "vue-good-table/dist/vue-good-table.css";
import VueGoodTablePlugin from "vue-good-table";
Vue.use(VueGoodTablePlugin);

export default {
    components: {
        InfoIcon,
        PlusCircleIcon,
        Trash2Icon,
        UploadIcon,
        CheckIcon
    },
    data() {
        return {
            colorLoading: "#ff8000",
            fechaModificar: moment().format("DD/MM/YYYY HH:mm"),
            fechaEliminar: moment().format("DD/MM/YYYY HH:mm"),
            solicitudes: [],
            columns: [
                {
                    label: "N° Ticket",
                    field: "nticket",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Solicitante",
                    field: "nombre",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Servicio",
                    field: "descripcionServicio",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Descripcion Problema",
                    field: "descripcionP",
                    html: true,
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Tipo Reparacion",
                    field: "descripcionTipoReparacion",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Estado",
                    field: "descripcionEstado",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Fecha Solicitud",
                    field: "fechaSolicitud",
                    type: "date",
                    dateInputFormat: "dd/MM/yyyy",
                    dateOutputFormat: "dd/MM/yyyy",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Opciones",
                    field: "action"
                }
            ],
            value1: "",
            value2: "",
            validaEliminar: false,
            popupActive2: false,
            popupActive3: false,
            localVal: process.env.MIX_APP_URL,
            nombre:
                sessionStorage.getItem("nombre") +
                " " +
                sessionStorage.getItem("apellido"),
            run: sessionStorage.getItem("run"),

            data: {
                idServicio: sessionStorage.getItem("idServicio"),
                idUser: sessionStorage.getItem("id")
            }
        };
    },
    methods: {
        openLoadingColor() {
            this.$vs.loading({ color: this.colorLoading });
            setTimeout(() => {
                this.$vs.loading.close();
            }, 1000);
        },
        cargarSolicitudes() {
            const data = this.data;
            axios
                .post(this.localVal + "/api/Usuario/getDataSolicitudes", data, {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.solicitudes = res.data;
                });
        },
        detalleSolicitud(id, uuid) {
            this.$router.push({
                name: "InformacionSolicitud",
                params: {
                    id: `${id}`,
                    uuid: `${uuid}`
                }
            });
        },
        abrirPop(id, uuid) {
            this.validaEliminar = true;
            this.value1 = id;
            this.value2 = uuid;
            this.popupActive2 = true;
        },
        modificarSolicitud(id, uuid) {
            //router.push(`/agenteView/FormularioModificar/${id}`);
            axios
                .get(this.localVal + `/api/Usuario/GetSolicitudCreada/${id}`, {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    if (res.data) {
                        this.$router.push({
                            name: "ModificarTicketUsuario",
                            params: {
                                id: `${id}`,
                                uuid: `${uuid}`
                            }
                        });
                    }
                });
        },
        eliminarSolicitud(id, uuid, eliminar) {
            if (eliminar) {
                axios
                    .get(this.localVal + `/api/Usuario/destroyTicket/${id}`, {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        var eliminado = res.data;
                        this.popupActive2 = false;
                        if (eliminado) {
                            this.$vs.notify({
                                title: "Ticket Eliminado ",
                                time: 4000,
                                text: "Se recargara el listado ",
                                color: "danger",
                                position: "top-right"
                            });
                            this.cargarSolicitudes();
                        }
                    });
            }
        },
        abrirPopFinalizar(id, uuid) {
            this.value1 = id;
            this.value2 = uuid;
            this.popupActive3 = true;
        } /* ,
        finalizarTicket(id, uuid) {
            console.log(id);
            console.log(uuid);
        },
        Redirigir(id, uuid) {
            console.log(id);
            console.log(uuid);
        },
        probar() {
            console.log(this.fechaModificar);
            console.log(this.fechaEliminar);
        } */
    },
    beforeMount() {
        this.cargarSolicitudes();
        this.openLoadingColor();
    }
};
</script>
<style lang="stylus">
.popup-example
  .vs-button
    float left
    width 97%
    margin 10px
    margin-top 5px
</style>
