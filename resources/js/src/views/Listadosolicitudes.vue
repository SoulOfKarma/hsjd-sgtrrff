<template>
    <div>
        <vx-card title="1. Listado de Tickets" code-toggler>
            <vs-alert active="true" color="success">
                Listado de tickets creados por: {{ nombre }} - {{ run }}
            </vs-alert>

            <vs-table search :data="solicitudes" max-items="5" pagination>
                <template slot="thead">
                    <vs-th>N° Solicitud</vs-th>
                    <vs-th>Persona Solicitante</vs-th>
                    <vs-th>Titulo</vs-th>
                    <vs-th>Descripcion</vs-th>
                    <vs-th>Estado</vs-th>
                    <vs-th>Opciones Ticket</vs-th>
                </template>

                <template slot-scope="{ data }">
                    <vs-tr :key="indextr" v-for="(tr, indextr) in data">
                        <vs-td :data="data[indextr].id">{{
                            data[indextr].nticket
                        }}</vs-td>

                        <vs-td :data="data[indextr].id_user">{{
                            data[indextr].nombre + " " + data[indextr].apellido
                        }}</vs-td>

                        <vs-td :data="data[indextr].tituloP">{{
                            data[indextr].tituloP
                        }}</vs-td>

                        <vs-td
                            :data="data[indextr].descripcionP"
                            v-html="data[indextr].descripcionP"
                            >{{ data[indextr].descripcionP }}</vs-td
                        >
                        <vs-td :data="data[indextr].descripcionP">{{
                            data[indextr].descripcionEstado
                        }}</vs-td>
                        <vs-td :data="data[indextr].id">
                            <div v-if="data[indextr].Horas < 1">
                                <info-icon
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        detalleSolicitud(
                                            data[indextr].id,
                                            data[indextr].uuid
                                        )
                                    "
                                ></info-icon>
                                <upload-icon
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        modificarSolicitud(
                                            data[indextr].id,
                                            data[indextr].uuid
                                        )
                                    "
                                ></upload-icon>

                                <trash-2-icon
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        abrirPop(
                                            data[indextr].id,
                                            data[indextr].uuid
                                        )
                                    "
                                ></trash-2-icon>
                            </div>
                            <div v-else-if="data[indextr].Horas < 8">
                                <info-icon
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        detalleSolicitud(
                                            data[indextr].id,
                                            data[indextr].uuid
                                        )
                                    "
                                ></info-icon>
                                <upload-icon
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        modificarSolicitud(
                                            data[indextr].id,
                                            data[indextr].uuid
                                        )
                                    "
                                ></upload-icon>
                            </div>
                            <div v-else-if="data[indextr].id_estado == 5">
                                <info-icon
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        detalleSolicitud(
                                            data[indextr].id,
                                            data[indextr].uuid
                                        )
                                    "
                                ></info-icon>
                                <check-icon
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        abrirPopFinalizar(
                                            data[indextr].id,
                                            data[indextr].uuid
                                        )
                                    "
                                ></check-icon>
                            </div>
                            <div v-else>
                                <info-icon
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        detalleSolicitud(
                                            data[indextr].id,
                                            data[indextr].uuid
                                        )
                                    "
                                ></info-icon>
                            </div>
                        </vs-td>
                    </vs-tr>
                </template>
            </vs-table>
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
            value1: "",
            value2: "",
            validaEliminar: false,
            popupActive2: false,
            popupActive3: false,
            localVal: "http://10.66.248.51:8000",
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
                .post(this.localVal + "/api/Usuario/getDataSolicitudes", data)
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
                .get(this.localVal + `/api/Usuario/GetSolicitudCreada/${id}`)
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
                    .get(this.localVal + `/api/Usuario/destroyTicket/${id}`)
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
        },
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
        }
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
