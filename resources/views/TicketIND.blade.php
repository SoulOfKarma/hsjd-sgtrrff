<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://localhost:8080/proyectov1/public/css/bootstrap.min.css">

        <title>Ticket-Industrial</title>
        <style>#TADescripcion{
          width: 99%;
        }
        
        #alinearDerecha{
          text-align: right;
          width: 75%;
        }
        
        #tituloOrd{
          text-align: center;
          width: 75%;
        }
        
        #subOrd{
          text-align: center;
          width: 75%;
        }

        #hoverL{
          text-align: center;
          width:60%;
       
        }

        #centrarFirmas{
          width: 300px;
          height: 50px;
        }
        
        #TADescripcion {
            height: 8em;
            width: 90%;
        }
        
        .panel-body{
          height: 5em;
            width: 90%;
        }
        </style>

    </head>
    <body>
        <div class="container">
            <div class="row">
              <div class="col-xs-2"> <img src="http://localhost:8080/proyectov1/resources/assets/images/logo/1.png"></div>
                <div class="col-xs-10">
                  <h3 id="tituloOrd"><b>Orden de Trabajo</b> </h3>
                  <h4 id="subOrd"><b>Unidad de Mantenimiento - Industrial</b> </h4>
                  
                </div>
                <div class="col-xs-2"></div>
            
            </div>
            <div class="row">
              <div class="col-xs-2"><label>N°Ticket</label></div>
              <div class="col-xs-2"><strong>{{$idSolicitud}}</strong></div>
              <div class="col-xs-1"></div>
              <div class="col-xs-3"><label>Fecha Solicitud</label> </div>
              <div class="col-xs-2"><label>{{$fechaS}}</label></div>
              <div class="col-xs-2"></div>
            </div>
            <div class="row">
              <div class="col-xs-2"><label>Edificio</label></div>
              <div class="col-xs-2"><label>{{$desEdificio}}</label></div>
              <div class="col-xs-1"></div>
              <div class="col-xs-3"><label>Servicio</label></div>
              <div class="col-xs-2"><label>{{$desServicio}}</label></div>
              <div class="col-xs-2"></div>
            </div>
            <div class="row">
              <div class="col-xs-2"><label>Unidad Especifica</label></div>
              <div class="col-xs-2"><label>{{$desUnidadEsp}}</label></div>
              <div class="col-xs-1"></div>
              <div class="col-xs-3"><label>Estado</label></div>
              <div class="col-xs-2"><label>{{$desEstado}}</label></div>
              <div class="col-xs-2"></div>
            </div>
            <div class="row">
              <div class="col-xs-2"><label>Responsable</label></div>
              <div class="col-xs-2"><label>{{$nombreTra}}</label> </div>
              <div class="col-xs-1"></div>
              <div class="col-xs-3"><label>Supervisor</label> </div>
              <div class="col-xs-2"><label>{{$nombreSup}}</label></div>
              <div class="col-xs-2"></div>
            </div>
            <div class="row">
              <div class="col-xs-2"><label>Apoyo 1</label></div>
              <div class="col-xs-2"><label>{{$nomApoyo1}} {{$apeApoyo3}}</label> </div>
              <div class="col-xs-1"></div>
              <div class="col-xs-3"><label>Apoyo 2</label> </div>
              <div class="col-xs-2"><label>{{$nomApoyo2}} {{$apeApoyo3}}</label></div>
              <div class="col-xs-2"></div>
            </div>
            <div class="row">
              <div class="col-xs-2"><label>Apoyo 3</label></div>
              <div class="col-xs-2"><label>{{$nomApoyo3}} {{$apeApoyo3}}</label></div>
              <div class="col-xs-1"></div>
              <div class="col-xs-3"><label>Especialidad</label> </div>
              <div class="col-xs-2"><label>{{$desTipoRep}}</label></div>
              <div class="col-xs-2"></div>
            </div>
            <div class="row">
              <div class="col-xs-2"><label>Fecha Programada</label></div>
              <div class="col-xs-2"><label>{{$fechaI}}</label> </div>
              <div class="col-xs-1"></div>
              <div class="col-xs-3"><label>Dias Ejecucion</label></div>
              <div class="col-xs-2"><label>{{$diasEjecucion}}</label></div>
              <div class="col-xs-2"></div>
            </div>
            <div class="row">
              <div class="col-xs-2"><label>Horas Ejecucion</label></div>
              <div class="col-xs-2"><label>{{$horasEjecucion}}</label> </div>
              <div class="col-xs-1"></div>
              <div class="col-xs-3"><label>Turno</label></div>
              <div class="col-xs-2"><label>{{$descripcionTurno}}</label></div>
              <div class="col-xs-2"></div>
            </div><br>
            <div class="row">
              <div class="col-xs-12">
                <div class="panel panel-primary">
                  <div class="panel-heading">
                    <h3 class="panel-title">Solicitud realizada por el servicio de {{$desServicio}} - {{$desEdificio}}</h3>
                  </div>
                  <div class="panel-body" id="descripcion">
                    {{$descripcionPro}}
                  </div>
                </div>
              </div>
            </div><br>
            <div class="row">
              <div class="col-xs-12">    
                <div class="panel panel-primary">
                  <div class="panel-heading">
                    <h3 class="panel-title">Trabajo realizado por la unidad de Mantencion</h3>
                  </div>
                  <div class="panel-body">
                    
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-1"></div>
              <div class="col-xs-5" id="centrarFirmas"><label id="hoverL">Nombre y firma Solicitante</label></div>
              <div class="col-xs-5" id="centrarFirmas"><label id="hoverL">_____________________</label><br>
                <label id="hoverL">{{$nombreUsuario}}</label>
              </div>
              <div class="col-xs-1"></div>
            </div><br>
            <div class="row">
              <div class="col-xs-1"></div>
              <div class="col-xs-5" id="centrarFirmas">
                <label id="hoverL" >Nombre y firma Responsable</label></div>
              <div class="col-xs-5" id="centrarFirmas"><label id="hoverL">_____________________</label> <br>
                <label id="hoverL" >{{$nombreTra}}</label>
              </div>
              <div class="col-xs-1"></div>
              
            </div><br>
            <div class="row">
              <div class="col-xs-1"></div>
              <div class="col-xs-5" id="centrarFirmas"><label id="hoverL">Nombre y firma Supervisor</label></div>
              <div class="col-xs-5" id="centrarFirmas"><label id="hoverL"> _____________________</label> <br>
                <label id="hoverL" >{{$nombreSup}}</label>
              </div>
              <div class="col-xs-1"></div>
              
            </div>
        </div>
        
    </body>
   
</html>