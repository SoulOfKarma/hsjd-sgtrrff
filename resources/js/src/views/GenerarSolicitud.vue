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
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.1 - Seleccione el Edificio</h6>
                            <br />
                            <v-select
                                v-model="seleccionEdificio"
                                placeholder="Edificio"
                                class="w-full select-large"
                                label="descripcionEdificio"
                                :options="listadoEdificios"
                                @input="filtroSegunEdificio"
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

                            <div class="vx-col w-full mt-5">
                                <h6>Adjuntar Documento</h6>
                                <br />
                                <vs-input
                                    type="file"
                                    @change="getImage"
                                    class="form-control w-full"
                                />
                            </div>
                        </div>
                    </div>
                </vx-card>
            </div>
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row">
                    <div class="vx-col sm:w-2/3 w-full ml-auto">
                        <input
                            type="hidden"
                            name="_token"
                            :value="csrf_token"
                        />
                        <vs-button
                            color="success"
                            class="mr-3 mb-2"
                            @click="volver"
                            >Volver</vs-button
                        >
                        <vs-button
                            color="warning"
                            class="mr-3 mb-2"
                            @click="limpiar"
                            >Limpiar</vs-button
                        >
                        <vs-button class="mb-2" @click="cargarUltimoID"
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
import moment from "moment";

import { create } from "axios-add-jsonp";
import { quillEditor } from "vue-quill-editor";
import Axios from "axios";

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
        listadoTipoRep: [],
        listadoCorreo: [],
        listadoCategoria: [],
        listadoServiciosData: [],
        listadoUsuarios: [],
        localVal: process.env.MIX_APP_URL,
        apiInformatica: "http://10.4.237.33:80/ticket",
        uuidC: "",

        solicitud: {
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
            id_ubicacionEx: 42,
            id_tipoReparacion: 0,
            id_solicitud: 0,
            id_categoria: 0,
            uuid: "",
            descripcionSeguimiento: "Solicitud creada",
            descripcionCorreo: ""
        },

        solicitudInformatica: {
            api_key: process.env.MIX_API_KEY_CREATE,
            user_id: sessionStorage.getItem("id"),
            subject: "",
            body: "",
            helptopic: 1,
            sla: 1,
            priority: 1,
            dept: "",
            token: "",
            first_name: "",
            last_name: "",
            phone: 0,
            code: 91,
            mobile: 0,
            duedate: moment().fromNow(),
            email: ""
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
        seleccionReparacion: {
            id: 0,
            descripcionTipoReparacion: "Seleccione Tipo de Reparacion"
        },
        seleccionCategoria: {
            id: 0,
            des_categoria: "Seleccione Categoria"
        },
        image: "",
        lastID: 0
    }),
    computed: {
        csrf_token() {
            let token = document.head.querySelector('meta[name="csrf-token"]');
            return token.content;
        }
    },
    methods: {
        getImage(event) {
            //Asignamos la imagen a  nuestra data
            this.image = event.target.files[0];
        },
        volver() {
            router.back();
        },
        limpiar() {
            this.seleccionReparacion = {
                id: 0,
                descripcionTipoReparacion: "Seleccione Tipo de Reparacion"
            };
            this.seleccionCategoria = {
                id: 0,
                des_categoria: "Seleccione Categoria"
            };
            this.solicitud.descripcionP = "";
            this.solicitud.tituloP = "";
        },
        cargaESU() {
            var idGeneral = this.seleccionUnidadEsp.id;

            let c = this.listadoUnidadEspData;
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
            try {
                if (
                    this.seleccionServicio == null ||
                    this.seleccionServicio.id == 0
                ) {
                    this.listadoServicios = this.listadoServiciosData;
                } else {
                    var idGeneral = this.seleccionServicio.id;

                    let c = this.listadoServiciosData;
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
                }
            } catch (error) {
                console.log(error);
            }
        },
        filtroSegunEdificio() {
            try {
                if (
                    this.seleccionEdificio == null ||
                    this.seleccionEdificio == 0
                ) {
                    this.listadoServicios = this.listadoServiciosData;
                    this.listadoUnidadEsp = this.listadoUnidadEspData;
                } else {
                    var idGeneral = this.seleccionEdificio.id;
                    let c = this.listadoServiciosData;
                    let b = [];
                    var a = 0;
                    c.forEach((value, index) => {
                        a = value.id_edificio;
                        if (a == idGeneral) {
                            b.push(value);
                        }
                    });

                    this.listadoServicios = b;
                }
            } catch (error) {
                console.log(error);
            }
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
                    this.listadoServiciosData = res.data;
                });
        },
        cargarCategoria() {
            this.csrf_token;

            axios
                .get(this.localVal + "/api/Usuario/GetCategoria", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoCategoria = res.data;
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
                text: "Seleccione " + mensajeError,
                color: "danger",
                position: "top-right"
            });
        },
        cargarUsuarios() {
            let id = sessionStorage.getItem("id");
            axios
                .get(this.localVal + `/api/Usuario/getUsuarios/${id}`, {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoUsuarios = res.data;
                    this.seleccionEdificio.id = this.listadoUsuarios.id_edificio;
                    this.seleccionServicio.id = this.listadoUsuarios.id_servicio;
                    this.seleccionUnidadEsp.id = this.listadoUsuarios.id_unidadEspecifica;
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
                text: "Ticket creado correctamente, Se limpiaran los campos",
                color: "success",
                position: "top-right"
            });
        },
        async guardarSolicitud() {
            try {
                if (this.seleccionCategoria.id == 5) {
                    //Json de Login de faveo

                    let data = {
                        username: "ricardo.soto.g@redsalud.gov.cl",
                        password: "Darkzero25"
                    };

                    //Variable para guardar token retornado
                    let tokenI = "";
                    //Hacer la peticion para recuperar token
                    await axios
                        .post(
                            this.apiInformatica + "/public/api/v1/authenticate",
                            data
                        )
                        .then(res => {
                            const infoToken = res.data;
                            tokenI = infoToken.token;
                            console.log(tokenI);
                        })
                        .catch(function(error) {
                            if (error.response) {
                                // The request was made and the server responded with a status code
                                // that falls out of the range of 2xx
                                console.log(error);
                            } else if (error.request) {
                                // The request was made but no response was received
                                // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                                // http.ClientRequest in node.js
                                console.log(error);
                            } else {
                                // Something happened in setting up the request that triggered an Error
                                console.log("Error", error);
                            }
                            console.log(error);
                        });
                    //Llenando los campos para guardar el ticket en faveo
                    this.solicitudInformatica.first_name = sessionStorage.getItem(
                        "nombre"
                    );
                    this.solicitudInformatica.last_name = sessionStorage.getItem(
                        "apellido"
                    );
                    this.solicitudInformatica.subject = this.solicitud.tituloP;
                    this.solicitudInformatica.body = this.solicitud.descripcionP;
                    this.solicitudInformatica.email = this.listadoUsuarios.email;
                    this.solicitudInformatica.phone = this.listadoUsuarios.anexo;
                    this.solicitudInformatica.token = tokenI;

                    const solicitudNueva = this.solicitudInformatica;
                    //Haciendo la peticion para crear el ticket
                    await axios
                        .post(
                            this.apiInformatica +
                                "/public/api/v1/helpdesk/create?apikey=PZe1Mv3VhuLnTXNSEE1si1R0e53DRp8C",
                            solicitudNueva
                        )
                        .then(res => {
                            const solicitudServer = res.data;
                            this.mensajeGuardado();
                        })
                        .catch(function(error) {
                            if (error.response) {
                                // The request was made and the server responded with a status code
                                // that falls out of the range of 2xx
                                console.log(error);
                                console.log(error);
                                console.log(error);
                            } else if (error.request) {
                                // The request was made but no response was received
                                // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                                // http.ClientRequest in node.js
                                console.log(error.request);
                            } else {
                                // Something happened in setting up the request that triggered an Error
                                console.log("Error", error);
                            }
                            console.log(error);
                        });
                } else if (
                    this.image == "" ||
                    this.image == null ||
                    this.image == 0
                ) {
                    //Llenando Campos para Guardar Ticket de Mantencion
                    this.solicitud.id_edificio = this.seleccionEdificio[0].id;
                    this.solicitud.id_servicio = this.seleccionServicio[0].id;
                    this.solicitud.id_tipoReparacion = this.seleccionReparacion.id;
                    this.solicitud.id_categoria = this.seleccionCategoria.id;
                    var newElement = document.createElement("div");
                    newElement.innerHTML = this.solicitud.descripcionP;
                    this.solicitud.descripcionCorreo = newElement.textContent;
                    const solicitudNueva = this.solicitud;
                    this.openLoadingColor();
                    this.solicitud = {
                        descripcionP: "",
                        tituloP: "",
                        id_user: sessionStorage.getItem("id"),
                        id_estado: 1,
                        id_edificio: 0,
                        id_servicio: 0,
                        id_ubicacionEx: 42,
                        id_tipoReparacion: 0,
                        id_categoria: 0
                    };
                    //Enviando Datos para crear ticket
                    await axios
                        .post(
                            this.localVal + "/api/Usuario/PostSolicitud",
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

                            if (solicitudServer == true) {
                                this.mensajeGuardado();

                                this.limpiar();
                            } else {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Error",
                                    text:
                                        "No fue posible crear el ticket, revise los campos e intente nuevamente",
                                    color: "danger",
                                    position: "top-right"
                                });
                            }
                        });
                } else {
                    var data = new FormData();
                    //Añadimos la imagen seleccionada
                    data.append("avatar", this.image);
                    data.append("id", this.lastID + 1);

                    //Llenando Campos para Guardar Ticket de Mantencion
                    this.solicitud.id_edificio = this.seleccionEdificio[0].id;
                    this.solicitud.id_servicio = this.seleccionServicio[0].id;
                    this.solicitud.id_tipoReparacion = this.seleccionReparacion.id;
                    this.solicitud.id_categoria = this.seleccionCategoria.id;
                    var newElement = document.createElement("div");
                    newElement.innerHTML = this.solicitud.descripcionP;
                    this.solicitud.descripcionCorreo = newElement.textContent;
                    const solicitudNueva = this.solicitud;
                    this.openLoadingColor();
                    this.solicitud = {
                        descripcionP: "",
                        tituloP: "",
                        id_user: sessionStorage.getItem("id"),
                        id_estado: 1,
                        id_edificio: 0,
                        id_servicio: 0,
                        id_ubicacionEx: 42,
                        id_tipoReparacion: 0,
                        id_categoria: 0
                    };
                    //Enviando Datos para crear ticket
                    await axios
                        .all([
                            axios.post(
                                this.localVal + "/api/Agente/PostDocumentoF",
                                data,
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            ),
                            axios.post(
                                this.localVal + "/api/Usuario/PostSolicitud",
                                solicitudNueva,
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            )
                        ])
                        .then(
                            axios.spread((res1, res2) => {
                                let data1 = res1.data;
                                let data2 = res2.data;
                                if (data1 == true && data2 == true) {
                                    this.mensajeGuardado();

                                    this.limpiar();
                                } else {
                                    this.$vs.notify({
                                        time: 5000,
                                        title: "Error",
                                        text:
                                            "No fue posible crear el ticket, revise los campos e intente nuevamente",
                                        color: "danger",
                                        position: "top-right"
                                    });
                                }
                            })
                        );
                }
            } catch (error) {
                console.log(error);
            }
        },
        openLoadingColor() {
            this.$vs.loading({ color: this.colorLoading });
            setTimeout(() => {
                this.$vs.loading.close();
            }, 2000);
        },
        cargarUltimoID() {
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
            } else if (this.seleccionReparacion.id == 0) {
                this.mensajeError = "el tipo de reparacion";
                this.errorDrop(this.mensajeError);
            } else if (this.seleccionCategoria.id == 0) {
                this.mensajeError = "el tipo de categoria";
                this.errorDrop(this.mensajeError);
            } else {
                axios
                    .get(this.localVal + "/api/Usuario/traerUltimoT", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        let list = res.data;
                        this.lastID = list.id;
                        this.guardarSolicitud();
                    });
            }
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
        this.cargarUsuarios();
        this.cargarEdificios();
        this.cargarServicios();
        this.cargarCategoria();
        this.cargarTipoRep();
    },
    beforeMount() {
        setTimeout(() => {
            this.cargaESU();
        }, 2000);
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
