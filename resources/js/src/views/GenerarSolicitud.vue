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
                    <h2 class="mb-1">Registrar nuevo Ticket</h2>
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
                        <div class="vx-col w-1/3 mt-5">
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
                        <div class="vx-col w-1/3 mt-5">
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
                        <div class="vx-col w-1/3 mt-5">
                            <h6>1.3 - Seleccione la Unidad Especifica</h6>
                            <br />
                            <v-select
                                v-model="seleccionUnidadEsp"
                                placeholder="Unidad Especifica"
                                class="w-full select-large"
                                label="descripcionUnidadEsp"
                                :options="listadoUnidadEsp"
                                @input="cargaSegunUnidadEsp"
                            ></v-select>
                        </div>
                    </div>
                </vx-card>
            </div>
            <!-- Informacion del problema -->
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
                            ></v-select>
                            <br />
                            <h6>2.2 - Categoria</h6>
                            <br />
                            <v-select
                                v-model="seleccionCategoria"
                                placeholder="Seleccione Categoria"
                                class="w-full select-large"
                                label="des_categoria"
                                :options="listadoCategoria"
                            ></v-select>
                            <br />
                            <h6>2.3 - Titulo del Problema</h6>
                            <br />
                            <vs-input
                                placeholder="Ej. Falla de red en equipo x"
                                v-model="solicitud.tituloP"
                                class="w-full"
                                name="Titulo"
                            />

                            <br />
                            <h6>2.4 - Descripcion del Problema</h6>
                            <br />
                            <quill-editor
                                v-model="solicitud.descripcionP"
                                :options="editorOption"
                                name="Descripcion"
                            >
                                <div id="toolbar" slot="toolbar"></div>
                            </quill-editor>
                            <br />
                        </div>
                    </div>
                </vx-card>
            </div>
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row">
                    <div class="vx-col sm:w-2/3 w-full ml-auto">
                        <vs-button
                            color="warning"
                            class="mr-3 mb-2"
                            @click="probando"
                            >Limpiar</vs-button
                        >
                        <vs-button class="mb-2" @click="guardarSolicitud"
                            >Enviar</vs-button
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
import { Validator } from "vee-validate";
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

        colorLoading: "#ff8000",
        listadoEdificios: [],
        listadoServicios: [],
        listadoUnidadEsp: [],
        listadoTipoRep: [],
        listadoCorreo: [],
        listadoCategoria: [],
        localVal: "http://127.0.0.1:8000",
        uuidC: "",

        solicitud: {
            nombre:
                localStorage.getItem("nombre") +
                " " +
                localStorage.getItem("apellido"),
            descripcionP: "",
            tituloP: "",
            id_user: localStorage.getItem("id"),
            id_estado: 1,
            id_edificio: 0,
            id_servicio: 0,
            id_ubicacionEx: 0,
            id_tipoReparacion: 0,
            id_solicitud: 0,
            id_categoria: 0,
            uuid: "",
            descripcionSeguimiento: "Solicitud creada",
            descripcionCorreo: ""
        },
        datosCorreo: {
            nombre: "",
            descripcionP: "",
            id: 0
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
            id: 0,
            descripcionUnidadEsp: "Seleccion Unidad Especifica"
        },
        seleccionReparacion: {
            id: 0,
            descripcionTipoReparacion: "Seleccione Tipo de Reparacion"
        },
        seleccionCategoria: {
            id: 0,
            des_categoria: "Seleccione Categoria"
        }
    }),
    computed: {
        csrf_token() {
            let token = document.head.querySelector('meta[name="csrf-token"]');
            return token.content;
        }
    },
    methods: {
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

            axios.get(this.localVal + "/api/Usuario/GetEdificios").then(res => {
                this.listadoEdificios = res.data;
            });
        },
        cargarServicios() {
            this.csrf_token;

            axios.get(this.localVal + "/api/Usuario/GetServicios").then(res => {
                this.listadoServicios = res.data;
            });
        },
        cargarCategoria() {
            this.csrf_token;

            axios.get(this.localVal + "/api/Usuario/GetCategoria").then(res => {
                this.listadoCategoria = res.data;
            });
        },
        cargarUnidadEsp() {
            this.csrf_token;

            axios.get(this.localVal + "/api/Usuario/GetUnidadEsp").then(res => {
                this.listadoUnidadEsp = res.data;
            });
        },
        cargarTipoRep() {
            this.csrf_token;

            axios.get(this.localVal + "/api/Usuario/GetTipoRep").then(res => {
                this.listadoTipoRep = res.data;
            });
        },
        errorDrop(mensajeError) {
            this.$vs.notify({
                title: "Falto seleccionar " + mensajeError,
                text: "Seleccione " + mensajeError,
                color: "danger",
                position: "top-right"
            });
        },
        cargarUsuarios() {
            axios.get(this.localVal + "/api/Agente/getUsuarios").then(res => {
                this.listadoUsuarios = res.data;
            });
        },
        errorTitulo(mensajeError) {
            this.$vs.notify({
                title: mensajeError,
                text: "Debe escribir un titulo superior a 10 caracteres",
                color: "danger",
                position: "top-right"
            });
        },
        errorDescripcion(mensajeError) {
            this.$vs.notify({
                title: mensajeError,
                text: "Debe escribir una descripcion superior a 15 caracteres",
                color: "danger",
                position: "top-right"
            });
        },
        mensajeGuardado() {
            this.$vs.notify({
                time: 5000,
                title: "Ticket Creado",
                text:
                    "Ticket creado correctamente, Retornara a la pagina anterior",
                color: "success",
                position: "top-right"
            });
        },
        guardarSolicitud() {
            if (
                this.solicitud.descripcionP.trim() === "" ||
                this.solicitud.descripcionP.length < 15
            ) {
                this.mensajeError =
                    "La descripcion no supera los 15 caracteres";
                this.errorDescripcion(this.mensajeError);
            } else if (
                this.solicitud.tituloP.trim() === "" ||
                this.solicitud.tituloP.length < 10
            ) {
                this.mensajeError = "el titulo no supera los 10 caracteres";
                this.errorTitulo(this.mensajeError);
            } else if (this.seleccionEdificio.id == 0) {
                this.mensajeError = "el Edificio";
                this.errorDrop(this.mensajeError);
            } else if (this.seleccionServicio.id == 0) {
                this.mensajeError = "el servicio";
                this.errorDrop(this.mensajeError);
            } else if (this.seleccionUnidadEsp.id == 0) {
                this.mensajeError = "la Unidad especifica";
                this.errorDrop(this.mensajeError);
            } else if (this.seleccionReparacion.id == 0) {
                this.mensajeError = "el tipo de reparacion";
                this.errorDrop(this.mensajeError);
            } else if (this.seleccionCategoria.id == 0) {
                this.mensajeError = "el tipo de categoria";
                this.errorDrop(this.mensajeError);
            } else {
                this.solicitud.id_edificio = this.seleccionEdificio[0].id;
                this.solicitud.id_servicio = this.seleccionServicio[0].id;
                this.solicitud.id_ubicacionEx = this.seleccionUnidadEsp[0].id;
                this.solicitud.id_tipoReparacion = this.seleccionReparacion.id;
                this.solicitud.id_categoria = this.seleccionCategoria.id;
                var newElement = document.createElement("div");
                newElement.innerHTML = this.solicitud.descripcionP;
                this.solicitud.descripcionCorreo = newElement.textContent;
                const solicitudNueva = this.solicitud;
                this.openLoadingColor();
                (this.solicitud = {
                    descripcionP: "",
                    tituloP: "",
                    id_user: localStorage.getItem("id"),
                    id_estado: 1,
                    id_edificio: 0,
                    id_servicio: 0,
                    id_ubicacionEx: 0,
                    id_tipoReparacion: 0,
                    id_categoria: 0
                }),
                    axios
                        .post(
                            this.localVal + "/api/Usuario/PostSolicitud",
                            solicitudNueva
                        )
                        .then(res => {
                            const solicitudServer = res.data;
                            this.mensajeGuardado();
                            setTimeout(() => {
                                router.back();
                            }, 5000);
                            //console.log(res.data);
                        });
            }
        },
        openLoadingColor() {
            this.$vs.loading({ color: this.colorLoading });
            setTimeout(() => {
                this.$vs.loading.close();
            }, 2000);
        },
        probando() {
            this.solicitud.id_user;
            console.log(this.seleccionUnidadEsp[0].id);
        },
        verListas() {
            var idGeneral = 4;

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
        }
    },
    created() {
        this.cargarEdificios();
        this.cargarServicios();
        this.cargarUnidadEsp();
        this.cargarCategoria();
        this.cargarTipoRep();
        this.cargarUsuarios();
    },
    mounted() {},

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
