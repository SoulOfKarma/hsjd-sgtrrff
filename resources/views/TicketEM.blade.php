<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://localhost:8001/sgtrrff/public/css/bootstrap.min.css">

        <title>Ticket-EquiposMedicos</title>
        <style>
                    /*!
            * Bootstrap v3.3.7 (http://getbootstrap.com)
            * Copyright 2011-2016 Twitter, Inc.
            * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
            */

            /*! normalize.css v3.0.3 | MIT License | github.com/necolas/normalize.css */

            html {
                font-family: sans-serif;
                -webkit-text-size-adjust: 100%;
                -ms-text-size-adjust: 100%;
            }

            body {
                margin: 0;
            }

            ul,
            ol {
              margin-top: 0;
              margin-bottom: 10px;
            }
            ul ul,
            ol ul,
            ul ol,
            ol ol {
              margin-bottom: 0;
            }
            .list-unstyled {
              padding-left: 0;
              list-style: none;
            }
            .list-inline {
              padding-left: 0;
              margin-left: -5px;
              list-style: none;
            }
            .list-inline > li {
              display: inline-block;
              padding-right: 5px;
              padding-left: 5px;
            }
            dl {
              margin-top: 0;
              margin-bottom: 20px;
            }
            dt,
            dd {
              line-height: 1.42857143;
            }
            dt {
              font-weight: bold;
            }
            dd {
              margin-left: 0;
            }
            @media (min-width: 768px) {
              .dl-horizontal dt {
                float: left;
                width: 160px;
                overflow: hidden;
                clear: left;
                text-align: right;
                text-overflow: ellipsis;
                white-space: nowrap;
              }
              .dl-horizontal dd {
                margin-left: 180px;
              }
            }
            abbr[title],
            abbr[data-original-title] {
              cursor: help;
              border-bottom: 1px dotted #777;
            }
            .initialism {
              font-size: 90%;
              text-transform: uppercase;
            }
            blockquote {
              padding: 10px 20px;
              margin: 0 0 20px;
              font-size: 17.5px;
              border-left: 5px solid #eee;
            }
            blockquote p:last-child,
            blockquote ul:last-child,
            blockquote ol:last-child {
              margin-bottom: 0;
            }

            hr {
                margin-top: 20px;
                margin-bottom: 20px;
                border: 0;
                border-top: 1px solid #eee;
            }

            .list-group {
              padding-left: 0;
              margin-bottom: 20px;
            }
            .list-group-item {
              position: relative;
              display: block;
              padding: 10px 15px;
              margin-bottom: -1px;
              background-color: #fff;
              border: 1px solid #ddd;
            }

            .panel > .list-group,
            .panel > .panel-collapse > .list-group {
              margin-bottom: 0;
            }
            .panel > .list-group .list-group-item,
            .panel > .panel-collapse > .list-group .list-group-item {
              border-width: 1px 0;
              border-radius: 0;
            }

            .list-group + .panel-footer {
              border-top-width: 0;
            }

            .panel-group .panel-heading + .panel-collapse > .panel-body,
            .panel-group .panel-heading + .panel-collapse > .list-group {
              border-top: 1px solid #ddd;
            }

            article,
            aside,
            details,
            figcaption,
            figure,
            footer,
            header,
            hgroup,
            main,
            menu,
            nav,
            section,
            summary {
                display: block;
            }

            b,
            strong {
                font-weight: 700;
            }

            h1 {
                margin: 0.67em 0;
                font-size: 2em;
            }

            hr {
                height: 0;
                -webkit-box-sizing: content-box;
                -moz-box-sizing: content-box;
                box-sizing: content-box;
            }

            /*! Source: https://github.com/h5bp/html5-boilerplate/blob/master/src/css/main.css */

            @media print {
                *,
                h2,
                h3,
                p {
                    orphans: 3;
                    widows: 3;
                }
                h2,
                h3 {
                    page-break-after: avoid;
                }
            }

            hr {
                margin-top: 20px;
                margin-bottom: 20px;
                border: 0;
                border-top: 1px solid #eee;
            }

            .h1,
            .h2,
            .h3,
            .h4,
            .h5,
            .h6,
            h1,
            h2,
            h3,
            h4,
            h5,
            h6 {
                font-family: inherit;
                font-weight: 500;
                line-height: 1.1;
                color: inherit;
            }

            .h1 .small,
            .h1 small,
            .h2 .small,
            .h2 small,
            .h3 .small,
            .h3 small,
            .h4 .small,
            .h4 small,
            .h5 .small,
            .h5 small,
            .h6 .small,
            .h6 small,
            h1 .small,
            h1 small,
            h2 .small,
            h2 small,
            h3 .small,
            h3 small,
            h4 .small,
            h4 small,
            h5 .small,
            h5 small,
            h6 .small,
            h6 small {
                font-weight: 400;
                line-height: 1;
                color: #777;
            }

            .h1,
            .h2,
            .h3,
            h1,
            h2,
            h3 {
                margin-top: 20px;
                margin-bottom: 10px;
            }

            .h1 .small,
            .h1 small,
            .h2 .small,
            .h2 small,
            .h3 .small,
            .h3 small,
            h1 .small,
            h1 small,
            h2 .small,
            h2 small,
            h3 .small,
            h3 small {
                font-size: 65%;
            }

            .h4,
            .h5,
            .h6,
            h4,
            h5,
            h6 {
                margin-top: 10px;
                margin-bottom: 10px;
            }

            .h4 .small,
            .h4 small,
            .h5 .small,
            .h5 small,
            .h6 .small,
            .h6 small,
            h4 .small,
            h4 small,
            h5 .small,
            h5 small,
            h6 .small,
            h6 small {
                font-size: 75%;
            }

            .h1,
            h1 {
                font-size: 36px;
            }

            .h2,
            h2 {
                font-size: 30px;
            }

            .h3,
            h3 {
                font-size: 24px;
            }

            .h4,
            h4 {
                font-size: 18px;
            }

            .h5,
            h5 {
                font-size: 14px;
            }

            .h6,
            h6 {
                font-size: 12px;
            }

            p {
                margin: 0 0 10px;
            }

            .container {
                padding-right: 15px;
                padding-left: 15px;
                margin-right: auto;
                margin-left: auto;
            }

            @media (min-width: 768px) {
                .container {
                    width: 750px;
                }
            }

            @media (min-width: 992px) {
                .container {
                    width: 970px;
                }
            }

            @media (min-width: 1200px) {
                .container {
                    width: 1170px;
                }
            }

            .container-fluid {
                padding-right: 15px;
                padding-left: 15px;
                margin-right: auto;
                margin-left: auto;
            }

            .row {
                margin-right: -15px;
                margin-left: -15px;
            }

            .col-xs-1,
            .col-xs-10,
            .col-xs-11,
            .col-xs-12,
            .col-xs-2,
            .col-xs-3,
            .col-xs-4,
            .col-xs-5,
            .col-xs-6,
            .col-xs-7,
            .col-xs-8,
            .col-xs-9 {
                position: relative;
                min-height: 1px;
                padding-right: 15px;
                padding-left: 15px;
            }

            .col-xs-1,
            .col-xs-10,
            .col-xs-11,
            .col-xs-12,
            .col-xs-2,
            .col-xs-3,
            .col-xs-4,
            .col-xs-5,
            .col-xs-6,
            .col-xs-7,
            .col-xs-8,
            .col-xs-9 {
                float: left;
            }

            .col-xs-12 {
                width: 100%;
            }

            .col-xs-11 {
                width: 91.66666667%;
            }

            .col-xs-10 {
                width: 83.33333333%;
            }

            .col-xs-9 {
                width: 75%;
            }

            .col-xs-8 {
                width: 66.66666667%;
            }

            .col-xs-7 {
                width: 58.33333333%;
            }

            .col-xs-6 {
                width: 50%;
            }

            .col-xs-5 {
                width: 41.66666667%;
            }

            .col-xs-4 {
                width: 33.33333333%;
            }

            .col-xs-3 {
                width: 25%;
            }

            .col-xs-2 {
                width: 16.66666667%;
            }

            .col-xs-1 {
                width: 8.33333333%;
            }

            label {
                display: inline-block;
                max-width: 100%;
                margin-bottom: 5px;
                font-weight: 700;
            }

            .container-fluid > .navbar-collapse,
            .container-fluid > .navbar-header,
            .container > .navbar-collapse,
            .container > .navbar-header {
                margin-right: -15px;
                margin-left: -15px;
            }

            .panel {
                margin-bottom: 15px;
                background-color: #fff;
                border: 1px solid transparent;
                border-radius: 4px;
                -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
                box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
            }

            .panel-body {
                padding: 16px;
            }

            .panel-heading {
                padding: 10px 15px;
                border-bottom: 1px solid transparent;
                border-top-left-radius: 3px;
                border-top-right-radius: 3px;
            }

            .panel-heading > .dropdown .dropdown-toggle {
                color: inherit;
            }

            .panel-title {
                margin-top: 0;
                margin-bottom: 0;
                font-size: 16px;
                color: inherit;
            }

            .panel-title > .small,
            .panel-title > .small > a,
            .panel-title > a,
            .panel-title > small,
            .panel-title > small > a {
                color: inherit;
            }

            .panel-footer {
                padding: 10px 15px;
                background-color: #f5f5f5;
                border-top: 1px solid #ddd;
                border-bottom-right-radius: 3px;
                border-bottom-left-radius: 3px;
            }

            .panel-primary {
                border-color: #337ab7;
            }

            .panel-primary > .panel-heading {
                color: #000000;
                background-color: #fff;
                border-color: #337ab7;
            }

            .panel-primary > .panel-heading + .panel-collapse > .panel-body {
                border-top-color: #337ab7;
            }

            .panel-primary > .panel-heading .badge {
                color: #000000;
                background-color: #fff;
            }

            .panel-primary > .panel-footer + .panel-collapse > .panel-body {
                border-bottom-color: #337ab7;
            }

            .container-fluid:after,
            .container-fluid:before,
            .container:after,
            .container:before,
            .panel-body:after,
            .panel-body:before,
            .row:after,
            .row:before {
                display: table;
                content: " ";
            }

            .container-fluid:after,
            .container:after,
            .panel-body:after,
            .row:after {
                clear: both;
            }
                    </style>
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
                      height: 2em;
                        width: 90%;
                    }
        </style>

    </head>
    <body>
        <div class="container">
            <div class="row">
              <div class="col-xs-2"> <img src="http://localhost:8001/sgtrrff/resources/assets/images/logo/1.png"></div>
                <div class="col-xs-10">
                  <h3 id="tituloOrd"><b>Orden de Trabajo</b> </h3>
                  <h4 id="subOrd"><b>Unidad de Mantenimiento - Equipo Medico</b> </h4>
                  
                </div>
                <div class="col-xs-2"></div>
            
            </div>
            <div class="row">
              <div class="col-xs-2"><label>N°OT</label></div>
              <div class="col-xs-2"><small>{{$idSolicitud}}</small></div>
              <div class="col-xs-1"></div>
              <div class="col-xs-2"><label>Fecha Solicitud</label> </div>
              <div class="col-xs-2"><small>{{$fechaS}}</small></div>
              <div class="col-xs-1"></div>
            </div>
            <div class="row">
              <div class="col-xs-2"><label>Edificio</label></div>
              <div class="col-xs-2"><small>{{$desEdificio}}</small></div>
              <div class="col-xs-1"></div>
              <div class="col-xs-2"><label>Servicio</label></div>
              <div class="col-xs-2"><small>{{$desServicio}}</small></div>
              <div class="col-xs-1"></div>
            </div>
            <div class="row">
              <div class="col-xs-2"><label>Estado</label></div>
              <div class="col-xs-2"><small>{{$desEstado}}</small></div>
              <div class="col-xs-1"></div>
            </div>
            <div class="row">
              <div class="col-xs-2"><label>Responsable</label></div>
              <div class="col-xs-2"><small>{{$nombreTra}}</smail> </div>
              <div class="col-xs-1"></div>
              <div class="col-xs-2"><label>Supervisor</label> </div>
              <div class="col-xs-2"><small>{{$nombreSup}}</small></div>
              <div class="col-xs-1"></div>
            </div>
            <div class="row">
              <div class="col-xs-2"><label>Apoyo 1</label></div>
              <div class="col-xs-2"><small>{{$nomApoyo1}} {{$apeApoyo1}} <small></div>
              <div class="col-xs-1"></div>
              <div class="col-xs-2"><label>Apoyo 2</label> </div>
              <div class="col-xs-2"><small>{{$nomApoyo2}} {{$apeApoyo2}}</small></div>
              <div class="col-xs-1"></div>
            </div>
            <div class="row">
              <div class="col-xs-2"><label>Apoyo 3</label></div>
              <div class="col-xs-2"><small>{{$nomApoyo3}} {{$apeApoyo3}}</small></div>
              <div class="col-xs-1"></div>
              <div class="col-xs-2"><label>Especialidad</label> </div>
              <div class="col-xs-2"><small>{{$desTipoRep}}</small></div>
              <div class="col-xs-1"></div>
            </div>
            <div class="row">
              <div class="col-xs-2"><label>Fecha Programada</label></div>
              <div class="col-xs-2"><small>{{$fechaI}}</small> </div>
              <div class="col-xs-1"></div>
              <div class="col-xs-2"><label>Dias Ejecucion</label></div>
              <div class="col-xs-2"><small>{{$diasEjecucion}}</small></div>
              <div class="col-xs-1"></div>
            </div>
            <div class="row">
              <div class="col-xs-2"><label>Horas Ejecucion</label></div>
              <div class="col-xs-2"><small>{{$horasEjecucion}}</small> </div>
              <div class="col-xs-1"></div>
              <div class="col-xs-2"><label>Turno</label></div>
              <div class="col-xs-2"><small>{{$descripcionTurno}}</small></div>
              <div class="col-xs-1"></div>
            </div>
            <div class="row">
              <div class="col-xs-2"><label>Anexo</label></div>
              <div class="col-xs-2"><small>{{$anexo}}</small> </div>
              <div class="col-xs-1"></div>
              <div class="col-xs-2"><label>Duracion</label></div>
              <div class="col-xs-2"><small>{{$duracionSolicitudes}}</small></div>
              <div class="col-xs-1"></div>
            </div><br>
            <div class="row">
              <div class="col-xs-12">
                <div class="panel panel-primary">
                  <div class="panel-heading">
                    <h3 class="panel-title">Solicitud realizada por el servicio de {{$desServicio}} - {{$desEdificio}}</h3>
                  </div>
                  <br>
                  <!-- <div class="panel-body" id="descripcion">
                  </div>  -->
                  
                  <?php
                    echo "<ul>$descripcionPro </ul>";
                  ?>  
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
            <br>
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