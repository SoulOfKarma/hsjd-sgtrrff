<template>
    <div>
        <!-- NOTIFICATIONS -->
        <vs-dropdown vs-custom-content vs-trigger-click class="cursor-pointer">
            <feather-icon
                icon="AlertTriangleIcon"
                class="cursor-pointer mt-1 sm:mr-6 mr-2"
                :badge="totalNTickets"
            />

            <vs-dropdown-menu
                class="notification-dropdown dropdown-custom vx-navbar-dropdown"
            >
                <div
                    class="notification-top text-center p-5 bg-primary text-white"
                >
                    <h3 class="text-white">
                        {{ totalNTickets }} Tickets Nuevos
                    </h3>
                    <p class="opacity-75">
                        Notificacion Tickets Nuevos
                    </p>
                </div>

                <component
                    :is="scrollbarTag"
                    ref="mainSidebarPs"
                    class="scroll-area--nofications-dropdown p-0 mb-10"
                    :settings="settings"
                    :key="$vs.rtl"
                >
                    <ul class="bordered-items">
                        <li
                            v-for="ntf in unreadNotificationsN"
                            :key="ntf.index"
                            class="flex justify-between px-4 py-4 notification cursor-pointer"
                            @click="abrirNotificacion(ntf.id)"
                        >
                            <div class="flex items-start">
                                <feather-icon
                                    :icon="ntf.icon"
                                    :svgClasses="[
                                        `text-${ntf.category}`,
                                        'stroke-current mr-1 h-6 w-6'
                                    ]"
                                ></feather-icon>
                                <div class="mx-2">
                                    <span
                                        class="font-medium block notification-title"
                                        :class="[`text-${ntf.category}`]"
                                        >{{ ntf.title }}</span
                                    >
                                    <small>{{ ntf.msg }}</small>
                                </div>
                            </div>
                        </li>
                    </ul>
                </component>
            </vs-dropdown-menu>
        </vs-dropdown>
        <!-- NOTIFICATIONS -->
        <vs-dropdown vs-custom-content vs-trigger-click class="cursor-pointer">
            <feather-icon
                icon="AlertCircleIcon"
                class="cursor-pointer mt-1 sm:mr-6 mr-2"
                :badge="totalPTickets"
            />

            <vs-dropdown-menu
                class="notification-dropdown dropdown-custom vx-navbar-dropdown"
            >
                <div
                    class="notification-top text-center p-5 bg-primary text-white"
                >
                    <h3 class="text-white">
                        {{ totalPTickets }} Tickets en proceso
                    </h3>
                    <p class="opacity-75">
                        Notificacion Tickets En Proceso
                    </p>
                </div>

                <component
                    :is="scrollbarTag"
                    ref="mainSidebarPs"
                    class="scroll-area--nofications-dropdown p-0 mb-10"
                    :settings="settings"
                    :key="$vs.rtl"
                >
                    <ul class="bordered-items">
                        <li
                            v-for="ntf in unreadNotifications"
                            :key="ntf.index"
                            class="flex justify-between px-4 py-4 notification cursor-pointer"
                            @click="abrirNotificacionP(ntf.id)"
                        >
                            <div class="flex items-start">
                                <feather-icon
                                    :icon="ntf.icon"
                                    :svgClasses="[
                                        `text-${ntf.category}`,
                                        'stroke-current mr-1 h-6 w-6'
                                    ]"
                                ></feather-icon>
                                <div class="mx-2">
                                    <span
                                        class="font-medium block notification-title"
                                        :class="[`text-${ntf.category}`]"
                                        >{{ ntf.title }}</span
                                    >
                                    <small>{{ ntf.msg }}</small>
                                </div>
                            </div>
                        </li>
                    </ul>
                </component>
            </vs-dropdown-menu>
        </vs-dropdown>
    </div>
</template>

<script>
import VuePerfectScrollbar from "vue-perfect-scrollbar";
import axios from "axios";
import router from "@/router";

export default {
    components: {
        VuePerfectScrollbar
    },
    data() {
        return {
            unreadNotifications: [],
            unreadNotificationsN: [],
            totalPTickets: 0,
            totalNTickets: 0,
            settings: {
                maxScrollbarLength: 60,
                wheelSpeed: 0.6
            },
            localVal: process.env.MIX_APP_URL
        };
    },
    computed: {
        scrollbarTag() {
            return this.$store.getters.scrollbarTag;
        }
    },
    methods: {
        elapsedTime(startTime) {
            const x = new Date(startTime);
            const now = new Date();
            let timeDiff = now - x;
            timeDiff /= 1000;

            const seconds = Math.round(timeDiff);
            timeDiff = Math.floor(timeDiff / 60);

            const minutes = Math.round(timeDiff % 60);
            timeDiff = Math.floor(timeDiff / 60);

            const hours = Math.round(timeDiff % 24);
            timeDiff = Math.floor(timeDiff / 24);

            const days = Math.round(timeDiff % 365);
            timeDiff = Math.floor(timeDiff / 365);

            const years = timeDiff;

            if (years > 0) {
                return `${years + (years > 1 ? " Years " : " Year ")}ago`;
            } else if (days > 0) {
                return `${days + (days > 1 ? " Days " : " Day ")}ago`;
            } else if (hours > 0) {
                return `${hours + (hours > 1 ? " Hrs " : " Hour ")}ago`;
            } else if (minutes > 0) {
                return `${minutes + (minutes > 1 ? " Mins " : " Min ")}ago`;
            } else if (seconds > 0) {
                return seconds + (seconds > 1 ? " sec ago" : "just now");
            }

            return "";
        },
        // Method for creating dummy notification time
        randomDate({ hr, min, sec }) {
            const date = new Date();

            if (hr) date.setHours(date.getHours() - hr);
            if (min) date.setMinutes(date.getMinutes() - min);
            if (sec) date.setSeconds(date.getSeconds() - sec);

            return date;
        },
        abrirNotificacionP(item) {
            try {
                axios
                    .get(
                        this.localVal +
                            `/api/Agente/ValidarTicketAsignadoMod/${item}`,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        if (res.data == 1) {
                            this.$vs.notify({
                                title: "Ticket no ha sido asignado ",
                                text:
                                    "Ticket necesita ya estar asignado primero para modificarlo ",
                                color: "danger",
                                position: "top-right"
                            });
                        } else {
                            this.$router.push({
                                name: "ModificarSolicitudAgente",
                                params: {
                                    id: `${item}`
                                }
                            });
                        }
                    });
            } catch (error) {
                console.log("Error al capturar datos");
            }
        },
        abrirNotificacion(item) {
            try {
                console.log(item);
            } catch (error) {
                console.log("Error al capturar datos");
            }
        },
        cargaNotificaciones() {
            try {
                axios
                    .get(this.localVal + "/api/Agente/TraerNotificaciones", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        let data = res.data;
                        let b = [];
                        let obj = {};
                        data.forEach((value, index) => {
                            obj = {};
                            obj = {
                                id: value.id,
                                index: index,
                                title: "Tickets en proceso",
                                msg: value.msg,
                                icon: "MessageSquareIcon",
                                category: "danger"
                            };
                            b.push(obj);
                        });
                        this.unreadNotifications = b;
                    });
            } catch (error) {
                console.log("Error al recuperar datos");
            }
        },
        cargaNotificacionesN() {
            try {
                axios
                    .get(this.localVal + "/api/Agente/TraerNotificacionesN", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        let data = res.data;
                        let b = [];
                        let obj = {};
                        data.forEach((value, index) => {
                            obj = {};
                            obj = {
                                id: value.id,
                                index: index,
                                title: "Tickets en proceso",
                                msg: value.msg,
                                icon: "MessageSquareIcon",
                                category: "danger"
                            };
                            b.push(obj);
                        });
                        this.unreadNotificationsN = b;
                    });
            } catch (error) {
                console.log("Error al recuperar datos");
            }
        },
        cargaKPI() {
            try {
                axios
                    .get(this.localVal + "/api/Agente/TraerKPITicketsTotal", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        let data = res.data;
                        this.totalPTickets = data[0].OpenTickets;
                        this.totalNTickets = data[0].NewTickets;
                    });
            } catch (error) {
                console.log("Error al recuperar datos");
            }
        }
    },
    created() {
        this.cargaNotificaciones();
        this.cargaNotificacionesN();
        this.cargaKPI();
    }
};
</script>
