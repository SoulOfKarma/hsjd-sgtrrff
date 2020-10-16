<template>
    <div>
        <vx-card title="Listado de Tickets" code-toggler>
            <vs-alert active="true" color="success">
                Listado de tickets creados por: {{ nombre }} - {{ run }}
            </vs-alert>

            <vs-table search :data="solicitudes" max-items="5" pagination>
                <template slot="thead">
                    <vs-th>N° Solicitud</vs-th>
                    <vs-th>Persona Solicitante</vs-th>
                    <vs-th>Titulo</vs-th>
                    <vs-th>Descripcion</vs-th>
                    <vs-th>Fecha Creacion</vs-th>
                    <vs-th>Fecha Asignacion</vs-th>
                    <vs-th>Estado</vs-th>
                    <vs-th>Opciones Ticket</vs-th>
                </template>

                <template slot-scope="{ data }">
                    <vs-tr :key="indextr" v-for="(tr, indextr) in data">
                        <vs-td :data="data[indextr].id">{{
                            data[indextr].nticket
                        }}</vs-td>

                        <vs-td :data="data[indextr].id_user">{{
                            data[indextr].nombre
                        }}</vs-td>

                        <vs-td :data="data[indextr].tituloP">{{
                            data[indextr].tituloP
                        }}</vs-td>

                        <vs-td
                            :data="data[indextr].descripcionP"
                            v-html="data[indextr].descripcionP"
                            >{{ data[indextr].descripcionP }}</vs-td
                        >
                        <vs-td :data="data[indextr].fechaCreacion">{{
                            data[indextr].fechaCreacion
                        }}</vs-td>
                        <vs-td :data="data[indextr].fechaAsignacion">{{
                            data[indextr].fechaAsignacion
                        }}</vs-td>
                        <vs-td :data="data[indextr].descripcionEstado">{{
                            data[indextr].descripcionEstado
                        }}</vs-td>
                        <vs-td :data="data[indextr].id">
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
                            <plus-circle-icon
                                size="1.5x"
                                class="custom-class"
                                @click="
                                    resolucionSolicitud(
                                        data[indextr].id,
                                        data[indextr].uuid
                                    )
                                "
                            ></plus-circle-icon>
                            <archive-icon
                                size="1.5x"
                                class="custom-class"
                                @click="
                                    generarTicket(
                                        data[indextr].id,
                                        data[indextr].uuid,
                                        data[indextr].id_categoria
                                    )
                                "
                            ></archive-icon>
                        </vs-td>
                    </vs-tr>
                </template>
            </vs-table>
        </vx-card>
    </div>
</template>
<script>
import axios from "axios";
import router from "@/router";
import { InfoIcon } from "vue-feather-icons";
import { PlusCircleIcon } from "vue-feather-icons";
import { Trash2Icon } from "vue-feather-icons";
import { UploadIcon } from "vue-feather-icons";
import { ArchiveIcon } from "vue-feather-icons";
export default {
    components: {
        InfoIcon,
        PlusCircleIcon,
        Trash2Icon,
        UploadIcon,
        ArchiveIcon
    },
    data() {
        return {
            solicitudes: [],
            localVal: "http://127.0.0.1:8000",
            nombre: localStorage.getItem("nombre"),
            run: localStorage.getItem("run")
        };
    },
    methods: {
        cargarSolicitudes() {
            let id = localStorage.getItem("id");
            axios
                .get(this.localVal + `/api/Trabajador/TraerTickets/${id}`)
                .then(res => {
                    this.solicitudes = res.data;
                });
        },
        detalleSolicitud(id, uuid) {
            this.$router.push({
                name: "InformacionSolicitudTrabajador",
                params: {
                    id: `${id}`,
                    uuid: `${uuid}`
                }
            });
        },
        generarTicket(id, uuid, categoria) {
            if ((categoria = 1)) {
                const url =
                    this.localVal + "/api/Agente/imprimirPorTicketINFRA/" + id;
                window.open(url, "_blank");
            } else if ((categoria = 2)) {
                const url =
                    this.localVal + "/api/Agente/imprimirPorTicketEM/" + id;
                window.open(url, "_blank");
            } else if ((categoria = 3)) {
                const url =
                    this.localVal + "/api/Agente/imprimirPorTicketIND/" + id;
                window.open(url, "_blank");
            } else if ((categoria = 4)) {
                const url =
                    this.localVal + "/api/Agente/imprimirPorTicketCA/" + id;
                window.open(url, "_blank");
            } else {
                this.$vs.notify({
                    title: "Error al generar Ticket",
                    text: "Intente nuevamente o contacte con algun agente",
                    color: "danger",
                    position: "top-right",
                    fixed: true
                });
            }
        },
        resolucionSolicitud(id, uuid) {
            this.$router.push({
                name: "ResolucionSolicitud",
                params: {
                    id: `${id}`,
                    uuid: `${uuid}`
                }
            });
        }
    },
    created() {
        this.cargarSolicitudes();
    }
};
</script>
