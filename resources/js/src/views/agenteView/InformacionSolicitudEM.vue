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
                <p>Recuerda que todos los campos son obligatorios!</p>
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
                        <div class="vx-col w-full mt-5">
                            <vs-input
                                label-placeholder="Unidad Especifica"
                                v-model="infoSeguimiento.unidadEsp"
                                disabled="true"
                                class="w-full"
                            />
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
                            <vs-button
                                type="gradient"
                                @click="guardarSeguimiento"
                                >Actualizar</vs-button
                            >

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
                                max-items="2"
                                pagination
                            >
                                <vx-card
                                    :title="tr.nombre"
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
        currentx: 1,
        localVal: "http://127.0.0.1:8000",
        solicitudes: [],
        seguimiento: [],
        titulo: "",
        infoSeguimiento: {
            edificio: "",
            servicio: "",
            unidadEsp: "",
            nombre: ""
        },
        nombre: localStorage.getItem("nombre"),
        run: localStorage.getItem("run"),
        seguimientos: {
            descripcionSeguimiento: "",
            id_solicitud: 0,
            uuid: "",
            nombre: localStorage.getItem("nombre"),
            id_user: localStorage.getItem("id"),
            descripcionCorreo: ""
        },
        colorLoading: "#ff8000"
    }),
    methods: {
        cargaSolicitudEspecifica() {
            let id = this.$route.params.uuid;
            axios
                .get(this.localVal + `/api/Agente/TraerSolicitud/${id}`)
                .then(res => {
                    this.solicitudes = res.data;
                    try {
                        this.titulo = "Ticket N°" + this.solicitudes[0].id;
                        this.infoSeguimiento.nombre = this.solicitudes[0].nombre;
                        this.infoSeguimiento.edificio = this.solicitudes[0].descripcionEdificio;
                        this.infoSeguimiento.servicio = this.solicitudes[0].descripcionServicio;
                        this.infoSeguimiento.unidadEsp = this.solicitudes[0].descripcionUnidadEsp;
                    } catch (error) {
                        router.back();
                    }
                });
        },
        cargaSeguimiento() {
            let uuid = this.$route.params.uuid;
            axios
                .get(this.localVal + `/api/Agente/TraerSeguimiento/${uuid}`)
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
                nombre: localStorage.getItem("nombre"),
                id_user: localStorage.getItem("id")
            };
            this.openLoadingColor();
            axios
                .post(
                    this.localVal + `/api/Agente/GuardarSeguimiento/${uuid}`,
                    seguimientoNuevo
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

<style lang="stylus">
.cardx {
  margin: 15px;
}
</style>
