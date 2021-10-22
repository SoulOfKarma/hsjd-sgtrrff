<template>
    <div>
        <vx-card>
            <vs-alert active="true" color="success">
                Agente:
                {{ nombre }} - {{ run }}
            </vs-alert>

            <br />
        </vx-card>
        <vx-card title="Listado de Solicitudes">
            <vue-good-table
                :columns="columns"
                :rows="solicitudes"
                :pagination-options="{
                    enabled: true,
                    perPage: 10
                }"
            >
                <template slot="table-row" slot-scope="props">
                    <!-- Column: Name -->
                    <span
                        v-if="props.column.field === 'fullName'"
                        class="text-nowrap"
                    >
                    </span>

                    <span
                        v-if="props.column.field == 'descripcionEstado'"
                        class="text-nowrap"
                    >
                        <vs-chip
                            v-if="props.row.id_estado == 1"
                            color="primary"
                        >
                            {{ props.row.descripcionEstado }}
                        </vs-chip>

                        <vs-chip
                            v-if="props.row.id_estado == 2"
                            color="success"
                        >
                            {{ props.row.descripcionEstado }}
                        </vs-chip>
                        <vs-chip
                            v-if="props.row.id_estado == 3"
                            color="warning"
                        >
                            {{ props.row.descripcionEstado }}
                        </vs-chip>
                        <vs-chip
                            v-if="props.row.id_estado == 4"
                            color="warning"
                        >
                            {{ props.row.descripcionEstado }}
                        </vs-chip>
                        <vs-chip v-if="props.row.id_estado == 5" color="danger">
                            {{ props.row.descripcionEstado }}
                        </vs-chip>
                        <vs-chip v-if="props.row.id_estado == 6" color="danger">
                            {{ props.row.descripcionEstado }}
                        </vs-chip>
                        <vs-chip
                            v-if="props.row.id_estado == 7"
                            color="warning"
                        >
                            {{ props.row.descripcionEstado }}
                        </vs-chip>
                    </span>

                    <!-- Column: Action -->
                    <span v-else-if="props.column.field === 'action'">
                        <div v-if="props.row.idTicketCilindro > 0">
                            <plus-circle-icon
                                size="1.5x"
                                class="custom-class"
                                @click="
                                    asignarSolicitud(
                                        props.row.id,
                                        props.row.uuid
                                    )
                                "
                            ></plus-circle-icon>
                            <upload-icon
                                size="1.5x"
                                class="custom-class"
                                @click="
                                    modificarSolicitud(
                                        props.row.id,
                                        props.row.uuid
                                    )
                                "
                            ></upload-icon>
                            <trash-2-icon
                                size="1.5x"
                                class="custom-class"
                                @click="abrirPop(props.row.id, props.row.uuid)"
                            ></trash-2-icon>
                            <corner-down-right-icon
                                size="1.5x"
                                class="custom-class"
                                @click="
                                    cambiarCategoria(
                                        props.row.id,
                                        props.row.uuid
                                    )
                                "
                            ></corner-down-right-icon>
                            <printer-icon
                                size="1.5x"
                                class="custom-class"
                                @click="
                                    generarTicket(props.row.id, props.row.uuid)
                                "
                            ></printer-icon>
                            <file-plus-icon
                                size="1.5x"
                                class="custom-class"
                                @click="
                                    generarCilindro(
                                        props.row.id,
                                        props.row.uuid
                                    )
                                "
                            ></file-plus-icon>
                            <save-icon
                                size="1.5x"
                                class="custom-class"
                                @click="
                                    guardarPDFEscaneado(
                                        props.row.id,
                                        props.row.uuid
                                    )
                                "
                            ></save-icon>
                            <file-text-icon
                                size="1.5x"
                                class="custom-class"
                                @click="
                                    listadoDocumentacionAsociada(
                                        props.row.id,
                                        props.row.uuid
                                    )
                                "
                            ></file-text-icon>
                            <loader-icon
                                size="1.5x"
                                class="custom-class"
                                @click="
                                    GenerarTicketBID(
                                        props.row.id,
                                        props.row.uuid
                                    )
                                "
                            ></loader-icon>
                            <alert-triangle-icon
                                size="1.5x"
                                class="custom-class"
                                @click="
                                    popCerrarTicket(
                                        props.row.id,
                                        props.row.uuid
                                    )
                                "
                            ></alert-triangle-icon>
                        </div>
                        <div v-else>
                            <plus-circle-icon
                                size="1.5x"
                                class="custom-class"
                                @click="
                                    asignarSolicitud(
                                        props.row.id,
                                        props.row.uuid
                                    )
                                "
                            ></plus-circle-icon>
                            <upload-icon
                                size="1.5x"
                                class="custom-class"
                                @click="
                                    modificarSolicitud(
                                        props.row.id,
                                        props.row.uuid
                                    )
                                "
                            ></upload-icon>
                            <trash-2-icon
                                size="1.5x"
                                class="custom-class"
                                @click="abrirPop(props.row.id, props.row.uuid)"
                            ></trash-2-icon>
                            <corner-down-right-icon
                                size="1.5x"
                                class="custom-class"
                                @click="
                                    cambiarCategoria(
                                        props.row.id,
                                        props.row.uuid
                                    )
                                "
                            ></corner-down-right-icon>
                            <printer-icon
                                size="1.5x"
                                class="custom-class"
                                @click="
                                    generarTicket(props.row.id, props.row.uuid)
                                "
                            ></printer-icon>
                            <save-icon
                                size="1.5x"
                                class="custom-class"
                                @click="
                                    guardarPDFEscaneado(
                                        props.row.id,
                                        props.row.uuid
                                    )
                                "
                            ></save-icon>
                            <file-text-icon
                                size="1.5x"
                                class="custom-class"
                                @click="
                                    listadoDocumentacionAsociada(
                                        props.row.id,
                                        props.row.uuid
                                    )
                                "
                            ></file-text-icon>
                            <loader-icon
                                size="1.5x"
                                class="custom-class"
                                @click="
                                    GenerarTicketBID(
                                        props.row.id,
                                        props.row.uuid
                                    )
                                "
                            ></loader-icon>
                            <alert-triangle-icon
                                size="1.5x"
                                class="custom-class"
                                @click="
                                    popCerrarTicket(
                                        props.row.id,
                                        props.row.uuid
                                    )
                                "
                            ></alert-triangle-icon>
                        </div>
                    </span>

                    <!-- Column: Common -->
                    <span v-else>
                        {{ props.formattedRow[props.column.field] }}
                    </span>
                </template></vue-good-table
            >
        </vx-card>
        <vs-popup
            classContent="popup-example"
            title="Realmente desea eliminar el ticket?"
            :active.sync="popupActive2"
        >
            <vs-input
                class="inputx mb-3"
                placeholder="Placeholder"
                v-model="value1"
                hidden
            />
            <vs-input
                disabled
                class="inputx mb-3"
                placeholder="Disabled"
                v-model="value2"
                hidden
            />
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row">
                    <div class="vx-col sm:w-full w-full ">
                        <h6>Razon de la eliminacion</h6>
                        <br />
                        <quill-editor
                            v-model="dataEliminacion.descripcionSeguimiento"
                            :options="editorOption"
                        >
                            <div
                                id="toolbar"
                                slot="toolbar"
                            ></div> </quill-editor
                        ><br />
                        <vs-button
                            @click="
                                eliminarSolicitud(
                                    value1,
                                    value2,
                                    validaEliminar
                                )
                            "
                            color="danger"
                            type="filled"
                            >Eliminar</vs-button
                        >
                    </div>
                    <div class="vx-col sm:w-full w-full ">
                        <vs-button
                            @click="popupActive2 = false"
                            color="primary"
                            type="filled"
                            >Volver</vs-button
                        >
                    </div>
                </div>
            </div>
        </vs-popup>
        <vs-popup
            classContent="popup-example"
            title="Subir Solicitud Escaneada"
            :active.sync="popupActive3"
        >
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row">
                    <div class="vx-col sm:w-full w-full ">
                        <vx-card>
                            <div class="vx-row mb-12">
                                <div class="vx-col w-full mt-5">
                                    <vs-input
                                        type="file"
                                        @change="getImage"
                                        class="form-control w-full"
                                    />
                                </div>
                            </div>
                        </vx-card>
                        <br />
                        <vs-button
                            color="danger"
                            type="filled"
                            @click="uploadImage"
                            >Guardar Documento</vs-button
                        >
                    </div>
                    <div class="vx-col sm:w-full w-full ">
                        <vs-button
                            @click="popupActive3 = false"
                            color="primary"
                            type="filled"
                            >Volver</vs-button
                        >
                    </div>
                </div>
            </div>
        </vs-popup>
        <vs-popup
            classContent="popup-example"
            title="Ver Documentos Asociados"
            :active.sync="popupActive4"
        >
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row">
                    <div class="vx-col sm:w-full w-full ">
                        <vx-card>
                            <vs-table :data="documentacion">
                                <template slot="thead">
                                    <vs-th>ID</vs-th>
                                    <vs-th>N° Solicitud</vs-th>
                                    <vs-th>Documento</vs-th>
                                </template>

                                <template slot-scope="{ data }">
                                    <vs-tr
                                        :key="indextr"
                                        v-for="(tr, indextr) in data"
                                    >
                                        <vs-td :data="data[indextr].id">
                                            {{ data[indextr].id }}
                                        </vs-td>

                                        <vs-td :data="data[indextr].nticket">
                                            {{ data[indextr].nticket }}
                                        </vs-td>

                                        <vs-td
                                            :data="
                                                data[indextr].nombre_documento
                                            "
                                        >
                                            <file-text-icon
                                                size="1.5x"
                                                class="custom-class"
                                                @click="
                                                    verDocumento(
                                                        data[indextr]
                                                            .nombre_documento
                                                    )
                                                "
                                            ></file-text-icon>
                                        </vs-td>
                                    </vs-tr>
                                </template>
                            </vs-table>
                        </vx-card>
                        <br />
                    </div>
                    <div class="vx-col sm:w-full w-full ">
                        <vs-button
                            @click="popupActive4 = false"
                            color="primary"
                            type="filled"
                            >Volver</vs-button
                        >
                    </div>
                </div>
            </div>
        </vs-popup>
        <vs-popup
            classContent="popFinTicket"
            title="Cerrar Ticket?"
            :active.sync="popFinTicket"
        >
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row">
                    <div class="vx-col sm:w-full w-full ">
                        <vx-card>
                            <h6>Horas Trabajadas.</h6>
                            <br />
                            <vs-input
                                class="inputx mb-3 w-full"
                                v-model="horasTrabajadas"
                                @keypress="isNumber($event)"
                            />
                            <br />
                            <h6>Estado</h6>
                            <br />
                            <v-select
                                v-model="seleccionEstado"
                                placeholder="Seleccione el Estado"
                                class="w-full select-large"
                                label="descripcionEstado"
                                :options="listadoEstado"
                                @input="arrayEstado(seleccionEstado.id)"
                            ></v-select>
                        </vx-card>
                        <br />
                    </div>
                    <div class="vx-col w-full md-5">
                        <vs-button
                            @click="popFinTicket = false"
                            color="primary"
                            type="filled"
                            class="w-full m-1"
                            >Volver</vs-button
                        >
                        <vs-button
                            @click="finalizarTicket"
                            color="danger"
                            type="filled"
                            class="w-full m-1"
                            >Finalizar Ticket</vs-button
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
import router from "@/router";
import { InfoIcon } from "vue-feather-icons";
import { PlusCircleIcon } from "vue-feather-icons";
import { Trash2Icon } from "vue-feather-icons";
import { UploadIcon } from "vue-feather-icons";
import { CornerDownRightIcon } from "vue-feather-icons";
import { ArchiveIcon } from "vue-feather-icons";
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import { quillEditor } from "vue-quill-editor";
import { SaveIcon } from "vue-feather-icons";
import { FileTextIcon } from "vue-feather-icons";
import { LoaderIcon } from "vue-feather-icons";
import { AlertTriangleIcon } from "vue-feather-icons";
import { FilePlusIcon } from "vue-feather-icons";
import vSelect from "vue-select";
import moment from "moment";
import { PrinterIcon } from "vue-feather-icons";
import Vue from "vue";
// import the styles
import "vue-good-table/dist/vue-good-table.css";
import VueGoodTablePlugin from "vue-good-table";
Vue.use(VueGoodTablePlugin);

export default {
    components: {
        ArchiveIcon,
        "v-select": vSelect,
        InfoIcon,
        PlusCircleIcon,
        Trash2Icon,
        UploadIcon,
        CornerDownRightIcon,
        quillEditor,
        SaveIcon,
        FileTextIcon,
        LoaderIcon,
        AlertTriangleIcon,
        PrinterIcon,
        FilePlusIcon
    },
    data() {
        return {
            pageLength: 10,
            dir: false,
            searchTerm: "",
            editorOption: {
                modules: {
                    toolbar: [
                        ["bold", "italic", "underline", "strike"],
                        ["blockquote", "code-block"],
                        [{ header: 1 }, { header: 2 }],
                        [{ list: "ordered" }, { list: "bullet" }],
                        [{ indent: "-1" }, { indent: "+1" }],
                        [{ direction: "rtl" }],
                        [{ font: [] }],
                        [{ align: [] }],
                        ["clean"]
                    ]
                }
            },
            image: "",
            componentKey: 0,
            dataEliminacion: {
                id_solicitud: 0,
                descripcionSeguimiento: "",
                id_user: 0,
                uuid: "",
                nombre: sessionStorage.getItem("nombre"),
                razonEliminacion: ""
            },
            colorLoading: "#ff8000",
            value1: "",
            value2: "",
            value3: "",
            validaEliminar: false,
            popupActive2: false,
            popupActive3: false,
            popupActive4: false,
            popFinTicket: false,
            horasTrabajadas: 0,
            solicitudes: [],
            documentacion: [],
            dataDocumentacion: [],
            localVal: process.env.MIX_APP_URL,
            urlDocumentos: process.env.MIX_APP_URL_DOCUMENTOS,
            nombre:
                sessionStorage.getItem("nombre") +
                " " +
                sessionStorage.getItem("apellido"),
            run: sessionStorage.getItem("run"),
            idCierreTicket: "",
            uuidCierreTicket: "",
            listadoEstado: [],
            seleccionEstado: {
                id: 0,
                descripcionEstado: "Seleccione Estado"
            },
            columns: [
                {
                    label: "N° Ticket",
                    field: "nticket",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Solicitante",
                    field: "nombre",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Responsable",
                    field: "nombreTra",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Servicio",
                    field: "descripcionServicio",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Descripcion Problema",
                    field: "desFormat",
                    html: true,
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Tipo Reparacion",
                    field: "descripcionTipoReparacion",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Estado",
                    field: "descripcionEstado",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Fecha Solicitud",
                    field: "fechaSolicitud",
                    type: "date",
                    dateInputFormat: "dd/MM/yyyy",
                    dateOutputFormat: "dd/MM/yyyy",
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
    methods: {
        isNumber: function($event) {
            // console.log($event.keyCode); //keyCodes value
            let keyCode = $event.keyCode ? $event.keyCode : $event.which;

            // only allow number and one dot
            if (
                (keyCode < 48 || keyCode > 57) &&
                (keyCode !== 46 || this.price.indexOf(".") != -1)
            ) {
                // 46 is dot
                $event.preventDefault();
            }

            // restrict to 2 decimal places
            if (
                this.price != null &&
                this.price.indexOf(".") > -1 &&
                this.price.split(".")[1].length > 1
            ) {
                $event.preventDefault();
            }
        },
        popCerrarTicket(id, uuid) {
            try {
                this.popFinTicket = true;
                this.idCierreTicket = id;
                this.uuidCierreTicket = uuid;
            } catch (error) {
                console.log("Error al Abrir el Pop de cierre");
            }
        },
        finalizarTicket() {
            try {
                let data = {
                    id_solicitud: this.idCierreTicket,
                    uuid: this.uuidCierreTicket,
                    horasEjecucion: this.horasTrabajadas,
                    id: this.idCierreTicket,
                    id_estado: this.seleccionEstado[0].id,
                    horaTermino: moment(new Date()).format("H:mm"),
                    fechaTermino: moment(new Date()).format("YYYY-MM-DD")
                };
                axios
                    .post(
                        this.localVal + "/api/Agente/PostCierreTicketIND",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(response => {
                        if (response.data == true) {
                            this.$vs.notify({
                                title: "Ticket Cerrado ",
                                text: "Se recargara listado",
                                color: "success",
                                position: "top-right"
                            });
                            this.popFinTicket = false;
                            this.cargarSolicitudes();
                            this.horasTrabajadas = 0;
                        } else {
                            this.$vs.notify({
                                title: "Error Al cerrar ticket ",
                                text:
                                    "Verifique los campos e intente Nuevamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log("Error al Guardar guardar cambios");
                console.log(error);
            }
        },
        GenerarTicketBID(id, uuid) {
            try {
                this.$router.push({
                    name: "GenerarTicketIDBase",
                    params: {
                        id: `${id}`,
                        uuid: `${uuid}`
                    }
                });
            } catch (error) {
                console.log("No puede cargar la siguiente pagina");
            }
        },
        verDocumento(link) {
            const url = this.urlDocumentos + link;

            window.open(url, "_blank");
        },
        getImage(event) {
            //Asignamos la imagen a  nuestra data
            this.image = event.target.files[0];
        },
        uploadImage() {
            //Creamos el formData
            var data = new FormData();
            //Añadimos la imagen seleccionada
            data.append("avatar", this.image);
            data.append("id", this.value3);

            axios
                .post(this.localVal + "/api/Agente/PostDocumentoF", data, {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(response => {
                    if (response.data) {
                        this.$vs.notify({
                            title: "Documento Guardado ",
                            text:
                                "Podra Visualizarlo en el menu del costado para descargarlo o visualizarlo en el navegador ",
                            color: "success",
                            position: "top-right"
                        });
                        this.popupActive3 = false;
                    } else {
                        this.$vs.notify({
                            title: "Error al subir el documento ",
                            text:
                                "Intente nuevamente con el formato PDF o alguna Imagen ",
                            color: "danger",
                            position: "top-right"
                        });
                    }
                });
        },
        openLoadingColor() {
            this.$vs.loading({ color: this.colorLoading });
            setTimeout(() => {
                this.$vs.loading.close();
            }, 1000);
        },
        abrirPop(id, uuid) {
            this.validaEliminar = true;
            this.value1 = id;
            this.value2 = uuid;
            this.popupActive2 = true;
        },
        guardarPDFEscaneado(id, uuid) {
            this.value3 = id;

            this.popupActive3 = true;
        },
        listadoDocumentacionAsociada(id, uuid) {
            this.popupActive4 = true;
            let c = this.dataDocumentacion;
            let b = [];
            var a = 0;
            c.forEach((value, index) => {
                a = value.id_solicitud;
                if (a == id) {
                    b.push(value);
                }
            });

            this.documentacion = b;
        },
        forceRerender() {
            this.componentKey += 1;
        },
        cargarDocumentacion() {
            this.popupActive4 = true;
            let data = {
                id: id
            };
            axios
                .post(this.localVal + "/api/Agente/getDocumentos", data, {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    let listado = res.data;
                    /* let b = [];
                    let a = 0;
                    listado.forEach((value, index) => {
                        a = value.id_solicitud;
                        if (a == id) {
                            b.push(value);
                        }
                    }); */

                    this.documentacion = JSON.parse(JSON.stringify(listado));
                });
            //let c = this.dataDocumentacion;
        },
        cargarSolicitudes() {
            axios
                .get(this.localVal + "/api/Agente/GetSolicitudTicketsIND", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.solicitudes = res.data;
                });
        },
        generarTicket(id, uuid) {
            axios
                .get(
                    this.localVal +
                        `/api/Agente/ValidarTicketAsignadoModIND/${id}`,
                    {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    }
                )
                .then(res => {
                    if (res.data == 1) {
                        this.$vs.notify({
                            title: "Ticket no ha sido asignado ",
                            text:
                                "Ticket necesita ya estar asignado primero para generar el ticket ",
                            color: "danger",
                            position: "top-right"
                        });
                    } else {
                        const url =
                            this.localVal +
                            "/api/Agente/imprimirPorTicketIND/" +
                            id;
                        window.open(url, "_blank");
                    }
                });
        },
        generarCilindro(id, uuid) {
            axios
                .get(
                    this.localVal +
                        `/api/Agente/ValidarTicketAsignadoModIND/${id}`,
                    {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    }
                )
                .then(res => {
                    if (res.data == 1) {
                        this.$vs.notify({
                            title: "Ticket no ha sido asignado ",
                            text:
                                "Ticket necesita ya estar asignado primero para generar el ticket ",
                            color: "danger",
                            position: "top-right"
                        });
                    } else {
                        const url =
                            this.localVal +
                            "/api/Agente/imprimirCilindroIND/" +
                            id;
                        window.open(url, "_blank");
                    }
                });
        },
        detalleSolicitud(id, uuid) {
            this.$router.push({
                name: "InformacionSolicitudAgenteIND",
                params: {
                    id: `${id}`,
                    uuid: `${uuid}`
                }
            });
        },
        cambiarCategoria(id, uuid) {
            this.$router.push({
                name: "ModificarCategoriaTicket",
                params: {
                    id: `${id}`,
                    uuid: `${uuid}`
                }
            });
        },
        detalleSolicitudEliminados(id, uuid) {
            this.$router.push({
                name: "InformacionSolicitudEliminadosIND",
                params: {
                    id: `${id}`,
                    uuid: `${uuid}`
                }
            });
        },
        detalleSolicitudFinalizados(id, uuid) {
            this.$router.push({
                name: "InformacionSolicitudFinalizadosIND",
                params: {
                    id: `${id}`,
                    uuid: `${uuid}`
                }
            });
        },
        asignarSolicitud(id, uuid) {
            // router.push(`/agenteView/FormularioAsignar/${id}`);
            axios
                .get(
                    this.localVal +
                        `/api/Agente/ValidarTicketAsignadoIND/${id}`,
                    {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    }
                )
                .then(res => {
                    if (res.data == 2) {
                        this.$vs.notify({
                            title: "Ticket ya asignado ",
                            text:
                                "Si necesita modificarlo vaya a Modificar Ticket ",
                            color: "danger",
                            position: "top-right"
                        });
                    } else {
                        this.$router.push({
                            name: "AsignarSolicitudAgenteIND",
                            params: {
                                id: `${id}`,
                                uuid: `${uuid}`
                            }
                        });
                    }
                });
        },
        modificarSolicitud(id, uuid, id_user) {
            //router.push(`/agenteView/FormularioModificar/${id}`);
            axios
                .get(
                    this.localVal +
                        `/api/Agente/ValidarTicketAsignadoModIND/${id}`,
                    {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    }
                )
                .then(res => {
                    if (res.data == 1) {
                        this.$vs.notify({
                            title: "Ticket no ha sido asignado ",
                            text:
                                "Ticket necesita ya estar asignado primero para modificarlo ",
                            color: "danger",
                            position: "top-right"
                        });
                    } else {
                        this.$router.push({
                            name: "ModificarSolicitudAgenteIND",
                            params: {
                                id: `${id}`,
                                uuid: `${uuid}`,
                                id_user: `${id_user}`
                            }
                        });
                    }
                });
        },
        eliminarSolicitud(id, uuid, eliminar) {
            if (eliminar) {
                if (
                    this.dataEliminacion.descripcionSeguimiento == null ||
                    this.dataEliminacion.descripcionSeguimiento.length < 10
                ) {
                    this.$vs.notify({
                        title: "Campo Razon Vacio ",
                        text:
                            "Debe Escribir la razon de la eliminacion del ticket ",
                        time: 3000,
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    var iduser = sessionStorage.getItem("id");
                    this.dataEliminacion.id_solicitud = id;
                    this.dataEliminacion.uuid = uuid;
                    var newElement = document.createElement("div");
                    newElement.innerHTML = this.dataEliminacion.descripcionSeguimiento;
                    this.dataEliminacion.razonEliminacion =
                        newElement.textContent;
                    this.dataEliminacion.descripcionSeguimiento =
                        "El Agente " +
                        this.nombre +
                        " a eliminado el Ticket N°" +
                        id +
                        " " +
                        "<br/>" +
                        "Razon de la eliminacion:" +
                        this.dataEliminacion.descripcionSeguimiento;

                    this.dataEliminacion.id_user = iduser;
                    const dataEliminacion = this.dataEliminacion;
                    axios
                        .post(
                            this.localVal + "/api/Agente/destroyTicketIND",
                            dataEliminacion,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            var eliminado = res.data;
                            this.popupActive2 = false;
                            if (eliminado) {
                                this.$vs.notify({
                                    title: "Ticket Eliminado ",
                                    text: "Se recargara el listado ",
                                    time: 3000,
                                    color: "danger",
                                    position: "top-right"
                                });
                                this.cargarSolicitudes();
                            }
                        });
                }
            }
        },
        cargarEstado() {
            axios
                .get(this.localVal + "/api/Agente/GetEstado", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoEstado = res.data;
                });
        },
        arrayEstado(id) {
            let c = JSON.parse(JSON.stringify(this.listadoEstado));
            let b = [];
            var a = 0;

            c.forEach((value, index) => {
                a = value.id;
                if (a == id) {
                    b.push(value);
                }
            });
            this.seleccionEstado = b;
        }
    },
    beforeMount() {
        this.cargarSolicitudes();
        this.openLoadingColor();
        this.forceRerender();
        //this.cargarDocumentacion();
        this.cargarEstado();
    }
};
</script>
<style lang="stylus">
.popup-example
  .vs-button
    float left
    width 97%
    margin 10px
    margin-top 5px
</style>
