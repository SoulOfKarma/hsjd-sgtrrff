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
                    <h2 class="mb-1">Derivar Ticket</h2>
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

            <!-- Ubicacion -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="1. Categoria">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-full mt-5">
                            <h6>1.1 - Seleccione la Categoria</h6>
                            <br />
                            <v-select
                                v-model="seleccionCategoria"
                                placeholder="Seleccione Categoria"
                                class="w-full select-large"
                                label="des_categoria"
                                :options="listadoCategoria"
                            ></v-select>
                        </div>
                    </div>
                </vx-card>
            </div>

            <!-- Enviar o Limpiar Formulario -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row">
                    <div class="vx-col sm:w-2/3 w-full ml-auto">
                        <vs-button color="warning" class="mb-2" @click="volver"
                            >Volver</vs-button
                        >
                        <vs-button
                            class="mr-3 mb-2"
                            color="success"
                            @click="cambiar"
                            >Derivar</vs-button
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
import moment from "moment";
import axios from "axios";
import vSelect from "vue-select";
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import { quillEditor } from "vue-quill-editor";
import router from "@/router";

export default {
    data: () => ({
        nombre: localStorage.getItem("nombre"),
        run: localStorage.getItem("run"),
        colorLoading: "#ff8000",

        listadoCategoria: [],
        categoria: {
            idsolicitud: 0,
            idCategoria: 0,
            uuid: "",
            nombre: "",
            desCategoria: "",
            id_user: 0
        },

        localVal: "http://127.0.0.1:8000",
        seleccionCategoria: {
            id: 0,
            des_categoria: "Seleccione Categoria"
        }
    }),
    computed: {},
    methods: {
        volver() {
            router.back();
        },
        cambiar() {
            let uuid = this.$route.params.uuid;
            let id = this.$route.params.id;

            this.categoria.idsolicitud = id;
            this.categoria.uuid = uuid;
            this.categoria.idCategoria = this.seleccionCategoria.id;
            this.categoria.nombre = this.nombre;
            this.categoria.desCategoria = this.seleccionCategoria.des_categoria;
            this.categoria.id_user = localStorage.getItem("id");

            const cat = this.categoria;
            axios
                .post(this.localVal + "/api/Agente/ModificarCategoria", cat)
                .then(res => {
                    if (res.data) {
                        this.$vs.notify({
                            title: "Ticket Derivado correctamente",
                            text:
                                "Retornara a la pagina anterior en unos segundos",
                            color: "success",
                            position: "top-right"
                        });
                        setTimeout(() => {
                            router.back();
                        }, 5000);
                    } else {
                        this.$vs.notify({
                            title: "Error al derivar",
                            text: "Intente nuevamente",
                            color: "danger",
                            position: "top-right",
                            fixed: true
                        });
                    }

                    //console.log(res.data);
                });
        },
        cargarCategoria() {
            axios.get(this.localVal + "/api/Usuario/GetCategoria").then(res => {
                this.listadoCategoria = res.data;
            });
        }
    },
    created: function() {
        this.cargarCategoria();
    },
    components: {
        flatPickr,
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
