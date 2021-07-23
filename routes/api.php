<?php

use Illuminate\Http\Request;
use App\SeguimientoSolicitudes;
use App\Mail\AutoRespuesta;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
        Route::group(['middleware' => ['jwt.verify']], function() {
            //Retornar Login
            Route::get('/auth/user', 'LoginController@getAuthenticatedUser');
            //Retorna Ultimo ID Ingresado de las solicitudes
            Route::get('/Usuario/traerUltimoT', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@traerUltimoT']);
            //Retorna Edificios
            Route::get('/Usuario/GetEdificios', ['middleware' => 'cors', 'uses' => 'EdificioController@index']);
            //Route::get('/Usuario/GetEdificios', 'EdificioController@index');
            //Retorna Servicios
            Route::get('/Usuario/GetServicios', ['middleware' => 'cors', 'uses' => 'ServicioController@index']);
            //Retorna Categorias
            Route::get('/Usuario/GetCategoria', ['middleware' => 'cors', 'uses' => 'CategoriaController@index']);
            //Route::get('/Usuario/GetEdificios', 'ServicioController@index');
            //Retorna Tipo Unidad Especifica
            Route::get('/Usuario/GetUnidadEsp', ['middleware' => 'cors', 'uses' => 'UnidadExController@index']);
            //Route::get('/Usuario/GetEdificios', 'UnidadExController@index');
            //Retorna Tipo Reparacion
            Route::get('/Usuario/GetTipoRep', ['middleware' => 'cors', 'uses' => 'TipoReparacionController@index']);

            //Retorna Edificios
            Route::get('/Usuario/GetEdificios', ['middleware' => 'cors', 'uses' => 'EdificioController@index']);
            //Route::get('/Usuario/GetEdificios', 'EdificioController@index');
            //Retorna Servicios
            Route::get('/Usuario/GetServicios', ['middleware' => 'cors', 'uses' => 'ServicioController@index']);
            //Retorna Categorias
            Route::get('/Usuario/GetCategoria', ['middleware' => 'cors', 'uses' => 'CategoriaController@index']);
            //Route::get('/Usuario/GetEdificios', 'ServicioController@index');
            //Retorna Tipo Unidad Especifica
            Route::get('/Usuario/GetUnidadEsp', ['middleware' => 'cors', 'uses' => 'UnidadExController@index']);
            //Route::get('/Usuario/GetEdificios', 'UnidadExController@index');
            //Retorna Tipo Reparacion
            Route::get('/Usuario/GetTipoRep', ['middleware' => 'cors', 'uses' => 'TipoReparacionController@index']);
            //Route::get('/Usuario/GetEdificios', 'TipoReparacionController@index');
            //Retornar Usuarios Join
            Route::get('/Usuario/GetSolicitudUsuarios/{idservicio}', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@getSolicitudUsuariosJoin']);
            //Traer Usuario Especifico
            Route::get('/Usuario/getUsuarios/{id}', ['middleware' => 'cors', 'uses' => 'UsersController@buscarUsuarioData']);
            //Traer Data especifica
            Route::post('/Usuario/getDataSolicitudes', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@getSolicitudUsuariosByID']);
            //Solicitud Usuario
            //Traer Datos para el listado de tickets
            Route::get('/Usuario/GetSolicitud', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@index']);
            //Traer Datos para el listado de tickets
            Route::get('/Usuario/correo', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@correo']);
            //Traer datos especificos
            Route::get('/Usuario/TraerSolicitud/{id}', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@indexEspecifico']);
            //Guardar Solicitud
            Route::post('/Usuario/PostSolicitud', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@store']);
            //Modificar Solicitud
            Route::post('/Usuario/PutSolicitud', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@ModificarSolicitud']);
            //Traer seguimiento
            Route::get('/Usuario/TraerSeguimiento/{uuid}', ['middleware' => 'cors', 'uses' => 'SeguimientoController@indexSeguimiento']);
            //Guardar Seguimiento
            Route::post('/Usuario/GuardarSeguimiento/{uuid}', ['middleware' => 'cors', 'uses' => 'SeguimientoController@store']);
            //Traer Datos para el listado de tickets
            Route::get('/Usuario/GetSolicitudCreada/{id}', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@GetSolicitudCreada']);
            //Eliminar Ticket
            Route::get('/Usuario/destroyTicket/{id}', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@destroy']);
                        /*AÑADE AQUI LAS RUTAS QUE QUIERAS PROTEGER CON JWT*/

            //Gestion Agentes
            //Traer supervisores
            Route::get('/Agente/GetSupervisores', ['middleware' => 'cors', 'uses' => 'SupervisorController@index']);
            //Traer Todos los tickets Asignados Para Api Externa
            Route::get('/Agente/ticketsAll', ['middleware' => 'cors', 'uses' => 'GestionTicketController@ticketsAll']);
            //Traer Todos los tickets asignados
            Route::get('/Agente/GetTicketAsignadosInfra', ['middleware' => 'cors', 'uses' => 'GestionTicketController@ticketsCategoriaInfra']);
            //Traer Todos los tickets asignados
            Route::get('/Agente/GetTicketAsignadosEM', ['middleware' => 'cors', 'uses' => 'GestionTicketController@ticketsCategoriaEM']);
            //Traer Todos los tickets asignados
            Route::get('/Agente/GetTicketAsignadosIND', ['middleware' => 'cors', 'uses' => 'GestionTicketController@ticketsCategoriaIND']);
            //Traer Todos los tickets asignados
            Route::get('/Agente/GetTicketAsignadosCA', ['middleware' => 'cors', 'uses' => 'GestionTicketController@ticketsCategoriaCA']);
            //Traer Trabajadores
            Route::get('/Agente/GetTrabajadores', ['middleware' => 'cors', 'uses' => 'TrabajadorController@index']);
            //Retorna Categorias
            Route::get('/Agente/GetCategoria', ['middleware' => 'cors', 'uses' => 'CategoriaController@index']);
            //Traer Estado
            Route::get('/Agente/GetEstado', ['middleware' => 'cors', 'uses' => 'EstadoController@index']);
            //Guardar Ticket
            Route::post('/Agente/PostTicket', ['middleware' => 'cors', 'uses' => 'GestionTicketController@store']);
            //Guardar Ticket
            Route::post('/Agente/PostTicketEM', ['middleware' => 'cors', 'uses' => 'GestionTicketController@AsignarTicketEM']);
            //Guardar Ticket
            Route::post('/Agente/PostTicketIND', ['middleware' => 'cors', 'uses' => 'GestionTicketController@AsignarTicketIND']);
            //Guardar Ticket
            Route::post('/Agente/PostTicketCA', ['middleware' => 'cors', 'uses' => 'GestionTicketController@AsignarTicketCA']);
            //Traer Tickets con sus usuarios Infraestructura
            Route::get('/Agente/GetSolicitudTickets', ['middleware' => 'cors', 'uses' => 'GestionTicketController@getSolicitudUsuariosJoin']);
            //Traer Tickets con sus usuarios Equipos Medicos
            Route::get('/Agente/GetSolicitudTicketsEM', ['middleware' => 'cors', 'uses' => 'GestionTicketController@getSolicitudUsuariosJoinEM']);
            //Traer Tickets con sus usuarios Industrial
            Route::get('/Agente/GetSolicitudTicketsIND', ['middleware' => 'cors', 'uses' => 'GestionTicketController@getSolicitudUsuariosJoinIND']);
            //Traer Tickets con sus usuarios CA
            Route::get('/Agente/GetSolicitudTicketsCA', ['middleware' => 'cors', 'uses' => 'GestionTicketController@getSolicitudUsuariosJoinCA']);
            //Traer Turno
            Route::get('/Agente/GetTurnos', ['middleware' => 'cors', 'uses' => 'TurnoController@index']);
            //Traer Cargos
            Route::get('/Agente/GetCargos', ['middleware' => 'cors', 'uses' => 'CargoUsuarioController@index']);
            //Traer Cargos sin Jefatura
            Route::get('/Agente/GetCargoNoJefatura', ['middleware' => 'cors', 'uses' => 'CargoUsuarioController@getCargoNoJefatura']);
            //Traer Jefatura Usuarios
            Route::get('/Agente/GetUsuariosCargo', ['middleware' => 'cors', 'uses' => 'UsersController@traerTodoUsuarios']);

            //Traer seguimiento de tickets
            Route::get('/Agente/TraerSeguimiento/{uuid}', ['middleware' => 'cors', 'uses' => 'SeguimientoController@indexSeguimiento']);
            //Traer datos especificos
            Route::get('/Agente/TraerSolicitud/{id}', ['middleware' => 'cors', 'uses' => 'SeguimientoController@indexEspecifico']);
            //Guardar seguimiento agente
            Route::post('/Agente/GuardarSeguimiento/{uuid}', ['middleware' => 'cors', 'uses' => 'SeguimientoController@store']);
            //Guardar Seguimiento Externo Bodega
            Route::post('/seguimientoExternoBodega', ['middleware' => 'cors', 'uses' => 'SeguimientoController@seguimientoExternoBodega']);
            //Traer data especifica para correo Asignado
            Route::get('/Agente/GetDataCorreo/{uuid}', ['middleware' => 'cors', 'uses' => 'GestionTicketController@getDataCorreo']);
            //Envio de data para el correo
            Route::post('/Agente/enviarCorreo', ['middleware' => 'cors', 'uses' => 'GestionTicketController@enviarCorreo']);
            //Validar Existencia de ticket asignado Para modificar
            Route::get('/Agente/ValidarTicketAsignadoMod/{id}', ['middleware' => 'cors', 'uses' => 'GestionTicketController@ValidarTicketAsignadoMod']);
            //Guardar Ticket
            Route::post('/Agente/PutTicket', ['middleware' => 'cors', 'uses' => 'GestionTicketController@modificarTicket']);
            //Guardar Ticket
            Route::post('/Agente/PutTicketCA', ['middleware' => 'cors', 'uses' => 'GestionTicketController@modificarTicketCA']);
            //Guardar Ticket
            Route::post('/Agente/PutTicketEM', ['middleware' => 'cors', 'uses' => 'GestionTicketController@modificarTicketEM']);
            //Guardar Ticket
            Route::post('/Agente/PutTicketIND', ['middleware' => 'cors', 'uses' => 'GestionTicketController@modificarTicketIND']);
            //Guardar Nuevo Ticket
            Route::post('/Agente/PostNuevoTicket', ['middleware' => 'cors', 'uses' => 'GestionTicketController@NuevoTicket']);
            //Guardar Nuevo Ticket
            Route::post('/Agente/PostNuevoTicketEM', ['middleware' => 'cors', 'uses' => 'GestionTicketController@NuevoTicketEM']);
            //Guardar Nuevo Ticket
            Route::post('/Agente/PostNuevoTicketIND', ['middleware' => 'cors', 'uses' => 'GestionTicketController@NuevoTicketIND']);
            //Guardar Nuevo Ticket
            Route::post('/Agente/PostNuevoTicketCA', ['middleware' => 'cors', 'uses' => 'GestionTicketController@NuevoTicketCA']);
            //Traer Usuarios
            Route::get('/Agente/getUsuarios', ['middleware' => 'cors', 'uses' => 'GestionTicketController@getUsuarios']);
            //Traer el ticket especifico asignado
            Route::get('/Agente/TraerTicket/{id}', ['middleware' => 'cors', 'uses' => 'GestionTicketController@getTicketCreado']);
            //Traer Dato Join Calendario
            Route::get('/Agente/getDatoCalendario', ['middleware' => 'cors', 'uses' => 'GestionTicketController@GetDatoCalendario']);
            //Traer Trabajadores EX
            Route::get('/Agente/GetTrabajadoresEX', ['middleware' => 'cors', 'uses' => 'TrabajadorController@GetTrabajadoresEX']);
            //Eliminar Ticket
            Route::post('/Agente/destroyTicket', ['middleware' => 'cors', 'uses' => 'GestionTicketController@destroy']);
            //Eliminar Ticket
            Route::post('/Agente/FinalizarTicket', ['middleware' => 'cors', 'uses' => 'GestionTicketController@FinalizarTicket']);
            //Traer ticket asignado
            Route::get('/Agente/GetTicketAsignado/{id}', ['middleware' => 'cors', 'uses' => 'GestionTicketController@GetTicketAsignado']);
            //Validar Existencia de ticket asignado para asignar
            Route::get('/Agente/ValidarTicketAsignado/{id}', ['middleware' => 'cors', 'uses' => 'GestionTicketController@ValidarTicketAsignado']);


            //Traer Dato Join Calendario
            Route::get('/Agente/getDatoCalendarioEM', ['middleware' => 'cors', 'uses' => 'GestionTicketController@GetDatoCalendarioEM']);
            //Traer Dato Join Calendario
            Route::get('/Agente/getDatoCalendarioIND', ['middleware' => 'cors', 'uses' => 'GestionTicketController@GetDatoCalendarioIND']);
            //Traer Dato Join Calendario
            Route::get('/Agente/getDatoCalendarioCA', ['middleware' => 'cors', 'uses' => 'GestionTicketController@GetDatoCalendarioCA']);
            //Traer Dato Join Calendario
            Route::post('/Agente/ModificarCategoria', ['middleware' => 'cors', 'uses' => 'GestionTicketController@ModificarCategoria']);

            //Api Trabajador
            //Traer datos especificos
            Route::get('/Trabajador/TraerTickets/{id}', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@getTicketsAsignadosJoin']);
            //Guardar seguimiento Trabajador
            //Route::post('/Trabajador/GuardarSeguimiento/{uuid}', ['middleware' => 'cors', 'uses' => 'SeguimientoController@store']);
            //Guardar seguimiento Trabajador
            Route::post('/Trabajador/GuardarSeguimiento/{uuid}', ['middleware' => 'cors', 'uses' => 'SeguimientoController@seguimientoTrabajador']);
            //Guardar seguimiento Trabajador Resolucion Final 
            Route::post('/Trabajador/GuardarSeguimientoT/{uuid}', ['middleware' => 'cors', 'uses' => 'SeguimientoController@guardarSeguimientoT']);

            //Guardar Nuevo Usuario
            Route::post('/Agente/GuardarUsuarioJefe', ['middleware' => 'cors', 'uses' => 'UsersController@registrarUsuario']);
            //Modificar Usuario Jefatura
            Route::post('/Agente/ModificarUsuarioJefe', ['middleware' => 'cors', 'uses' => 'UsersController@modificarUsuarioJefe']);
            //Guardar Nuevo Usuario Sub
            Route::post('/Agente/GuardarUsuarioSub', ['middleware' => 'cors', 'uses' => 'UsersController@registrarUsuarioSub']);
            //Modificar Usuario Subrogante
            Route::post('/Agente/ModificarUsuarioSub', ['middleware' => 'cors', 'uses' => 'UsersController@modificarUsuarioSub']);
            //Traer Cargos 
            Route::get('/Agente/getCargos', ['middleware' => 'cors', 'uses' => 'CargoUsuarioController@index']);
            //Traer Cargos No Jefatura,Supervisor RRFF y trabajador RRFF
            Route::get('/Agente/getCargoNoJefatura', ['middleware' => 'cors', 'uses' => 'CargoUsuarioController@getCargoNoJefatura']);
            //Traer Usuarios Supervisores RRFF
            Route::get('/Agente/getSupervisoresRRFF', ['middleware' => 'cors', 'uses' => 'UsersController@getSoloSupervisoresRRFF']);
            //Traer Usuarios Trabajadores RRFF
            Route::get('/Agente/getTrabajadoresRRFF', ['middleware' => 'cors', 'uses' => 'UsersController@getSoloTrabajadoresRRFF']);
            //Traer Especialidades
            Route::get('/Agente/getEspecialidad', ['middleware' => 'cors', 'uses' => 'EspecialidadController@index']);
            //Guardar Nuevo Edificio
            Route::post('/Agente/PostEdificios', ['middleware' => 'cors', 'uses' => 'EdificioController@create']);
            //Guardar Nuevo Servicio
            Route::post('/Agente/PostServicios', ['middleware' => 'cors', 'uses' => 'ServicioController@create']);
            //Guardar Nuevo Unidad Especifica
            Route::post('/Agente/PostUnidadEspecifica', ['middleware' => 'cors', 'uses' => 'UnidadExController@create']);
            //Modificar Edificio
            Route::post('/Agente/PutModificarEdificio', ['middleware' => 'cors', 'uses' => 'EdificioController@modificarEdificio']);
            //Modificar Servicio
            Route::post('/Agente/PutModificarServicio', ['middleware' => 'cors', 'uses' => 'ServicioController@modificarServicio']);
            //Modificar Unidad Especifica
            Route::post('/Agente/PutModificarUnidadEsp', ['middleware' => 'cors', 'uses' => 'UnidadExController@modificarUnidadEspecifica']);
            //Guardar Nuevo Cargo
            Route::post('/Agente/PostCargo', ['middleware' => 'cors', 'uses' => 'CargoUsuarioController@create']);
            //Modificar Cargo Existente
            Route::post('/Agente/PutCargo', ['middleware' => 'cors', 'uses' => 'CargoUsuarioController@modificarCargo']);
            //Guardar Nuevo Tipo Reparacion
            Route::post('/Agente/PostTipoReparacion', ['middleware' => 'cors', 'uses' => 'TipoReparacionController@create']);
            //Modificar Tipo Reparacion Existente
            Route::post('/Agente/PutTipoReparacion', ['middleware' => 'cors', 'uses' => 'TipoReparacionController@modificarTipoReparacion']);
            //Guardar Nuevo Supervisor
            Route::post('/Agente/GuardarSupervisor', ['middleware' => 'cors', 'uses' => 'UsersController@registrarSupervisor']);
            //Guardar Nuevo Trabajador
            Route::post('/Agente/GuardarTrabajador', ['middleware' => 'cors', 'uses' => 'UsersController@registrarTrabajador']);
            //Guardar Nueva Especialidad
            Route::post('/Agente/PostEspecialidad', ['middleware' => 'cors', 'uses' => 'EspecialidadController@agregarEspecialidad']);
            //Modificar Especialidad Existente
            Route::post('/Agente/PutEspecialidad', ['middleware' => 'cors', 'uses' => 'EspecialidadController@modificarEspecialidad']);
            //Modificar Trabajador Existente
            Route::post('/Agente/PutTrabajador', ['middleware' => 'cors', 'uses' => 'UsersController@modificarTrabajador']);
            //Modificar Supervisor Existente
            Route::post('/Agente/PutSupervisor', ['middleware' => 'cors', 'uses' => 'UsersController@modificarSupervisor']);
            //Traer Jefatura Usuarios
            Route::get('/Agente/getUsuariosJefatura', ['middleware' => 'cors', 'uses' => 'UsersController@getSoloJefatura']);
            //Traer Jefatura Usuarios
            Route::get('/Agente/getUsuariosSubrogantes', ['middleware' => 'cors', 'uses' => 'UsersController@getSoloSubrogantes']);
            //Traer Trabajadores
            Route::get('/Trabajador/getTrabajadoresByRun/{run}', ['middleware' => 'cors', 'uses' => 'TrabajadorController@getTrabajadoresByRun']);

            //Agregar Nuevo Calendario Ascensores
            Route::post('/Agente/PostCalendarioAsc', ['middleware' => 'cors', 'uses' => 'CalendarioAscensoresController@postNuevoTCalendario']);
            //Traer Todo Calendario Ascensores
            Route::get('/Agente/GetCalendarioAsc', ['middleware' => 'cors', 'uses' => 'CalendarioAscensoresController@getTodoCalendario']);
            //Modificar o Agregar Items Calendario Ascensores
            Route::post('/Agente/PutCalendarioAsc', ['middleware' => 'cors', 'uses' => 'CalendarioAscensoresController@PutNuevoTCalendario']);
            //Get Dia Administrativo Ascensoristas
            Route::get('/Agente/DAdminAsc', ['middleware' => 'cors', 'uses' => 'DiaAdministrativoController@get_dia_adm']);
            //Get Reemplazos Ascensoristas
            Route::get('/Agente/RAscensoristas', ['middleware' => 'cors', 'uses' => 'ReemplazoController@get_reemplazo']);
            //Get Turno Extra Ascensoristas
            Route::get('/Agente/TurExtAscensoristas', ['middleware' => 'cors', 'uses' => 'TurnoExtraController@get_turnoExtra']);
            //Get Vacaciones Ascensoristas
            Route::get('/Agente/VAscensoristas', ['middleware' => 'cors', 'uses' => 'VacacionesController@get_vacaciones']);
            //Traer data especifica
            Route::post('/Agente/GetDataCalenAsc', ['middleware' => 'cors', 'uses' => 'CalendarioAscensoresController@get_data_esp_asc']);

            //Agregar Nuevo Calendario Central Telefonica
            Route::post('/Agente/PostCalendarioCTel', ['middleware' => 'cors', 'uses' => 'CalendarioCTelefonicaController@postNuevoTCalendarioCTEL']);
            //Traer Todo Calendario Central Telefonica
            Route::get('/Agente/GetCalendarioCTel', ['middleware' => 'cors', 'uses' => 'CalendarioCTelefonicaController@getTodoCalendarioCTEL']);
            //Modificar o Agregar Items Calendario Central Telefonica
            Route::post('/Agente/PutCalendarioCTel', ['middleware' => 'cors', 'uses' => 'CalendarioCTelefonicaController@PutNuevoTCalendarioCTEL']);
            //Get Dia Administrativo Central Telefonica
            Route::get('/Agente/DAdminCTel', ['middleware' => 'cors', 'uses' => 'DiaAdministrativoCTelefonicaController@get_dia_adm']);
            //Get Reemplazos Central Telefonica
            Route::get('/Agente/RCTelefonica', ['middleware' => 'cors', 'uses' => 'ReemplazoCTelefonicaController@get_reemplazo']);
            //Get Turno Extra Central Telefonica
            Route::get('/Agente/TurExtCTelefonica', ['middleware' => 'cors', 'uses' => 'TurnoExtraCTelefonicaController@get_turnoExtra']);
            //Get Vacaciones Central Telefonica
            Route::get('/Agente/VCTelefonica', ['middleware' => 'cors', 'uses' => 'VacacionesCTelefonicaController@get_vacaciones']);
            //Traer data especifica Central Telefonica
            Route::post('/Agente/GetDataCalenCTel', ['middleware' => 'cors', 'uses' => 'CalendarioCTelefonicaController@get_data_esp_CTEL']);
            //Traer Trabajadores Solo Ascensoristas
            Route::get('/Agente/GetTrabajadoresEspAsc', ['middleware' => 'cors', 'uses' => 'TrabajadorController@GetTrabajadoresEspAsc']);
            //Traer Trabajadores Solo Central Telefonica
            Route::get('/Agente/GetTrabajadoresEspCTel', ['middleware' => 'cors', 'uses' => 'TrabajadorController@GetTrabajadoresEspCTel']);
            //Retorna Edificios Solo de Ascensores
            Route::get('/Usuario/GetEdificiosAsc', ['middleware' => 'cors', 'uses' => 'EdificioController@GetEdificiosAsc']);
            //Traer Turno Sin Libre
            Route::get('/Agente/getTurnoSL', ['middleware' => 'cors', 'uses' => 'TurnoController@getTurnoSL']);
            //Retorna Categorias Sin Informatica
            Route::get('/Usuario/getCategoriaSI', ['middleware' => 'cors', 'uses' => 'CategoriaController@getCategoriaSI']);
            //Retorna Tipo Reparacion
            Route::get('/Usuario/getTReparacionSI', ['middleware' => 'cors', 'uses' => 'TipoReparacionController@getTReparacionSI']);
            //Inserta Documentos de las solicitudes finalizadas
            Route::post('/Agente/PostDocumentoF', ['middleware' => 'cors', 'uses' => 'DocumentosFController@store']);
            //Inserta Documentos de las solicitudes finalizadas
            Route::post('/Agente/getDocumentos', ['middleware' => 'cors', 'uses' => 'DocumentosFController@getData']);
            //Trae Duracion 
            Route::get('/Agente/GetDuracion', ['middleware' => 'cors', 'uses' => 'DuracionSolicitudesController@getAll']);
            //Guardar Ticket
            Route::post('/Agente/PostCierreTicket', ['middleware' => 'cors', 'uses' => 'GestionTicketController@PostCierreTicket']);

            //Datos KPI 
            //Traer Estados Tickets
            Route::get('/Agente/TraerKPITickets', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@getTicketsKPI']);
            //Traer Tickets Pendientes,Finalizados y Nuevos.
            Route::get('/Agente/TraerKPITicketsTotal', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@getTicketsKPITotal']);
            //Traer Servicio mas solicitado.
            Route::get('/Agente/TraerServicioKPI', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@getKPIServicio']);
            //Traer usuario mas solicitante.
            Route::get('/Agente/TraerUsuarioKPI', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@getKPIUsuario']);
            //Traer Categoria mas solicitante.
            Route::get('/Agente/TraerCategoriaKPI', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@getKPICategoria']);
            //Traer Tipo Mantencion mas solicitante.
            Route::get('/Agente/TraerTipoMantencionKPI', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@getKPITipoMantencion']);
            
            //Datos Calendario 
            //Traer Obras Existentes
            Route::get('/Agente/VerificacionIdExistente', ['middleware' => 'cors', 'uses' => 'GanttObrasController@verificacionId']);
            //Guardar Nueva Obra
            Route::post('/Agente/GuardarNObra', ['middleware' => 'cors', 'uses' => 'GanttObrasController@PostNObra']);
            //Traer Obra Recurso Nulo
            Route::get('/Agente/BuscarObraRANull', ['middleware' => 'cors', 'uses' => 'GanttObrasController@PostNObraRANull']);
            //Traer Obra Recurso Activo
            Route::get('/Agente/BuscarObraRActiva', ['middleware' => 'cors', 'uses' => 'GanttObrasController@PostNObraRA']);
      });
      //Generar Excel	
      Route::get('/Agente/generarExcelTodo', 'ExcelController@generarExcelTodo');
      //Generar Excel	Por Fechas
      Route::get('/Agente/generarExcelByFecha/{fechaInicio}/{fechaTermino}', 'ExcelController@generarExcelByFecha');
      //Generar Excel	
      Route::get('/Agente/generarExcelTodoEM', 'ExcelController@generarExcelTodoEM');
      //Generar Excel	Por Fechas
      Route::get('/Agente/generarExcelByFechaEM/{fechaInicio}/{fechaTermino}', 'ExcelController@generarExcelByFechaEM');
      //Generar Excel	
      Route::get('/Agente/generarExcelTodoAP', 'ExcelController@generarExcelTodoAP');
      //Generar Excel	Por Fechas
      Route::get('/Agente/generarExcelByFechaAP/{fechaInicio}/{fechaTermino}', 'ExcelController@generarExcelByFechaAP');
      //Generar Excel	
      Route::get('/Agente/generarExcelTodoI', 'ExcelController@generarExcelTodoI');
      //Generar Excel	Por Fechas
      Route::get('/Agente/generarExcelByFechaI/{fechaInicio}/{fechaTermino}', 'ExcelController@generarExcelByFechI');

    Route::post('/auth/login', 'LoginController@login');
    Route::post('/auth/check', 'LoginController@checkToken');
    Route::post('/auth/generarToken', 'LoginController@generarToken');
     
      //Guardar Solicitud Comodin para Backend
    Route::post('/Usuario/PostSolicitudInformatica', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@createTicketInformatica']);

    Route::post('/Login/GetUsers', ['middleware' => 'cors', 'uses' => 'LoginController@getUsuarios']);
    Route::post('/Login/LoginByRut', ['middleware' => 'cors', 'uses' => 'LoginController@GetUsersByExternalRut']);
    Route::post('/Login/getpr', ['middleware' => 'cors', 'uses' => 'LoginController@adminPr']);
    Route::post('/Login/Salir', ['middleware' => 'cors', 'uses' => 'LoginController@salir']);

    //Imprimir Ticket Infraestructura
    Route::get('/Agente/imprimirPorTicketINFRA/{id}', ['middleware' => 'cors', 'uses' => 'PdfController@imprimirPorTicketINFRA']);
    //Imprimir Ticket Equipos Medicos
    Route::get('/Agente/imprimirPorTicketEM/{id}', ['middleware' => 'cors', 'uses' => 'PdfController@imprimirPorTicketEM']);
    //Imprimir Ticket Industrial
    Route::get('/Agente/imprimirPorTicketIND/{id}', ['middleware' => 'cors', 'uses' => 'PdfController@imprimirPorTicketIND']);
    //Imprimir CA
    Route::get('/Agente/imprimirPorTicketCA/{id}', ['middleware' => 'cors', 'uses' => 'PdfController@imprimirPorTicketCA']);


