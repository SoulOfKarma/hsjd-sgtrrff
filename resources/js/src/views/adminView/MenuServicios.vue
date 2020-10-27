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
                        Menu Servicios
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
                            <vx-card title="Agregar Servicio">
                                <v-select
                                    v-model="seleccionEdificiosA"
                                    placeholder="Edificios"
                                    class="w-full select-large"
                                    label="descripcionEdificio"
                                    :options="listEdificiosA"
                                ></v-select>
                                <br />
                                <vs-input
                                    class="w-full inputx"
                                    placeholder="Agregar Servicio"
                                    v-model="agregar"
                                />
                                <br />
                                <vs-button color="success" type="filled"
                                    >Agregar</vs-button
                                >
                            </vx-card>
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <vx-card title="Modificar Servicio">
                                <v-select
                                    v-model="seleccionEdificios"
                                    placeholder="Edificios"
                                    class="w-full select-large"
                                    label="descripcionEdificio"
                                    :options="listEdificios"
                                    @input="filtroSegunEdificio"
                                ></v-select>
                                <br />
                                <v-select
                                    v-model="seleccionServicios"
                                    placeholder="Edificios"
                                    class="w-full select-large"
                                    label="descripcionServicio"
                                    :options="listServicios"
                                    @input="cargaSegunServicio"
                                ></v-select>
                                <br />
                                <vs-input
                                    class="inputx w-full"
                                    placeholder="Modificar Servicio Seleccionado"
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
            listServicios: [],
            listEdificios: [],
            listEdificiosA: [],
            listadoServiciosData: [],
            localVal: "http://127.0.0.1:8000",
            seleccionServicios: {
                id: 0,
                descripcionServicio: "Seleccione Servicio"
            },
            seleccionEdificios: {
                id: 0,
                descripcionEdificio: "Seleccione Edificio"
            },
            seleccionEdificiosA: {
                id: 0,
                descripcionEdificio: "Seleccione Edificio"
            }
        };
    },
    computed: {},
    methods: {
        listadoServicios() {
            axios.get(this.localVal + "/api/Usuario/GetServicios").then(res => {
                this.listServicios = res.data;
                this.listadoServiciosData = res.data;
            });
        },
        listadoEdificios() {
            axios.get(this.localVal + "/api/Usuario/GetEdificios").then(res => {
                this.listEdificios = res.data;
                this.listEdificiosA = res.data;
            });
        },
        filtroSegunEdificio() {
            if (
                this.seleccionEdificios == null ||
                this.seleccionEdificios == 0
            ) {
                this.listServicios = this.listadoServiciosData;
            } else {
                var idGeneral = this.seleccionEdificios.id;
                let c = this.listadoServiciosData;
                let b = [];
                var a = 0;
                c.forEach((value, index) => {
                    a = value.id_edificio;
                    if (a == idGeneral) {
                        b.push(value);
                    }
                });

                this.listServicios = b;
            }
        },
        cargaSegunServicio() {
            if (
                this.seleccionServicios == null ||
                this.seleccionServicios.id == 0
            ) {
                this.listServicios = this.listadoServiciosData;
            } else {
                let idGeneral = this.seleccionServicios.id;
                let b = [];

                let c = this.listadoServiciosData;
                let a = 0;

                c.forEach((value, index) => {
                    a = value.id;
                    if (a == idGeneral) {
                        b.push(value);
                    }
                });

                this.seleccionServicios = b;
                idGeneral = 0;
                idGeneral = this.seleccionServicios[0].id_edificio;
                b = [];
                c = this.listEdificios;

                c.forEach((value, index) => {
                    a = value.id;
                    if (a == idGeneral) {
                        b.push(value);
                    }
                });

                this.seleccionEdificios = b;
            }
        }
    },
    created() {
        this.listadoServicios();
        this.listadoEdificios();
    }
};
</script>
