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
                        Menu Tipo Reparacion
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
                            <vx-card title="Agregar Tipo Reparacion">
                                <vs-input
                                    class="w-full inputx"
                                    placeholder="Agregar Tipo Reparacion"
                                    v-model="agregar"
                                />
                                <br />
                                <vs-button
                                    color="success"
                                    type="filled"
                                    @click="agregarNuevoTipoReparacion"
                                    >Agregar</vs-button
                                >
                            </vx-card>
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <vx-card title="Modificar Tipo Reparacion">
                                <v-select
                                    v-model="seleccionReparacion"
                                    placeholder="Tipo Reparacion"
                                    class="w-full select-large"
                                    label="descripcionTipoReparacion"
                                    :options="listReparacion"
                                    @input="cargarSeleccionado"
                                ></v-select>
                                <br />
                                <vs-input
                                    class="inputx w-full"
                                    placeholder="Modificar Tipo Reparacion Seleccionado"
                                    v-model="modificar"
                                />
                                <br />
                                <vs-button
                                    color="warning"
                                    type="filled"
                                    @click="modificarTipoReparacionExistente"
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
            listReparacion: [],
            localVal: "http://10.66.248.51:8000",
            seleccionReparacion: {
                id: 0,
                descripcionTipoReparacion: "Seleccione Tipo de Reparacion"
            },
            nuevoTipoReparacion: {
                descripcionTipoReparacion: ""
            },
            modificarTipoReparacion: {
                id: 0,
                descripcionTipoReparacion: ""
            }
        };
    },
    computed: {},
    methods: {
        limpiar() {
            this.seleccionReparacion = {
                id: 0,
                descripcionTipoReparacion: "Seleccione Tipo de Reparacion"
            };
            this.nuevoTipoReparacion = {
                descripcionTipoReparacion: ""
            };
            this.modificarTipoReparacion = {
                id: 0,
                descripcionTipoReparacion: ""
            };
            this.agregar = "";
            this.modificar = "";
        },
        cargarSeleccionado() {
            this.modificar = this.seleccionReparacion.descripcionTipoReparacion;
        },
        agregarNuevoTipoReparacion() {
            if (this.agregar == "" || this.agregar == null) {
                this.$vs.notify({
                    time: 3000,
                    title: "Error",
                    text: "Campo Tipo de Reparacion Vacio",
                    color: "danger",
                    position: "top-right"
                });
            } else {
                this.nuevoTipoReparacion.descripcionTipoReparacion = this.agregar;
                const tipoReparacion = this.nuevoTipoReparacion;

                axios
                    .post(
                        this.localVal + "/api/Agente/PostTipoReparacion",
                        tipoReparacion
                    )
                    .then(res => {
                        if (res.data == true) {
                            this.listadoReparacion();
                            this.agregar = "";
                            this.$vs.notify({
                                time: 3000,
                                title:
                                    "Tipo de Reparacion Agregado Correctamente",
                                text: "Se Recargara Listado",
                                color: "success",
                                position: "top-right"
                            });
                            this.limpiar();
                        } else {
                            this.$vs.notify({
                                time: 3000,
                                title: "Error",
                                text:
                                    "Hubo una falla al agregar el nuevo Tipo de Reparacion",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            }
        },
        modificarTipoReparacionExistente() {
            if (
                this.modificar == "" ||
                this.modificar == null ||
                this.seleccionReparacion.id == 0
            ) {
                this.$vs.notify({
                    time: 3000,
                    title: "Error",
                    text:
                        "Campo Tipo de Reparacion Vacio o Sin seleccionar del listado",
                    color: "danger",
                    position: "top-right"
                });
            } else {
                this.modificarTipoReparacion.id = this.seleccionReparacion.id;
                this.modificarTipoReparacion.descripcionTipoReparacion = this.modificar;
                const tipoReparacion = this.modificarTipoReparacion;
                axios
                    .post(
                        this.localVal + "/api/Agente/PutTipoReparacion",
                        tipoReparacion
                    )
                    .then(res => {
                        if (res.data == true) {
                            this.listadoReparacion();
                            this.modificar = "";
                            this.$vs.notify({
                                time: 3000,
                                title:
                                    "Tipo de Reparacion modificado Correctamente",
                                text: "Se Recargara Listado",
                                color: "success",
                                position: "top-right"
                            });
                            this.limpiar();
                        } else {
                            this.$vs.notify({
                                time: 3000,
                                title: "Error",
                                text:
                                    "Hubo una falla al modificar el Tipo de Reparacion",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            }
        },
        listadoReparacion() {
            axios.get(this.localVal + "/api/Usuario/GetTipoRep").then(res => {
                this.listReparacion = res.data;
            });
        }
    },
    created() {
        this.listadoReparacion();
    }
};
</script>
