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
    </div>
</template>
<script>
import axios from "axios";
import VxTimeline from "@/components/timeline/VxTimeline";
import router from "@/router";
export default {
    components: {
        VxTimeline
    },
    data() {
        return {
            localVal: "http://10.66.248.51:8000",
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
    }
};
</script>
<style lang="scss">
@import "@sass/vuexy/components/vxTimeline.scss";
</style>
