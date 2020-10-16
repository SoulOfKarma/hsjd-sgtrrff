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
                    <h2 class="mb-1">Resolucion de la solicitud</h2>
                </div>
                <div class="vx-breadcrumb ml-4 md:block hidden">
                    <div
                        class="content-area__heading pr-4 border-0 md:border-r border-solid border-grey-light"
                    >
                        <h3 class="mb-1">
                            Trabajador:
                            <p>{{ nombre }} - {{ run }}</p>
                        </h3>
                    </div>
                </div>
            </div>

            <!-- Ubicacion -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="1. Ingrese la solucion del problema">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-full mt-5">
                            <h6>1.1 - Resolucion del problema</h6>
                            <br />
                            <quill-editor
                                v-model="seguimientos.descripcionSeguimiento"
                                :options="editorOption"
                            >
                                <div id="toolbar" slot="toolbar"></div>
                            </quill-editor>
                        </div>
                    </div>
                </vx-card>
            </div>

            <!-- Enviar o Limpiar Formulario -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row mb-12">
                    <div class="vx-col w-1/3 mt-5">
                        <vs-button
                            color="primary"
                            class="mb-2 w-full"
                            @click="volver"
                            >Volver</vs-button
                        >
                    </div>
                    <div class="vx-col w-1/3 mt-5">
                        <vs-button
                            class="mb-2 w-full"
                            color="warning"
                            @click="limpiar"
                            >Limpiar</vs-button
                        >
                    </div>
                    <div class="vx-col w-1/3 mt-5">
                        <vs-button
                            class="mb-2 w-full"
                            color="success"
                            @click="guardar"
                            >Guardar</vs-button
                        >
                    </div>
                </div>
            </div>
        </vs-row>
    </div>
</template>
<script>
import axios from "axios";
import moment from "moment";
import router from "@/router";
import { InfoIcon } from "vue-feather-icons";
import { PlusCircleIcon } from "vue-feather-icons";
import { Trash2Icon } from "vue-feather-icons";
import { UploadIcon } from "vue-feather-icons";
import { CornerDownRightIcon } from "vue-feather-icons";
import { ArchiveIcon } from "vue-feather-icons";
import Datepicker from "vuejs-datepicker";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import { quillEditor } from "vue-quill-editor";

export default {
    components: {
        ArchiveIcon,
        InfoIcon,
        PlusCircleIcon,
        Trash2Icon,
        UploadIcon,
        CornerDownRightIcon,
        flatPickr,
        quillEditor
    },
    data() {
        return {
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
            nombre: localStorage.getItem("nombre"),
            run: localStorage.getItem("run"),
            localVal: "http://127.0.0.1:8000",
            seguimientos: {
                descripcionSeguimiento: "",
                id_solicitud: 0,
                uuid: "",
                nombre: localStorage.getItem("nombre"),
                id_user: localStorage.getItem("id"),
                descripcionCorreo: ""
            }
        };
    },
    methods: {
        volver() {
            router.back();
        },
        limpiar() {
            this.seguimientos.descripcionSeguimiento = " ";
        },
        guardar() {
            let uuid = this.$route.params.uuid;
            let id = this.$route.params.id;

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
                    this.localVal +
                        `/api/Trabajador/GuardarSeguimientoT/${uuid}`,
                    seguimientoNuevo
                )
                .then(res => {
                    const seguimientoServer = res.data;
                    this.$vs.notify({
                        time: 3000,
                        title: "Actualizacion realizada",
                        text:
                            "Se volvera a la pagina anterior en unos segundos",
                        color: "success",
                        position: "top-right"
                    });
                    router.back();
                });
        },
        openLoadingColor() {
            this.$vs.loading({ color: this.colorLoading });
            setTimeout(() => {
                this.$vs.loading.close();
            }, 2000);
        }
    }
};
</script>
