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

                <vs-dropdown-group
                    :is="scrollbarTag"
                    ref="mainSidebarPs"
                    class="scroll-area--nofications-dropdown p-0 mb-10"
                    :settings="settings"
                    :key="$vs.rtl"
                >
                    <vs-dropdown-item class="bordered-items">
                        <li
                            v-for="ntf in unreadNotificationsN"
                            :key="ntf.index"
                            class="flex justify-between px-4 py-4 notification cursor-pointer"
                            @click="
                                abrirNotificacionP(
                                    ntf.id,
                                    ntf.uuid,
                                    ntf.id_user,
                                    ntf.idCategoria
                                )
                            "
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
                    </vs-dropdown-item>
                </vs-dropdown-group>
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

                <vs-dropdown-group
                    :is="scrollbarTag"
                    ref="mainSidebarPs"
                    class="scroll-area--nofications-dropdown p-0 mb-10"
                    :settings="settings"
                    :key="$vs.rtl"
                >
                    <vs-dropdown-item class="bordered-items">
                        <li
                            v-for="ntf in unreadNotifications"
                            :key="ntf.index"
                            class="flex justify-between px-4 py-4 notification cursor-pointer"
                            @click="
                                abrirNotificacion(
                                    ntf.id,
                                    ntf.uuid,
                                    ntf.id_user,
                                    ntf.idCategoria
                                )
                            "
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
                    </vs-dropdown-item>
                </vs-dropdown-group>
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
        abrirNotificacionP(id, uuid, id_user, idCategoria) {
            if (sessionStorage.getItem("permiso_usuario") == 1) {
                try {
                    if (idCategoria == 1) {
                        const path = {
                            name: "AsignarSolicitudAgente",
                            params: {
                                id: `${id}`,
                                uuid: `${uuid}`,
                                id_user: `${id_user}`
                            }
                        };
                        axios
                            .get(
                                this.localVal +
                                    `/api/Agente/ValidarTicketAsignado/${id}`,
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            )
                            .then(res => {
                                if (res.data == 2) {
                                    this.$vs.notify({
                                        title: "Ticket ya asignado ",
                                        text:
                                            "Si necesita modificarlo vaya a Modificar Ticket ",
                                        color: "danger",
                                        position: "top-right"
                                    });
                                } else if (this.$route.path !== path) {
                                    this.$router.push(path).catch(err => {});
                                }
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
                    } else if (idCategoria == 2) {
                        const path = {
                            name: "AsignarSolicitudAgenteEM",
                            params: {
                                id: `${id}`,
                                uuid: `${uuid}`,
                                id_user: `${id_user}`
                            }
                        };
                        axios
                            .get(
                                this.localVal +
                                    `/api/Agente/ValidarTicketAsignadoEM/${id}`,
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            )
                            .then(res => {
                                if (res.data == 2) {
                                    this.$vs.notify({
                                        title: "Ticket ya asignado ",
                                        text:
                                            "Si necesita modificarlo vaya a Modificar Ticket ",
                                        color: "danger",
                                        position: "top-right"
                                    });
                                } else if (this.$route.path !== path) {
                                    this.$router.push(path).catch(err => {});
                                }
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
                    } else if (idCategoria == 3) {
                        const path = {
                            name: "AsignarSolicitudAgenteIND",
                            params: {
                                id: `${id}`,
                                uuid: `${uuid}`,
                                id_user: `${id_user}`
                            }
                        };
                        axios
                            .get(
                                this.localVal +
                                    `/api/Agente/ValidarTicketAsignadoIND/${id}`,
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            )
                            .then(res => {
                                if (res.data == 2) {
                                    this.$vs.notify({
                                        title: "Ticket ya asignado ",
                                        text:
                                            "Si necesita modificarlo vaya a Modificar Ticket ",
                                        color: "danger",
                                        position: "top-right"
                                    });
                                } else if (this.$route.path !== path) {
                                    this.$router.push(path).catch(err => {});
                                }
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
                    } else if (idCategoria == 4) {
                        const path = {
                            name: "AsignarSolicitudAgenteCA",
                            params: {
                                id: `${id}`,
                                uuid: `${uuid}`,
                                id_user: `${id_user}`
                            }
                        };
                        axios
                            .get(
                                this.localVal +
                                    `/api/Agente/ValidarTicketAsignadoAP/${id}`,
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            )
                            .then(res => {
                                if (res.data == 2) {
                                    this.$vs.notify({
                                        title: "Ticket ya asignado ",
                                        text:
                                            "Si necesita modificarlo vaya a Modificar Ticket ",
                                        color: "danger",
                                        position: "top-right"
                                    });
                                } else if (this.$route.path !== path) {
                                    this.$router.push(path).catch(err => {});
                                }
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
                    }
                } catch (error) {
                    console.log("Error al capturar datos");
                }
            } else if (sessionStorage.getItem("permiso_usuario") == 5) {
                try {
                    const path = {
                        name: "AsignarSolicitudAgente",
                        params: {
                            id: `${id}`,
                            uuid: `${uuid}`,
                            id_user: `${id_user}`
                        }
                    };
                    axios
                        .get(
                            this.localVal +
                                `/api/Agente/ValidarTicketAsignado/${id}`,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            if (res.data == 2) {
                                this.$vs.notify({
                                    title: "Ticket ya asignado ",
                                    text:
                                        "Si necesita modificarlo vaya a Modificar Ticket ",
                                    color: "danger",
                                    position: "top-right"
                                });
                            } else if (this.$route.path !== path) {
                                this.$router.push(path).catch(err => {});
                            }
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
                } catch (error) {
                    console.log("Error al capturar datos");
                }
            } else if (sessionStorage.getItem("permiso_usuario") == 6) {
                try {
                    const path = {
                        name: "AsignarSolicitudAgenteEM",
                        params: {
                            id: `${id}`,
                            uuid: `${uuid}`,
                            id_user: `${id_user}`
                        }
                    };
                    axios
                        .get(
                            this.localVal +
                                `/api/Agente/ValidarTicketAsignadoEM/${id}`,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            if (res.data == 2) {
                                this.$vs.notify({
                                    title: "Ticket ya asignado ",
                                    text:
                                        "Si necesita modificarlo vaya a Modificar Ticket ",
                                    color: "danger",
                                    position: "top-right"
                                });
                            } else if (this.$route.path !== path) {
                                this.$router.push(path).catch(err => {});
                            }
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
                } catch (error) {
                    console.log("Error al capturar datos");
                }
            } else if (sessionStorage.getItem("permiso_usuario") == 7) {
                try {
                    const path = {
                        name: "AsignarSolicitudAgenteIND",
                        params: {
                            id: `${id}`,
                            uuid: `${uuid}`,
                            id_user: `${id_user}`
                        }
                    };
                    axios
                        .get(
                            this.localVal +
                                `/api/Agente/ValidarTicketAsignadoIND/${id}`,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            if (res.data == 2) {
                                this.$vs.notify({
                                    title: "Ticket ya asignado ",
                                    text:
                                        "Si necesita modificarlo vaya a Modificar Ticket ",
                                    color: "danger",
                                    position: "top-right"
                                });
                            } else if (this.$route.path !== path) {
                                this.$router.push(path).catch(err => {});
                            }
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
                } catch (error) {
                    console.log("Error al capturar datos");
                }
            } else if (sessionStorage.getItem("permiso_usuario") == 8) {
                try {
                    const path = {
                        name: "AsignarSolicitudAgenteCA",
                        params: {
                            id: `${id}`,
                            uuid: `${uuid}`,
                            id_user: `${id_user}`
                        }
                    };
                    axios
                        .get(
                            this.localVal +
                                `/api/Agente/ValidarTicketAsignadoAP/${id}`,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            if (res.data == 2) {
                                this.$vs.notify({
                                    title: "Ticket ya asignado ",
                                    text:
                                        "Si necesita modificarlo vaya a Modificar Ticket ",
                                    color: "danger",
                                    position: "top-right"
                                });
                            } else if (this.$route.path !== path) {
                                this.$router.push(path).catch(err => {});
                            }
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
                } catch (error) {
                    console.log("Error al capturar datos");
                }
            }
        },
        abrirNotificacion(id, uuid, id_user, idCategoria) {
            if (sessionStorage.getItem("permiso_usuario") == 1) {
                try {
                    if (idCategoria == 1) {
                        const path = {
                            name: "ModificarSolicitudAgente",
                            params: {
                                id: `${id}`,
                                uuid: `${uuid}`,
                                id_user: `${id_user}`
                            }
                        };
                        axios
                            .get(
                                this.localVal +
                                    `/api/Agente/ValidarTicketAsignadoMod/${id}`,
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
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
                                } else if (this.$route.path !== path) {
                                    this.$router.push(path).catch(err => {});
                                }
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
                    } else if (idCategoria == 2) {
                        const path = {
                            name: "ModificarSolicitudAgenteEM",
                            params: {
                                id: `${id}`,
                                uuid: `${uuid}`,
                                id_user: `${id_user}`
                            }
                        };
                        axios
                            .get(
                                this.localVal +
                                    `/api/Agente/ValidarTicketAsignadoModEM/${id}`,
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
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
                                } else if (this.$route.path !== path) {
                                    this.$router.push(path).catch(err => {});
                                }
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
                    } else if (idCategoria == 3) {
                        const path = {
                            name: "ModificarSolicitudAgenteIND",
                            params: {
                                id: `${id}`,
                                uuid: `${uuid}`,
                                id_user: `${id_user}`
                            }
                        };
                        axios
                            .get(
                                this.localVal +
                                    `/api/Agente/ValidarTicketAsignadoModIND/${id}`,
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
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
                                } else if (this.$route.path !== path) {
                                    this.$router.push(path).catch(err => {});
                                }
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
                    } else if (idCategoria == 4) {
                        const path = {
                            name: "ModificarSolicitudAgenteCA",
                            params: {
                                id: `${id}`,
                                uuid: `${uuid}`,
                                id_user: `${id_user}`
                            }
                        };
                        axios
                            .get(
                                this.localVal +
                                    `/api/Agente/ValidarTicketAsignadoModAP/${id}`,
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
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
                                } else if (this.$route.path !== path) {
                                    this.$router.push(path).catch(err => {});
                                }
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
                    }
                } catch (error) {
                    console.log("Error al capturar datos");
                }
            } else if (sessionStorage.getItem("permiso_usuario") == 5) {
                try {
                    const path = {
                        name: "ModificarSolicitudAgente",
                        params: {
                            id: `${id}`,
                            uuid: `${uuid}`,
                            id_user: `${id_user}`
                        }
                    };
                    axios
                        .get(
                            this.localVal +
                                `/api/Agente/ValidarTicketAsignadoMod/${id}`,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
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
                            } else if (this.$route.path !== path) {
                                this.$router.push(path).catch(err => {});
                            }
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
                } catch (error) {
                    console.log("Error al capturar datos");
                }
            } else if (sessionStorage.getItem("permiso_usuario") == 6) {
                try {
                    const path = {
                        name: "ModificarSolicitudAgenteEM",
                        params: {
                            id: `${id}`,
                            uuid: `${uuid}`,
                            id_user: `${id_user}`
                        }
                    };
                    axios
                        .get(
                            this.localVal +
                                `/api/Agente/ValidarTicketAsignadoModEM/${id}`,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
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
                            } else if (this.$route.path !== path) {
                                this.$router.push(path).catch(err => {});
                            }
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
                } catch (error) {
                    console.log("Error al capturar datos");
                }
            } else if (sessionStorage.getItem("permiso_usuario") == 7) {
                try {
                    const path = {
                        name: "ModificarSolicitudAgenteIND",
                        params: {
                            id: `${id}`,
                            uuid: `${uuid}`,
                            id_user: `${id_user}`
                        }
                    };
                    axios
                        .get(
                            this.localVal +
                                `/api/Agente/ValidarTicketAsignadoModIND/${id}`,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
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
                            } else if (this.$route.path !== path) {
                                this.$router.push(path).catch(err => {});
                            }
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
                } catch (error) {
                    console.log("Error al capturar datos");
                }
            } else if (sessionStorage.getItem("permiso_usuario") == 8) {
                try {
                    const path = {
                        name: "ModificarSolicitudAgenteCA",
                        params: {
                            id: `${id}`,
                            uuid: `${uuid}`,
                            id_user: `${id_user}`
                        }
                    };
                    axios
                        .get(
                            this.localVal +
                                `/api/Agente/ValidarTicketAsignadoModAP/${id}`,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
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
                            } else if (this.$route.path !== path) {
                                this.$router.push(path).catch(err => {});
                            }
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
                } catch (error) {
                    console.log("Error al capturar datos");
                }
            }
        },
        cargaNotificaciones() {
            if (sessionStorage.getItem("permiso_usuario") == 1) {
                try {
                    axios
                        .get(
                            this.localVal + "/api/Agente/TraerNotificacionesJ",
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            let listado = [];
                            listado = res.data;
                            let b = [];
                            let obj = {};
                            listado.forEach((value, index) => {
                                obj = {};
                                obj = {
                                    id: value.id,
                                    idCategoria: value.id_categoria,
                                    uuid: value.uuid,
                                    id_user: value.id_user,
                                    index: index,
                                    title: value.descripcionTipoReparacion,
                                    msg: value.msg,
                                    icon: "MessageSquareIcon",
                                    category: "danger"
                                };
                                b.push(obj);
                            });
                            this.unreadNotifications = b;
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
                } catch (error) {
                    console.log("Error al recuperar datos");
                }
            } else if (sessionStorage.getItem("permiso_usuario") == 5) {
                try {
                    axios
                        .get(
                            this.localVal + "/api/Agente/TraerNotificaciones",
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            let listado = [];
                            listado = res.data;
                            let b = [];
                            let obj = {};
                            listado.forEach((value, index) => {
                                obj = {};
                                obj = {
                                    id: value.id,
                                    uuid: value.uuid,
                                    id_user: value.id_user,
                                    index: index,
                                    title: value.descripcionTipoReparacion,
                                    msg: value.msg,
                                    icon: "MessageSquareIcon",
                                    category: "danger"
                                };
                                b.push(obj);
                            });
                            this.unreadNotifications = b;
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
                } catch (error) {
                    console.log("Error al recuperar datos");
                }
            } else if (sessionStorage.getItem("permiso_usuario") == 6) {
                try {
                    axios
                        .get(
                            this.localVal + "/api/Agente/TraerNotificacionesEM",
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            let listado = [];
                            listado = res.data;
                            let b = [];
                            let obj = {};
                            listado.forEach((value, index) => {
                                obj = {};
                                obj = {
                                    id: value.id,
                                    uuid: value.uuid,
                                    id_user: value.id_user,
                                    index: index,
                                    title: value.descripcionTipoReparacion,
                                    msg: value.msg,
                                    icon: "MessageSquareIcon",
                                    category: "danger"
                                };
                                b.push(obj);
                            });
                            this.unreadNotifications = b;
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
                } catch (error) {
                    console.log("Error al recuperar datos");
                }
            } else if (sessionStorage.getItem("permiso_usuario") == 7) {
                try {
                    axios
                        .get(
                            this.localVal +
                                "/api/Agente/TraerNotificacionesIND",
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            let listado = [];
                            listado = res.data;
                            let b = [];
                            let obj = {};
                            listado.forEach((value, index) => {
                                obj = {};
                                obj = {
                                    id: value.id,
                                    uuid: value.uuid,
                                    id_user: value.id_user,
                                    index: index,
                                    title: value.descripcionTipoReparacion,
                                    msg: value.msg,
                                    icon: "MessageSquareIcon",
                                    category: "danger"
                                };
                                b.push(obj);
                            });
                            this.unreadNotifications = b;
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
                } catch (error) {
                    console.log("Error al recuperar datos");
                }
            } else if (sessionStorage.getItem("permiso_usuario") == 8) {
                try {
                    axios
                        .get(
                            this.localVal + "/api/Agente/TraerNotificacionesAP",
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            let listado = [];
                            listado = res.data;
                            let b = [];
                            let obj = {};
                            listado.forEach((value, index) => {
                                obj = {};
                                obj = {
                                    id: value.id,
                                    uuid: value.uuid,
                                    id_user: value.id_user,
                                    index: index,
                                    title: value.descripcionTipoReparacion,
                                    msg: value.msg,
                                    icon: "MessageSquareIcon",
                                    category: "danger"
                                };
                                b.push(obj);
                            });
                            this.unreadNotifications = b;
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
                } catch (error) {
                    console.log("Error al recuperar datos");
                }
            }
        },
        cargaNotificacionesN() {
            if (sessionStorage.getItem("permiso_usuario") == 1) {
                try {
                    axios
                        .get(
                            this.localVal + "/api/Agente/TraerNotificacionesNJ",
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            let listado = [];
                            listado = res.data;
                            let b = [];
                            let obj = {};
                            listado.forEach((value, index) => {
                                obj = {};
                                obj = {
                                    id: value.id,
                                    idCategoria: value.id_categoria,
                                    uuid: value.uuid,
                                    id_user: value.id_user,
                                    index: index,
                                    title: value.descripcionTipoReparacion,
                                    msg: value.msg,
                                    icon: "MessageSquareIcon",
                                    category: "danger"
                                };
                                b.push(obj);
                            });
                            this.unreadNotificationsN = b;
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
                } catch (error) {
                    console.log("Error al recuperar datos");
                }
            } else if (sessionStorage.getItem("permiso_usuario") == 5) {
                try {
                    axios
                        .get(
                            this.localVal + "/api/Agente/TraerNotificacionesN",
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            let listado = [];
                            listado = res.data;
                            let b = [];
                            let obj = {};
                            listado.forEach((value, index) => {
                                obj = {};
                                obj = {
                                    id: value.id,
                                    uuid: value.uuid,
                                    id_user: value.id_user,
                                    index: index,
                                    title: value.descripcionTipoReparacion,
                                    msg: value.msg,
                                    icon: "MessageSquareIcon",
                                    category: "danger"
                                };
                                b.push(obj);
                            });
                            this.unreadNotificationsN = b;
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
                } catch (error) {
                    console.log("Error al recuperar datos");
                }
            } else if (sessionStorage.getItem("permiso_usuario") == 6) {
                try {
                    axios
                        .get(
                            this.localVal +
                                "/api/Agente/TraerNotificacionesNEM",
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            let listado = [];
                            listado = res.data;
                            let b = [];
                            let obj = {};
                            listado.forEach((value, index) => {
                                obj = {};
                                obj = {
                                    id: value.id,
                                    uuid: value.uuid,
                                    id_user: value.id_user,
                                    index: index,
                                    title: value.descripcionTipoReparacion,
                                    msg: value.msg,
                                    icon: "MessageSquareIcon",
                                    category: "danger"
                                };
                                b.push(obj);
                            });
                            this.unreadNotificationsN = b;
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
                } catch (error) {
                    console.log("Error al recuperar datos");
                }
            } else if (sessionStorage.getItem("permiso_usuario") == 7) {
                try {
                    axios
                        .get(
                            this.localVal +
                                "/api/Agente/TraerNotificacionesNIND",
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            let listado = [];
                            listado = res.data;
                            let b = [];
                            let obj = {};
                            listado.forEach((value, index) => {
                                obj = {};
                                obj = {
                                    id: value.id,
                                    uuid: value.uuid,
                                    id_user: value.id_user,
                                    index: index,
                                    title: value.descripcionTipoReparacion,
                                    msg: value.msg,
                                    icon: "MessageSquareIcon",
                                    category: "danger"
                                };
                                b.push(obj);
                            });
                            this.unreadNotificationsN = b;
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
                } catch (error) {
                    console.log("Error al recuperar datos");
                }
            } else if (sessionStorage.getItem("permiso_usuario") == 8) {
                try {
                    axios
                        .get(
                            this.localVal +
                                "/api/Agente/TraerNotificacionesNAP",
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            let listado = [];
                            listado = res.data;
                            let b = [];
                            let obj = {};
                            listado.forEach((value, index) => {
                                obj = {};
                                obj = {
                                    id: value.id,
                                    uuid: value.uuid,
                                    id_user: value.id_user,
                                    index: index,
                                    title: value.descripcionTipoReparacion,
                                    msg: value.msg,
                                    icon: "MessageSquareIcon",
                                    category: "danger"
                                };
                                b.push(obj);
                            });
                            this.unreadNotificationsN = b;
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
                } catch (error) {
                    console.log("Error al recuperar datos");
                }
            }
        },
        cargaKPI() {
            if (sessionStorage.getItem("permiso_usuario") == 1) {
                try {
                    axios
                        .get(
                            this.localVal + "/api/Agente/TraerKPITicketsTotal",
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            let data = res.data;
                            this.totalPTickets = data[0].OpenTickets;
                            this.totalNTickets = data[0].NewTickets;
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
                } catch (error) {
                    console.log("Error al recuperar datos");
                }
            } else if (sessionStorage.getItem("permiso_usuario") == 5) {
                try {
                    axios
                        .get(
                            this.localVal + "/api/Agente/TraerKPITicketsTotal",
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            let data = res.data;
                            this.totalPTickets = data[0].OpenTickets;
                            this.totalNTickets = data[0].NewTickets;
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
                } catch (error) {
                    console.log("Error al recuperar datos");
                }
            } else if (sessionStorage.getItem("permiso_usuario") == 6) {
                try {
                    axios
                        .get(
                            this.localVal +
                                "/api/Agente/TraerKPITicketsTotalEM",
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            let data = res.data;
                            this.totalPTickets = data[0].OpenTickets;
                            this.totalNTickets = data[0].NewTickets;
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
                } catch (error) {
                    console.log("Error al recuperar datos");
                }
            } else if (sessionStorage.getItem("permiso_usuario") == 7) {
                try {
                    axios
                        .get(
                            this.localVal +
                                "/api/Agente/TraerKPITicketsTotalIND",
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            let data = res.data;
                            this.totalPTickets = data[0].OpenTickets;
                            this.totalNTickets = data[0].NewTickets;
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
                } catch (error) {
                    console.log("Error al recuperar datos");
                }
            } else if (sessionStorage.getItem("permiso_usuario") == 8) {
                try {
                    axios
                        .get(
                            this.localVal +
                                "/api/Agente/TraerKPITicketsTotalAP",
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            let data = res.data;
                            this.totalPTickets = data[0].OpenTickets;
                            this.totalNTickets = data[0].NewTickets;
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
                } catch (error) {
                    console.log("Error al recuperar datos");
                }
            }
        }
    },
    created() {
        axios.interceptors.request.use(
            function(config) {
                return config;
            },
            function(error) {
                router.push("/pages/login");
                return Promise.reject(error);
            }
        );

        axios.interceptors.response.use(
            function(response) {
                return response;
            },
            function(error) {
                router.push("/pages/login");
                return Promise.reject(error);
            }
        );

        this.cargaNotificaciones();
        this.cargaNotificacionesN();
        this.cargaKPI();
    }
};
</script>
