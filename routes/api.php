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
            //Rutas Protegidas con JWT , agregalas aca.
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
            //Retorna Equipamiento Medico
            Route::get('/Usuario/GetTodoEquipamientoMedico', ['middleware' => 'cors', 'uses' => 'EquipamientoMedicosController@GetTodoEquipamientoMedico']);
            //Route::get('/Usuario/GetEdificios', 'ServicioController@index');
            //Retorna Tipo Unidad Especifica
            Route::get('/Usuario/GetUnidadEsp', ['middleware' => 'cors', 'uses' => 'UnidadExController@index']);
            //Route::get('/Usuario/GetEdificios', 'UnidadExController@index');
            //Retorna Tipo Reparacion
            Route::get('/Usuario/GetTipoRep', ['middleware' => 'cors', 'uses' => 'TipoReparacionController@index']);
            //Retorna Tipo Reparacion
            Route::get('/Usuario/GetPrioridades', ['middleware' => 'cors', 'uses' => 'PrioridadSolicitudController@GetPrioridades']);
            //Retornar Usuarios Join
            Route::get('/Usuario/GetSolicitudUsuarios/{idservicio}', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@getSolicitudUsuariosJoin']);
            //Traer Usuario Especifico
            Route::get('/Usuario/getUsuarios/{id}', ['middleware' => 'cors', 'uses' => 'UsersController@buscarUsuarioData']);
            //Traer Data especifica
            Route::post('/Usuario/getDataSolicitudes', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@getSolicitudUsuariosByID']);
            //Usuario Recepcion y finaliza solicitud
            Route::post('/Usuario/PostFinalizarSolicitud', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@PostFinalizarSolicitud']);
            //Solicitud Usuario
            //Traer Datos para el listado de tickets
            Route::get('/Usuario/GetSolicitud', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@index']);
            //Traer Datos para el listado de tickets
            Route::get('/Usuario/correo', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@correo']);
            //Traer datos especificos
            Route::get('/Usuario/TraerSolicitud/{id}', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@indexEspecifico']);
            //Traer datos especificos
            Route::get('/Usuario/TraerSolicitudEM/{id}', ['middleware' => 'cors', 'uses' => 'SolicitudTicketsEMController@indexEspecifico']);
            //Traer datos especificos
            Route::get('/Usuario/TraerSolicitudIND/{id}', ['middleware' => 'cors', 'uses' => 'SolicitudTicketINDsController@indexEspecifico']);
            //Traer datos especificos
            Route::get('/Usuario/TraerSolicitudAP/{id}', ['middleware' => 'cors', 'uses' => 'SolicitudTicketsApsController@indexEspecifico']);
            //Guardar Solicitud
            Route::post('/Usuario/PostSolicitud', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@store']);
            //Guardar Solicitud EM
            Route::post('/Usuario/PostSolicitudEM', ['middleware' => 'cors', 'uses' => 'SolicitudTicketsEMController@store']);
            //Guardar Solicitud IND
            Route::post('/Usuario/PostSolicitudIND', ['middleware' => 'cors', 'uses' => 'SolicitudTicketINDsController@store']);
            //Guardar Solicitud AP
            Route::post('/Usuario/PostSolicitudAP', ['middleware' => 'cors', 'uses' => 'SolicitudTicketsApsController@store']);
            //Modificar Solicitud
            Route::post('/Usuario/PutSolicitud', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@ModificarSolicitud']);
            //Modificar Solicitud
            Route::post('/Usuario/PutSolicitudEM', ['middleware' => 'cors', 'uses' => 'SolicitudTicketsEMController@ModificarSolicitud']);
            //Modificar Solicitud
            Route::post('/Usuario/PutSolicitudIND', ['middleware' => 'cors', 'uses' => 'SolicitudTicketINDsController@ModificarSolicitud']);
            //Modificar Solicitud
            Route::post('/Usuario/PutSolicitudAP', ['middleware' => 'cors', 'uses' => 'SolicitudTicketsApsController@ModificarSolicitud']);
            //Traer seguimiento
            Route::get('/Usuario/TraerSeguimiento/{uuid}', ['middleware' => 'cors', 'uses' => 'SeguimientoController@indexSeguimiento']);
            //Traer seguimiento
            Route::get('/Usuario/TraerSeguimientoEM/{uuid}', ['middleware' => 'cors', 'uses' => 'SeguimientoEMSolicitudesController@indexSeguimiento']);
            //Traer seguimiento
            Route::get('/Usuario/TraerSeguimientoIND/{uuid}', ['middleware' => 'cors', 'uses' => 'SeguimientoINDSolicitudesController@indexSeguimiento']);
            //Traer seguimiento
            Route::get('/Usuario/TraerSeguimientoAP/{uuid}', ['middleware' => 'cors', 'uses' => 'SeguimientoAPSolicitudesController@indexSeguimiento']);
            //Guardar Seguimiento
            Route::post('/Usuario/GuardarSeguimiento/{uuid}', ['middleware' => 'cors', 'uses' => 'SeguimientoController@store']);
            //Guardar Seguimiento
            Route::post('/Usuario/GuardarSeguimientoEM/{uuid}', ['middleware' => 'cors', 'uses' => 'SeguimientoEMSolicitudesController@store']);
            //Guardar Seguimiento
            Route::post('/Usuario/GuardarSeguimientoIND/{uuid}', ['middleware' => 'cors', 'uses' => 'SeguimientoINDSolicitudesController@store']);
            //Guardar Seguimiento
            Route::post('/Usuario/GuardarSeguimientoAP/{uuid}', ['middleware' => 'cors', 'uses' => 'SeguimientoAPSolicitudesController@store']);
            //Traer Datos para el listado de tickets
            Route::post('/Usuario/GetSolicitudCreada', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@GetSolicitudCreada']);
            //Traer Datos para el listado de tickets
            Route::post('/Usuario/GetSolicitudCreadaEM', ['middleware' => 'cors', 'uses' => 'SolicitudTicketsEMController@GetSolicitudCreada']);
            //Traer Datos para el listado de tickets
            Route::post('/Usuario/GetSolicitudCreadaIND', ['middleware' => 'cors', 'uses' => 'SolicitudTicketINDsController@GetSolicitudCreada']);
            //Traer Datos para el listado de tickets
            Route::post('/Usuario/GetSolicitudCreadaAP', ['middleware' => 'cors', 'uses' => 'SolicitudTicketsApsController@GetSolicitudCreada']);
            //Eliminar Ticket
            Route::get('/Usuario/destroyTicket/{id}', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@destroy']);
            //Eliminar Ticket
            Route::get('/Usuario/destroyTicketEM/{id}', ['middleware' => 'cors', 'uses' => 'SolicitudTicketsEMController@destroy']);
            //Eliminar Ticket
            Route::get('/Usuario/destroyTicketIND/{id}', ['middleware' => 'cors', 'uses' => 'SolicitudTicketINDsController@destroy']);
            //Eliminar Ticket
            Route::get('/Usuario/destroyTicketAP/{id}', ['middleware' => 'cors', 'uses' => 'SolicitudTicketsApsController@destroy']);
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
            Route::get('/Agente/GetTicketAsignadosIND', ['middleware' => 'cors', 'uses' => 'GestionTicketContrINDsoller@ticketsCategoriaIND']);
            //Traer Todos los tickets asignados
            Route::get('/Agente/GetTicketAsignadosCA', ['middleware' => 'cors', 'uses' => 'GestionTicketController@ticketsCategoriaCA']);
            //Traer Trabajadores
            Route::get('/Agente/GetTrabajadores', ['middleware' => 'cors', 'uses' => 'TrabajadorController@index']);
            //Retorna Categorias
            Route::get('/Agente/GetCategoria', ['middleware' => 'cors', 'uses' => 'CategoriaController@index']);
            //Traer Estado
            Route::get('/Agente/GetEstadoAsignar', ['middleware' => 'cors', 'uses' => 'EstadoController@EstadoAsignar']);
            //Traer Estado
            Route::get('/Agente/GetEstado', ['middleware' => 'cors', 'uses' => 'EstadoController@index']);
            //Guardar Ticket
            Route::post('/Agente/PostTicket', ['middleware' => 'cors', 'uses' => 'GestionTicketController@store']);
            //Guardar Ticket
            Route::post('/Agente/PostTicketEM', ['middleware' => 'cors', 'uses' => 'GestionTicketEMSController@AsignarTicketEM']);
            //Guardar Ticket
            Route::post('/Agente/PostTicketIND', ['middleware' => 'cors', 'uses' => 'GestionTicketsINDsController@AsignarTicketIND']);
            //Guardar Ticket
            Route::post('/Agente/PostTicketCA', ['middleware' => 'cors', 'uses' => 'GestionTicketsApsController@AsignarTicketCA']);
            //Traer Tickets con sus usuarios Infraestructura
            Route::get('/Agente/GetSolicitudTickets', ['middleware' => 'cors', 'uses' => 'GestionTicketController@getSolicitudUsuariosJoin']);
            //Traer Tickets con sus usuarios Equipos Medicos
            Route::get('/Agente/GetSolicitudTicketsEM', ['middleware' => 'cors', 'uses' => 'GestionTicketEMSController@getSolicitudUsuariosJoinEM']);
            //Traer Tickets con sus usuarios Industrial
            Route::get('/Agente/GetSolicitudTicketsIND', ['middleware' => 'cors', 'uses' => 'GestionTicketsINDsController@getSolicitudUsuariosJoinIND']);
            //Traer Tickets con sus usuarios Apoyo Clinico
            Route::get('/Agente/GetSolicitudTicketsCA', ['middleware' => 'cors', 'uses' => 'GestionTicketsApsController@getSolicitudUsuariosJoinCA']);
            //Traer Tickets con sus usuarios Infraestructura Historico
            Route::get('/Agente/GetSolicitudTicketsH', ['middleware' => 'cors', 'uses' => 'GestionTicketController@getSolicitudUsuariosJoinH']);
            //Traer Tickets con sus usuarios Equipos Medicos Historico
            Route::get('/Agente/GetSolicitudTicketsEMH', ['middleware' => 'cors', 'uses' => 'GestionTicketEMSController@getSolicitudUsuariosJoinEMH']);
            //Traer Tickets con sus usuarios Industrial Historico
            Route::get('/Agente/GetSolicitudTicketsINDH', ['middleware' => 'cors', 'uses' => 'GestionTicketsINDsController@getSolicitudUsuariosJoinINDH']);
            //Traer Tickets con sus usuarios CA Historico
            Route::get('/Agente/GetSolicitudTicketsCAH', ['middleware' => 'cors', 'uses' => 'GestionTicketsApsController@getSolicitudUsuariosJoinCAH']);
            //Traer Todos Los tickets Existentes
            Route::get('/Agente/GetTicketsTotales', ['middleware' => 'cors', 'uses' => 'GestionTicketController@GetTicketsTotales']);
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
            //Validar Existencia de ticket asignado Para modificar
            Route::get('/Agente/ValidarTicketAsignadoModEM/{id}', ['middleware' => 'cors', 'uses' => 'GestionTicketEMSController@ValidarTicketAsignadoMod']);
            //Validar Existencia de ticket asignado Para modificar
            Route::get('/Agente/ValidarTicketAsignadoModIND/{id}', ['middleware' => 'cors', 'uses' => 'GestionTicketsINDsController@ValidarTicketAsignadoMod']);
            //Validar Existencia de ticket asignado Para modificar
            Route::get('/Agente/ValidarTicketAsignadoModAP/{id}', ['middleware' => 'cors', 'uses' => 'GestionTicketsApsController@ValidarTicketAsignadoMod']);
            //Guardar Ticket
            Route::post('/Agente/PutTicket', ['middleware' => 'cors', 'uses' => 'GestionTicketController@modificarTicket']);
            //Guardar Ticket
            Route::post('/Agente/PutTicketCA', ['middleware' => 'cors', 'uses' => 'GestionTicketsApsController@modificarTicketCA']);
            //Guardar Ticket
            Route::post('/Agente/PutTicketEM', ['middleware' => 'cors', 'uses' => 'GestionTicketEMSController@modificarTicketEM']);
            //Guardar Ticket
            Route::post('/Agente/PutTicketIND', ['middleware' => 'cors', 'uses' => 'GestionTicketsINDsController@modificarTicketIND']);
            //Guardar Nuevo Ticket
            Route::post('/Agente/PostNuevoTicket', ['middleware' => 'cors', 'uses' => 'GestionTicketController@NuevoTicket']);
            //Guardar Nuevo Ticket
            Route::post('/Agente/PostNuevoTicketEM', ['middleware' => 'cors', 'uses' => 'GestionTicketEMSController@NuevoTicketEM']);
            //Guardar Nuevo Ticket
            Route::post('/Agente/PostNuevoTicketIND', ['middleware' => 'cors', 'uses' => 'GestionTicketsINDsController@NuevoTicketIND']);
            //Guardar Nuevo Ticket
            Route::post('/Agente/PostNuevoTicketCA', ['middleware' => 'cors', 'uses' => 'GestionTicketsApsController@NuevoTicketCA']);
            //Traer Usuarios
            Route::get('/Agente/getUsuarios', ['middleware' => 'cors', 'uses' => 'GestionTicketController@getUsuarios']);
            //Traer el ticket especifico asignado
            Route::get('/Agente/TraerTicket/{id}', ['middleware' => 'cors', 'uses' => 'GestionTicketController@getTicketCreado']);
            //Traer el ticket especifico asignado
            Route::get('/Agente/TraerTicketIND/{id}', ['middleware' => 'cors', 'uses' => 'GestionTicketsINDsController@getTicketCreado']);
            //Traer el ticket especifico asignado
            Route::get('/Agente/TraerTicketEM/{id}', ['middleware' => 'cors', 'uses' => 'GestionTicketEMSController@getTicketCreado']);
            //Traer el ticket especifico asignado
            Route::get('/Agente/TraerTicketCA/{id}', ['middleware' => 'cors', 'uses' => 'GestionTicketsApsController@getTicketCreado']);
            //Traer Dato Join Calendario
            Route::get('/Agente/getDatoCalendario', ['middleware' => 'cors', 'uses' => 'GestionTicketController@GetDatoCalendario']);
            //Traer Trabajadores EX
            Route::get('/Agente/GetTrabajadoresEX', ['middleware' => 'cors', 'uses' => 'TrabajadorController@GetTrabajadoresEX']);
            //Eliminar Ticket Infra
            Route::post('/Agente/destroyTicket', ['middleware' => 'cors', 'uses' => 'GestionTicketController@destroy']);
            //Eliminar Ticket Equipo Medico
            Route::post('/Agente/destroyTicketEM', ['middleware' => 'cors', 'uses' => 'GestionTicketEMSController@destroy']);
            //Eliminar Ticket Industrial
            Route::post('/Agente/destroyTicketIND', ['middleware' => 'cors', 'uses' => 'GestionTicketsINDsController@destroy']);
            //Eliminar Ticket Apoyo Clinico
            Route::post('/Agente/destroyTicketAP', ['middleware' => 'cors', 'uses' => 'GestionTicketsApsController@destroy']);
            //Finalizar Ticket
            Route::post('/Agente/FinalizarTicket', ['middleware' => 'cors', 'uses' => 'GestionTicketController@FinalizarTicket']);
            //Finalizar Ticket
            Route::post('/Agente/FinalizarTicketEM', ['middleware' => 'cors', 'uses' => 'GestionTicketEMSController@FinalizarTicket']);
            //Finalizar Ticket
            Route::post('/Agente/FinalizarTicketIND', ['middleware' => 'cors', 'uses' => 'GestionTicketsINDsController@FinalizarTicket']);
            //Finalizar Ticket
            Route::post('/Agente/FinalizarTicketAP', ['middleware' => 'cors', 'uses' => 'GestionTicketsApsController@FinalizarTicket']);
            //Traer ticket asignado
            Route::get('/Agente/GetTicketAsignado/{id}', ['middleware' => 'cors', 'uses' => 'GestionTicketController@GetTicketAsignado']);
            //Traer ticket asignado
            Route::get('/Agente/GetTicketAsignadoEM/{id}', ['middleware' => 'cors', 'uses' => 'GestionTicketEMSController@GetTicketAsignado']);
            //Traer ticket asignado
            Route::get('/Agente/GetTicketAsignadoIND/{id}', ['middleware' => 'cors', 'uses' => 'GestionTicketsINDsController@GetTicketAsignado']);
            //Traer ticket asignado
            Route::get('/Agente/GetTicketAsignadoAP/{id}', ['middleware' => 'cors', 'uses' => 'GestionTicketsApsController@GetTicketAsignado']);
            //Validar Existencia de ticket asignado para asignar
            Route::get('/Agente/ValidarTicketAsignado/{id}', ['middleware' => 'cors', 'uses' => 'GestionTicketController@ValidarTicketAsignado']);
            //Validar Existencia de ticket asignado para asignar
            Route::get('/Agente/ValidarTicketAsignadoEM/{id}', ['middleware' => 'cors', 'uses' => 'GestionTicketEMSController@ValidarTicketAsignado']);
            //Validar Existencia de ticket asignado para asignar
            Route::get('/Agente/ValidarTicketAsignadoIND/{id}', ['middleware' => 'cors', 'uses' => 'GestionTicketsINDsController@ValidarTicketAsignado']);
            //Validar Existencia de ticket asignado para asignar
            Route::get('/Agente/ValidarTicketAsignadoAP/{id}', ['middleware' => 'cors', 'uses' => 'GestionTicketsApsController@ValidarTicketAsignado']);


            //Traer Dato Join Calendario
            Route::get('/Agente/getDatoCalendarioEM', ['middleware' => 'cors', 'uses' => 'GestionTicketController@GetDatoCalendarioEM']);
            //Traer Dato Join Calendario
            Route::get('/Agente/getDatoCalendarioIND', ['middleware' => 'cors', 'uses' => 'GestionTicketController@GetDatoCalendarioIND']);
            //Traer Dato Join Calendario
            Route::get('/Agente/getDatoCalendarioCA', ['middleware' => 'cors', 'uses' => 'GestionTicketController@GetDatoCalendarioCA']);
            //Traer Dato Join Calendario
            Route::post('/Agente/ModificarCategoria', ['middleware' => 'cors', 'uses' => 'CategoriaController@PutCategoria']);

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
            //Traer Usuarios Con su estado
            Route::get('/Agente/TraerUsuariosPermisos', ['middleware' => 'cors', 'uses' => 'UsersController@GetUsuariosPermisos']);
            //Desabilitar Usuario
            Route::post('/Agente/desabilitarHabilitarUsuario', ['middleware' => 'cors', 'uses' => 'UsersController@PutDesabilitarHabilitarUsuario']);
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
            //Traer Especialidades Sin Informatica
            Route::get('/Agente/getEspecialidadI', ['middleware' => 'cors', 'uses' => 'EspecialidadController@TraerdatossinI']);
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
            //Traer Listado Tipo Daño Equipos Medicos
            Route::get('/Agente/GetListadoDanio', ['middleware' => 'cors', 'uses' => 'EquipamientomedicodaniosController@GetListadoDanio']);
            //Traer Listado Detalles y Resolucion - Observacion Equipos Medicos
            Route::post('/Agente/DetallesEquipoMedico', ['middleware' => 'cors', 'uses' => 'DetalleSolicitudEMsController@GetDetallesEquipoMedico']);
             //Modificar Equipamiento Medico 
             Route::post('/Agente/PutEquipamientoMedico', ['middleware' => 'cors', 'uses' => 'EquipamientoMedicosController@PutEquipamientoMedico']);


            //Traer Listado Equipamiento Apoyo Clinico
            Route::get('/Agente/GetTodoEquipamientoApoyoClinico', ['middleware' => 'cors', 'uses' => 'EquipamientoApoyoClinicosController@GetTodoEquipamientoApoyoClinico']);


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

            //Agregar Nuevo Calendario Calderas
            Route::post('/Agente/PostCalendarioCal', ['middleware' => 'cors', 'uses' => 'CalendarioCalderasController@postNuevoTCalendario']);
            //Traer Todo Calendario Calderas
            Route::get('/Agente/GetCalendarioCal', ['middleware' => 'cors', 'uses' => 'CalendarioCalderasController@getTodoCalendario']);
            //Modificar o Agregar Items Calendario Calderas
            Route::post('/Agente/PutCalendarioCal', ['middleware' => 'cors', 'uses' => 'CalendarioCalderasController@PutNuevoTCalendario']);
            //Get Dia Administrativo Calderas
            Route::get('/Agente/DAdminCal', ['middleware' => 'cors', 'uses' => 'DiaAdministrativoCalderasController@get_dia_adm']);
            //Get Reemplazos Calderas
            Route::get('/Agente/RCalderas', ['middleware' => 'cors', 'uses' => 'ReemplazoCalderasController@get_reemplazo']);
            //Get Turno Extra Calderas
            Route::get('/Agente/TurExtCalderas', ['middleware' => 'cors', 'uses' => 'TurnoExtraCalderasController@get_turnoExtra']);
            //Get Vacaciones Calderas
            Route::get('/Agente/VCalderas', ['middleware' => 'cors', 'uses' => 'VacacionesCalderasController@get_vacaciones']);
            //Traer data especifica Calderas
            Route::post('/Agente/GetDataCalenCal', ['middleware' => 'cors', 'uses' => 'CalendarioCalderasController@get_data_esp_asc']);

            //Agregar Nuevo Calendario Electricos
            Route::post('/Agente/PostCalendarioElec', ['middleware' => 'cors', 'uses' => 'CalendarioElectricosController@postNuevoTCalendario']);
            //Traer Todo Calendario Electricos
            Route::get('/Agente/GetCalendarioElec', ['middleware' => 'cors', 'uses' => 'CalendarioElectricosController@getTodoCalendario']);
            //Modificar o Agregar Items Calendario Electricos
            Route::post('/Agente/PutCalendarioElec', ['middleware' => 'cors', 'uses' => 'CalendarioElectricosController@PutNuevoTCalendario']);
            //Get Dia Administrativo Electricos
            Route::get('/Agente/DAdminElec', ['middleware' => 'cors', 'uses' => 'DiaAdministrativoElectricosController@get_dia_adm']);
            //Get Reemplazos Electricos
            Route::get('/Agente/RElectricos', ['middleware' => 'cors', 'uses' => 'ReemplazoElectricosController@get_reemplazo']);
            //Get Turno Extra Electricos
            Route::get('/Agente/TurExtElectricos', ['middleware' => 'cors', 'uses' => 'TurnoExtraElectricosController@get_turnoExtra']);
            //Get Vacaciones Electricos
            Route::get('/Agente/VElectricos', ['middleware' => 'cors', 'uses' => 'VacacionesElectricosController@get_vacaciones']);
            //Traer data especifica Electricos
            Route::post('/Agente/GetDataCalenElec', ['middleware' => 'cors', 'uses' => 'CalendarioElectricosController@get_data_esp_asc']);

            //Agregar Nuevo Calendario Gasfiters
            Route::post('/Agente/PostCalendarioGasf', ['middleware' => 'cors', 'uses' => 'CalendarioGasfitersController@postNuevoTCalendario']);
            //Traer Todo Calendario Gasfiters
            Route::get('/Agente/GetCalendarioGasf', ['middleware' => 'cors', 'uses' => 'CalendarioGasfitersController@getTodoCalendario']);
            //Modificar o Agregar Items Calendario Gasfiters
            Route::post('/Agente/PutCalendarioGasf', ['middleware' => 'cors', 'uses' => 'CalendarioGasfitersController@PutNuevoTCalendario']);
            //Get Dia Administrativo Gasfiters
            Route::get('/Agente/DAdminGasfiters', ['middleware' => 'cors', 'uses' => 'DiaAdministrativoGasfitersController@get_dia_adm']);
            //Get Reemplazos Gasfiters
            Route::get('/Agente/RGasfiters', ['middleware' => 'cors', 'uses' => 'ReemplazoGasfitersController@get_reemplazo']);
            //Get Turno Extra Gasfiters
            Route::get('/Agente/TurExtGasfiters', ['middleware' => 'cors', 'uses' => 'TurnoExtraGasfitersController@get_turnoExtra']);
            //Get Vacaciones Gasfiters
            Route::get('/Agente/VGasfiters', ['middleware' => 'cors', 'uses' => 'VacacionesGasfitersController@get_vacaciones']);
            //Traer data especifica Gasfiters
            Route::post('/Agente/GetDataCalenGasf', ['middleware' => 'cors', 'uses' => 'CalendarioGasfitersController@get_data_esp_asc']);

            //Agregar Nuevo Calendario Oxigenistas
            Route::post('/Agente/PostCalendarioOxi', ['middleware' => 'cors', 'uses' => 'CalendarioOxigenistasController@postNuevoTCalendario']);
            //Traer Todo Calendario Gasfiters
            Route::get('/Agente/GetCalendarioOxi', ['middleware' => 'cors', 'uses' => 'CalendarioOxigenistasController@getTodoCalendario']);
            //Modificar o Agregar Items Calendario Gasfiters
            Route::post('/Agente/PutCalendarioOxi', ['middleware' => 'cors', 'uses' => 'CalendarioOxigenistasController@PutNuevoTCalendario']);
            //Get Dia Administrativo Gasfiters
            Route::get('/Agente/DAdminOxigenistas', ['middleware' => 'cors', 'uses' => 'DiaAdministrativoOxigenistasController@get_dia_adm']);
            //Get Reemplazos Gasfiters
            Route::get('/Agente/ROxigenistas', ['middleware' => 'cors', 'uses' => 'ReemplazoOxigenistasController@get_reemplazo']);
            //Get Turno Extra Gasfiters
            Route::get('/Agente/TurExtOxigenistas', ['middleware' => 'cors', 'uses' => 'TurnoExtraOxigenistasController@get_turnoExtra']);
            //Get Vacaciones Gasfiters
            Route::get('/Agente/VOxigenistas', ['middleware' => 'cors', 'uses' => 'VacacionesOxigenistasController@get_vacaciones']);
            //Traer data especifica Gasfiters
            Route::post('/Agente/GetDataCalenOxigenistas', ['middleware' => 'cors', 'uses' => 'CalendarioOxigenistasController@get_data_esp_asc']);

            //Retorna Categorias Sin Informatica
            Route::get('/Usuario/getCategoriaSI', ['middleware' => 'cors', 'uses' => 'CategoriaController@getCategoriaSI']);
            //Retorna Tipo Reparacion
            Route::get('/Usuario/getTReparacionSI', ['middleware' => 'cors', 'uses' => 'TipoReparacionController@getTReparacionSI']);
            //Inserta Documentos de las solicitudes finalizadas
            Route::post('/Usuario/PostDocumentoF', ['middleware' => 'cors', 'uses' => 'DocumentosFController@store']);
            //Inserta Documentos de las solicitudes finalizadas
            Route::post('/Usuario/PostDocumentoAP', ['middleware' => 'cors', 'uses' => 'DocumentosFController@storeAP']);
            //Inserta Documentos de las solicitudes finalizadas
            Route::post('/Usuario/PostDocumentoEM', ['middleware' => 'cors', 'uses' => 'DocumentosFController@storeEM']);
            //Inserta Documentos de las solicitudes finalizadas
            Route::post('/Usuario/PostDocumentoIND', ['middleware' => 'cors', 'uses' => 'DocumentosFController@storeIND']);
            //Inserta Documentos de las solicitudes finalizadas
            Route::post('/Agente/getDocumentos', ['middleware' => 'cors', 'uses' => 'DocumentosFController@getData']);
            //Trae Duracion 
            Route::get('/Agente/GetDuracion', ['middleware' => 'cors', 'uses' => 'DuracionSolicitudesController@getAll']);
            //Guardar Ticket
            Route::post('/Agente/PostCierreTicket', ['middleware' => 'cors', 'uses' => 'GestionTicketController@PostCierreTicket']);
            //Guardar Ticket
            Route::post('/Agente/PostCierreTicketEM', ['middleware' => 'cors', 'uses' => 'GestionTicketEMSController@PostCierreTicket']);
            //Guardar Ticket
            Route::post('/Agente/PostCierreTicketIND', ['middleware' => 'cors', 'uses' => 'GestionTicketsINDsController@PostCierreTicket']);
            //Guardar Ticket
            Route::post('/Agente/PostCierreTicketAP', ['middleware' => 'cors', 'uses' => 'GestionTicketsApsController@PostCierreTicket']);

            //Datos KPI 
            //Traer Estados Tickets
            Route::get('/Agente/TraerKPITickets', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@getTicketsKPI']);
            //Traer Tickets Pendientes,Finalizados y Nuevos.
            Route::get('/Agente/TraerKPITicketsTotal', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@getTicketsKPITotal']);
            //Traer Estados Tickets
            Route::get('/Agente/TraerKPITicketsEM', ['middleware' => 'cors', 'uses' => 'SolicitudTicketsEMController@getTicketsKPI']);
            //Traer Tickets Pendientes,Finalizados y Nuevos.
            Route::get('/Agente/TraerKPITicketsTotalEM', ['middleware' => 'cors', 'uses' => 'SolicitudTicketsEMController@getTicketsKPITotal']);
            //Traer Estados Tickets
            Route::get('/Agente/TraerKPITicketsIND', ['middleware' => 'cors', 'uses' => 'SolicitudTicketINDsController@getTicketsKPI']);
            //Traer Tickets Pendientes,Finalizados y Nuevos.
            Route::get('/Agente/TraerKPITicketsTotalIND', ['middleware' => 'cors', 'uses' => 'SolicitudTicketINDsController@getTicketsKPITotal']);
            //Traer Estados Tickets
            Route::get('/Agente/TraerKPITicketsAP', ['middleware' => 'cors', 'uses' => 'SolicitudTicketsApsController@getTicketsKPI']);
            //Traer Tickets Pendientes,Finalizados y Nuevos.
            Route::get('/Agente/TraerKPITicketsTotalAP', ['middleware' => 'cors', 'uses' => 'SolicitudTicketsApsController@getTicketsKPITotal']);
            //Traer Servicio mas solicitado.
            Route::get('/Agente/TraerServicioKPI', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@getKPIServicio']);
            //Traer usuario mas solicitante.
            Route::get('/Agente/TraerUsuarioKPI', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@getKPIUsuario']);
            //Traer Categoria mas solicitante.
            Route::get('/Agente/TraerCategoriaKPI', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@getKPICategoria']);
            //Traer Tipo Mantencion mas solicitante.
            Route::get('/Agente/TraerTipoMantencionKPI', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@getKPITipoMantencion']);
             //Traer Servicio mas solicitado Jefatura.
             Route::get('/Agente/TraerServicioKPIJ', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@getKPIServicioJ']);
             //Traer usuario mas solicitante Jefatura.
             Route::get('/Agente/TraerUsuarioKPIJ', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@getKPIUsuarioJ']);
             //Traer Categoria mas solicitante Jefatura.
             Route::get('/Agente/TraerCategoriaKPIJ', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@getKPICategoriaJ']);
             //Traer Tipo Mantencion mas solicitante Jefatura.
             Route::get('/Agente/TraerTipoMantencionKPIJ', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@getKPITipoMantencionJ']);
            //Traer Servicio mas solicitado EM.
            Route::get('/Agente/TraerServicioKPIEM', ['middleware' => 'cors', 'uses' => 'SolicitudTicketsEMController@getKPIServicio']);
            //Traer usuario mas solicitante EM.
            Route::get('/Agente/TraerUsuarioKPIEM', ['middleware' => 'cors', 'uses' => 'SolicitudTicketsEMController@getKPIUsuario']);
            //Traer Categoria mas solicitante EM.
            Route::get('/Agente/TraerCategoriaKPIEM', ['middleware' => 'cors', 'uses' => 'SolicitudTicketsEMController@getKPICategoria']);
            //Traer Tipo Mantencion mas solicitante.
            Route::get('/Agente/TraerTipoMantencionKPIEM', ['middleware' => 'cors', 'uses' => 'SolicitudTicketsEMController@getKPITipoMantencion']);
            //Traer Servicio mas solicitado IND.
            Route::get('/Agente/TraerServicioKPIIND', ['middleware' => 'cors', 'uses' => 'SolicitudTicketINDsController@getKPIServicio']);
            //Traer usuario mas solicitante IND.
            Route::get('/Agente/TraerUsuarioKPIIND', ['middleware' => 'cors', 'uses' => 'SolicitudTicketINDsController@getKPIUsuario']);
            //Traer Categoria mas solicitante IND.
            Route::get('/Agente/TraerCategoriaKPIIND', ['middleware' => 'cors', 'uses' => 'SolicitudTicketINDsController@getKPICategoria']);
            //Traer Tipo Mantencion mas solicitante IND.
            Route::get('/Agente/TraerTipoMantencionKPIIND', ['middleware' => 'cors', 'uses' => 'SolicitudTicketINDsController@getKPITipoMantencion']);
            //Traer Servicio mas solicitado AP.
            Route::get('/Agente/TraerServicioKPIAP', ['middleware' => 'cors', 'uses' => 'SolicitudTicketsApsController@getKPIServicio']);
            //Traer usuario mas solicitante.
            Route::get('/Agente/TraerUsuarioKPIAP', ['middleware' => 'cors', 'uses' => 'SolicitudTicketsApsController@getKPIUsuario']);
            //Traer Categoria mas solicitante.
            Route::get('/Agente/TraerCategoriaKPIAP', ['middleware' => 'cors', 'uses' => 'SolicitudTicketsApsController@getKPICategoria']);
            //Traer Tipo Mantencion mas solicitante.
            Route::get('/Agente/TraerTipoMantencionKPIAP', ['middleware' => 'cors', 'uses' => 'SolicitudTicketsApsController@getKPITipoMantencion']);

            
            //Datos Calendario 
            //Traer ultimo ID Ingresado
            Route::get('/Agente/UltimoIDObra', ['middleware' => 'cors', 'uses' => 'GanttObrasController@GetLastIdObras']);
            //Traer Obras Existentes
            Route::get('/Agente/ListadoObras', ['middleware' => 'cors', 'uses' => 'GanttObrasController@GetObras']);
            //Guardar Nueva Obra
            Route::post('/Agente/GuardarNObra', ['middleware' => 'cors', 'uses' => 'GanttObrasController@PostNObra']);
            //Guardar Nueva Sub Categoria Obra
            Route::post('/Agente/GuardarNSubObra', ['middleware' => 'cors', 'uses' => 'GanttObrasController@PostNSubObra']);
            //Traer Obra Recurso Nulo
            Route::get('/Agente/BuscarObraRANull', ['middleware' => 'cors', 'uses' => 'GanttObrasController@PostNObraRANull']);
            //Traer Obra Recurso Activo
            Route::get('/Agente/BuscarObraRActiva', ['middleware' => 'cors', 'uses' => 'GanttObrasController@PostNObraRA']);
            //Modificar Obra 
            Route::post('/Agente/ModificarObra', ['middleware' => 'cors', 'uses' => 'GanttObrasController@PutObra']);
            //Traer Color Cargo
            Route::post('/Agente/TraerColorCargo', ['middleware' => 'cors', 'uses' => 'GanttObrasController@GetColorCargo']);

            //Datos Calendario Industrial
            //Traer ultimo ID Ingresado
            Route::get('/Agente/UltimoIDMantencionI', ['middleware' => 'cors', 'uses' => 'GanttIndustrialController@GetLastIdObras']);
            //Traer Obras Existentes
            Route::get('/Agente/ListadoMantencionI', ['middleware' => 'cors', 'uses' => 'GanttIndustrialController@GetObras']);
            //Guardar Nueva Obra
            Route::post('/Agente/GuardarNMantencionI', ['middleware' => 'cors', 'uses' => 'GanttIndustrialController@PostNObra']);
            //Guardar Nueva Sub Categoria Obra
            Route::post('/Agente/GuardarNSubMantencionI', ['middleware' => 'cors', 'uses' => 'GanttIndustrialController@PostNSubObra']);
            //Traer Obra Recurso Nulo
            Route::get('/Agente/BuscarMantencionRANullI', ['middleware' => 'cors', 'uses' => 'GanttIndustrialController@PostNObraRANull']);
            //Traer Obra Recurso Activo
            Route::get('/Agente/BuscarMantencionRActivaI', ['middleware' => 'cors', 'uses' => 'GanttIndustrialController@PostNObraRA']);
            //Modificar Obra 
            Route::post('/Agente/ModificarMantencionI', ['middleware' => 'cors', 'uses' => 'GanttIndustrialController@PutObra']);
            //Traer Color Cargo
            Route::post('/Agente/TraerColorCargoI', ['middleware' => 'cors', 'uses' => 'GanttIndustrialController@GetColorCargo']);

            //Datos Notificaciones
            //Traer Ultimas 5 Notificaciones en Proceso Infraestructura
            Route::get('/Agente/TraerNotificacionesJ', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@getNotificacionesJ']);
            //Traer Ultimas 5 Notificaciones en Proceso Infraestructura
            Route::get('/Agente/TraerNotificaciones', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@getNotificaciones']);
            //Traer Ultimas 5 Notificaciones en Proceso Equipos Medicos
            Route::get('/Agente/TraerNotificacionesEM', ['middleware' => 'cors', 'uses' => 'SolicitudTicketsEMController@getNotificaciones']);
            //Traer Ultimas 5 Notificaciones en Proceso Industrial
            Route::get('/Agente/TraerNotificacionesIND', ['middleware' => 'cors', 'uses' => 'SolicitudTicketINDsController@getNotificaciones']);
            //Traer Ultimas 5 Notificaciones en Proceso Apoyo Clinico
            Route::get('/Agente/TraerNotificacionesAP', ['middleware' => 'cors', 'uses' => 'SolicitudTicketsApsController@getNotificaciones']);
            //Traer Ultimas 5 Notificaciones nuevas
            Route::get('/Agente/TraerNotificacionesN', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@getNotificacionesN']);
            //Traer Ultimas 5 Notificaciones nuevas
            Route::get('/Agente/TraerNotificacionesNJ', ['middleware' => 'cors', 'uses' => 'SolicitudUsuarioController@getNotificacionesNJ']);
            //Traer Ultimas 5 Notificaciones nuevas
            Route::get('/Agente/TraerNotificacionesNEM', ['middleware' => 'cors', 'uses' => 'SolicitudTicketsEMController@getNotificacionesN']);
            //Traer Ultimas 5 Notificaciones nuevas
            Route::get('/Agente/TraerNotificacionesNIND', ['middleware' => 'cors', 'uses' => 'SolicitudTicketINDsController@getNotificacionesN']);
            //Traer Ultimas 5 Notificaciones nuevas
            Route::get('/Agente/TraerNotificacionesNAP', ['middleware' => 'cors', 'uses' => 'SolicitudTicketsApsController@getNotificacionesN']);

            //Seccion de Informatica
            //Traer Tickets con sus usuarios - Informatica
            Route::get('/Agente/GetSolicitudTicketsI', ['middleware' => 'cors', 'uses' => 'GestionTicketController@getSolicitudUsuariosJoinI']);

            //Busqueda Ticket Cadena
            Route::post('/Agente/GetTicketCadena', ['middleware' => 'cors', 'uses' => 'TicketCadenasController@BuscarExistenciaCadena']);

            //Calendario Mantenciones Apoyo Clinico
            Route::post('/Agente/PostCalendarioMAP', ['middleware' => 'cors', 'uses' => 'MantencionApProgramadasController@PostCalMantencionI']);

            Route::post('/Agente/GetListadoEstRes', ['middleware' => 'cors', 'uses' => 'MantencionApProgramadasController@GetListadoEstRes']);

            Route::post('/Agente/GetMantencionesAPAnio', ['middleware' => 'cors', 'uses' => 'MantencionApProgramadasController@GetListadoMantencion']);

            Route::post('/Agente/PostDocumentoAP', ['middleware' => 'cors', 'uses' => 'DocumentacionAPTablesController@PostDocumentoAP']);

            Route::post('/Agente/GetDocumentosMAP', ['middleware' => 'cors', 'uses' => 'DocumentacionAPTablesController@showRegistroEspecifico']);

            Route::post('/Agente/PutCodMantencionAP', ['middleware' => 'cors', 'uses' => 'MantencionApProgramadasController@PostCodMantencionN']);

            Route::post('/Agente/PostEstadoMAP', ['middleware' => 'cors', 'uses' => 'MantencionApProgramadasController@PostEstadoM']);

            Route::post('/Agente/PostResponsableMAP', ['middleware' => 'cors', 'uses' => 'ResponsableApMantencionesController@PostResponsableAP']);

            Route::post('/Agente/GetListadoEspecificoAP', ['middleware' => 'cors', 'uses' => 'MantencionApProgramadasController@GetListadoEspecifico']);

            Route::post('/Agente/PutModificarCodigoMAP', ['middleware' => 'cors', 'uses' => 'MantencionApProgramadasController@PutModificarCodigoM']);

            Route::post('/Agente/PostDeleteDocumentoAP', ['middleware' => 'cors', 'uses' => 'DocumentacionAPTablesController@DestroyDocReg']);

            Route::post('/Agente/PostDeleteMantencionAP', ['middleware' => 'cors', 'uses' => 'MantencionApProgramadasController@PostDeleteMantencion']);

            //KPI Apoyo clinico 
            Route::get('/Agente/TraerKPIMProgramadaAP', ['middleware' => 'cors', 'uses' => 'MantencionApProgramadasController@getTicketsKPI']);

            //Guardar Calendario
            Route::post('/Agente/PostCalendarioMIndustrial', ['middleware' => 'cors', 'uses' => 'MantencionProgramadasController@PostCalMantencionI']);

            Route::post('/Agente/PostAnios', ['middleware' => 'cors', 'uses' => 'CalendarioaniosController@PostAnio']);

            Route::get('/Agente/GetAnios', ['middleware' => 'cors', 'uses' => 'CalendarioaniosController@GetAnio']);

            Route::post('/Agente/GetMantencionesAnio', ['middleware' => 'cors', 'uses' => 'MantencionProgramadasController@GetListadoMantencion']);

            Route::post('/Agente/PostDocumentoF', ['middleware' => 'cors', 'uses' => 'DocumentacionIndustrialsController@PostDocumentoIND']);

            Route::post('/Agente/GetDocumentosMIND', ['middleware' => 'cors', 'uses' => 'DocumentacionIndustrialsController@showRegistroEspecifico']);

            Route::get('/Agente/GetTMantencion', ['middleware' => 'cors', 'uses' => 'TipoMantencionesController@GetTipoMantenciones']);

            Route::get('/Agente/GetEstadoMIndustrial', ['middleware' => 'cors', 'uses' => 'EstadoCodMIndustrialesController@GetEstadoCodMInd']);

            Route::post('/Agente/PutCodMantencion', ['middleware' => 'cors', 'uses' => 'MantencionProgramadasController@PostCodMantencionN']);

            Route::post('/Agente/PostEstadoM', ['middleware' => 'cors', 'uses' => 'MantencionProgramadasController@PostEstadoM']);

            Route::post('/Agente/GetListadoEspecifico', ['middleware' => 'cors', 'uses' => 'MantencionProgramadasController@GetListadoEspecifico']);
            
            Route::post('/Agente/PutModificarCodigoM', ['middleware' => 'cors', 'uses' => 'MantencionProgramadasController@PutModificarCodigoM']);

            Route::post('/Agente/PostDeleteDocumento', ['middleware' => 'cors', 'uses' => 'DocumentacionIndustrialsController@DestroyDocReg']);

            Route::post('/Agente/PostDeleteMantencion', ['middleware' => 'cors', 'uses' => 'MantencionProgramadasController@PostDeleteMantencion']);

            //KPI Mantencion Industrial

             //Traer Estados Tickets
             Route::get('/Agente/TraerKPIMProgramada', ['middleware' => 'cors', 'uses' => 'MantencionProgramadasController@getTicketsKPI']);

             //Cilindros
              //Traer Estados Tickets
              Route::get('/Agente/GetCilindros', ['middleware' => 'cors', 'uses' => 'CilindrosController@GetCilindros']);
              
              //Post Cilindros
              Route::post('/Agente/PostECilindros', ['middleware' => 'cors', 'uses' => 'EntregacilindrosController@PostECilindros']);

              //Datos Ticket Para exportar a PDF Bodega
              Route::post('/Agente/ExportarDataPDF', ['middleware' => 'cors', 'uses' => 'PdfController@ExportarDataPDF']);

            //Listado Equipamiento Medicos  
            Route::post('/Agente/ListadoEquipamientoMedicoByID', ['middleware' => 'cors', 'uses' => 'TblTicketEquipamientoMedicosController@ListadoEquipamientoMedicoByID']); 
            
            //Modificar Fechas 
            Route::post('/Agente/PutFechasI', ['middleware' => 'cors', 'uses' => 'GestionTicketsINDsController@PutFechas']);  
            //Modificar Fechas 
            Route::post('/Agente/PutFechasEM', ['middleware' => 'cors', 'uses' => 'GestionTicketsINDsController@PutFechas']);  
            //Modificar Fechas 
            Route::post('/Agente/PutFechasIND', ['middleware' => 'cors', 'uses' => 'GestionTicketsINDsController@PutFechas']);  
            //Modificar Fechas 
            Route::post('/Agente/PutFechasAP', ['middleware' => 'cors', 'uses' => 'GestionTicketsINDsController@PutFechas']);  

            //Enviar Correo Personalizado a Usuario
            Route::post('/Agente/PostMensajeCorreo', ['middleware' => 'cors', 'uses' => 'GestionTicketController@PostMensajeCorreo']);
            
            //Enviar Correo Personalizado a Usuario Apoyo Clinico
            Route::post('/Agente/PostMensajeCorreoAP', ['middleware' => 'cors', 'uses' => 'GestionTicketsApsController@PostMensajeCorreo']);

            //Enviar Correo Personalizado a Usuario Equipos Medicos
            Route::post('/Agente/PostMensajeCorreoEM', ['middleware' => 'cors', 'uses' => 'GestionTicketEMSController@PostMensajeCorreo']);

            //Enviar Correo Personalizado a Usuario Industrial
            Route::post('/Agente/PostMensajeCorreoIND', ['middleware' => 'cors', 'uses' => 'GestionTicketsINDsController@PostMensajeCorreo']);
      });
      //Rutas sin JWT
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
      Route::get('/Agente/generarExcelByFechaI/{fechaInicio}/{fechaTermino}', 'ExcelController@generarExcelByFechaI');

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
    //Imprimir Acta Cilindros
    //Imprimir Ticket Industrial
    Route::get('/Agente/imprimirCilindroIND/{id}', ['middleware' => 'cors', 'uses' => 'PdfController@imprimirCilindroIND']);

    //Generar Excel	Jefatura
    Route::get('/Agente/generarExcelTodoJ', 'ExcelJefaturaController@generarExcelTodo');
    //Generar Excel	Por Fechas
    Route::get('/Agente/generarExcelByFechaJ/{fechaInicio}/{fechaTermino}', 'ExcelJefaturaController@generarExcelByFecha');
    //Generar Excel	
    Route::get('/Agente/generarExcelTodoEMJ', 'ExcelJefaturaController@generarExcelTodoEM');
    //Generar Excel	Por Fechas
    Route::get('/Agente/generarExcelByFechaEMJ/{fechaInicio}/{fechaTermino}', 'ExcelJefaturaController@generarExcelByFechaEM');
    //Generar Excel	
    Route::get('/Agente/generarExcelTodoAPJ', 'ExcelJefaturaController@generarExcelTodoAP');
    //Generar Excel	Por Fechas
    Route::get('/Agente/generarExcelByFechaAPJ/{fechaInicio}/{fechaTermino}', 'ExcelJefaturaController@generarExcelByFechaAP');
    //Generar Excel	
    Route::get('/Agente/generarExcelTodoIJ', 'ExcelJefaturaController@generarExcelTodoI');
    //Generar Excel	Por Fechas
    Route::get('/Agente/generarExcelByFechaIJ/{fechaInicio}/{fechaTermino}', 'ExcelJefaturaController@generarExcelByFechaI');
    




