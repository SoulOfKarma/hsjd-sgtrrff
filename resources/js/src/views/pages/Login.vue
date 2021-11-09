<!-- =========================================================================================
    File Name: Login.vue
    Description: Login Page
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>
    <div
        class="h-screen flex w-full  vx-row no-gutter items-center justify-center"
        id="page-login"
    >
        <vs-row vs-justify="center">
            <vs-col
                type="flex"
                vs-justify="center"
                vs-align="center"
                vs-w="25%"
                class="login-box"
            >
                <vx-card
                    class="text-center"
                    vs-w="100%"
                    title=""
                    title-color="#ffffff"
                    card-background="#4792f9"
                    content-color="#ffffff"
                >
                    <h3 class="text-white">Bienvenido a SGTRRFF!</h3>
                </vx-card>
                <br />
                <vs-card class="cardx">
                    <div slot="header">
                        <h3>
                            <img
                                src="@assets/images/pages/login.png"
                                alt="login"
                                class="mx-auto"
                            />
                        </h3>
                    </div>
                    <div slot="media"></div>
                    <div class="vx-card__title mb-4 text-center">
                        <h4 class="mb-4">
                            Autenticarse para iniciar sesión
                        </h4>
                    </div>
                    <br />
                    <div>
                        <div>
                            <vs-input
                                name="run"
                                icon="icon icon-user"
                                icon-pack="feather"
                                label-placeholder="Rut"
                                v-model="run"
                                v-on:blur="formatear_run"
                                class="w-full no-icon-border"
                            />
                            <span
                                style="font-size: 10px; color: red; margin-left: 10px;"
                                v-if="val_run"
                                >Rut incorrecto</span
                            >

                            <vs-input
                                type="password"
                                name="password"
                                icon="icon icon-lock"
                                icon-pack="feather"
                                label-placeholder="Contraseña"
                                v-model="password"
                                @keyup.native.enter="validarSesion"
                                class="w-full mt-6 no-icon-border"
                            />
                            <br />
                            <input
                                type="hidden"
                                name="_token"
                                :value="csrf_token"
                            />
                            <!-- <router-link to="../Home"> -->
                            <div slot="footer">
                                <vs-row vs-justify="flex-end">
                                    <vs-button
                                        class="fixedHeight"
                                        @click="validarSesion"
                                        icon="home"
                                        >Ingresar</vs-button
                                    >
                                </vs-row>
                            </div>

                            <!-- </router-link> -->
                        </div>
                    </div>
                </vs-card>
            </vs-col>
        </vs-row>
        <vs-popup
            classContent="popup-example"
            title="Seleccione Perfil de Inicio"
            :active.sync="popPerfilesAccesoJefatura"
        >
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row">
                    <div class="vx-col sm:w-full w-full">
                        <vs-button
                            color="warning"
                            type="filled"
                            class="w-full m-2"
                            @click="PerfilJefatura()"
                            >Jefatura</vs-button
                        >
                    </div>
                    <div class="vx-col sm:w-full w-full">
                        <vs-button
                            class="w-full m-2"
                            @click="PerfilUsuario()"
                            color="primary"
                            type="filled"
                        >
                            Usuario</vs-button
                        >
                    </div>
                </div>
            </div>
        </vs-popup>
    </div>
</template>

<script>
import axios from "axios";
import router from "../../router";
import { validate, clean, format } from "rut.js";

export default {
    data() {
        return {
            run: "",
            password: "",
            val_run: false,
            checkbox_remember_me: false,
            localVal: process.env.MIX_APP_URL,
            popPerfilesAccesoJefatura: false,
            idPermisoUsuario: 0
        };
    },
    computed: {
        csrf_token() {
            let token = document.head.querySelector('meta[name="csrf-token"]');
            return token.content;
        }
    },
    methods: {
        //Login por rut y generacion de token
        async autenticarToken() {
            try {
                const valor = window.location.search;

                const urlParams = new URLSearchParams(valor);

                let data = {
                    run: urlParams.get("run")
                };
                //let run = sessionStorage.getItem("run");

                if (data.run != null && data.run.length > 8) {
                    var sw = 0;
                    var pr = 0;
                    var permiso_usuario = "";

                    await axios
                        .post(this.localVal + "/api/Login/LoginByRut", {
                            run: urlParams.get("run")
                        })
                        .then(function(response) {
                            if (response.data.length > 0) {
                                sessionStorage.setItem(
                                    "nombre",
                                    response.data[0].nombre
                                );
                                sessionStorage.setItem(
                                    "apellido",
                                    response.data[0].apellido
                                );
                                sessionStorage.setItem(
                                    "idServicio",
                                    response.data[0].id_servicio
                                );
                                sessionStorage.setItem(
                                    "run",
                                    response.data[0].run
                                );
                                sessionStorage.setItem(
                                    "id",
                                    response.data[0].id
                                );
                                sessionStorage.setItem(
                                    "api_token",
                                    response.data[0].api_token
                                );
                                sw = 1;
                            } else {
                                pr = 1;
                            }
                        })
                        .catch(error =>
                            console.log("Error Usuario o Contraseña")
                        );
                    let rut = sessionStorage.getItem("run");
                    const myNewStr = rut.substring(0, 4);

                    await axios
                        .post(this.localVal + "/api/auth/generarToken", {
                            run: sessionStorage.getItem("run"),
                            password: myNewStr
                        })
                        .then(function(response) {
                            sessionStorage.setItem(
                                "token",
                                response.data.token
                            );
                        });

                    if (sw == 1) {
                        await axios
                            .post(this.localVal + "/api/Login/getpr", {
                                run: urlParams.get("run")
                            })
                            .then(function(response2) {
                                if (response2.data.length > 0) {
                                    if (response2.data[0].estado_login == 1) {
                                        sessionStorage.setItem(
                                            "permiso_usuario",
                                            response2.data[0].permiso_usuario
                                        );
                                        if (
                                            response2.data[0].permiso_usuario ==
                                            1
                                        ) {
                                            pr = 3;
                                        }
                                        if (
                                            response2.data[0].permiso_usuario ==
                                            2
                                        ) {
                                            pr = 4;
                                        }
                                        if (
                                            response2.data[0].permiso_usuario ==
                                            3
                                        ) {
                                            pr = 5;
                                        }
                                        if (
                                            response2.data[0].permiso_usuario ==
                                            4
                                        ) {
                                            pr = 6;
                                        }
                                        //router.push('/home');
                                        //pr = 3;
                                    } else {
                                        pr = 2;
                                    }
                                }
                            });
                    }
                    if (pr == 1) {
                        this.$vs.notify({
                            color: "danger",
                            title: "Login",
                            text: "Usuario y/o Contraseña Incorrectos."
                        });
                    }
                    if (pr == 2) {
                        this.$vs.notify({
                            color: "danger",
                            title: "Login",
                            text: "Usted no posee acceso a la plataforma."
                        });
                    }
                    if (pr == 3) {
                        console.log("Agente");
                        //localStorage.setItem('run',response2.data[0].permiso_usuario);
                        router.push("/agenteView/HomeAgente");
                    }
                    if (pr == 4 || pr == 6) {
                        console.log("Usuario");
                        //localStorage.setItem('run',response2.data[0].permiso_usuario);
                        router.push("/home");
                    }
                    if (pr == 5) {
                        console.log("Trabajador");
                        router.push("/HomeTrabajador");
                    } else {
                        this.val_run = true;
                    }
                } else {
                    console.log("Hubo un error");
                }
            } catch (error) {
                this.$vs.notify({
                    color: "danger",
                    title: "Login",
                    text: "Usuario y/o Contraseña Incorrectos."
                });
            }
        },
        formatear_run() {
            this.run = format(this.run);
            this.val_run = !validate(this.run);
        },
        async PerfilUsuario() {
            var sw = 0;
            var pr = 0;
            var permiso_usuario = "";
            await axios
                .post(this.localVal + "/api/Login/GetUsers", {
                    run: this.run,
                    password: this.password
                })
                .then(response => {
                    if (response.data.length > 0) {
                        if (response.data != 1) {
                            sessionStorage.setItem(
                                "nombre",
                                response.data[0].nombre
                            );
                            sessionStorage.setItem(
                                "apellido",
                                response.data[0].apellido
                            );
                            sessionStorage.setItem(
                                "idServicio",
                                response.data[0].id_servicio
                            );
                            sessionStorage.setItem("run", response.data[0].run);
                            sessionStorage.setItem("id", response.data[0].id);
                            sessionStorage.setItem(
                                "api_token",
                                response.data[0].api_token
                            );
                            sw = 1;
                        }
                    } else {
                        pr = 1;
                    }
                });

            await axios
                .post(this.localVal + "/api/auth/login", {
                    run: sessionStorage.getItem("run"),
                    password: this.password
                })
                .then(response => {
                    sessionStorage.setItem("token", response.data.token);
                });

            if (sw == 1) {
                axios
                    .post(this.localVal + "/api/Login/getpr", {
                        run: this.run,
                        password: this.password
                    })
                    .then(response2 => {
                        if (response2.data.length > 0) {
                            if (response2.data[0].estado_login == 1) {
                                sessionStorage.setItem("permiso_usuario", 2);
                                if (response2.data[0].permiso_usuario == 1) {
                                    this.popPerfilesAccesoJefatura = false;
                                    setTimeout(() => {
                                        router.push("/home");
                                    }, 1000);

                                    //pr = 3;
                                }
                                //router.push('/home');
                                //pr = 3;
                            } else {
                                pr = 2;
                            }
                        }
                    });
            }
        },
        async PerfilJefatura() {
            var sw = 0;
            var pr = 0;
            var permiso_usuario = "";
            await axios
                .post(this.localVal + "/api/Login/GetUsers", {
                    run: this.run,
                    password: this.password
                })
                .then(response => {
                    if (response.data.length > 0) {
                        if (response.data != 1) {
                            sessionStorage.setItem(
                                "nombre",
                                response.data[0].nombre
                            );
                            sessionStorage.setItem(
                                "apellido",
                                response.data[0].apellido
                            );
                            sessionStorage.setItem(
                                "idServicio",
                                response.data[0].id_servicio
                            );
                            sessionStorage.setItem("run", response.data[0].run);
                            sessionStorage.setItem("id", response.data[0].id);
                            sessionStorage.setItem(
                                "api_token",
                                response.data[0].api_token
                            );
                            sw = 1;
                        }
                    } else {
                        pr = 1;
                    }
                });

            await axios
                .post(this.localVal + "/api/auth/login", {
                    run: sessionStorage.getItem("run"),
                    password: this.password
                })
                .then(response => {
                    sessionStorage.setItem("token", response.data.token);
                });

            if (sw == 1) {
                axios
                    .post(this.localVal + "/api/Login/getpr", {
                        run: this.run,
                        password: this.password
                    })
                    .then(response2 => {
                        if (response2.data.length > 0) {
                            if (response2.data[0].estado_login == 1) {
                                sessionStorage.setItem("permiso_usuario", 1);
                                if (response2.data[0].permiso_usuario == 1) {
                                    this.popPerfilesAccesoJefatura = false;
                                    setTimeout(() => {
                                        router.push("/agenteView/HomeAgente");
                                    }, 1000);
                                }
                                //router.push('/home');
                                //pr = 3;
                            } else {
                                pr = 2;
                            }
                        }
                    });
            }
        },
        //Login Normal
        async validarSesion() {
            try {
                if (
                    this.run == "" ||
                    this.run == null ||
                    this.password == "" ||
                    this.password == null
                ) {
                    this.$vs.notify({
                        color: "danger",
                        title: "Datos de sesion",
                        text: "Run o Contraseña no Ingresada"
                    });
                } else {
                    this.run = format(this.run);
                    if (validate(this.run)) {
                        var sw = 0;
                        var pr = 0;
                        var permiso_usuario = "";
                        axios
                            .post(this.localVal + "/api/Login/getpr", {
                                run: this.run,
                                password: this.password
                            })
                            .then(response2 => {
                                if (response2.data.length > 0) {
                                    if (response2.data[0].estado_login == 1) {
                                        if (
                                            response2.data[0].permiso_usuario ==
                                            1
                                        ) {
                                            this.idPermisoUsuario = 1;
                                            this.popPerfilesAccesoJefatura = true;
                                        }
                                    }
                                }
                            });

                        if (this.idPermisoUsuario == 1) {
                        } else {
                            await axios
                                .post(this.localVal + "/api/Login/GetUsers", {
                                    run: this.run,
                                    password: this.password
                                })
                                .then(function(response) {
                                    if (response.data.length > 0) {
                                        if (response.data != 1) {
                                            sessionStorage.setItem(
                                                "nombre",
                                                response.data[0].nombre
                                            );
                                            sessionStorage.setItem(
                                                "apellido",
                                                response.data[0].apellido
                                            );
                                            sessionStorage.setItem(
                                                "idServicio",
                                                response.data[0].id_servicio
                                            );
                                            sessionStorage.setItem(
                                                "run",
                                                response.data[0].run
                                            );
                                            sessionStorage.setItem(
                                                "id",
                                                response.data[0].id
                                            );
                                            sessionStorage.setItem(
                                                "api_token",
                                                response.data[0].api_token
                                            );
                                            sw = 1;
                                        }
                                    } else {
                                        pr = 1;
                                    }
                                });

                            await axios
                                .post(this.localVal + "/api/auth/login", {
                                    run: sessionStorage.getItem("run"),
                                    password: this.password
                                })
                                .then(function(response) {
                                    sessionStorage.setItem(
                                        "token",
                                        response.data.token
                                    );
                                });

                            if (sw == 1) {
                                await axios
                                    .post(this.localVal + "/api/Login/getpr", {
                                        run: this.run,
                                        password: this.password
                                    })
                                    .then(function(response2) {
                                        if (response2.data.length > 0) {
                                            if (
                                                response2.data[0]
                                                    .estado_login == 1
                                            ) {
                                                sessionStorage.setItem(
                                                    "permiso_usuario",
                                                    response2.data[0]
                                                        .permiso_usuario
                                                );
                                                if (
                                                    response2.data[0]
                                                        .permiso_usuario == 2
                                                ) {
                                                    pr = 4;
                                                } else if (
                                                    response2.data[0]
                                                        .permiso_usuario == 3
                                                ) {
                                                    pr = 5;
                                                } else if (
                                                    response2.data[0]
                                                        .permiso_usuario == 4
                                                ) {
                                                    pr = 6;
                                                } else if (
                                                    response2.data[0]
                                                        .permiso_usuario == 5 ||
                                                    response2.data[0]
                                                        .permiso_usuario == 6 ||
                                                    response2.data[0]
                                                        .permiso_usuario == 7 ||
                                                    response2.data[0]
                                                        .permiso_usuario == 8
                                                ) {
                                                    pr = 3;
                                                }
                                                //router.push('/home');
                                                //pr = 3;
                                            } else {
                                                pr = 2;
                                            }
                                        }
                                    });
                            }

                            if (pr == 1) {
                                this.$vs.notify({
                                    color: "danger",
                                    title: "Login",
                                    text: "Usuario y/o Contraseña Incorrectos."
                                });
                            }
                            if (pr == 2) {
                                this.$vs.notify({
                                    color: "danger",
                                    title: "Login",
                                    text:
                                        "Usted no posee acceso a la plataforma."
                                });
                            }
                            if (pr == 3) {
                                //localStorage.setItem('run',response2.data[0].permiso_usuario);
                                router.push("/agenteView/HomeAgente");
                            }
                            if (pr == 4) {
                                //localStorage.setItem('run',response2.data[0].permiso_usuario);
                                router.push("/home");
                            }
                            if (pr == 5) {
                                router.push("/HomeTrabajador");
                            }
                            if (pr == 6) {
                                //localStorage.setItem('run',response2.data[0].permiso_usuario);
                                router.push("/informaticaView/homeInformatica");
                            } else {
                                this.val_run = true;
                            }
                        }
                    }
                }
            } catch (error) {
                this.$vs.notify({
                    color: "danger",
                    title: "Login",
                    text: "Usuario y/o Contraseña Incorrectos."
                });
            }
        }
    },
    mounted() {
        this.autenticarToken();
    }
};
</script>

<style lang="scss">
#login-box {
    width: 360px;
}
.h-screen {
    background-image: linear-gradient(rgb(233, 236, 239), rgb(49, 215, 129));
}
</style>
