<template>
    <vs-row>
        <div class="vx-col md:w-1/1 w-full mb-base">
            <vx-card :title="titulo">
                <div class="vx-row mb-4">
                    <div class="vx-col w-full ">
                        <vx-card
                            :title="solicitudes.tituloP"
                            title-color="success"
                        >
                            <p v-html="solicitudes.descripcionP">
                                {{ solicitudes.descripcionP }}
                            </p> </vx-card
                        ><br />
                        <div slot="footer">
                            <vs-row vs-justify="flex-end">
                                <vs-button class="fixedHeight" @click="volver"
                                    >Volver</vs-button
                                >
                            </vs-row>
                        </div>
                    </div>
                </div>
            </vx-card>
        </div>
        <div class="vx-col md:w-1/1 w-full mb-base">
            <vx-card title="2. Actualizar Seguimiento">
                <div class="vx-row mb-12">
                    <div class="vx-col w-full mt-5">
                        <quill-editor
                            v-model="seguimientos.descripcionSeguimiento"
                            :options="editorOption"
                            name="Descripcion"
                            v-validate="'required|max:50|min:15'"
                        >
                            <div id="toolbar" slot="toolbar"></div>
                        </quill-editor>

                        <span
                            class="text-danger text-sm"
                            v-show="errors.has('Descripcion')"
                            >{{ errors.first("Descripcion") }}</span
                        >
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
                    </div>
                </div>
            </vx-card>
        </div>
        <div class="vx-col md:w-1/1 w-full mb-base">
            <vx-card title="3. Respuestas Seguimiento">
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
</template>

<script>
import axios from "axios";
import router from "../router";
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import { quillEditor } from "vue-quill-editor";

export default {
    components: {
        quillEditor
    },
    data: () => ({
        types: ["default"],
        activeLoading: false,
        colorLoading: "#ff8000",
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
        solicitudes: [],
        seguimiento: [],
        localVal: "http://127.0.0.1:8000",
        titulo: "",
        seguimientos: {
            descripcionSeguimiento: "",
            id_solicitud: 0,
            uuid: "",
            nombre: localStorage.getItem("nombre"),
            id_user: localStorage.getItem("id"),
            descripcionCorreo: ""
        }
    }),
    methods: {
        volver() {
            router.back();
        },
        openLoadingColor() {
            this.$vs.loading({ color: this.colorLoading });
            setTimeout(() => {
                this.$vs.loading.close();
            }, 2000);
        },
        cargaSolicitudEspecifica() {
            let id = this.$route.params.id;
            axios
                .get(this.localVal + `/api/Usuario/TraerSolicitud/${id}`)
                .then(res => {
                    this.solicitudes = res.data;
                    this.titulo =
                        "1. Seguimiento Ticket N°" + this.solicitudes.id;
                });
        },
        cargaSeguimiento() {
            let uuid = this.$route.params.uuid;
            axios
                .get(this.localVal + `/api/Usuario/TraerSeguimiento/${uuid}`)
                .then(res => {
                    this.seguimiento = res.data;
                });
        },
        mensajeGuardado() {
            this.$vs.notify({
                time: 4000,
                title: "Nuevo Comentario",
                text:
                    "A sido guardado correctamente, se actualizara el listado",
                color: "success",
                position: "top-right"
            });
        },
        guardarSeguimiento() {
            let uuid = this.$route.params.uuid;
            console.log(uuid);
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
            } else {
                /* var aux = localStorage.getItem("nombre");
        this.seguimientos.nombre = aux; */
                var id = this.solicitudes.id;
                this.seguimientos.id = id;
                this.seguimientos.uuid = uuid;
                this.seguimientos.id_solicitud = id;
                var newElement = document.createElement("div");
                newElement.innerHTML = this.seguimientos.descripcionSeguimiento;
                this.seguimientos.descripcionCorreo = newElement.textContent;
                /* var iduser = localStorage.getItem("id");
        this.seguimientos.id_user = iduser; */
                const seguimientoNuevo = this.seguimientos;
                console.log(seguimientoNuevo);
                this.openLoadingColor();
                this.seguimientos = {
                    descripcionSeguimiento: "",
                    id_solicitud: 0,
                    uuid: this.$route.params.uuid,
                    nombre: localStorage.getItem("nombre"),
                    id_user: localStorage.getItem("id")
                };
                axios
                    .post(
                        this.localVal +
                            `/api/Usuario/GuardarSeguimiento/${uuid}`,
                        seguimientoNuevo
                    )
                    .then(res => {
                        this.mensajeGuardado();
                        const seguimientoServer = res.data;
                        console.log(seguimientoServer);
                        this.cargaSeguimiento();
                    });
            }
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
