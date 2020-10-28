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
                    <h2 class="mb-1">
                        Menu Edificios
                    </h2>
                </div>
                <div class="vx-breadcrumb ml-4 md:block hidden">
                    <div
                        class="content-area__heading pr-4 border-0 md:border-r border-solid border-grey-light"
                    >
                        <h3 class="mb-1">
                            Usuario:
                            <strong>{{ dataUsuarioCreador.nombre }}</strong>
                        </h3>
                    </div>
                </div>
            </div>
            <!-- Menu Cargo -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-1/2 mt-5">
                            <vx-card title="Agregar Edificio">
                                <vs-input
                                    class="w-full inputx"
                                    placeholder="Agregar Edificio"
                                    v-model="agregar"
                                />
                                <br />
                                <vs-button
                                    color="success"
                                    type="filled"
                                    @click="agregarEdificio"
                                    >Agregar</vs-button
                                >
                            </vx-card>
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <vx-card title="Modificar Edificios">
                                <v-select
                                    v-model="seleccionEdificios"
                                    placeholder="Edificios"
                                    class="w-full select-large"
                                    label="descripcionEdificio"
                                    :options="listEdificios"
                                ></v-select>
                                <br />
                                <vs-input
                                    class="inputx w-full"
                                    placeholder="Modificar Edificio Seleccionado"
                                    v-model="modificar"
                                />
                                <br />
                                <vs-button
                                    color="warning"
                                    type="filled"
                                    @click="PutEdificio"
                                    >Modificar</vs-button
                                >
                            </vx-card>
                        </div>
                    </div>
                </vx-card>
            </div>
        </vs-row>
    </div>
</template>
<script>
import axios from "axios";
import vSelect from "vue-select";
import router from "@/router";
export default {
    components: {
        "v-select": vSelect
    },
    data() {
        return {
            dataUsuarioCreador: {
                nombre:
                    localStorage.getItem("nombre") +
                    " " +
                    localStorage.getItem("apellido"),
                id_user: localStorage.getItem("id")
            },
            agregar: "",
            modificar: "",
            listEdificios: [],
            localVal: "http://127.0.0.1:8000",
            seleccionEdificios: {
                id: 0,
                descripcionEdificio: "Seleccione Edificio"
            },
            nuevoEdificio: {
                descripcionEdificio: ""
            },
            modificarEdificio: {
                id: 0,
                descripcionEdificio: ""
            }
        };
    },
    computed: {},
    methods: {
        agregarEdificio() {
            if (this.agregar == "" || this.agregar == null) {
                this.$vs.notify({
                    time: 3000,
                    title: "Error",
                    text: "Campo Edificio Vacio",
                    color: "danger",
                    position: "top-right"
                });
            } else {
                this.nuevoEdificio.descripcionEdificio = this.agregar;
                const edificio = this.nuevoEdificio;
                axios
                    .post(this.localVal + "/api/Agente/PostEdificios", edificio)
                    .then(res => {
                        if (res.data == true) {
                            this.listadoEdificios();
                            this.$vs.notify({
                                time: 3000,
                                title: "Edificio Agregado Correctamente",
                                text: "Se Recargara Listado",
                                color: "success",
                                position: "top-right"
                            });
                        } else {
                            this.$vs.notify({
                                time: 3000,
                                title: "Error",
                                text:
                                    "Hubo una falla al agregar el nuevo edificio",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            }
        },
        PutEdificio() {
            if (
                this.modificar == "" ||
                this.modificar == null ||
                this.seleccionEdificios.id == 0
            ) {
                this.$vs.notify({
                    time: 3000,
                    title: "Error",
                    text:
                        "Campo Edificio Vacio o Item del Listado sin seleccionar",
                    color: "danger",
                    position: "top-right"
                });
            } else {
                this.modificarEdificio.id = this.seleccionEdificios.id;
                this.modificarEdificio.descripcionEdificio = this.modificar;

                const edificio = this.modificarEdificio;
                axios
                    .post(
                        this.localVal + "/api/Agente/PutModificarEdificio",
                        edificio
                    )
                    .then(res => {
                        if (res.data == true) {
                            this.listadoEdificios();
                            this.$vs.notify({
                                time: 3000,
                                title: "Edificio Modificado Correctamente",
                                text: "Se Recargara Listado",
                                color: "success",
                                position: "top-right"
                            });
                        } else {
                            this.$vs.notify({
                                time: 3000,
                                title: "Error",
                                text: "Hubo una falla al modificar el edificio",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            }
        },
        listadoEdificios() {
            axios.get(this.localVal + "/api/Usuario/GetEdificios").then(res => {
                this.listEdificios = res.data;
            });
        }
    },
    created() {
        this.listadoEdificios();
    }
};
</script>
