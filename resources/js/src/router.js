/*=========================================================================================
  File Name: router.js
  Description: Routes for vue-router. Lazy loading is enabled.
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);

const router = new Router({
    mode: "history",
    base: "/",
    scrollBehavior() {
        return {
            x: 0,
            y: 0
        };
    },
    routes: [
        {
            path: "",
            redirect: "/pages/login"
        },
        {
            // =============================================================================
            // MAIN LAYOUT ROUTES
            // =============================================================================
            path: "",
            component: () => import("./layouts/main/MainUsuario.vue"),
            children: [
                // =============================================================================
                // Theme Routes
                // =============================================================================
                {
                    path: "/home",
                    name: "home",
                    component: () => import("./views/Home.vue")
                },
                {
                    path: "/Listadosolicitudes",
                    name: "Listadosolicitudes",
                    component: () => import("./views/Listadosolicitudes.vue")
                },
                {
                    path: "/GenerarSolicitud",
                    name: "GenerarSolicitud",
                    component: () => import("./views/GenerarSolicitud.vue")
                },
                {
                    path: "/HomeTrabajador",
                    name: "InicioTrabajador",
                    component: () =>
                        import("./views/trabajadorView/homeTrabajador.vue")
                },

                {
                    path: "/ListadoTicketsTrabajador",
                    name: "ListadoTicketsTrabajador",
                    component: () =>
                        import(
                            "./views/trabajadorView/ListadoTicketsTrabajador.vue"
                        )
                },
                {
                    path: "/InformacionSolicitud/:id,:uuid,:id_categoria",
                    name: "InformacionSolicitud",
                    component: () => import("./views/InformacionSolicitud.vue")
                },
                {
                    path: "/ModificarTicketUsuario/:id,:uuid,:id_categoria",
                    name: "ModificarTicketUsuario",
                    component: () =>
                        import("./views/ModificarTicketUsuario.vue")
                },
                {
                    path:
                        "/trabajadorView/InformacionSolicitud/:id,:uuid,:id_categoria",
                    name: "InformacionSolicitudTrabajador",
                    component: () =>
                        import(
                            "./views/trabajadorView/InformacionSolicitud.vue"
                        )
                },
                {
                    path: "/informaticaView/GenerarTicketI",
                    name: "GenerarTicketI",
                    component: () =>
                        import("./views/informaticaView/GenerarTicketI.vue")
                },
                {
                    path: "/informaticaView/ListadoTicketsI",
                    name: "ListadoTicketsI",
                    component: () =>
                        import("./views/informaticaView/ListadoTicketsI.vue")
                },
                {
                    path: "/informaticaView/homeInformatica",
                    name: "homeInformatica",
                    component: () =>
                        import("./views/informaticaView/homeInformatica.vue")
                },
                {
                    path: "/informaticaView/AsignarSolicitudAgenteI",
                    name: "AsignarSolicitudAgenteI",
                    component: () =>
                        import(
                            "./views/informaticaView/AsignarSolicitudAgenteI.vue"
                        )
                },
                {
                    path:
                        "/informaticaView/InformacionSolicitudAgenteI/:id,:uuid",
                    name: "InformacionSolicitudAgenteI",
                    component: () =>
                        import(
                            "./views/informaticaView/InformacionSolicitudAgenteI.vue"
                        )
                },
                {
                    path:
                        "/informaticaView/InformacionSolicitudEliminadosI/:id,:uuid",
                    name: "InformacionSolicitudEliminadosI",
                    component: () =>
                        import(
                            "./views/informaticaView/InformacionSolicitudEliminadosI.vue"
                        )
                },
                {
                    path:
                        "/informaticaView/InformacionSolicitudFinalizadosI/:id,:uuid",
                    name: "InformacionSolicitudFinalizadosI",
                    component: () =>
                        import(
                            "./views/informaticaView/InformacionSolicitudFinalizadosI.vue"
                        )
                },
                {
                    path: "/informaticaView/ModificarSolicitudAgenteI",
                    name: "ModificarSolicitudAgenteI",
                    component: () =>
                        import(
                            "./views/informaticaView/ModificarSolicitudAgenteI.vue"
                        )
                }
            ]
        },
        {
            // =============================================================================
            // MAIN LAYOUT ROUTES
            // =============================================================================
            path: "",
            component: () => import("./layouts/main/MainAgente.vue"),
            children: [
                // =============================================================================
                // Theme Routes
                // =============================================================================
                {
                    path: "/agenteView/HomeAgente",
                    name: "Inicio",
                    component: () => import("./views/agenteView/HomeAgente.vue")
                },
                {
                    path: "/agenteView/CalendarioAscensores",
                    name: "CalendarioAscensores",
                    component: () =>
                        import("./views/agenteView/CalendarioAscensores.vue")
                },
                {
                    path: "/agenteView/CalendarioCalderas",
                    name: "CalendarioCalderas",
                    component: () =>
                        import("./views/agenteView/CalendarioCalderas.vue")
                },
                {
                    path: "/agenteView/CalendarioElectricos",
                    name: "CalendarioElectricos",
                    component: () =>
                        import("./views/agenteView/CalendarioElectricos.vue")
                },
                {
                    path: "/agenteView/CalendarioOxigenistas",
                    name: "CalendarioOxigenistas",
                    component: () =>
                        import("./views/agenteView/CalendarioOxigenistas.vue")
                },
                {
                    path: "/agenteView/CalendarioTallerIndustrial",
                    name: "CalendarioTallerIndustrial",
                    component: () =>
                        import(
                            "./views/agenteView/CalendarioTallerIndustrial.vue"
                        )
                },
                {
                    path: "/agenteView/CalendarioTGasfiter",
                    name: "CalendarioTGasfiter",
                    component: () =>
                        import("./views/agenteView/CalendarioTGasfiter.vue")
                },
                {
                    path: "/agenteView/CalendarioCTelefonica",
                    name: "CalendarioCTelefonica",
                    component: () =>
                        import("./views/agenteView/CalendarioCTelefonica.vue")
                },
                {
                    path: "/agenteView/GenerarTicket",
                    name: "GenerarTicket",
                    component: () =>
                        import("./views/agenteView/GenerarTicket.vue")
                },
                {
                    path: "/AgregarUsuarioJefe",
                    name: "agregarUsuarioJefe",
                    component: () =>
                        import("./views/adminView/AgregarUsuarioJefe.vue")
                },
                {
                    path: "/MenuEdificios",
                    name: "menuEdificios",
                    component: () =>
                        import("./views/adminView/MenuEdificios.vue")
                },
                {
                    path: "/MenuServicios",
                    name: "menuServicios",
                    component: () =>
                        import("./views/adminView/MenuServicios.vue")
                },
                {
                    path: "/MenuUbicacionEspecifica",
                    name: "menuUbicacionEspecifica",
                    component: () =>
                        import("./views/adminView/MenuUbicacionEspecifica.vue")
                },
                {
                    path: "/AgregarTrabajador",
                    name: "agregarTrabajador",
                    component: () =>
                        import("./views/adminView/AgregarTrabajador.vue")
                },
                {
                    path: "/ModificarTrabajador",
                    name: "modificarTrabajador",
                    component: () =>
                        import("./views/adminView/ModificarTrabajador.vue")
                },
                {
                    path: "/AgregarSupervisor",
                    name: "agregarSupervisor",
                    component: () =>
                        import("./views/adminView/AgregarSupervisor.vue")
                },
                {
                    path: "/ModificarSupervisor",
                    name: "modificarSupervisor",
                    component: () =>
                        import("./views/adminView/ModificarSupervisor.vue")
                },
                {
                    path: "/HabilitarDesabilitarUsuarios",
                    name: "habilitarDesabilitarUsuarios",
                    component: () =>
                        import(
                            "./views/adminView/HabilitarDesabilitarUsuarios.vue"
                        )
                },
                {
                    path: "/MenuReparacion",
                    name: "menuReparacion",
                    component: () =>
                        import("./views/adminView/MenuReparacion.vue")
                },
                {
                    path: "/MenuEspecialidad",
                    name: "menuEspecialidad",
                    component: () =>
                        import("./views/adminView/MenuEspecialidad.vue")
                },
                {
                    path: "/MenuCargo",
                    name: "menu Cargo",
                    component: () => import("./views/adminView/MenuCargo.vue")
                },
                {
                    path: "/ModificarUsuarioJefe",
                    name: "modificar Usuario Jefe",
                    component: () =>
                        import("./views/adminView/ModificarUsuarioJefe.vue")
                },
                {
                    path: "/ModificarSubroganteJefe",
                    name: "modificar Subrogrante Jefe",
                    component: () =>
                        import("./views/adminView/ModificarSubroganteJefe.vue")
                },
                {
                    path: "/AgregarSubroganteJefe",
                    name: "agregarSubroganteJefe",
                    component: () =>
                        import("./views/adminView/AgregarSubroganteJefe.vue")
                },
                {
                    path: "/agenteView/ListadoSolicitudes",
                    name: "ListadoSolicitudesAgente",
                    component: () =>
                        import("./views/agenteView/ListadoSolicitudes.vue")
                },
                {
                    path: "/agenteView/InformacionSolicitud/:id,:uuid",
                    name: "InformacionSolicitudAgente",
                    component: () =>
                        import("./views/agenteView/InformacionSolicitud.vue")
                },
                {
                    path: "/agenteView/InformacionSolicitudCA/:id,:uuid",
                    name: "InformacionSolicitudAgenteCA",
                    component: () =>
                        import("./views/agenteView/InformacionSolicitudCA.vue")
                },
                {
                    path: "/agenteView/InformacionSolicitudEM/:id,:uuid",
                    name: "InformacionSolicitudAgenteEM",
                    component: () =>
                        import("./views/agenteView/InformacionSolicitudEM.vue")
                },
                {
                    path: "/agenteView/InformacionSolicitudIND/:id,:uuid",
                    name: "InformacionSolicitudAgenteIND",
                    component: () =>
                        import("./views/agenteView/InformacionSolicitudIND.vue")
                },
                {
                    path:
                        "/agenteView/InformacionSolicitudEliminados/:id,:uuid",
                    name: "InformacionSolicitudEliminados",
                    component: () =>
                        import(
                            "./views/agenteView/InformacionSolicitudEliminados.vue"
                        )
                },
                {
                    path:
                        "/agenteView/InformacionSolicitudEliminadosCA/:id,:uuid",
                    name: "InformacionSolicitudEliminadosCA",
                    component: () =>
                        import(
                            "./views/agenteView/InformacionSolicitudEliminadosCA.vue"
                        )
                },
                {
                    path:
                        "/agenteView/InformacionSolicitudEliminadosEM/:id,:uuid",
                    name: "InformacionSolicitudEliminadosEM",
                    component: () =>
                        import(
                            "./views/agenteView/InformacionSolicitudEliminadosEM.vue"
                        )
                },
                {
                    path:
                        "/agenteView/InformacionSolicitudEliminadosIND/:id,:uuid",
                    name: "InformacionSolicitudEliminadosIND",
                    component: () =>
                        import(
                            "./views/agenteView/InformacionSolicitudEliminadosIND.vue"
                        )
                },
                {
                    path:
                        "/agenteView/InformacionSolicitudFinalizadosCA/:id,:uuid",
                    name: "InformacionSolicitudFinalizadosCA",
                    component: () =>
                        import(
                            "./views/agenteView/InformacionSolicitudFinalizadosCA.vue"
                        )
                },
                {
                    path:
                        "/agenteView/InformacionSolicitudFinalizadosEM/:id,:uuid",
                    name: "InformacionSolicitudFinalizadosEM",
                    component: () =>
                        import(
                            "./views/agenteView/InformacionSolicitudFinalizadosEM.vue"
                        )
                },
                {
                    path:
                        "/agenteView/InformacionSolicitudFinalizadosIND/:id,:uuid",
                    name: "InformacionSolicitudFinalizadosIND",
                    component: () =>
                        import(
                            "./views/agenteView/InformacionSolicitudFinalizadosIND.vue"
                        )
                },
                {
                    path:
                        "/agenteView/InformacionSolicitudFinalizadosINF/:id,:uuid",
                    name: "InformacionSolicitudFinalizadosINF",
                    component: () =>
                        import(
                            "./views/agenteView/InformacionSolicitudFinalizadosINF.vue"
                        )
                },
                {
                    path: "/agenteView/ListadoTicketsEM",
                    name: "ListadoTicketsEM",
                    component: () =>
                        import("./views/agenteView/ListadoTicketsEM.vue")
                },
                {
                    path: "/agenteView/GenerarTicketEM",
                    name: "GenerarTicketEM",
                    component: () =>
                        import("./views/agenteView/GenerarTicketEM.vue")
                },
                {
                    path: "/agenteView/ListadoTicketsIND",
                    name: "ListadoTicketsIND",
                    component: () =>
                        import("./views/agenteView/ListadoTicketsIND.vue")
                },
                {
                    path: "/agenteView/ListadoTicketsCA",
                    name: "ListadoTicketsCA",
                    component: () =>
                        import("./views/agenteView/ListadoTicketsCA.vue")
                },
                {
                    path: "/agenteView/GenerarTicketIND",
                    name: "GenerarTicketIND",
                    component: () =>
                        import("./views/agenteView/GenerarTicketIND.vue")
                },
                {
                    path: "/agenteView/GenerarTicketIDBase/:id,:uuid",
                    name: "GenerarTicketIDBase",
                    component: () =>
                        import("./views/agenteView/GenerarTicketIDBase.vue")
                },
                {
                    path: "/agenteView/GenerarTicketRAP/:id,:uuid",
                    name: "GenerarTicketRAP",
                    component: () =>
                        import("./views/agenteView/GenerarTicketRAP.vue")
                },
                {
                    path: "/agenteView/GenerarTicketCA",
                    name: "GenerarTicketCA",
                    component: () =>
                        import("./views/agenteView/GenerarTicketCA.vue")
                },
                {
                    path:
                        "/agenteView/ModificarCategoriaTicket/:id,:uuid,:id_cat",
                    name: "ModificarCategoriaTicket",
                    component: () =>
                        import(
                            "./views/agenteView/ModificarCategoriaTicket.vue"
                        )
                },
                {
                    path: "/agenteView/FormularioAsignar/:id,:uuid,:id_user",
                    name: "AsignarSolicitudAgente",
                    component: () =>
                        import("./views/agenteView/FormularioAsignar.vue")
                },
                {
                    path: "/agenteView/FormularioAsignarCA/:id,:uuid",
                    name: "AsignarSolicitudAgenteCA",
                    component: () =>
                        import("./views/agenteView/FormularioAsignarCA.vue")
                },
                {
                    path: "/agenteView/FormularioAsignarEM/:id,:uuid",
                    name: "AsignarSolicitudAgenteEM",
                    component: () =>
                        import("./views/agenteView/FormularioAsignarEM.vue")
                },
                {
                    path: "/agenteView/FormularioAsignarIND/:id,:uuid",
                    name: "AsignarSolicitudAgenteIND",
                    component: () =>
                        import("./views/agenteView/FormularioAsignarIND.vue")
                },
                {
                    path: "/agenteView/FormularioModificar/:id,:uuid,:id_user",
                    name: "ModificarSolicitudAgente",
                    component: () =>
                        import("./views/agenteView/FormularioModificar.vue")
                },
                {
                    path:
                        "/agenteView/FormularioModificarEM/:id,:uuid,:id_user",
                    name: "ModificarSolicitudAgenteEM",
                    component: () =>
                        import("./views/agenteView/FormularioModificarEM.vue")
                },
                {
                    path:
                        "/agenteView/FormularioModificarCA/:id,:uuid,:id_user",
                    name: "ModificarSolicitudAgenteCA",
                    component: () =>
                        import("./views/agenteView/FormularioModificarCA.vue")
                },
                {
                    path:
                        "/agenteView/FormularioModificarIND/:id,:uuid,:id_user ",
                    name: "ModificarSolicitudAgenteIND",
                    component: () =>
                        import("./views/agenteView/FormularioModificarIND.vue")
                },
                {
                    path: "/agenteView/ReporteExDiaInfra",
                    name: "ReporteExDiaInfra",
                    component: () =>
                        import("./views/agenteView/ReporteExDiaInfra.vue")
                },

                {
                    path: "/agenteView/ReporteExDiaEM",
                    name: "ReporteExDiaEM",
                    component: () =>
                        import("./views/agenteView/ReporteExDiaEM.vue")
                },

                {
                    path: "/agenteView/ReporteExDiaIND",
                    name: "ReporteExDiaIND",
                    component: () =>
                        import("./views/agenteView/ReporteExDiaIND.vue")
                },

                {
                    path: "/agenteView/ReporteExDiaCA",
                    name: "ReporteExDiaCA",
                    component: () =>
                        import("./views/agenteView/ReporteExDiaCA.vue")
                },
                {
                    path: "/agenteView/CalendarioObras",
                    name: "CalendarioObras",
                    component: () =>
                        import("./views/agenteView/CalendarioObras.vue")
                },
                {
                    path: "/agenteView/CalendarioGIndustrial",
                    name: "CalendarioGIndustrial",
                    component: () =>
                        import("./views/agenteView/CalendarioGIndustrial.vue")
                },
                {
                    path: "/agenteView/CalendarioMIndustrial",
                    name: "CalendarioMIndustrial",
                    component: () =>
                        import("./views/agenteView/CalendarioMIndustrial.vue")
                },
                {
                    path: "/agenteView/CalendarioMApoyoClinico",
                    name: "CalendarioMApoyoClinico",
                    component: () =>
                        import("./views/agenteView/CalendarioMApoyoClinico.vue")
                },
                {
                    path: "/agenteView/ListadoTotalTickets",
                    name: "ListadoTotalTickets",
                    component: () =>
                        import("./views/agenteView/ListadoTotalTickets.vue")
                },
                {
                    path: "/agenteView/ReportesJefatura",
                    name: "ReportesJefatura",
                    component: () =>
                        import("./views/agenteView/ReportesJefatura.vue")
                },
                {
                    path: "/agenteView/ListadoSolicitudesHistorico",
                    name: "ListadoSolicitudesHistorico",
                    component: () =>
                        import(
                            "./views/agenteView/ListadoSolicitudesHistorico.vue"
                        )
                },
                {
                    path: "/agenteView/ListadoTicketsEMHistorico",
                    name: "ListadoTicketsEMHistorico",
                    component: () =>
                        import(
                            "./views/agenteView/ListadoTicketsEMHistorico.vue"
                        )
                },
                {
                    path: "/agenteView/ListadoTicketsINDHistorico",
                    name: "ListadoTicketsINDHistorico",
                    component: () =>
                        import(
                            "./views/agenteView/ListadoTicketsINDHistorico.vue"
                        )
                },
                {
                    path: "/agenteView/ListadoTicketsCAHistorico",
                    name: "ListadoTicketsCAHistorico",
                    component: () =>
                        import(
                            "./views/agenteView/ListadoTicketsCAHistorico.vue"
                        )
                }
            ]
        },
        // =============================================================================
        // FULL PAGE LAYOUTS
        // =============================================================================
        {
            path: "",
            component: () => import("@/layouts/full-page/FullPage.vue"),
            children: [
                // =============================================================================
                // PAGES
                // =============================================================================
                {
                    path: "/pages/login",
                    name: "page-login",
                    component: () => import("@/views/pages/Login.vue")
                },
                {
                    path: "/pages/error-404",
                    name: "page-error-404",
                    component: () => import("@/views/pages/Error404.vue")
                }
            ]
        },
        // Redirect to 404 page, if no match found
        {
            path: "*",
            redirect: "/pages/error-404"
        }
    ]
});

router.afterEach(() => {
    // Remove initial loading
    const appLoading = document.getElementById("loading-bg");
    if (appLoading) {
        appLoading.style.display = "none";
    }
});

export default router;
