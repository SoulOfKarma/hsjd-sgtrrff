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
                        class="content-area__heading pr-4 border-0 md:border-r border-solid border-grey-light"
                    >
                        <h3 class="mb-1">
                            Agente:
                            <p>{{ nombre }} - {{ run }}</p>
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
                <p>Informacion General de la Solicitud</p>
            </vs-alert>
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
                        <br />
                        <div class="vx-col w-full mt-5">
                            <div slot="footer">
                                <vs-row vs-justify="flex-end">
                                    <vs-button
                                        class="fixedHeight"
                                        @click="volver"
                                        >Volver</vs-button
                                    >
                                </vs-row>
                            </div>
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
        currentx: 1,
        localVal: process.env.MIX_APP_URL,
        solicitudes: [],
        seguimiento: [],
        titulo: "",
        infoSeguimiento: {
            edificio: "",
            servicio: "",
            nombre: ""
        },
        nombre: sessionStorage.getItem("nombre"),
        run: sessionStorage.getItem("run"),
        seguimientos: {
            descripcionSeguimiento: "",
            id_solicitud: 0,
            uuid: "",
            nombre: sessionStorage.getItem("nombre"),
            id_user: sessionStorage.getItem("id")
        }
    }),
    methods: {
        volver() {
            router.back();
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
                    this.titulo =
                        "1. Seguimiento Ticket N°" +
                        this.solicitudes[0].nticket;
                    this.infoSeguimiento.nombre = this.solicitudes[0].nombre;
                    this.infoSeguimiento.edificio = this.solicitudes[0].descripcionEdificio;
                    this.infoSeguimiento.servicio = this.solicitudes[0].descripcionServicio;
                })
                .catch(error => {
                    if (error.response.status === 401) {
                        this.$vs.notify({
                            title: "Token Invalido ",
                            text: "Debe iniciar sesion nuevamente",
                            color: "danger",
                            position: "top-right",
                            time: 3000
                        });
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
                })
                .catch(error => {
                    if (error.response.status === 401) {
                        this.$vs.notify({
                            title: "Token Invalido ",
                            text: "Debe iniciar sesion nuevamente",
                            color: "danger",
                            position: "top-right",
                            time: 3000
                        });
                    }
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
            var id = this.solicitudes.id;
            this.seguimientos.id = id;
            this.seguimientos.uuid = uuid;
            const seguimientoNuevo = this.seguimientos;
            this.seguimientos = {
                descripcionSeguimiento: "",
                id_solicitud: this.$route.params.id,
                uuid: this.$route.params.uuid,
                nombre: sessionStorage.getItem("nombre"),
                id_user: sessionStorage.getItem("id")
            };
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
                    this.cargaSeguimiento();
                })
                .catch(error => {
                    if (error.response.status === 401) {
                        this.$vs.notify({
                            title: "Token Invalido ",
                            text: "Debe iniciar sesion nuevamente",
                            color: "danger",
                            position: "top-right",
                            time: 3000
                        });
                    }
                });
        }
    },
    beforeMount() {
        this.cargaSolicitudEspecifica();
        this.cargaSeguimiento();
    }
};
</script>

<style lang="stylus">
.cardx {
  margin: 15px;
}
</style>
