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
                        Menu Especialidad
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
                            <vx-card title="Agregar Especialidad">
                                <vs-input
                                    class="w-full inputx"
                                    placeholder="Agregar Especialidad"
                                    v-model="agregar"
                                />
                                <br />
                                <vs-button
                                    color="success"
                                    type="filled"
                                    @click="agregarEspecialidad"
                                    >Agregar</vs-button
                                >
                            </vx-card>
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <vx-card title="Modificar Especialidad">
                                <v-select
                                    v-model="seleccionEspecialidad"
                                    placeholder="Especialidad"
                                    class="w-full select-large"
                                    label="descripcionEspecialidad"
                                    :options="listEspecialidad"
                                    @input="asignarCampoSeleccionado"
                                ></v-select>
                                <br />
                                <vs-input
                                    class="inputx w-full"
                                    placeholder="Modificar Especialidad Seleccionada"
                                    v-model="modificar"
                                />
                                <br />
                                <vs-button
                                    color="warning"
                                    type="filled"
                                    @click="modificarEspecialidadExistente"
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
            listEspecialidad: [],
            localVal: process.env.MIX_APP_URL,
            seleccionEspecialidad: {
                id: 0,
                descripcionEspecialidad: "Seleccione Especialidad"
            },
            nuevaEspecialidad: {
                descripcionEspecialidad: ""
            },
            modificarEspecialidad: {
                id: 0,
                descripcionEspecialidad: ""
            }
        };
    },
    computed: {},
    methods: {
        limpiar() {
            this.seleccionEspecialidad = {
                id: 0,
                descripcionEspecialidad: "Seleccione Especialidad"
            };
            this.nuevaEspecialidad = {
                descripcionEspecialidad: ""
            };
            this.modificarEspecialidad = {
                id: 0,
                descripcionEspecialidad: ""
            };
            this.modificar = "";
            this.agregar = "";
        },
        asignarCampoSeleccionado() {
            this.modificar = this.seleccionEspecialidad.descripcionEspecialidad;
        },
        agregarEspecialidad() {
            if (this.agregar == "" || this.agregar == null) {
                this.$vs.notify({
                    time: 3000,
                    title: "Error",
                    text: "Campo Especialidad Vacio",
                    color: "danger",
                    position: "top-right"
                });
            } else {
                this.nuevaEspecialidad.descripcionEspecialidad = this.agregar;
                const especialidad = this.nuevaEspecialidad;
                axios
                    .post(
                        this.localVal + "/api/Agente/PostEspecialidad",
                        especialidad,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        if (res.data == true) {
                            this.listadoEspecialidad();
                            this.$vs.notify({
                                time: 3000,
                                title: "Especialidad Agregada Correctamente",
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
                                    "Hubo una falla al agregar la nueva Especialidad",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    })
                    .catch(error => {
                        if (error.response.status === 401) {
                            this.$vs.notify({
                                title: "Token Invalido ",
                                text: "Debe iniciar sesion nuevamente",
                                color: "danger",
                                position: "top-right",
                                time: 3000
                            });
                        }
                    });
            }
        },
        modificarEspecialidadExistente() {
            if (
                this.modificar == "" ||
                this.modificar == null ||
                this.seleccionEspecialidad.id == 0
            ) {
                this.$vs.notify({
                    time: 3000,
                    title: "Error",
                    text:
                        "Campo Especialidad Vacio o Item del Listado sin seleccionar",
                    color: "danger",
                    position: "top-right"
                });
            } else {
                this.modificarEspecialidad.id = this.seleccionEspecialidad.id;
                this.modificarEspecialidad.descripcionEspecialidad = this.modificar;

                const especialidad = this.modificarEspecialidad;
                axios
                    .post(
                        this.localVal + "/api/Agente/PutEspecialidad",
                        especialidad,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        if (res.data == true) {
                            this.listadoEspecialidad();
                            this.$vs.notify({
                                time: 3000,
                                title: "Especialidad Modificado Correctamente",
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
                                    "Hubo una falla al modificar el Especialidad",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    })
                    .catch(error => {
                        if (error.response.status === 401) {
                            this.$vs.notify({
                                title: "Token Invalido ",
                                text: "Debe iniciar sesion nuevamente",
                                color: "danger",
                                position: "top-right",
                                time: 3000
                            });
                        }
                    });
            }
        },
        listadoEspecialidad() {
            axios
                .get(this.localVal + "/api/Agente/getEspecialidad", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listEspecialidad = res.data;
                })
                .catch(error => {
                    if (error.response.status === 401) {
                        this.$vs.notify({
                            title: "Token Invalido ",
                            text: "Debe iniciar sesion nuevamente",
                            color: "danger",
                            position: "top-right",
                            time: 3000
                        });
                    }
                });
        }
    },
    created() {
        this.listadoEspecialidad();
    }
};
</script>
