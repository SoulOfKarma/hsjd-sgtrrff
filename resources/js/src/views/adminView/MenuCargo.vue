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
                        Menu Cargo de Usuarios
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
                            <vx-card title="Agregar Cargo">
                                <vs-input
                                    class="w-full inputx"
                                    placeholder="Agregar Cargo"
                                    v-model="agregar"
                                />
                                <br />
                                <vs-button color="success" type="filled"
                                    >Agregar</vs-button
                                >
                            </vx-card>
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <vx-card title="Modificar Cargo">
                                <v-select
                                    v-model="seleccionCargo"
                                    placeholder="Cargo"
                                    class="w-full select-large"
                                    label="descripcionCargo"
                                    :options="listCargos"
                                ></v-select>
                                <br />
                                <vs-input
                                    class="inputx w-full"
                                    placeholder="Modificar Cargo Seleccionado"
                                    v-model="modificar"
                                />
                                <br />
                                <vs-button color="warning" type="filled"
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
            eliminar: "",
            listCargos: [],
            localVal: "http://127.0.0.1:8000",
            seleccionCargo: {
                id: 0,
                descripcionCargo: ""
            }
        };
    },
    computed: {},
    methods: {
        listadoCargos() {
            axios.get(this.localVal + "/api/Agente/getCargos").then(res => {
                this.listCargos = res.data;
            });
        }
    },
    created() {
        this.listadoCargos();
    }
};
</script>
