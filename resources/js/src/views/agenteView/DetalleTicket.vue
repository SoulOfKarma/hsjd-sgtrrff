<template>
    <div>
        <div
            class="vue-back-to-top"
            style="bottom: 5%; right: 30px; display: none;"
        >
            <button
                type="button"
                name="button"
                class="vs-component vs-button shadow-lg btn-back-to-top vs-button-primary vs-button-filled includeIcon includeIconOnly"
            >
                <span
                    class="vs-button-backgroundx vs-button--background"
                    style="opacity: 1; left: 20px; top: 20px; width: 0px; height: 0px; transition: width 0.3s ease 0s, height 0.3s ease 0s, opacity 0.3s ease 0s;"
                ></span
                ><i
                    class="vs-icon notranslate icon-scale vs-button--icon  feather icon-arrow-up null"
                    style="order: 0; margin-right: 0px; margin-left: 0px;"
                ></i
                ><!----><span
                    class="vs-button-linex"
                    style="top: auto; bottom: -2px; left: 50%; transform: translate(-50%);"
                ></span>
            </button>
        </div>
        <div id="invoice-page">
            <div class="flex flex-wrap items-center justify-between">
                <div class="vx-input-group flex mb-base mr-3">
                    <!---->
                    <div class="vx-input-group-default flex-grow">
                        <div
                            class="vs-component vs-con-input-label vs-input vs-input-primary"
                        >
                            <!---->
                            <div class="vs-con-input">
                                <input
                                    type="text"
                                    class="vs-inputx vs-input--input normal"
                                    style="border: 1px solid rgba(0, 0, 0, 0.2);"
                                /><span
                                    class="input-span-placeholder vs-input--placeholder normal"
                                >
                                    Email </span
                                ><!----><!---->
                            </div>
                            <span></span>
                        </div>
                    </div>
                    <div class="vx-input-group-append flex">
                        <div class="append-text btn-addon">
                            <button
                                type="button"
                                name="button"
                                class="vs-component vs-button whitespace-no-wrap vs-button-primary vs-button-border"
                                style="background: transparent none repeat scroll 0% 0%;"
                            >
                                <span
                                    class="vs-button-backgroundx vs-button--background"
                                    style="opacity: 1; left: 20px; top: 20px; width: 0px; height: 0px; transition: width 0.3s ease 0s, height 0.3s ease 0s, opacity 0.3s ease 0s;"
                                ></span
                                ><!----><span
                                    class="vs-button-text vs-button--text"
                                    >Send Invoice</span
                                ><span
                                    class="vs-button-linex"
                                    style="top: auto; bottom: -2px; left: 50%; transform: translate(-50%);"
                                ></span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="flex items-center">
                    <button
                        type="button"
                        name="button"
                        class="vs-component vs-button mb-base mr-3 vs-button-primary vs-button-border includeIcon"
                        style="background: transparent none repeat scroll 0% 0%;"
                    >
                        <span
                            class="vs-button-backgroundx vs-button--background"
                            style="opacity: 1; left: 20px; top: 20px; width: 0px; height: 0px; transition: width 0.3s ease 0s, height 0.3s ease 0s, opacity 0.3s ease 0s;"
                        ></span
                        ><i
                            class="vs-icon notranslate icon-scale vs-button--icon  feather icon icon-download null"
                            style="order: 0; margin-right: 5px; margin-left: 0px;"
                        ></i
                        ><span class="vs-button-text vs-button--text"
                            >Download</span
                        ><span
                            class="vs-button-linex"
                            style="top: auto; bottom: -2px; left: 50%; transform: translate(-50%);"
                        ></span>
                    </button>
                    <button
                        type="button"
                        @click="print"
                        name="button"
                        class="vs-component vs-button mb-base mr-3 vs-button-primary vs-button-filled includeIcon"
                    >
                        <span
                            class="vs-button-backgroundx vs-button--background"
                            style="opacity: 1; left: 39px; top: 18px; width: 0px; height: 0px; transition: width 0s ease 0s, height 0s ease 0s, opacity 0s ease 0s;"
                        ></span
                        ><i
                            class="vs-icon notranslate icon-scale vs-button--icon  feather icon icon-file null"
                            style="order: 0; margin-right: 5px; margin-left: 0px;"
                        ></i
                        ><span class="vs-button-text vs-button--text"
                            >Print</span
                        ><span
                            class="vs-button-linex"
                            style="top: auto; bottom: -2px; left: 50%; transform: translate(-50%);"
                        ></span>
                    </button>
                </div>
            </div>
            <div class="vx-card">
                <!---->
                <div
                    class="vx-card__collapsible-content vs-con-loading__container"
                >
                    <div class="vx-card__body" id="invoice-container">
                        <vs-row vs-w="12">
                            <vs-col
                                vs-type="flex"
                                vs-justify="center"
                                vs-align="left"
                                vs-lg="1"
                                vs-sm="4"
                                vs-xs="12"
                            >
                                <img
                                    src="@assets/images/logo/1.png"
                                    alt="vuexy-logo"
                                />
                                <!-- vs-sm="4" vs-xs="12" -->
                            </vs-col>
                            <vs-col
                                vs-align="center"
                                vs-lg="10"
                                vs-sm="4"
                                vs-xs="12"
                            >
                                <h2 class="text-center">
                                    Orden de Trabajo
                                </h2>
                                <h5 class="text-center">
                                    Unidad de Mantenimiento - Infraestructura
                                </h5>
                                <!-- vs-sm="4" vs-xs="12" -->
                            </vs-col>
                            <vs-col
                                vs-type="flex"
                                vs-justify="center"
                                vs-align="center"
                                vs-lg="1"
                                vs-sm="4"
                                vs-xs="12"
                            >
                                <!-- vs-sm="4" vs-xs="12" -->
                            </vs-col>
                        </vs-row>
                        <vs-row vs-w="12">
                            <vs-col
                                vs-type="flex"
                                vs-justify="center"
                                vs-align="center"
                                vs-lg="2"
                                vs-sm="4"
                                vs-xs="12"
                            >
                                <!-- vs-sm="4" vs-xs="12" -->
                            </vs-col>
                            <vs-col
                                vs-type="flex"
                                vs-justify="center"
                                vs-align="center"
                                vs-lg="2"
                                vs-sm="4"
                                vs-xs="12"
                            >
                                <h5>N° Ticket:</h5>
                                <!-- vs-sm="4" vs-xs="12" -->
                            </vs-col>
                            <vs-col
                                vs-type="flex"
                                vs-justify="center"
                                vs-align="center"
                                vs-lg="2"
                                vs-sm="4"
                                vs-xs="12"
                            >
                                <h5>5</h5>
                                <!-- vs-sm="4" vs-xs="12" -->
                            </vs-col>
                            <vs-col
                                vs-align="center"
                                vs-lg="2"
                                vs-sm="4"
                                vs-xs="12"
                                ><h5>Fecha Solicitud:</h5>
                            </vs-col>
                            <vs-col
                                vs-type="flex"
                                vs-justify="center"
                                vs-align="center"
                                vs-lg="2"
                                vs-sm="4"
                                vs-xs="12"
                            >
                                <h5>20-06-12</h5>
                                <!-- vs-sm="4" vs-xs="12" -->
                            </vs-col>
                            <vs-col
                                vs-type="flex"
                                vs-justify="center"
                                vs-align="center"
                                vs-lg="2"
                                vs-sm="4"
                                vs-xs="12"
                            >
                                <!-- vs-sm="4" vs-xs="12" -->
                            </vs-col>
                        </vs-row>
                        <br />
                        <vs-row vs-w="12">
                            <vs-col
                                vs-type="flex"
                                vs-justify="center"
                                vs-align="center"
                                vs-lg="2"
                                vs-sm="4"
                                vs-xs="12"
                            >
                                <!-- vs-sm="4" vs-xs="12" -->
                            </vs-col>
                            <vs-col
                                vs-type="flex"
                                vs-justify="center"
                                vs-align="center"
                                vs-lg="2"
                                vs-sm="4"
                                vs-xs="12"
                            >
                                <h5>N° Ticket:</h5>
                                <!-- vs-sm="4" vs-xs="12" -->
                            </vs-col>
                            <vs-col
                                vs-type="flex"
                                vs-justify="center"
                                vs-align="center"
                                vs-lg="2"
                                vs-sm="4"
                                vs-xs="12"
                            >
                                <h5>5</h5>
                                <!-- vs-sm="4" vs-xs="12" -->
                            </vs-col>
                            <vs-col
                                vs-align="center"
                                vs-lg="2"
                                vs-sm="4"
                                vs-xs="12"
                                ><h5>Fecha Solicitud:</h5>
                            </vs-col>
                            <vs-col
                                vs-type="flex"
                                vs-justify="center"
                                vs-align="center"
                                vs-lg="2"
                                vs-sm="4"
                                vs-xs="12"
                            >
                                <h5>20-06-12</h5>
                                <!-- vs-sm="4" vs-xs="12" -->
                            </vs-col>
                            <vs-col
                                vs-type="flex"
                                vs-justify="center"
                                vs-align="center"
                                vs-lg="2"
                                vs-sm="4"
                                vs-xs="12"
                            >
                                <!-- vs-sm="4" vs-xs="12" -->
                            </vs-col> </vs-row
                        ><br />
                        <vs-row vs-w="12">
                            <vs-col
                                vs-type="flex"
                                vs-justify="center"
                                vs-align="center"
                                vs-lg="2"
                                vs-sm="4"
                                vs-xs="12"
                            >
                                <!-- vs-sm="4" vs-xs="12" -->
                            </vs-col>
                            <vs-col
                                vs-type="flex"
                                vs-justify="center"
                                vs-align="center"
                                vs-lg="2"
                                vs-sm="4"
                                vs-xs="12"
                            >
                                <h5>N° Ticket:</h5>
                                <!-- vs-sm="4" vs-xs="12" -->
                            </vs-col>
                            <vs-col
                                vs-type="flex"
                                vs-justify="center"
                                vs-align="center"
                                vs-lg="2"
                                vs-sm="4"
                                vs-xs="12"
                            >
                                <h5>5</h5>
                                <!-- vs-sm="4" vs-xs="12" -->
                            </vs-col>
                            <vs-col
                                vs-align="center"
                                vs-lg="2"
                                vs-sm="4"
                                vs-xs="12"
                                ><h5>Fecha Solicitud:</h5>
                            </vs-col>
                            <vs-col
                                vs-type="flex"
                                vs-justify="center"
                                vs-align="center"
                                vs-lg="2"
                                vs-sm="4"
                                vs-xs="12"
                            >
                                <h5>20-06-12</h5>
                                <!-- vs-sm="4" vs-xs="12" -->
                            </vs-col>
                            <vs-col
                                vs-type="flex"
                                vs-justify="center"
                                vs-align="center"
                                vs-lg="2"
                                vs-sm="4"
                                vs-xs="12"
                            >
                                <!-- vs-sm="4" vs-xs="12" -->
                            </vs-col>
                        </vs-row>
                        <br />
                    </div>
                    <!---->
                </div>
                <div
                    class="vx-card__code-container collapsed"
                    style="max-height: 0px; display: none;"
                >
                    <div class="code-content">
                        <pre
                            class="language-markup"
                        ><code class="language-markup"></code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Vue from "vue";
import VueHtmlToPaper from "vue-html-to-paper";
import { Printd } from "printd";

const options = {
    name: "_blank",
    specs: ["fullscreen=yes", "titlebar=yes", "scrollbars=yes"],
    styles: [
        "https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css",
        "https://unpkg.com/kidlat-css/css/kidlat.css"
    ]
};
Vue.use(VueHtmlToPaper, options);
export default {
    data() {
        return {
            output: null
        };
    },
    methods: {
        print() {
            // Pass the element id here
            this.$htmlToPaper("invoice-container");
        }
    }
};
</script>
