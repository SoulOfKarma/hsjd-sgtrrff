<template>
    <div>
        <vs-row>
            <div
                class="router-header flex flex-wrap items-center mb-6"
                style="margin-left:10px;"
            >
                <div
                    class="content-area__heading pr-4 border-0 md:border-r border-solid border-grey-light"
                >
                    <h2 class="mb-1">Modificar Solicitud</h2>
                </div>
                <div class="vx-breadcrumb ml-4 md:block hidden">
                    <div
                        class="content-area__heading pr-4 border-0 md:border-r border-solid border-grey-light"
                    >
                        <h3 class="mb-1">
                            Usuario:
                            <strong>{{ solicitud.nombre }}</strong>
                        </h3>
                    </div>
                </div>
            </div>
            <vs-alert
                color="primary"
                icon="new_releases"
                active="true"
                style="margin-bottom: 10px;"
            >
                <p>Recuerda que todos los campos son obligatorios!</p>
            </vs-alert>
            <!-- Ubicacion -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="1. Lugar del problema">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.1 - Seleccione el Edificio</h6>
                            <br />
                            <v-select
                                v-model="seleccionEdificio"
                                placeholder="Edificio"
                                class="w-full select-large"
                                label="descripcionEdificio"
                                :options="listadoEdificios"
                            ></v-select>
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.2 - Seleccione el Servicio</h6>
                            <br />
                            <v-select
                                v-model="seleccionServicio"
                                placeholder="Servicio"
                                class="w-full select-large"
                                label="descripcionServicio"
                                :options="listadoServicios"
                                @input="cargaSegunServicio"
                            ></v-select>
                        </div>
                    </div>
                </vx-card>
            </div>
            <!-- Informacion del Problema -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="2. Informacion del problema">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-full mt-5">
                            <h6>2.1 - Tipo de Reparacion</h6>
                            <br />
                            <v-select
                                v-model="seleccionReparacion"
                                placeholder="Seleccione Tipo de Reparacion"
                                class="w-full select-large"
                                label="descripcionTipoReparacion"
                                :options="listadoTipoRep"
                                @input="
                                    arrayTipoReparacion(seleccionReparacion.id)
                                "
                            ></v-select>
                            <br />
                            <h6>2.2 - Prioridad de la Solicitud</h6>
                            <br />
                            <v-select
                                v-model="seleccionPrioridad"
                                placeholder="Seleccione la Prioridad"
                                class="w-full select-large"
                                label="descripcion_prioridad"
                                :options="listadoPrioridad"
                            ></v-select>
                            <br />
                            <h6>2.3 - Titulo del Problema</h6>
                            <br />
                            <vs-input
                                label="Titulo problema"
                                placeholder="Ej. Falla de red en equipo x"
                                v-model="descripcionTitulo"
                                class="w-full"
                            />
                            <br />
                            <h6>2.4 - Descripcion del Problema</h6>
                            <br />
                            <quill-editor
                                v-model="descripcionProblema"
                                :options="editorOption"
                            >
                                <div id="toolbar" slot="toolbar"></div>
                            </quill-editor>
                            <br />
                            <h6>2.5 - Razon de la modificacion</h6>
                            <br />
                            <quill-editor
                                v-model="razoncambio"
                                :options="editorOption"
                            >
                                <div id="toolbar" slot="toolbar"></div>
                            </quill-editor>
                        </div>
                    </div>
                </vx-card>
            </div>
            <!-- Guardar o Limpiar -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row">
                    <div class="vx-col sm:w-2/3 w-full ml-auto">
                        <vs-button
                            class="mr-3 mb-2"
                            @click="volver"
                            color="success"
                            >Volver</vs-button
                        >
                        <vs-button
                            color="warning"
                            class="mr-3 mb-2"
                            @click="limpiar()"
                            >Limpiar</vs-button
                        >
                        <vs-button class="mb-2" @click="modificarSolicitud"
                            >Modificar</vs-button
                        >
                    </div>
                </div>
            </div>
        </vs-row>
    </div>
</template>

<script>
import Datepicker from "vuejs-datepicker";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import { FormWizard, TabContent } from "vue-form-wizard";
import "vue-form-wizard/dist/vue-form-wizard.min.css";
import axios from "axios";
import vSelect from "vue-select";
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import router from "@/router";

import { quillEditor } from "vue-quill-editor";

export default {
    data: () => ({
        editorOption: {
            modules: {
                toolbar: [
                    ["bold", "italic", "underline", "strike"],
                    ["blockquote", "code-block"],
                    [{ header: 1 }, { header: 2 }],
                    [{ list: "ordered" }, { list: "bullet" }],
                    [{ indent: "-1" }, { indent: "+1" }],
                    [{ direction: "rtl" }],
                    [{ font: [] }],
                    [{ align: [] }],
                    ["clean"]
                ]
            }
        },
        razoncambio: "",
        datosSolicitud: [],
        listadoEdificios: [],
        listadoServicios: [],
        listadoUnidadEsp: [],
        listadoTipoRep: [],
        listadoCorreo: [],
        listadoPrioridad: [],
        localVal: process.env.MIX_APP_URL,
        uuidC: "",
        colorLoading: "#ff8000",
        solicitud: {
            id: 0,
            nombre:
                sessionStorage.getItem("nombre") +
                " " +
                sessionStorage.getItem("apellido"),
            descripcionP: "",
            tituloP: "",
            id_user: sessionStorage.getItem("id"),
            id_estado: 1,
            id_edificio: 0,
            id_servicio: 0,
            id_ubicacionEx: 0,
            id_tipoReparacion: 0,
            id_prioridad: 0,
            id_solicitud: 0,
            uuid: "",
            descripcionSeguimiento: "",
            razonMail: "",
            descripcionProblema: ""
        },
        seleccionEdificio: {
            id: 0,
            descripcionEdificio: "Seleccione Edificio"
        },
        seleccionServicio: {
            id: 0,
            descripcionServicio: "Seleccione Servicio"
        },
        seleccionUnidadEsp: {
            id: 42,
            descripcionUnidadEsp: "N/A"
        },
        seleccionReparacion: {
            id: 0,
            descripcionTipoReparacion: "Seleccione Tipo de Reparacion"
        },
        seleccionPrioridad: {
            id: 0,
            descripcion_prioridad: "Seleccion Prioridad"
        },
        descripcionTitulo: "",
        descripcionProblema: ""
    }),
    computed: {
        csrf_token() {
            let token = document.head.querySelector('meta[name="csrf-token"]');
            return token.content;
        }
    },
    methods: {
        volver() {
            router.back();
        },
        limpiar() {
            this.solicitud = {
                id: 0,
                nombre:
                    sessionStorage.getItem("nombre") +
                    " " +
                    sessionStorage.getItem("apellido"),
                descripcionP: "",
                tituloP: "",
                id_user: sessionStorage.getItem("id"),
                id_estado: 1,
                id_edificio: 0,
                id_servicio: 0,
                id_ubicacionEx: 0,
                id_tipoReparacion: 0,
                id_solicitud: 0,
                uuid: "",
                descripcionSeguimiento: "",
                razonMail: "",
                descripcionProblema: "",
                razoncambio: ""
            };
            this.seleccionEdificio = {
                id: 0,
                descripcionEdificio: "Seleccione Edificio"
            };
            this.seleccionServicio = {
                id: 0,
                descripcionServicio: "Seleccione Servicio"
            };
            this.seleccionUnidadEsp = {
                id: 0,
                descripcionUnidadEsp: "Seleccione Unidad Especifica"
            };
            this.seleccionReparacion = {
                id: 0,
                descripcionTipoReparacion: "Seleccione Tipo de Reparacion"
            };
            this.descripcionTitulo = "";
            this.descripcionProblema = "";
        },
        arrayTipoReparacion(id) {
            let c = this.listadoTipoRep;
            let b = [];
            var a = 0;

            c.forEach((value, index) => {
                a = value.id;
                if (a == id) {
                    b.push(value);
                }
            });
            this.seleccionReparacion = b;
        },
        cargarPrioridades() {
            axios
                .get(this.localVal + "/api/Usuario/GetPrioridades", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoPrioridad = res.data;
                });
        },
        cargaSegunUnidadEsp() {
            var idGeneral = this.seleccionUnidadEsp.id;

            let c = this.listadoUnidadEsp;
            let b = [];
            var a = 0;

            c.forEach((value, index) => {
                a = value.id;
                if (a == idGeneral) {
                    b.push(value);
                }
            });
            this.seleccionUnidadEsp = b;
            idGeneral = 0;
            idGeneral = this.seleccionUnidadEsp[0].id_servicio;
            b = [];

            c = this.listadoServicios;

            c.forEach((value, index) => {
                a = value.id;
                if (a == idGeneral) {
                    b.push(value);
                }
            });

            this.seleccionServicio = b;
            idGeneral = 0;
            idGeneral = this.seleccionServicio[0].id_edificio;
            b = [];
            c = this.listadoEdificios;

            c.forEach((value, index) => {
                a = value.id;
                if (a == idGeneral) {
                    b.push(value);
                }
            });

            this.seleccionEdificio = b;
        },
        cargaSegunServicio() {
            var idGeneral = this.seleccionServicio.id;

            let c = this.listadoServicios;
            let b = [];
            var a = 0;

            c.forEach((value, index) => {
                a = value.id;
                if (a == idGeneral) {
                    b.push(value);
                }
            });
            this.seleccionServicio = b;
            idGeneral = 0;
            idGeneral = this.seleccionServicio[0].id_edificio;
            b = [];

            c = this.listadoEdificios;

            c.forEach((value, index) => {
                a = value.id;
                if (a == idGeneral) {
                    b.push(value);
                }
            });

            this.seleccionEdificio = b;
        },
        cargarEdificios() {
            this.csrf_token;

            axios
                .get(this.localVal + "/api/Usuario/GetEdificios", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoEdificios = res.data;
                });
        },
        cargarServicios() {
            this.csrf_token;

            axios
                .get(this.localVal + "/api/Usuario/GetServicios", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoServicios = res.data;
                });
        },
        cargarUnidadEsp() {
            this.csrf_token;

            axios
                .get(this.localVal + "/api/Usuario/GetUnidadEsp", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoUnidadEsp = res.data;
                });
        },
        cargarTipoRep() {
            this.csrf_token;

            axios
                .get(this.localVal + "/api/Usuario/GetTipoRep", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoTipoRep = res.data;
                });
        },
        errorDrop(mensajeError) {
            this.$vs.notify({
                title: "Falto seleccionar " + mensajeError,
                time: 3000,
                text: "Seleccione " + mensajeError,
                color: "danger",
                position: "top-right",
                fixed: true
            });
        },
        errorTitulo(mensajeError) {
            this.$vs.notify({
                title: mensajeError,
                time: 3000,
                text: "Debe escribir un titulo superior a 10 caracteres",
                color: "danger",
                position: "top-right",
                fixed: true
            });
        },
        errorDescripcion(mensajeError) {
            this.$vs.notify({
                title: mensajeError,
                time: 3000,
                text: "Debe escribir una descripcion superior a 15 caracteres",
                color: "danger",
                position: "top-right",
                fixed: true
            });
        },
        mensajeGuardado() {
            this.$vs.notify({
                time: 5000,
                title: "Ticket Modificado",
                text:
                    "A sido Modificado correctamente, Retornara a la pagina anterior",
                color: "success",
                position: "top-right"
            });
        },
        modificarSolicitud() {
            if (
                this.descripcionProblema.trim() === "" ||
                this.descripcionProblema.length < 15
            ) {
                this.mensajeError =
                    "La descripcion no supera los 15 caracteres";
                this.errorDescripcion(this.mensajeError);
            } else if (
                this.descripcionTitulo.trim() === "" ||
                this.descripcionTitulo.length < 10
            ) {
                this.mensajeError = "el titulo no supera los 10 caracteres";
                this.errorTitulo(this.mensajeError);
            } else if (this.seleccionEdificio.id == 0) {
                this.mensajeError = "el Edificio";
                this.errorDrop(this.mensajeError);
            } else if (this.seleccionServicio.id == 0) {
                this.mensajeError = "el servicio";
                this.errorDrop(this.mensajeError);
            } else if (this.seleccionReparacion.id == 0) {
                this.mensajeError = "el tipo de reparacion";
                this.errorDrop(this.mensajeError);
            } else if (this.seleccionPrioridad.id == 0) {
                this.mensajeError = "la prioridad";
                this.errorDrop(this.mensajeError);
            } else {
                this.solicitud.id_edificio = this.seleccionEdificio[0].id;
                this.solicitud.id_servicio = this.seleccionServicio[0].id;
                this.solicitud.id_ubicacionEx = this.seleccionUnidadEsp.id;
                this.solicitud.id_tipoReparacion = this.seleccionReparacion[0].id;
                this.solicitud.id = this.datosSolicitud.id;
                this.solicitud.tituloP = this.descripcionTitulo;
                this.solicitud.id_prioridad = this.seleccionPrioridad.id;
                var newElement = document.createElement("div");
                this.solicitud.descripcionP = this.descripcionProblema;
                newElement.innerHTML = this.descripcionProblema;
                this.solicitud.descripcionProblema = newElement.textContent;
                this.solicitud.id_solicitud = this.datosSolicitud.id;
                this.solicitud.uuid = this.datosSolicitud.uuid;
                newElement.innerHTML = this.razoncambio;
                var razonInner = newElement.textContent;
                this.solicitud.descripcionSeguimiento =
                    "El Usuario " +
                    this.solicitud.nombre +
                    " a realizado una modificacion en el Ticket N°" +
                    this.datosSolicitud.id +
                    " " +
                    "<br/>" +
                    "Razon del cambio: " +
                    this.razoncambio;

                newElement.innerHTML =
                    "El Usuario " +
                    this.solicitud.nombre +
                    " a realizado una modificacion en el Ticket N°" +
                    this.datosSolicitud.id +
                    " , " +
                    razonInner;
                this.solicitud.razonMail = newElement.textContent;

                const solicitudNueva = this.solicitud;
                this.openLoadingColor();
                this.solicitud = {
                    id: 0,

                    nombre:
                        sessionStorage.getItem("nombre") +
                        " " +
                        sessionStorage.getItem("apellido"),
                    descripcionP: "",
                    tituloP: "",
                    id_user: sessionStorage.getItem("id"),
                    id_estado: 1,
                    id_edificio: 0,
                    id_servicio: 0,
                    id_ubicacionEx: 0,
                    id_tipoReparacion: 0,
                    id_solicitud: 0,
                    uuid: "",
                    descripcionSeguimiento: ""
                };
                let id_categoria = this.$route.params.id_categoria;
                try {
                    if (id_categoria == 1) {
                        axios
                            .post(
                                this.localVal + "/api/Usuario/PutSolicitud",
                                solicitudNueva,
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            )
                            .then(res => {
                                const solicitudServer = res.data;
                                //console.log(res.data);
                                this.mensajeGuardado();
                                setTimeout(() => {
                                    router.back();
                                }, 5000);
                                this.limpiar();
                            });
                    } else if (id_categoria == 2) {
                        axios
                            .post(
                                this.localVal + "/api/Usuario/PutSolicitudEM",
                                solicitudNueva,
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            )
                            .then(res => {
                                const solicitudServer = res.data;
                                //console.log(res.data);
                                this.mensajeGuardado();
                                setTimeout(() => {
                                    router.back();
                                }, 5000);
                                this.limpiar();
                            });
                    } else if (id_categoria == 3) {
                        axios
                            .post(
                                this.localVal + "/api/Usuario/PutSolicitudIND",
                                solicitudNueva,
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            )
                            .then(res => {
                                const solicitudServer = res.data;
                                //console.log(res.data);
                                this.mensajeGuardado();
                                setTimeout(() => {
                                    router.back();
                                }, 5000);
                                this.limpiar();
                            });
                    } else if (id_categoria == 4) {
                        axios
                            .post(
                                this.localVal + "/api/Usuario/PutSolicitudAP",
                                solicitudNueva,
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            )
                            .then(res => {
                                const solicitudServer = res.data;
                                //console.log(res.data);
                                this.mensajeGuardado();
                                setTimeout(() => {
                                    router.back();
                                }, 5000);
                                this.limpiar();
                            });
                    } else {
                        this.$vs.notify({
                            title: "Error",
                            text:
                                "No es posible modificar los datos del ticket, Intente Nuevamente",
                            color: "danger",
                            position: "top-right",
                            fixed: true
                        });
                    }
                } catch (error) {
                    this.$vs.notify({
                        title: "Error",
                        text:
                            "No es posible modificar los datos del ticket, Intente Nuevamente",
                        color: "danger",
                        position: "top-right",
                        fixed: true
                    });
                }
            }
        },
        openLoadingColor() {
            this.$vs.loading({ color: this.colorLoading });
            setTimeout(() => {
                this.$vs.loading.close();
            }, 2000);
        },
        cargarDatosSolicitud() {
            let id = this.$route.params.id;
            let id_categoria = this.$route.params.id_categoria;
            let obj = {
                id: id,
                id_categoria: id_categoria
            };
            try {
                if (id_categoria == 1) {
                    axios
                        .post(
                            this.localVal + "/api/Usuario/GetSolicitudCreada",
                            obj,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            this.datosSolicitud = res.data;
                            this.cargarTodo();
                        });
                } else if (id_categoria == 2) {
                    axios
                        .post(
                            this.localVal + "/api/Usuario/GetSolicitudCreadaEM",
                            obj,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            this.datosSolicitud = res.data;
                            this.cargarTodo();
                        });
                } else if (id_categoria == 3) {
                    axios
                        .post(
                            this.localVal +
                                "/api/Usuario/GetSolicitudCreadaIND",
                            obj,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            this.datosSolicitud = res.data;
                            this.cargarTodo();
                        });
                } else if (id_categoria == 4) {
                    axios
                        .post(
                            this.localVal + "/api/Usuario/GetSolicitudCreadaAP",
                            obj,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            this.datosSolicitud = res.data;
                            this.cargarTodo();
                        });
                } else {
                    this.$vs.notify({
                        title: "Error",
                        text:
                            "No es posible cargar los datos del ticket, Intente Nuevamente",
                        color: "danger",
                        position: "top-right",
                        fixed: true
                    });
                }
            } catch (error) {
                this.$vs.notify({
                    title: "Error",
                    text:
                        "No es posible cargar los datos del ticket, Intente Nuevamente",
                    color: "danger",
                    position: "top-right",
                    fixed: true
                });
            }
        },
        cargaUSE() {
            var datoidServicio = this.datosSolicitud.id_servicio;
            var datoidEdificio = this.datosSolicitud.id_edificio;
            var datoidUbicacion = this.datosSolicitud.id_ubicacionEx;
            let c = this.listadoUnidadEsp;
            let b = [];
            var a = 0;
            c.forEach((value, index) => {
                a = value.id;

                if (a == datoidUbicacion) {
                    b.push(value);
                }
            });

            this.seleccionUnidadEsp = b;

            b = [];
            c = this.listadoServicios;

            c.forEach((value, index) => {
                a = value.id;
                if (a == datoidServicio) {
                    b.push(value);
                }
            });

            this.seleccionServicio = b;

            c = this.listadoEdificios;
            b = [];
            c.forEach((value, index) => {
                a = value.id;
                if (a == datoidEdificio) {
                    b.push(value);
                }
            });

            this.seleccionEdificio = b;
        },
        cargaTipoRepSeleccionado() {
            var datoidTipoRep = this.datosSolicitud.id_tipoReparacion;
            let c = this.listadoTipoRep;
            let b = [];
            var a = 0;
            c.forEach((value, index) => {
                a = value.id;

                if (a == datoidTipoRep) {
                    b.push(value);
                }
            });

            this.seleccionReparacion = b;
        },
        cargaDescripcionEscrita() {
            this.descripcionProblema = this.datosSolicitud.descripcionP;
        },
        cargaTituloEscrito() {
            this.descripcionTitulo = this.datosSolicitud.tituloP;
        },
        cargarTodo() {
            this.cargaUSE();

            this.cargaTipoRepSeleccionado();
            this.cargaDescripcionEscrita();
            this.cargaTituloEscrito();
        }
    },
    beforeMount() {
        this.cargarEdificios();
        this.cargarServicios();
        this.cargarUnidadEsp();
        this.cargarTipoRep();
        this.cargarPrioridades();
        this.cargarDatosSolicitud();
    },
    components: {
        "v-select": vSelect,
        quillEditor
    }
};
</script>

<style lang="stylus">
.examplex {
  display: flex;
  align-items: center;
  justify-content: center;

  button {
    margin: 0px !important;

    &.btnx {
      margin-left: 10px !important;
      border-radius: 5px 0px 0px 5px;
    }

    &.btn-drop {
      border-radius: 0px 5px 5px 0px;
      border-left: 1px solid rgba(255, 255, 255, 0.2);

      .cardx {
        margin: 15px;
      }
    }
  }
}
</style>
