/*=========================================================================================
  File Name: router.js
  Description: Routes for vue-router. Lazy loading is enabled.
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

const router = new Router({
    mode: 'history',
    base: '/',
    scrollBehavior() {
        return {
            x: 0,
            y: 0
        }
    },
    routes: [{
            path: '',
            redirect: '/pages/login'
        },
        {
            // =============================================================================
            // MAIN LAYOUT ROUTES
            // =============================================================================
            path: '',
            component: () =>
                import ('./layouts/main/MainUsuario.vue'),
            children: [
                // =============================================================================
                // Theme Routes
                // =============================================================================
                {
                    path: '/home',
                    name: 'home',
                    component: () =>
                        import ('./views/Home.vue')
                },
                {
                    path: '/Listadosolicitudes',
                    name: 'Listadosolicitudes',
                    component: () =>
                        import ('./views/Listadosolicitudes.vue')
                },
                {
                    path: '/GenerarSolicitud',
                    name: 'GenerarSolicitud',
                    component: () =>
                        import ('./views/GenerarSolicitud.vue')
                },
                {
                    path: '/HomeTrabajador',
                    name: 'InicioTrabajador',
                    component: () =>
                        import ('./views/trabajadorView/homeTrabajador.vue')
                },
                
                {
                    path: '/ListadoTicketsTrabajador',
                    name: 'ListadoTicketsTrabajador',
                    component: () =>
                        import ('./views/trabajadorView/ListadoTicketsTrabajador.vue')
                },
                {
                    path: '/ResolucionSolicitud/:id,:uuid',
                    name: 'ResolucionSolicitud',
                    component: () =>
                        import ('./views/trabajadorView/ResolucionSolicitud.vue')
                },
                {
                    path: '/InformacionSolicitud/:id,:uuid',
                    name: 'InformacionSolicitud',
                    component: () =>
                        import ('./views/InformacionSolicitud.vue')
                },
                {
                    path: '/ModificarTicketUsuario/:id,:uuid',
                    name: 'ModificarTicketUsuario',
                    component: () =>
                        import ('./views/ModificarTicketUsuario.vue')
                },
                {
                    path: '/InformacionSolicitud/:id,:uuid',
                    name: 'InformacionSolicitudTrabajador',
                    component: () =>
                        import ('./views/trabajadorView/InformacionSolicitud.vue')
                }


            ]
        },
        {
            // =============================================================================
            // MAIN LAYOUT ROUTES
            // =============================================================================
            path: '',
            component: () =>
                import ('./layouts/main/MainAgente.vue'),
            children: [
                // =============================================================================
                // Theme Routes
                // =============================================================================
                {
                    path: '/agenteView/HomeAgente',
                    name: 'Inicio',
                    component: () =>
                        import ('./views/agenteView/HomeAgente.vue')
                },
                {
                    path: '/agenteView/GenerarTicket',
                    name: 'GenerarTicket',
                    component: () =>
                        import ('./views/agenteView/GenerarTicket.vue')
                },
                {
                    path: '/AgregarUsuarioJefe',
                    name: 'agregarUsuarioJefe',
                    component: () =>
                        import ('./views/adminView/AgregarUsuarioJefe.vue')
                },
                {
                    path: '/AgregarSubroganteJefe',
                    name: 'agregarSubroganteJefe',
                    component: () =>
                        import ('./views/adminView/AgregarSubroganteJefe.vue')
                },
                {
                    path: '/agenteView/CalendarioSolicitudes',
                    name: 'Calendario Solicitudes',
                    component: () =>
                        import ('./views/agenteView/CalendarioSolicitudes.vue')
                },
                {
                    path: '/agenteView/ListadoSolicitudes',
                    name: 'ListadoSolicitudesAgente',
                    component: () =>
                        import ('./views/agenteView/ListadoSolicitudes.vue')
                },
                {
                    path: '/agenteView/InformacionSolicitud',
                    name: 'InformacionSolicitudAgente',
                    component: () =>
                        import ('./views/agenteView/InformacionSolicitud.vue')
                },
                {
                    path: '/agenteView/InformacionSolicitudCA',
                    name: 'InformacionSolicitudAgenteCA',
                    component: () =>
                        import ('./views/agenteView/InformacionSolicitudCA.vue')
                },
                {
                    path: '/agenteView/InformacionSolicitudEM',
                    name: 'InformacionSolicitudAgenteEM',
                    component: () =>
                        import ('./views/agenteView/InformacionSolicitudEM.vue')
                },
                {
                    path: '/agenteView/InformacionSolicitudIND',
                    name: 'InformacionSolicitudAgenteIND',
                    component: () =>
                        import ('./views/agenteView/InformacionSolicitudIND.vue')
                },
                {
                    path: '/agenteView/InformacionSolicitudEliminados',
                    name: 'InformacionSolicitudEliminados',
                    component: () =>
                        import ('./views/agenteView/InformacionSolicitudEliminados.vue')
                },
                {
                    path: '/agenteView/InformacionSolicitudEliminadosCA',
                    name: 'InformacionSolicitudEliminadosCA',
                    component: () =>
                        import ('./views/agenteView/InformacionSolicitudEliminadosCA.vue')
                },
                {
                    path: '/agenteView/InformacionSolicitudEliminadosEM',
                    name: 'InformacionSolicitudEliminadosEM',
                    component: () =>
                        import ('./views/agenteView/InformacionSolicitudEliminadosEM.vue')
                },
                {
                    path: '/agenteView/InformacionSolicitudEliminadosIND',
                    name: 'InformacionSolicitudEliminadosIND',
                    component: () =>
                        import ('./views/agenteView/InformacionSolicitudEliminadosIND.vue')
                },
                {
                    path: '/agenteView/DetalleTicket',
                    name: 'DetalleTicketImp',
                    component: () =>
                        import ('./views/agenteView/DetalleTicket.vue')
                },
                {
                    path: '/agenteView/ListadoTicketsEM',
                    name: 'ListadoTicketsEM',
                    component: () =>
                        import ('./views/agenteView/ListadoTicketsEM.vue')
                },
                {
                    path: '/agenteView/GenerarTicketEM',
                    name: 'GenerarTicketEM',
                    component: () =>
                        import ('./views/agenteView/GenerarTicketEM.vue')
                },
                {
                    path: '/agenteView/CalendarioSolicitudesEM',
                    name: 'CalendarioSolicitudesEM',
                    component: () =>
                        import ('./views/agenteView/CalendarioSolicitudesEM.vue')
                },
                {
                    path: '/agenteView/ListadoTicketsIND',
                    name: 'ListadoTicketsIND',
                    component: () =>
                        import ('./views/agenteView/ListadoTicketsIND.vue')
                },
                {
                    path: '/agenteView/ListadoTicketsCA',
                    name: 'ListadoTicketsCA',
                    component: () =>
                        import ('./views/agenteView/ListadoTicketsCA.vue')
                },
                {
                    path: '/agenteView/GenerarTicketIND',
                    name: 'GenerarTicketIND',
                    component: () =>
                        import ('./views/agenteView/GenerarTicketIND.vue')
                },
                {
                    path: '/agenteView/GenerarTicketCA',
                    name: 'GenerarTicketCA',
                    component: () =>
                        import ('./views/agenteView/GenerarTicketCA.vue')
                },
                {
                    path: '/agenteView/CalendarioSolicitudesIND',
                    name: 'CalendarioSolicitudesIND',
                    component: () =>
                        import ('./views/agenteView/CalendarioSolicitudesIND.vue')
                },
                {
                    path: '/agenteView/CalendarioSolicitudesCA',
                    name: 'CalendarioSolicitudesCA',
                    component: () =>
                        import ('./views/agenteView/CalendarioSolicitudesCA.vue')
                },
                {
                    path: '/agenteView/ModificarCategoriaTicket/:id,:uuid',
                    name: 'ModificarCategoriaTicket',
                    component: () =>
                        import ('./views/agenteView/ModificarCategoriaTicket.vue')
                },
                {
                    path: '/agenteView/FormularioAsignar/:id,:uuid',
                    name: 'AsignarSolicitudAgente',
                    component: () =>
                        import ('./views/agenteView/FormularioAsignar.vue')
                },
                {
                    path: '/agenteView/FormularioAsignarCA/:id,:uuid',
                    name: 'AsignarSolicitudAgenteCA',
                    component: () =>
                        import ('./views/agenteView/FormularioAsignarCA.vue')
                },
                {
                    path: '/agenteView/FormularioAsignarEM/:id,:uuid',
                    name: 'AsignarSolicitudAgenteEM',
                    component: () =>
                        import ('./views/agenteView/FormularioAsignarEM.vue')
                },
                {
                    path: '/agenteView/FormularioAsignarIND/:id,:uuid',
                    name: 'AsignarSolicitudAgenteIND',
                    component: () =>
                        import ('./views/agenteView/FormularioAsignarIND.vue')
                },
                {
                    path: '/agenteView/FormularioModificar/:id,:uuid',
                    name: 'ModificarSolicitudAgente',
                    component: () =>
                        import ('./views/agenteView/FormularioModificar.vue')
                },
                {
                    path: '/agenteView/FormularioModificarEM/:id,:uuid',
                    name: 'ModificarSolicitudAgenteEM',
                    component: () =>
                        import ('./views/agenteView/FormularioModificarEM.vue')
                },
                {
                    path: '/agenteView/FormularioModificarCA/:id,:uuid',
                    name: 'ModificarSolicitudAgenteCA',
                    component: () =>
                        import ('./views/agenteView/FormularioModificarCA.vue')
                },
                {
                    path: '/agenteView/FormularioModificarIND/:id,:uuid',
                    name: 'ModificarSolicitudAgenteIND',
                    component: () =>
                        import ('./views/agenteView/FormularioModificarIND.vue')
                },
                {
                    path: '/agenteView/ReporteExDiaInfra',
                    name: 'ReporteExDiaInfra',
                    component: () =>
                        import ('./views/agenteView/ReporteExDiaInfra.vue')
                },

                {
                    path: '/agenteView/ReporteExDiaEM',
                    name: 'ReporteExDiaEM',
                    component: () =>
                        import ('./views/agenteView/ReporteExDiaEM.vue')
                },

                {
                    path: '/agenteView/ReporteExDiaIND',
                    name: 'ReporteExDiaIND',
                    component: () =>
                        import ('./views/agenteView/ReporteExDiaIND.vue')
                },

                {
                    path: '/agenteView/ReporteExDiaCA',
                    name: 'ReporteExDiaCA',
                    component: () =>
                        import ('./views/agenteView/ReporteExDiaCA.vue')
                },



            ]
        },
        // =============================================================================
        // FULL PAGE LAYOUTS
        // =============================================================================
        {
            path: '',
            component: () =>
                import ('@/layouts/full-page/FullPage.vue'),
            children: [
                // =============================================================================
                // PAGES
                // =============================================================================
                {
                    path: '/pages/login',
                    name: 'page-login',
                    component: () =>
                        import ('@/views/pages/Login.vue')
                },
                {
                    path: '/pages/error-404',
                    name: 'page-error-404',
                    component: () =>
                        import ('@/views/pages/Error404.vue')
                }
            ]
        },
        // Redirect to 404 page, if no match found
        {
            path: '*',
            redirect: '/pages/error-404'
        }
    ]
})

router.afterEach(() => {
    // Remove initial loading
    const appLoading = document.getElementById('loading-bg')
    if (appLoading) {
        appLoading.style.display = 'none'
    }
})

export default router