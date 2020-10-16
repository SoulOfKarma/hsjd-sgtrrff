<template>
    <div>
        <div class="vx-row">
            <div
                class="router-header flex flex-wrap items-center mb-6"
                style="margin-left:10px;"
            >
                <div
                    class="content-area__heading pr-4 border-0 md:border-r border-solid border-grey-light"
                >
                    <h2 class="mb-1">Página de Inicio</h2>
                </div>
            </div>
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
                <vx-card title="Manual Rápido">
                    <ul class="activity-timeline" vx-timeline>
                        <li>
                            <div class="timeline-icon bg-primary">
                                <feather-icon
                                    icon="LayoutIcon"
                                    svgClasses="text-white stroke-current w-5 h-5"
                                ></feather-icon>
                            </div>
                            <div class="timeline-info">
                                <p class="font-semibold">Menú</p>
                                <span class="activity-desc">
                                    Encontrarás el acceso a la pantalla de
                                    Inicio, el listado de tickets solicitados y
                                    el calendario de trabajadores
                                </span>
                            </div>
                            <small class="text-grey activity-e-time"></small>
                        </li>
                        <li>
                            <div class="timeline-icon bg-warning">
                                <feather-icon
                                    icon="PlusSquareIcon"
                                    svgClasses="text-white stroke-current w-5 h-5"
                                ></feather-icon>
                            </div>
                            <div class="timeline-info">
                                <p class="font-semibold">Calendario</p>
                                <span class="activity-desc">
                                    En esta seccion podras ver a los
                                    trabajadores asignados para realizar una
                                    solicitud con su hora y fecha de termino
                                </span>
                            </div>
                            <small class="text-grey activity-e-time"></small>
                        </li>
                        <li>
                            <div class="timeline-icon bg-danger">
                                <feather-icon
                                    icon="LoaderIcon"
                                    svgClasses="text-white stroke-current w-5 h-5"
                                ></feather-icon>
                            </div>
                            <div class="timeline-info">
                                <p class="font-semibold">Listado de Tickets</p>
                                <span class="activity-desc">
                                    En esta sección podrás visulizar la
                                    informacion de las solicitudes realizadas
                                    por los usuarios, en ella podras asignarle
                                    tecnicos para su revision, asignarles una
                                    hora y fecha, confirmar su ubicacion y poder
                                    generar actualizaciones del avance del
                                    ticket.
                                </span>
                            </div>
                            <small class="text-grey activity-e-time"></small>
                        </li>
                    </ul>
                </vx-card>
            </div>
            <div class="vx-col w-full lg:w-1/4 mb-base"></div>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import router from "@/router";
export default {
    data() {
        return { localVal: "http://127.0.0.1:8000" };
    },
    methods: {
        detalleImpTicket() {
            this.$router.push({
                name: "DetalleTicketImp"
            });
        },
        imprimir() {
            axios.get(this.localVal + "/api/Agente/imprimir");
        }
    }
};
</script>
