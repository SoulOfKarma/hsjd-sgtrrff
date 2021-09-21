/*=========================================================================================
  File Name: sidebarItems.js
  Description: Sidebar Items list. Add / Remove menu items from here.
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

export default [
    {
        url: "/agenteView/HomeAgente",
        name: "Inicio",
        slug: "homeAgente",
        icon: "HomeIcon"
    },
    {
        url: null,
        name: "Supervisor",
        slug: "supervisor",
        icon: "UserCheckIcon",
        submenu: [
            {
                url: null,
                name: "Infraestructura",
                slug: "home",
                icon: "SendIcon",
                submenu: [
                    {
                        url: "/agenteView/ListadoSolicitudes",
                        name: "Listado Tickets",
                        slug: "ListadoSolicitudes",
                        icon: "FileIcon"
                    },
                    {
                        url: "/agenteView/GenerarTicket",
                        name: "Generar Ticket",
                        slug: "GenerarTicket",
                        icon: "FileIcon"
                    },
                    {
                        url: "/agenteView/ReporteExDiaInfra",
                        name: "Reportes",
                        slug: "ReporteExDiaInfra",
                        icon: "FileIcon"
                    }
                ]
            }
        ]
    },
    {
        url: null,
        name: "Administrador",
        slug: "administrador",
        icon: "UserPlusIcon",
        submenu: [
            {
                url: null,
                name: "Usuarios",
                slug: "home",
                icon: "PlusCircleIcon",
                submenu: [
                    {
                        url: "/AgregarUsuarioJefe",
                        name: "Agregar Jefe",
                        slug: "AgregarUsuarioJefe",
                        icon: "FileIcon"
                    },
                    {
                        url: "/AgregarSubroganteJefe",
                        name: "Agregar Subrogante",
                        slug: "AgregarSubroganteJefe",
                        icon: "FileIcon"
                    },
                    {
                        url: "/ModificarUsuarioJefe",
                        name: "Modificar Jefatura",
                        slug: "ModificarUsuarioJefe",
                        icon: "FileIcon"
                    },
                    {
                        url: "/ModificarSubroganteJefe",
                        name: "Modificar Subrogante",
                        slug: "ModificarSubroganteJefe",
                        icon: "FileIcon"
                    },
                    {
                        url: "/MenuCargo",
                        name: "Cargo",
                        slug: "MenuCargo",
                        icon: "FileIcon"
                    }
                ]
            },
            {
                url: null,
                name: "Ubicaciones",
                slug: "home",
                icon: "PlusCircleIcon",
                submenu: [
                    {
                        url: "/MenuEdificios",
                        name: "Edificios",
                        slug: "MenuEdificios",
                        icon: "FileIcon"
                    },
                    {
                        url: "/MenuServicios",
                        name: "Servicios",
                        slug: "MenuServicios",
                        icon: "FileIcon"
                    }
                ]
            },
            {
                url: null,
                name: "Trabajadores",
                slug: "home",
                icon: "PlusCircleIcon",
                submenu: [
                    {
                        url: "/AgregarTrabajador",
                        name: "Agregar Trabajador",
                        slug: "AgregarTrabajador",
                        icon: "FileIcon"
                    },
                    {
                        url: "/ModificarTrabajador",
                        name: "Modificar Trabajador",
                        slug: "ModificarTrabajador",
                        icon: "FileIcon"
                    }
                ]
            },
            {
                url: null,
                name: "Supervisores",
                slug: "home",
                icon: "PlusCircleIcon",
                submenu: [
                    {
                        url: "/AgregarSupervisor",
                        name: "Agregar Supervisor",
                        slug: "AgregarSupervisor",
                        icon: "FileIcon"
                    },
                    {
                        url: "/ModificarSupervisor",
                        name: "Modificar Supervisor",
                        slug: "ModificarSupervisor",
                        icon: "FileIcon"
                    }
                ]
            },
            {
                url: null,
                name: "Tipo Reparacion",
                slug: "home",
                icon: "PlusCircleIcon",
                submenu: [
                    {
                        url: "/MenuReparacion",
                        name: "Menu Reparacion",
                        slug: "MenuReparacion",
                        icon: "FileIcon"
                    }
                ]
            },
            {
                url: null,
                name: "Especialidad",
                slug: "home",
                icon: "PlusCircleIcon",
                submenu: [
                    {
                        url: "/MenuEspecialidad",
                        name: "Menu Especialidad",
                        slug: "MenuEspecialidad",
                        icon: "FileIcon"
                    }
                ]
            },
            {
                url: null,
                name: "Habilitar|Desabilitar Usuarios",
                slug: "home",
                icon: "PlusCircleIcon",
                submenu: [
                    {
                        url: "/HabilitarDesabilitarUsuarios",
                        name: "Habilitar|Desabilitar Usuarios",
                        slug: "HabilitarDesabilitarUsuarios",
                        icon: "HomeIcon"
                    }
                ]
            }
        ]
    },
    {
        url: "/agenteView/CalendarioElectricos",
        name: "Electricos",
        slug: "CalendarioElectricos",
        icon: "CalendarIcon"
    },
    {
        url: "/agenteView/CalendarioTGasfiter",
        name: "Gasfiter",
        slug: "CalendarioTGasfiter",
        icon: "CalendarIcon"
    },
    {
        url: "/agenteView/CalendarioObras",
        name: "Obras.",
        slug: "CalendarioObras",
        icon: "CalendarIcon"
    }
];
