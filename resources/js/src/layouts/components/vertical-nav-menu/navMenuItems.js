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
        url: "/home",
        name: "Inicio",
        slug: "home",
        icon: "HomeIcon"
    },
    {
        url: null,
        name: "Mantencion",
        slug: "home",
        icon: "HomeIcon",
        submenu: [
            {
                url: "/GenerarSolicitud",
                name: "Generar Solicitud",
                slug: "GenerarSolicitud",
                icon: "FileIcon"
            },
            {
                url: "/Listadosolicitudes",
                name: "Listado Solicitudes",
                slug: "Listadosolicitudes",
                icon: "FileIcon"
            }
        ]
    },
    {
        url: null,
        name: "Informatica",
        slug: "home",
        icon: "HomeIcon",
        submenu: [
            {
                url: "/informaticaView/GenerarTicketsInf",
                name: "Generar Solicitudes Informatica",
                slug: "GenerarTicketsInf",
                icon: "FileIcon"
            },
            {
                url: "/informaticaView/ListadoTicketsInf",
                name: "Listado Solicitudes Informatica",
                slug: "ListadoTicketsInf",
                icon: "FileIcon"
            }
        ]
    }
];
