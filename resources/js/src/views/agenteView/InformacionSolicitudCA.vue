<template>
    <div>
        <vs-row>
            <div
                class="router-header flex flex-wrap items-center mb-8"
                style="margin-left:10px;"
            >
                <div
                    class="content-area__heading pr-4 border-0 md:border-r border-solid border-grey-light"
                >
                    <h2 class="mb-1">Seguimiento Tickets</h2>
                </div>
                <div class="vx-breadcrumb ml-4 md:block hidden">
                    <div
                        class="content-area__heading pr-6 border-0 md:border-r border-solid border-grey-light"
                    >
                        <h3 class="mb-6">
                            Agente:
                            <p>{{ nombre }} - {{ run }}</p>
                        </h3>
                    </div>
                </div>
            </div>

            <!-- Informacion General Ticket -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card :title="titulo">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-full mt-5">
                            <vs-input
                                label-placeholder="Usuario Solicitante"
                                v-model="infoSeguimiento.nombre"
                                disabled="true"
                                class="w-full"
                            />
                            <br />
                        </div>
                        <div class="vx-col w-full mt-5">
                            <vs-input
                                label-placeholder="Edificio"
                                v-model="infoSeguimiento.edificio"
                                disabled="true"
                                class="w-full"
                            />
                            <br />
                        </div>
                        <div class="vx-col w-full mt-5">
                            <vs-input
                                label-placeholder="Servicio"
                                v-model="infoSeguimiento.servicio"
                                disabled="true"
                                class="w-full"
                            />
                            <br />
                        </div>

                        <div class="vx-col md:w-1/1 w-full mb-base">
                            <div class="vx-row">
                                <div class="vx-col sm:w-2/3 w-full ml-auto">
                                    <br />
                                    <vs-button
                                        class="fixedHeight"
                                        color="warning"
                                        @click="abrirPop"
                                        >Finalizar Ticket</vs-button
                                    >

                                    <vs-button
                                        class="fixedHeight"
                                        color="success"
                                        @click="volver"
                                        >Volver</vs-button
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </vx-card>
            </div>
            <!-- Actualizar Seguimiento -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="2. Actualizar Seguimiento">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-full mt-5">
                            <h6>2.1 - Descripcion del problema</h6>
                            <br />
                            <quill-editor
                                v-model="seguimientos.descripcionSeguimiento"
                                :options="editorOption"
                            >
                                <div id="toolbar" slot="toolbar"></div>
                            </quill-editor>
                            <br />
                            <div slot="footer">
                                <vs-row vs-justify="flex-end">
                                    <vs-button
                                        type="gradient"
                                        @click="guardarSeguimiento"
                                        >Actualizar</vs-button
                                    >
                                </vs-row>
                            </div>

                            <br />
                        </div>
                    </div>
                </vx-card>
            </div>
            <!-- Lista Seguimiento -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="Respuestas Seguimiento">
                    <div class="vx-row">
                        <div class="vx-col sm:w-full w-full">
                            <vs-list
                                :key="indextr"
                                v-for="(tr, indextr) in seguimiento"
                            >
                                <vx-card
                                    :title="tr.nombre + ' ' + tr.apellido"
                                    title-color="primary"
                                >
                                    <p v-html="tr.descripcionSeguimiento">
                                        {{ tr.descripcionSeguimiento }}
                                    </p>
                                </vx-card>
                            </vs-list>
                        </div>
                    </div>
                </vx-card>
            </div>
        </vs-row>
        <vs-popup
            classContent="popup-example"
            title="Finalizar Proceso Ticket"
            :active.sync="popupActive2"
        >
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row">
                    <div class="vx-col sm:w-full w-full ">
                        <h6>Presione Confirmar para finalizar.</h6>
                        <br />
                        <vs-button
                            color="danger"
                            type="filled"
                            @click="finalizarSolicitud"
                            >Confirmar</vs-button
                        >
                    </div>
                    <div class="vx-col sm:w-full w-full ">
                        <vs-button
                            @click="popupActive2 = false"
                            color="primary"
                            type="filled"
                            >Volver</vs-button
                        >
                    </div>
                </div>
            </div>
        </vs-popup>
    </div>
</template>

<script>
import axios from "axios";
import router from "../../router";
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import { quillEditor } from "vue-quill-editor";
export default {
    components: {
        quillEditor
    },
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

        textarea: "",

        localVal: process.env.MIX_APP_URL,
        solicitudes: [],
        seguimiento: [],
        titulo: "",
        infoSeguimiento: {
            edificio: "",
            servicio: "",
            nombre: ""
        },
        validaEliminar: false,
        popupActive2: false,
        nombre: sessionStorage.getItem("nombre"),
        run: sessionStorage.getItem("run"),
        seguimientos: {
            descripcionSeguimiento: "",
            id_solicitud: 0,
            uuid: "",
            nombre: sessionStorage.getItem("nombre"),
            id_user: sessionStorage.getItem("id"),
            descripcionCorreo: "",
            id_usuarioEspecifico: 0
        },
        colorLoading: "#ff8000"
    }),
    methods: {
        volver() {
            router.back();
        },
        finalizarSolicitud() {
            let uuid = this.$route.params.uuid;
            var id = this.solicitudes[0].id;
            this.seguimientos.id_usuarioEspecifico = this.solicitudes[0].id_user;

            this.seguimientos.id_solicitud = id;
            this.seguimientos.uuid = uuid;
            this.seguimientos.descripcionSeguimiento =
                "El Agente " + this.nombre + " a cerrado el Ticket N°" + id;
            const seguimientoNuevo = this.seguimientos;
            axios
                .post(
                    this.localVal + "/api/Agente/FinalizarTicket",
                    seguimientoNuevo,
                    {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    }
                )
                .then(res => {
                    const seguimientoServer = res.data;
                    this.popupActive2 = false;
                    this.$vs.notify({
                        time: 3000,
                        title: "Solicitud Finalizada",
                        text: "Se recargara el seguimiento",
                        color: "success",
                        position: "top-right"
                    });
                    this.cargaSeguimiento();
                    setTimeout(() => {
                        router.back();
                    }, 2000);
                });
        },
        abrirPop() {
            this.validaEliminar = true;
            this.popupActive2 = true;
        },
        cargaSolicitudEspecifica() {
            let id = this.$route.params.uuid;
            axios
                .get(this.localVal + `/api/Agente/TraerSolicitud/${id}`, {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.solicitudes = res.data;
                    try {
                        this.titulo =
                            "1. Seguimiento Ticket N°" +
                            this.solicitudes[0].nticket;
                        this.infoSeguimiento.nombre =
                            this.solicitudes[0].nombre +
                            " " +
                            this.solicitudes[0].apellido;
                        this.infoSeguimiento.edificio = this.solicitudes[0].descripcionEdificio;
                        this.infoSeguimiento.servicio = this.solicitudes[0].descripcionServicio;
                    } catch (error) {
                        router.back();
                    }
                });
        },
        cargaSeguimiento() {
            let uuid = this.$route.params.uuid;
            axios
                .get(this.localVal + `/api/Agente/TraerSeguimiento/${uuid}`, {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.seguimiento = res.data;
                });
        },
        guardarSeguimiento() {
            let uuid = this.$route.params.uuid;

            if (
                this.seguimientos.descripcionSeguimiento.trim() === "" ||
                this.seguimientos.descripcionSeguimiento < 15
            ) {
                this.$vs.notify({
                    title: "Error en la descripcion",
                    text: "Esta vacio o no supera los 15 caracteres",
                    color: "danger",
                    position: "top-right",
                    fixed: true
                });
                return;
            }
            this.seguimientos.id_usuarioEspecifico = this.solicitudes[0].id_user;
            var id = this.solicitudes[0].id;
            this.seguimientos.id = id;
            this.seguimientos.uuid = uuid;
            var newElement = document.createElement("div");
            newElement.innerHTML = this.seguimientos.descripcionSeguimiento;
            this.seguimientos.descripcionCorreo = newElement.textContent;
            const seguimientoNuevo = this.seguimientos;
            this.seguimientos = {
                descripcionSeguimiento: "",
                id_solicitud: this.$route.params.id,
                uuid: this.$route.params.uuid,
                nombre: sessionStorage.getItem("nombre"),
                id_user: sessionStorage.getItem("id")
            };
            this.openLoadingColor();
            axios
                .post(
                    this.localVal + `/api/Agente/GuardarSeguimiento/${uuid}`,
                    seguimientoNuevo,
                    {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    }
                )
                .then(res => {
                    const seguimientoServer = res.data;
                    this.$vs.notify({
                        time: 3000,
                        title: "Actualizacion realizada",
                        text: "Se cargara listado automaticamente",
                        color: "success",
                        position: "top-right"
                    });
                    this.cargaSeguimiento();
                });
        },
        openLoadingColor() {
            this.$vs.loading({ color: this.colorLoading });
            setTimeout(() => {
                this.$vs.loading.close();
            }, 2000);
        }
    },
    beforeMount() {
        this.cargaSolicitudEspecifica();
        this.cargaSeguimiento();
    }
};
</script>

<style lang="scss">
.fill-row-loading {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    .loading-example {
        width: 120px;
        float: left;
        height: 120px;
        box-shadow: 0px 5px 20px 0px rgba(0, 0, 0, 0.05);
        border-radius: 10px;
        margin: 8px;
        transition: all 0.3s ease;
        cursor: pointer;
        &:hover {
            box-shadow: 0px 0px 0px 0px rgba(0, 0, 0, 0.05);
            transform: translate(0, 4px);
        }
        h4 {
            z-index: 40000;
            position: relative;
            text-align: center;
            padding: 10px;
        }
        &.activeLoading {
            opacity: 0 !important;
            transform: scale(0.5);
        }
    }
}
</style>
