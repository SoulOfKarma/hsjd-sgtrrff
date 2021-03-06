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
                        url: "/agenteView/CalendarioSolicitudes",
                        name: "Calendario",
                        slug: "CalendarioSolicitudes",
                        icon: "FileIcon"
                    },
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
            },
            {
                url: null,
                name: "Equipos Medicos",
                slug: "home",
                icon: "SendIcon",
                submenu: [
                    {
                        url: "/agenteView/CalendarioSolicitudesEM",
                        name: "Calendario",
                        slug: "CalendarioSolicitudesEM",
                        icon: "FileIcon"
                    },
                    {
                        url: "/agenteView/ListadoTicketsEM",
                        name: "Listado Tickets ",
                        slug: "ListadoTicketsEM",
                        icon: "FileIcon"
                    },
                    {
                        url: "/agenteView/GenerarTicketEM",
                        name: "Generar Ticket ",
                        slug: "GenerarTicketEM",
                        icon: "FileIcon"
                    },
                    {
                        url: "/agenteView/ReporteExDiaEM",
                        name: "Reportes",
                        slug: "ReporteExDiaEM",
                        icon: "FileIcon"
                    }
                ]
            },
            {
                url: null,
                name: "Industrial",
                slug: "home",
                icon: "SendIcon",
                submenu: [
                    {
                        url: "/agenteView/CalendarioSolicitudesIND",
                        name: "Calendario",
                        slug: "CalendarioSolicitudesIND",
                        icon: "FileIcon"
                    },
                    {
                        url: "/agenteView/ListadoTicketsIND",
                        name: "Listado Tickets",
                        slug: "ListadoTicketsIND",
                        icon: "FileIcon"
                    },
                    {
                        url: "/agenteView/GenerarTicketIND",
                        name: "Generar Ticket",
                        slug: "GenerarTicketIND",
                        icon: "FileIcon"
                    },
                    {
                        url: "/agenteView/ReporteExDiaIND",
                        name: "Reportes",
                        slug: "ReporteExDiaIND",
                        icon: "FileIcon"
                    }
                ]
            },
            {
                url: null,
                name: "Apoyo Clinico",
                slug: "home",
                icon: "SendIcon",
                submenu: [
                    {
                        url: "/agenteView/CalendarioSolicitudesCA",
                        name: "Calendario",
                        slug: "CalendarioSolicitudesCA",
                        icon: "FileIcon"
                    },
                    {
                        url: "/agenteView/ListadoTicketsCA",
                        name: "Listado Tickets",
                        slug: "ListadoSolicitudesCA",
                        icon: "FileIcon"
                    },
                    {
                        url: "/agenteView/GenerarTicketCA",
                        name: "Generar Ticket",
                        slug: "GenerarTicketCA",
                        icon: "FileIcon"
                    },
                    {
                        url: "/agenteView/ReporteExDiaCA",
                        name: "Reportes",
                        slug: "ReporteExDiaCA",
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
            }
        ]
    },
    {
        url: "/agenteView/CalendarioAscensores",
        name: "Ascensoristas",
        slug: "CalendarioAscensores",
        icon: "CalendarIcon"
    },
    {
        url: "/agenteView/CalendarioCTelefonica",
        name: "C. Telefonica",
        slug: "CalendarioCTelefonica",
        icon: "CalendarIcon"
    },
    {
        url: "/agenteView/CalendarioPruebas",
        name: "Calendario P.",
        slug: "CalendarioPruebas",
        icon: "CalendarIcon"
    }
];
