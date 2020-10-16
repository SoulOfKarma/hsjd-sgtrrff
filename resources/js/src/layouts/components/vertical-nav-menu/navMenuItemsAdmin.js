/*=========================================================================================
  File Name: sidebarItems.js
  Description: Sidebar Items list. Add / Remove menu items from here.
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


export default [{
        url: '/HomeAdmin',
        name: 'Inicio',
        slug: 'home',
        icon: 'HomeIcon'
    }, {
        url: null,
        name: 'Mantenedor',
        slug: 'mantenedor',
        icon: 'HomeIcon',
        submenu: [{
                url: '/AgregarUsuarioJefe',
                name: 'Agregar Usuario Jefatura',
                slug: 'AgregarUsuarioJefe',
                icon: 'FileIcon'
            },
            {
                url: '/AgregarSubroganteJefe',
                name: 'Agregar Subrogante Jefe',
                slug: 'AgregarSubroganteJefe',
                icon: 'FileIcon'
            }
        ]
    }

]