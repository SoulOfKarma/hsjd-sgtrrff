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
                        Habilitar | Desabilitar Usuarios Existentes
                    </h2>
                </div>
                <div class="vx-breadcrumb ml-4 md:block hidden">
                    <div
                        class="content-area__heading pr-4 border-0 md:border-r border-solid border-grey-light"
                    >
                        <h3 class="mb-1">
                            Usuario:
                            <strong>{{ nombre }}</strong>
                        </h3>
                    </div>
                </div>
            </div>
            <!-- Menu Cargo -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="Listado de Usuarios">
                    <div class="vx-row mb-12">
                        <vue-good-table
                            :columns="columns"
                            :rows="rows"
                            :pagination-options="{
                                enabled: true,
                                perPage: 10
                            }"
                            class="w-full"
                            ><template slot="table-row" slot-scope="props">
                                <!-- Column: Name -->
                                <span
                                    v-if="props.column.field === 'fullName'"
                                    class="text-nowrap"
                                >
                                </span>
                                <!-- Column: Action -->
                                <span
                                    v-else-if="props.column.field === 'action'"
                                >
                                    <div v-if="props.row.estado_login == 1">
                                        <plus-circle-icon
                                            size="1.5x"
                                            class="custom-class"
                                            @click="
                                                popDesabilitarUsuario(
                                                    props.row.id
                                                )
                                            "
                                        ></plus-circle-icon>
                                    </div>
                                    <div v-else>
                                        <plus-circle-icon
                                            size="1.5x"
                                            class="custom-class"
                                            @click="
                                                popHabilitarUsuario(
                                                    props.row.id
                                                )
                                            "
                                        ></plus-circle-icon>
                                    </div> </span></template
                        ></vue-good-table>
                    </div>
                </vx-card>
            </div>
        </vs-row>
        <vs-popup
            classContent="popDesabilitar"
            title="Desabilitar Usuario?"
            :active.sync="popDesabilitar"
        >
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row">
                    <div class="vx-col w-full md-5">
                        <vs-button
                            @click="popDesabilitar = false"
                            color="primary"
                            type="filled"
                            class="w-full m-1"
                            >Volver</vs-button
                        >
                        <vs-button
                            @click="desabilitarUsuario(tblID)"
                            color="danger"
                            type="filled"
                            class="w-full m-1"
                            >Desabilitar Usuario</vs-button
                        >
                    </div>
                </div>
                <div class="vx-row"></div>
            </div>
        </vs-popup>
        <vs-popup
            classContent="popHabilitar"
            title="Habilitar Usuario?"
            :active.sync="popHabilitar"
        >
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row">
                    <div class="vx-col w-full md-5">
                        <vs-button
                            @click="popHabilitar = false"
                            color="primary"
                            type="filled"
                            class="w-full m-1"
                            >Volver</vs-button
                        >
                        <vs-button
                            @click="habilitarUsuario(tblID)"
                            color="danger"
                            type="filled"
                            class="w-full m-1"
                            >Habilitar o Cambiar Perfil Usuario</vs-button
                        >
                    </div>
                </div>
                <div class="vx-row"></div>
            </div>
        </vs-popup>
        <vs-popup
            classContent="popSeleccionarHabilitar"
            title="Seleccionar Perfil Usuario"
            :active.sync="popSeleccionHabilitar"
        >
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row">
                    <div class="vx-col w-full md-5">
                        <h6>Seleccion Perfil</h6>
                        <br />
                        <v-select
                            v-model="seleccionPerfil"
                            placeholder="Servicio"
                            class="w-full select-large"
                            label="nombre"
                            :options="dataPerfil"
                        ></v-select>
                        <br />
                    </div>
                    <div class="vx-col w-full md-5">
                        <vs-button
                            @click="volverHabilitarDesabilitar()"
                            color="primary"
                            type="filled"
                            class="w-full m-1"
                            >Volver</vs-button
                        >
                        <vs-button
                            @click="habilitarSeleccionUsuario(tblID)"
                            color="danger"
                            type="filled"
                            class="w-full m-1"
                            >Habilitar Usuario</vs-button
                        >
                    </div>
                </div>
                <div class="vx-row"></div>
            </div>
        </vs-popup>
    </div>
</template>
<script>
import axios from "axios";
import vSelect from "vue-select";
import router from "@/router";
import VueGoodTablePlugin from "vue-good-table";
import Vue from "vue";
import { PlusCircleIcon } from "vue-feather-icons";

// import the styles
import "vue-good-table/dist/vue-good-table.css";

Vue.use(VueGoodTablePlugin);

export default {
    components: {
        "v-select": vSelect,
        PlusCircleIcon
    },
    data() {
        return {
            localVal: process.env.MIX_APP_URL,
            nombre:
                sessionStorage.getItem("nombre") +
                " " +
                sessionStorage.getItem("apellido"),
            popDesabilitar: false,
            popHabilitar: false,
            popSeleccionHabilitar: false,
            rows: [],
            tblID: 0,
            dataPerfil: [
                { id: 1, nombre: "Jefatura CR" },
                { id: 2, nombre: "Usuarios" },
                {
                    id: 3,
                    nombre: "trabajadores"
                },
                {
                    id: 5,
                    nombre: "Infraestructura"
                },
                {
                    id: 6,
                    nombre: "Equipos Medicos"
                },
                {
                    id: 7,
                    nombre: "Industrial"
                },
                { id: 8, nombre: "Apoyo Clinico" },
                {
                    id: 9,
                    nombre: "Desabilitado"
                }
            ],
            seleccionPerfil: {
                id: 2,
                nombre: "Usuarios"
            },
            columns: [
                {
                    label: "Rut",
                    field: "run",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Nombre Usuario",
                    field: "nombreUsuario",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Cargo",
                    field: "descripcionCargo",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Estado",
                    field: "estadoUsuario",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Opciones",
                    field: "action"
                }
            ]
        };
    },
    computed: {},
    methods: {
        cargarListadoUsuariosPermisos() {
            try {
                axios
                    .get(this.localVal + "/api/Agente/TraerUsuariosPermisos", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.rows = res.data;
                    });
            } catch (error) {
                this.$vs.notify({
                    title: "Error ",
                    time: 4000,
                    text: "No es posible Cargar los datos",
                    color: "danger",
                    position: "top-right"
                });
            }
        },
        popDesabilitarUsuario(id) {
            try {
                this.popDesabilitar = true;
                this.tblID = id;
            } catch (error) {
                this.$vs.notify({
                    title: "Error ",
                    time: 4000,
                    text: "No es posible abrir la ventana, intente nuevamente",
                    color: "danger",
                    position: "top-right"
                });
            }
        },
        popHabilitarUsuario(id) {
            try {
                this.popHabilitar = true;
                this.tblID = id;
            } catch (error) {
                this.$vs.notify({
                    title: "Error ",
                    time: 4000,
                    text: "No es posible abrir la ventana, intente nuevamente",
                    color: "danger",
                    position: "top-right"
                });
            }
        },
        volverHabilitarDesabilitar() {
            try {
                this.popSeleccionHabilitar = false;
                this.popHabilitar = true;
            } catch (error) {
                this.$vs.notify({
                    title: "Error ",
                    time: 4000,
                    text: "No es posible abrir la ventana, intente nuevamente",
                    color: "danger",
                    position: "top-right"
                });
            }
        },
        habilitarUsuario() {
            try {
                this.popSeleccionHabilitar = true;
                this.popHabilitar = false;
            } catch (error) {
                this.$vs.notify({
                    title: "Error ",
                    time: 4000,
                    text: "No es posible abrir la ventana, intente nuevamente",
                    color: "danger",
                    position: "top-right"
                });
            }
        },
        desabilitarUsuario(id) {
            try {
                let data = { id: id, estado_login: 0 };
                axios
                    .post(
                        this.localVal + "/api/Agente/PutDesabilitarUsuario",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(response => {
                        let data = response.data;
                        this.$vs.notify({
                            title: "Realizado ",
                            time: 4000,
                            text:
                                "Usuario desabilitado correctamente, se recargara listado",
                            color: "success",
                            position: "top-right"
                        });
                        this.popDesabilitar = false;
                        this.cargarListadoUsuariosPermisos();
                    });
            } catch (error) {
                this.$vs.notify({
                    title: "Error ",
                    time: 4000,
                    text:
                        "No es posible desabilitar cuenta, intente nuevamente",
                    color: "danger",
                    position: "top-right"
                });
            }
        },

        habilitarSeleccionUsuario(id) {
            try {
                let data = {
                    id: id,
                    permiso_usuario: this.seleccionPerfil.id,
                    estado_login: 1
                };
                axios
                    .post(
                        this.localVal + "/api/Agente/PutHabilitarUsuario",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(response => {
                        let data = response.data;
                        this.$vs.notify({
                            title: "Realizado ",
                            time: 4000,
                            text:
                                "Usuario habilitado correctamente, se recargara listado",
                            color: "success",
                            position: "top-right"
                        });
                        this.popHabilitar = false;
                        this.popSeleccionHabilitar = false;
                        this.cargarListadoUsuariosPermisos();
                    });
            } catch (error) {
                this.$vs.notify({
                    title: "Error ",
                    time: 4000,
                    text: "No es posible habilitar cuenta, intente nuevamente",
                    color: "danger",
                    position: "top-right"
                });
            }
        }
    },
    created() {
        this.cargarListadoUsuariosPermisos();
    }
};
</script>
