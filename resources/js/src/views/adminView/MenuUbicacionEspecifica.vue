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
                        Menu Ubicacion Especifica
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
                                    @input="filtroSegunEdificioA"
                                ></v-select>
                                <br />
                                <v-select
                                    v-model="seleccionServiciosA"
                                    placeholder="Edificios"
                                    class="w-full select-large"
                                    label="descripcionServicio"
                                    :options="listServiciosA"
                                    @input="cargaSegunServicioA"
                                ></v-select>
                                <br />
                                <vs-input
                                    class="w-full inputx"
                                    placeholder="Agregar Unidad"
                                    v-model="agregar"
                                />
                                <br />
                                <vs-button
                                    color="success"
                                    type="filled"
                                    @click="agregarUnidadEspecifica"
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
                                    placeholder="Servicios"
                                    class="w-full select-large"
                                    label="descripcionServicio"
                                    :options="listServicios"
                                    @input="cargaSegunServicio"
                                ></v-select>
                                <br />
                                <v-select
                                    v-model="seleccionUnidadEsp"
                                    placeholder="Unidad Especifica"
                                    class="w-full select-large"
                                    label="descripcionUnidadEsp"
                                    :options="listUnidadEsp"
                                    @input="cargaSegunUnidadEsp"
                                ></v-select>
                                <br />
                                <vs-input
                                    class="inputx w-full"
                                    placeholder="Modificar Unidad Seleccionada"
                                    v-model="modificar"
                                />
                                <br />
                                <vs-button
                                    color="warning"
                                    type="filled"
                                    @click="modificarUnidadEspecifica"
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
                    sessionStorage.getItem("nombre") +
                    " " +
                    sessionStorage.getItem("apellido"),
                id_user: sessionStorage.getItem("id")
            },
            agregar: "",
            modificar: "",
            listUnidadEsp: [],
            listEdificiosA: [],
            listServicios: [],
            listServiciosA: [],
            listEdificios: [],
            listadoServiciosData: [],
            listadoEdificiosData: [],
            listadoUnidadEspData: [],
            localVal: "http://10.66.248.51:8000",
            seleccionUnidadEsp: {
                id: 0,
                descripcionUnidadEsp: "Seleccione Unidad"
            },
            seleccionServicios: {
                id: 0,
                descripcionServicio: "Seleccione Servicio"
            },
            seleccionServiciosA: {
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
            },
            nuevaUnidadEsp: {
                id_servicio: 0,
                descripcionUnidadEsp: ""
            },
            modificarUnidadEsp: {
                id_servicio: 0,
                id: 0,
                descripcionUnidadEsp: ""
            }
        };
    },
    computed: {},
    methods: {
        limpiar() {
            this.agregar = "";
            this.modificar = "";
            this.seleccionUnidadEsp = {
                id: 0,
                descripcionUnidadEsp: "Seleccione Unidad"
            };
            this.seleccionServicios = {
                id: 0,
                descripcionServicio: "Seleccione Servicio"
            };
            this.seleccionServiciosA = {
                id: 0,
                descripcionServicio: "Seleccione Servicio"
            };
            this.seleccionEdificios = {
                id: 0,
                descripcionEdificio: "Seleccione Edificio"
            };
            this.seleccionEdificiosA = {
                id: 0,
                descripcionEdificio: "Seleccione Edificio"
            };
            this.nuevaUnidadEsp = {
                id_servicio: 0,
                descripcionUnidadEsp: ""
            };
            this.modificarUnidadEsp = {
                id_servicio: 0,
                id: 0,
                descripcionUnidadEsp: ""
            };
        },
        agregarUnidadEspecifica() {
            if (
                this.agregar == "" ||
                this.agregar == null ||
                this.seleccionServiciosA.id == 0 ||
                this.seleccionEdificiosA.id == 0
            ) {
                this.$vs.notify({
                    time: 3000,
                    title: "Error",
                    text:
                        "Campo Unidad Especifica Vacio o Edificio,Servicio no Seleccionado",
                    color: "danger",
                    position: "top-right"
                });
            } else {
                this.nuevaUnidadEsp.id_servicio = this.seleccionServiciosA[0].id;
                this.nuevaUnidadEsp.descripcionUnidadEsp = this.agregar;
                const unidadEsp = this.nuevaUnidadEsp;
                axios
                    .post(
                        this.localVal + "/api/Agente/PostUnidadEspecifica",
                        unidadEsp
                    )
                    .then(res => {
                        if (res.data == true) {
                            this.listadoEdificios();
                            this.listadoServicios();
                            this.listadoUnidadEspecifica();
                            this.agregar = "";
                            this.$vs.notify({
                                time: 3000,
                                title:
                                    "Unidad Especifica Agregada Correctamente",
                                text: "Se Recargara Listado",
                                color: "success",
                                position: "top-right"
                            });
                            this.limpiar();
                        } else {
                            this.$vs.notify({
                                time: 3000,
                                title: "Error",
                                text: "Hubo una falla al agregar la unidad",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            }
        },
        modificarUnidadEspecifica() {
            if (
                this.modificar == "" ||
                this.modificar == null ||
                this.seleccionServicios[0].id == 0 ||
                this.seleccionEdificios[0].id == 0 ||
                this.seleccionUnidadEsp[0].id == 0
            ) {
                this.$vs.notify({
                    time: 3000,
                    title: "Error",
                    text:
                        "Campo Unidad Especifica Vacio o Edificio,Servicio o Unidad Especifica no Seleccionado",
                    color: "danger",
                    position: "top-right"
                });
            } else {
                this.modificarUnidadEsp.id_servicio = this.seleccionServicios[0].id;
                this.modificarUnidadEsp.id = this.seleccionUnidadEsp[0].id;
                this.modificarUnidadEsp.descripcionUnidadEsp = this.modificar;
                const unidadEsp = this.modificarUnidadEsp;
                axios
                    .post(
                        this.localVal + "/api/Agente/PutModificarUnidadEsp",
                        unidadEsp
                    )
                    .then(res => {
                        if (res.data == true) {
                            this.listadoEdificios();
                            this.listadoServicios();
                            this.listadoUnidadEspecifica();
                            this.modificar = "";
                            this.$vs.notify({
                                time: 3000,
                                title:
                                    "Unidad Especifica Agregada Correctamente",
                                text: "Se Recargara Listado",
                                color: "success",
                                position: "top-right"
                            });
                            this.limpiar();
                        } else {
                            this.$vs.notify({
                                time: 3000,
                                title: "Error",
                                text: "Hubo una falla al agregar la unidad",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            }
        },
        listadoUnidadEspecifica() {
            axios.get(this.localVal + "/api/Usuario/GetUnidadEsp").then(res => {
                this.listUnidadEsp = res.data;
                this.listadoUnidadEspData = res.data;
            });
        },
        listadoServicios() {
            axios.get(this.localVal + "/api/Usuario/GetServicios").then(res => {
                this.listServicios = res.data;
                this.listServiciosA = res.data;
                this.listadoServiciosData = res.data;
            });
        },
        listadoEdificios() {
            axios.get(this.localVal + "/api/Usuario/GetEdificios").then(res => {
                this.listEdificios = res.data;
                this.listEdificiosA = res.data;
                this.listadoEdificiosData = res.data;
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
                this.listUnidadEsp = this.listadoUnidadEspData;
            } else {
                //Unidad Esp
                let idGeneral = this.seleccionServicios.id;
                let b = [];

                let c = this.listadoUnidadEspData;
                let a = 0;

                c.forEach((value, index) => {
                    a = value.id_servicio;
                    if (a == idGeneral) {
                        b.push(value);
                    }
                });

                this.listUnidadEsp = b;

                //Servicios
                b = [];

                c = this.listadoServiciosData;
                a = 0;

                c.forEach((value, index) => {
                    a = value.id;
                    if (a == idGeneral) {
                        b.push(value);
                    }
                });

                this.seleccionServicios = b;
                //Edificios
                idGeneral = this.seleccionServicios[0].id_edificio;
                b = [];
                c = this.listadoEdificiosData;

                c.forEach((value, index) => {
                    a = value.id;
                    if (a == idGeneral) {
                        b.push(value);
                    }
                });

                this.seleccionEdificios = b;
            }
        },
        filtroSegunEdificioA() {
            if (
                this.seleccionEdificiosA == null ||
                this.seleccionEdificiosA == 0
            ) {
                this.listServiciosA = this.listadoServiciosData;
            } else {
                var idGeneral = this.seleccionEdificiosA.id;
                let c = this.listadoServiciosData;
                let b = [];
                var a = 0;
                c.forEach((value, index) => {
                    a = value.id_edificio;
                    if (a == idGeneral) {
                        b.push(value);
                    }
                });

                this.listServiciosA = b;
            }
        },
        cargaSegunServicioA() {
            if (
                this.seleccionServiciosA == null ||
                this.seleccionServiciosA.id == 0
            ) {
                this.listServiciosA = this.listadoServiciosData;
            } else {
                let idGeneral = this.seleccionServiciosA.id;
                let b = [];

                let c = this.listadoServiciosData;
                let a = 0;

                c.forEach((value, index) => {
                    a = value.id;
                    if (a == idGeneral) {
                        b.push(value);
                    }
                });

                this.seleccionServiciosA = b;
                idGeneral = 0;
                idGeneral = this.seleccionServiciosA[0].id_edificio;
                b = [];
                c = this.listEdificiosA;

                c.forEach((value, index) => {
                    a = value.id;
                    if (a == idGeneral) {
                        b.push(value);
                    }
                });

                this.seleccionEdificiosA = b;
            }
        },
        cargaSegunUnidadEsp() {
            if (
                this.seleccionUnidadEsp == null ||
                this.seleccionUnidadEsp.id == 0
            ) {
                //this.listadoServicios = this.listadoServiciosData;
                this.listUnidadEsp = this.listadoUnidadEspData;
            } else {
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

                c = this.listadoServiciosData;

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
                c = this.listadoEdificiosData;

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
        this.listadoUnidadEspecifica();
    }
};
</script>
