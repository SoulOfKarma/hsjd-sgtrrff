<template>
    <div id="simple-calendar-app">
        <div class="vx-card no-scroll-content">
            <calendar-view
                ref="calendar"
                :displayPeriodUom="calendarView"
                :show-date="showDate"
                :events="listadoCalendarioAsc"
                :eventTop="windowWidth <= 400 ? '2rem' : '3rem'"
                eventBorderHeight="0px"
                eventContentHeight="1.65rem"
                class="theme-default"
                @click-date="openAddNewEvent"
                @click-event="openEditEvent"
                @drop-on-date="eventDragged"
            >
                <div slot="header" class="mb-4">
                    <div class="vx-row no-gutter">
                        <!-- Month Name -->
                        <div class="vx-col w-1/3 items-center sm:flex hidden">
                            <!-- Add new event button -->
                            <vs-button
                                icon-pack="feather"
                                icon="icon-plus"
                                @click="promptAddNewEvent(new Date())"
                                >Agregar</vs-button
                            >
                        </div>

                        <!-- Current Month -->
                        <div
                            class="vx-col sm:w-1/3 w-full sm:my-0 my-3 flex sm:justify-end justify-center order-last"
                        >
                            <div class="flex items-center">
                                <feather-icon
                                    :icon="
                                        $vs.rtl
                                            ? 'ChevronRightIcon'
                                            : 'ChevronLeftIcon'
                                    "
                                    @click="updateMonth(-1)"
                                    svgClasses="w-5 h-5 m-1"
                                    class="cursor-pointer bg-primary text-white rounded-full"
                                />

                                <span
                                    class="mx-3 text-xl font-medium whitespace-no-wrap"
                                    >{{ showDate | month }}</span
                                >

                                <feather-icon
                                    :icon="
                                        $vs.rtl
                                            ? 'ChevronLeftIcon'
                                            : 'ChevronRightIcon'
                                    "
                                    @click="updateMonth(1)"
                                    svgClasses="w-5 h-5 m-1"
                                    class="cursor-pointer bg-primary text-white rounded-full"
                                />
                            </div>
                        </div>

                        <div class="vx-col sm:w-1/3 w-full flex justify-center">
                            <template
                                v-for="(view, index) in calendarViewTypes"
                            >
                                <vs-button
                                    v-if="calendarView === view.val"
                                    :key="String(view.val) + 'filled'"
                                    type="filled"
                                    class="p-3 md:px-8 md:py-3"
                                    :class="{
                                        'border-l-0 rounded-l-none': index,
                                        'rounded-r-none':
                                            calendarViewTypes.length !==
                                            index + 1
                                    }"
                                    @click="calendarView = view.val"
                                    >{{ view.label }}</vs-button
                                >
                                <vs-button
                                    v-else
                                    :key="String(view.val) + 'border'"
                                    type="border"
                                    class="p-3 md:px-8 md:py-3"
                                    :class="{
                                        'border-l-0 rounded-l-none': index,
                                        'rounded-r-none':
                                            calendarViewTypes.length !==
                                            index + 1
                                    }"
                                    @click="calendarView = view.val"
                                    >{{ view.label }}</vs-button
                                >
                            </template>
                        </div>
                    </div>

                    <div class="vx-row sm:flex hidden mt-4">
                        <div class="vx-col w-full flex">
                            <!-- Labels -->
                            <div
                                class="flex flex-wrap sm:justify-start justify-center"
                            >
                                <div
                                    v-for="(label, index) in calendarLabels"
                                    :key="index"
                                    class="flex items-center mr-4 mb-2"
                                >
                                    <div
                                        class="h-3 w-3 inline-block rounded-full mr-2"
                                        :class="'bg-' + label.color"
                                    ></div>
                                    <span>{{ label.text }}</span>
                                </div>
                                <div class="flex items-center mr-4 mb-2">
                                    <div
                                        class="h-3 w-3 inline-block rounded-full mr-2 bg-primary"
                                    ></div>
                                    <span>Ninguno</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </calendar-view>
        </div>

        <!-- ADD EVENT -->

        <vs-popup
            class="calendar-event-dialog"
            title="Agregar Nuevo Evento"
            :is-valid="validForm"
            :active.sync="activePromptAddEvent"
        >
            <div class="calendar__label-container flex">
                <vs-chip
                    v-if="labelLocal != 'none'"
                    class="text-white"
                    :class="'bg-' + labelColor(labelLocal)"
                    >{{ labelLocal }}</vs-chip
                >

                <vs-dropdown
                    vs-custom-content
                    vs-trigger-click
                    class="ml-auto my-2 cursor-pointer"
                >
                    <feather-icon
                        icon="TagIcon"
                        svgClasses="h-5 w-5"
                        class="cursor-pointer"
                        @click.prevent
                    ></feather-icon>

                    <vs-dropdown-menu style="z-index: 200001">
                        <vs-dropdown-item
                            v-for="(label, index) in calendarLabels"
                            :key="index"
                            @click="labelLocal = label.value"
                        >
                            <div
                                class="h-3 w-3 inline-block rounded-full mr-2"
                                :class="'bg-' + label.color"
                            ></div>
                            <span>{{ label.text }}</span>
                        </vs-dropdown-item>

                        <vs-dropdown-item @click="labelLocal = 'none'">
                            <div
                                class="h-3 w-3 mr-1 inline-block rounded-full mr-2 bg-primary"
                            ></div>
                            <span>Ninguno</span>
                        </vs-dropdown-item>
                    </vs-dropdown-menu>
                </vs-dropdown>
            </div>
            <div class="flex mb-4">
                <div class="w-full m-2">
                    <vs-input
                        name="event-name"
                        v-validate="'required'"
                        class="w-full"
                        label-placeholder="Titulo"
                        v-model="title"
                    ></vs-input>
                </div>
            </div>
            <div class="flex mb-4">
                <div class="w-full m-2">
                    <vs-input
                        name="event-name"
                        v-validate="'required'"
                        class="w-full"
                        label-placeholder="Descripcion"
                        v-model="descripcion_ascensores"
                    ></vs-input>
                </div>
            </div>
            <div class="flex mb-4">
                <div class="w-full m-2">
                    <v-select
                        placeholder="Trabajador"
                        class="w-full select-large"
                        label="tra_nombre_apellido"
                        :options="listadoTrabajadores"
                        v-model="seleccionTrabajador"
                    ></v-select>
                </div>
            </div>
            <div class="flex mb-4">
                <div class="w-full m-2">
                    <v-select
                        placeholder="Turno"
                        class="w-full select-large"
                        label="descripcionTurno"
                        :options="listadoTurno"
                        v-model="seleccionTurno"
                    ></v-select>
                </div>
            </div>
            <div class="flex mb-4">
                <div class="w-full m-2">
                    <v-select
                        placeholder="Edificio"
                        class="w-full select-large"
                        label="descripcionEdificio"
                        :options="listadoEdificios"
                        v-model="seleccionEdificio"
                    ></v-select>
                </div>
            </div>
            <div class="flex mb-4">
                <div class="w-1/2 m-2">
                    <small class="date-label">Seleccione Fecha Inicio</small>
                    <flat-pickr
                        class="w-full"
                        :config="configFromdateTimePicker"
                        v-model="startDate"
                        placeholder="Fecha Inicio"
                        @on-change="onFromChange"
                    />
                </div>

                <div class="w-1/2 m-2">
                    <small class="date-label">Seleccione Hora Inicio</small>
                    <flat-pickr
                        class="w-full"
                        :config="configdateTimePicker"
                        v-model="hora_inicio"
                        placeholder="Seleccione Hora"
                    />
                </div>
            </div>
            <div class="flex mb-4">
                <div class="w-1/2 m-2">
                    <small class="date-label">Seleccione Fecha Termino</small>
                    <flat-pickr
                        class="w-full"
                        :config="configTodateTimePicker"
                        v-model="endDate"
                        placeholder="Fecha Termino"
                    />
                </div>
                <div class="w-1/2 m-2">
                    <small class="date-label">Seleccione Hora Termino</small>
                    <flat-pickr
                        class="w-full"
                        :config="configdateTimePicker"
                        v-model="hora_termino"
                        placeholder="Seleccione Hora"
                    />
                </div>
            </div>
            <div class="flex mb-4">
                <div class="w-1/2 m-2 ">
                    <vs-button
                        @click="addEvent"
                        class="w-full"
                        color="warning"
                        type="filled"
                        >Agregar</vs-button
                    >
                </div>

                <div class="w-1/2 m-2">
                    <vs-button class="w-full" color="danger" type="filled"
                        >Cerrar</vs-button
                    >
                </div>
            </div>
        </vs-popup>

        <!-- EDIT EVENT -->
        <vs-popup
            class="calendar-event-dialog"
            title="Modificar Evento"
            :is-valid="validForm"
            :active.sync="activePromptEditEvent"
        >
            <div class="calendar__label-container flex">
                <vs-chip
                    v-if="labelLocal != 'none'"
                    class="text-white"
                    :class="'bg-' + labelColor(labelLocal)"
                    >{{ labelLocal }}</vs-chip
                >

                <vs-dropdown
                    vs-custom-content
                    class="ml-auto my-2 cursor-pointer"
                >
                    <feather-icon
                        icon="TagIcon"
                        svgClasses="h-5 w-5"
                        @click.prevent
                    ></feather-icon>

                    <vs-dropdown-menu style="z-index: 200001">
                        <vs-dropdown-item
                            v-for="(label, index) in calendarLabels"
                            :key="index"
                            @click="labelLocal = label.value"
                        >
                            <div
                                class="h-3 w-3 inline-block rounded-full mr-2"
                                :class="'bg-' + label.color"
                            ></div>
                            <span>{{ label.text }}</span>
                        </vs-dropdown-item>

                        <vs-dropdown-item @click="labelLocal = 'none'">
                            <div
                                class="h-3 w-3 mr-1 inline-block rounded-full mr-2 bg-primary"
                            ></div>
                            <span>Ninguno</span>
                        </vs-dropdown-item>
                    </vs-dropdown-menu>
                </vs-dropdown>
            </div>
            <div class="flex mb-4">
                <div class="w-full m-2">
                    <small class="date-label">Titulo</small>
                    <vs-input
                        name="event-name"
                        v-validate="'required'"
                        class="w-full"
                        v-model="title"
                    ></vs-input>
                </div>
            </div>
            <div class="flex mb-4">
                <div class="w-full m-2">
                    <small class="date-label">Descripcion</small>
                    <vs-input
                        name="event-name"
                        v-validate="'required'"
                        class="w-full"
                        v-model="descripcion_ascensores"
                    ></vs-input>
                </div>
            </div>
            <div class="flex mb-4">
                <div class="w-full m-2">
                    <small class="date-label"
                        >Seleccione Al Trabajador Encargado</small
                    >
                    <v-select
                        placeholder="Trabajador"
                        class="w-full select-large"
                        label="tra_nombre_apellido"
                        :options="listadoTrabajadores"
                        v-model="seleccionTrabajador"
                    ></v-select>
                </div>
            </div>
            <div class="flex mb-4">
                <div class="w-full m-2">
                    <small class="date-label">Seleccione Turno</small>
                    <v-select
                        placeholder="Turno"
                        class="w-full select-large"
                        label="descripcionTurno"
                        :options="listadoTurno"
                        v-model="seleccionTurno"
                    ></v-select>
                </div>
            </div>
            <div class="flex mb-4">
                <div class="w-full m-2">
                    <small class="date-label">Seleccione Edificio</small>
                    <v-select
                        placeholder="Edificio"
                        class="w-full select-large"
                        label="descripcionEdificio"
                        :options="listadoEdificios"
                        v-model="seleccionEdificio"
                    ></v-select>
                </div>
            </div>

            <div class="flex mb-4">
                <div class="w-1/2 m-2">
                    <small class="date-label">Seleccione Fecha Inicio</small>
                    <flat-pickr
                        class="w-full"
                        :config="configFromdateTimePicker"
                        v-model="startDate"
                        placeholder="Fecha Inicio"
                        @on-change="onFromChange"
                    />
                </div>

                <div class="w-1/2 m-2">
                    <small class="date-label">Seleccione Hora Inicio</small>
                    <flat-pickr
                        class="w-full"
                        :config="configdateTimePicker"
                        v-model="hora_inicio"
                        placeholder="Seleccione Hora"
                    />
                </div>
            </div>
            <div class="flex mb-4">
                <div class="w-1/2 m-2">
                    <small class="date-label">Seleccione Fecha Termino</small>
                    <flat-pickr
                        class="w-full"
                        :config="configTodateTimePicker"
                        v-model="endDate"
                        placeholder="Fecha Termino"
                    />
                </div>
                <div class="w-1/2 m-2">
                    <small class="date-label">Seleccione Hora Termino</small>
                    <flat-pickr
                        class="w-full"
                        :config="configdateTimePicker"
                        v-model="hora_termino"
                        placeholder="Seleccione Hora"
                    />
                </div>
            </div>
            <div class="flex mb-4">
                <div class="w-full m-2">
                    <small class="date-label"
                        >Solicito Dia Administrativo?</small
                    >
                    <v-select
                        placeholder="Dia Administrativo"
                        class="w-full select-large"
                        label="descripcionValDAdministrativo"
                        :options="listadoValDAdministrativo"
                        v-model="seleccionValDAdministrativo"
                        @input="arrayDiaAdm"
                    ></v-select>
                </div>
            </div>
            <div v-if="seleccionValDAdministrativo.idValDAdministrativo == 1">
                <div class="flex mb-4">
                    <div class="w-full m-2">
                        <small class="date-label"
                            >Seleccione Tipo de Dia Administrativo</small
                        >
                        <v-select
                            placeholder="Dia Administrativo"
                            class="w-full select-large"
                            label="descripcionDAdministrativo"
                            :options="listadoDAdministrativo"
                            v-model="seleccionDAdministrativo"
                        ></v-select>
                    </div>
                </div>
                <div class="flex mb-4">
                    <div class="w-full m-2">
                        <small class="date-label"
                            >Fecha Dia Administrativo</small
                        >
                        <flat-pickr
                            class="w-full"
                            :config="configFromdateTimePicker"
                            v-model="fecha_dia_administrativo"
                            placeholder="Fecha Inicio"
                        />
                    </div>
                </div>
                <div class="flex mb-4">
                    <div class="w-full m-2">
                        <ul class="centerx">
                            <li>
                                <vs-radio v-model="rDAdmin" vs-value="1"
                                    >Nuevo Dia Administrativo</vs-radio
                                >
                            </li>
                            <li>
                                <vs-radio v-model="rDAdmin" vs-value="2"
                                    >Modificar Dia Administrativo</vs-radio
                                >
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="flex mb-4">
                <div class="w-full m-2">
                    <small class="date-label">Solicito Vacaciones?</small>
                    <v-select
                        placeholder="Vacaciones?"
                        class="w-full select-large"
                        label="descripcionVacaciones"
                        :options="listadoVacaciones"
                        v-model="seleccionVacaciones"
                        @input="arrayVacaciones"
                    ></v-select>
                </div>
            </div>
            <div v-if="seleccionVacaciones.idVacaciones == 1">
                <div class="flex mb-4">
                    <div class="w-full m-2">
                        <small class="date-label"
                            >Fecha Inicio Vacaciones</small
                        >
                        <flat-pickr
                            class="w-full"
                            :config="configFromdateTimePicker"
                            v-model="fecha_inicio_vacaciones"
                            placeholder="Fecha Inicio"
                        />
                    </div>
                </div>
                <div class="flex mb-4">
                    <div class="w-full m-2">
                        <small class="date-label"
                            >Fecha Termino Vacaciones</small
                        >
                        <flat-pickr
                            class="w-full"
                            :config="configTodateTimePicker"
                            v-model="fecha_termino_vacaciones"
                            placeholder="Fecha Termino"
                        />
                    </div>
                </div>
                <div class="flex mb-4">
                    <div class="w-full m-2">
                        <ul class="centerx">
                            <li>
                                <vs-radio v-model="rVacaciones" vs-value="1"
                                    >Nueva Solicitud de Vacaciones</vs-radio
                                >
                            </li>
                            <li>
                                <vs-radio v-model="rVacaciones" vs-value="2"
                                    >Modificar Vacaciones Asignadas</vs-radio
                                >
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="flex mb-4">
                <div class="w-full m-2">
                    <small class="date-label">Se requiere reemplazo?</small>
                    <v-select
                        placeholder="Reemplazo"
                        class="w-full select-large"
                        label="descripcionReemplazo"
                        :options="listadoReemplazo"
                        v-model="seleccionReemplazo"
                        @input="arrayReemplazo"
                    ></v-select>
                </div>
            </div>
            <div v-if="seleccionReemplazo.idReemplazo == 1">
                <div class="flex mb-4">
                    <div class="w-full m-2">
                        <small class="date-label">Seleccione Trabajador</small>
                        <v-select
                            placeholder="Trabajador"
                            class="w-full select-large"
                            label="tra_nombre_apellido"
                            :options="listadoTrabajadores"
                            v-model="seleccionTrabajadorReemplazo"
                        ></v-select>
                    </div>
                </div>
                <div class="flex mb-4">
                    <div class="w-full m-2">
                        <small class="date-label">Fecha Inicio Reemplazo</small>
                        <flat-pickr
                            class="w-full"
                            :config="configFromdateTimePicker"
                            v-model="fecha_inicio_reemplazo"
                            placeholder="Fecha Inicio"
                        />
                    </div>
                </div>
                <div class="flex mb-4">
                    <div class="w-full m-2">
                        <small class="date-label"
                            >Fecha Termino Reemplazo</small
                        >
                        <flat-pickr
                            class="w-full"
                            :config="configTodateTimePicker"
                            v-model="fecha_termino_reemplazo"
                            placeholder="Fecha Termino"
                        />
                    </div>
                </div>
                <div class="flex mb-4">
                    <div class="w-full m-2">
                        <ul class="centerx">
                            <li>
                                <vs-radio v-model="rReemplazo" vs-value="1"
                                    >Nuevo Reemplazo</vs-radio
                                >
                            </li>
                            <li>
                                <vs-radio v-model="rReemplazo" vs-value="2"
                                    >Modificar Reemplazo Asignado</vs-radio
                                >
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="flex mb-4">
                <div class="w-full m-2">
                    <small class="date-label">Tiene Turno Extra?</small>
                    <v-select
                        placeholder="Turno Extra"
                        class="w-full select-large"
                        label="descripcionTurnoExtra"
                        :options="listadoTurnoExtra"
                        v-model="seleccionTurnoExtra"
                        @input="arrayTurnoExtra"
                    ></v-select>
                </div>
            </div>
            <div v-if="seleccionTurnoExtra.idTurnoExtra == 1">
                <div class="flex mb-4">
                    <div class="w-1/2 m-2">
                        <small class="date-label"
                            >Fecha Inicio Turno Extra</small
                        >
                        <flat-pickr
                            class="w-full"
                            :config="configFromdateTimePicker"
                            v-model="fecha_inicio_turno_extra"
                            placeholder="Fecha Inicio"
                        />
                    </div>
                    <div class="w-1/2 m-2">
                        <small class="date-label"
                            >Hora Inicio Turno Extra</small
                        >
                        <flat-pickr
                            class="w-full"
                            :config="configdateTimePicker"
                            v-model="hora_inicio_turno_extra"
                            placeholder="Seleccione Hora"
                        />
                    </div>
                </div>
                <div class="flex mb-4">
                    <div class="w-1/2 m-2">
                        <small class="date-label"
                            >Fecha Termino Turno Extra</small
                        >
                        <flat-pickr
                            class="w-full"
                            :config="configTodateTimePicker"
                            v-model="fecha_termino_turno_extra"
                            placeholder="Fecha Termino"
                        />
                    </div>
                    <div class="w-1/2 m-2">
                        <small class="date-label"
                            >Hora Termino Turno Extra</small
                        >
                        <flat-pickr
                            class="w-full"
                            :config="configdateTimePicker"
                            v-model="hora_termino_turno_extra"
                            placeholder="Seleccione Hora"
                        />
                    </div>
                </div>
                <div class="flex mb-4">
                    <div class="w-full m-2">
                        <ul class="centerx">
                            <li>
                                <vs-radio v-model="rTurnoExtra" vs-value="1"
                                    >Nuevo Turno Extra</vs-radio
                                >
                            </li>
                            <li>
                                <vs-radio v-model="rTurnoExtra" vs-value="2"
                                    >Modificar Turno Extra Asignado</vs-radio
                                >
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="flex mb-4">
                <div class="w-1/3 m-2 ">
                    <vs-button
                        @click="editEvent"
                        class="w-full"
                        color="warning"
                        type="filled"
                        >Editar</vs-button
                    >
                </div>
                <div class="w-1/3 m-2">
                    <vs-button
                        @click="infoDetallada"
                        class="w-full"
                        color="primary"
                        type="filled"
                        >Informacion Completa</vs-button
                    >
                </div>
                <div class="w-1/3 m-2">
                    <vs-button
                        @click="volver"
                        class="w-full"
                        color="rgb(37, 172, 249)"
                        type="filled"
                        >Cerrar Ventana</vs-button
                    >
                </div>
            </div>
            <div class="popInforAsc">
                <vs-popup
                    title="Informacion Adicional"
                    :active.sync="infoAdicionalesAct"
                    classContent="popInfo"
                >
                    <vs-table max-items="3" pagination :data="listadoInf">
                        <template slot="thead">
                            <vs-th>ID</vs-th>
                            <vs-th>Titulo</vs-th>
                            <vs-th>Descripcion</vs-th>
                            <vs-th>Dia Administrativo</vs-th>
                            <vs-th>Vacaciones</vs-th>
                            <vs-th>Reemplazo</vs-th>
                            <vs-th>Turno Extra</vs-th>
                            <vs-th>Informacion</vs-th>
                        </template>

                        <template slot-scope="{ data }">
                            <vs-tr :key="indextr" v-for="(tr, indextr) in data">
                                <vs-td :data="data[indextr].id">
                                    {{ data[indextr].id }}
                                </vs-td>

                                <vs-td :data="data[indextr].title">
                                    {{ data[indextr].title }}
                                </vs-td>

                                <vs-td
                                    :data="data[indextr].descripcion_ascensores"
                                >
                                    {{ data[indextr].descripcion_ascensores }}
                                </vs-td>

                                <vs-td
                                    :data="
                                        data[indextr].id_val_dia_administrativo
                                    "
                                >
                                    <div
                                        v-if="
                                            data[indextr]
                                                .id_val_dia_administrativo == 1
                                        "
                                    >
                                        {{ "Si" }}
                                    </div>
                                    <div v-else>
                                        {{ "No" }}
                                    </div>
                                </vs-td>
                                <vs-td :data="data[indextr].id_val_vacaciones">
                                    <div
                                        v-if="
                                            data[indextr].id_val_vacaciones == 1
                                        "
                                    >
                                        {{ "Si" }}
                                    </div>
                                    <div v-else>
                                        {{ "No" }}
                                    </div>
                                </vs-td>
                                <vs-td :data="data[indextr].id_val_reemplazo">
                                    <div
                                        v-if="
                                            data[indextr].id_val_reemplazo == 1
                                        "
                                    >
                                        {{ "Si" }}
                                    </div>
                                    <div v-else>
                                        {{ "No" }}
                                    </div>
                                </vs-td>
                                <vs-td :data="data[indextr].id_val_turno_extra">
                                    <div
                                        v-if="
                                            data[indextr].id_val_turno_extra ==
                                                1
                                        "
                                    >
                                        {{ "Si" }}
                                    </div>
                                    <div v-else>
                                        {{ "No" }}
                                    </div>
                                </vs-td>
                                <vs-td :data="data[indextr].id">
                                    <div
                                        v-if="
                                            data[indextr]
                                                .id_val_dia_administrativo ==
                                                1 ||
                                                data[indextr]
                                                    .id_val_vacaciones == 1 ||
                                                data[indextr]
                                                    .id_val_reemplazo == 1 ||
                                                data[indextr]
                                                    .id_val_turno_extra == 1
                                        "
                                    >
                                        <info-icon
                                            size="1.5x"
                                            class="custom-class"
                                            @click="
                                                verInfo(
                                                    data[indextr]
                                                        .id_val_dia_administrativo,
                                                    data[indextr]
                                                        .id_val_vacaciones,
                                                    data[indextr]
                                                        .id_val_reemplazo,
                                                    data[indextr]
                                                        .id_val_turno_extra
                                                )
                                            "
                                        ></info-icon>
                                    </div>
                                </vs-td>
                            </vs-tr>
                        </template>
                    </vs-table>
                    <vs-popup
                        class="infoDet"
                        title="Informacion Desglosada"
                        :active.sync="popInfoDet"
                    >
                        <vs-list
                            :key="indextr"
                            v-for="(tr, indextr) in listadoDet"
                        >
                            <div v-if="listValidaciones.idDAdm == 1">
                                <vx-card>
                                    {{
                                        "Fecha Dia Administrativo :" +
                                            " " +
                                            tr.fecha_dia_administrativo
                                    }}
                                    <br />
                                    {{
                                        "Tipo de dia solicitado :" +
                                            " " +
                                            tr.id_tipo_dia_administrativo
                                    }}
                                    <br />
                                    {{
                                        "Estado dia Adminisrativo:" +
                                            " " +
                                            tr.estado_dia_administrativo
                                    }}
                                </vx-card>
                            </div>

                            <div v-if="listValidaciones.idVac == 1">
                                <vx-card>
                                    {{
                                        "Fecha Inicio Vacaciones :" +
                                            " " +
                                            tr.fecha_inicio_vacaciones
                                    }}
                                    <br />
                                    {{
                                        "Fecha Termino Vacaciones :" +
                                            " " +
                                            tr.fecha_termino_vacaciones
                                    }}
                                    <br />
                                    {{
                                        "Estado Vacaciones:" +
                                            " " +
                                            tr.estado_vacaciones
                                    }}
                                </vx-card>
                                <br />
                            </div>

                            <div v-if="listValidaciones.idRem == 1">
                                <vx-card>
                                    {{
                                        "Trabajador Reemplazante :" +
                                            " " +
                                            tr.tra_nombre +
                                            " " +
                                            tr.tra_apellido
                                    }}
                                    <br />
                                    {{
                                        "Fecha Inicio Reemplazo :" +
                                            " " +
                                            tr.fecha_inicio_reemplazo
                                    }}
                                    <br />
                                    {{
                                        "Fecha Termino Reemplazo:" +
                                            " " +
                                            tr.fecha_termino_reemplazo
                                    }}
                                    <br />
                                    {{
                                        "Estado Reemplazo:" +
                                            " " +
                                            tr.estado_reemplazo
                                    }}
                                </vx-card>
                                <br />
                            </div>

                            <div v-if="listValidaciones.idTExt == 1">
                                <vx-card>
                                    {{
                                        "Fecha Inicio Turno Extra :" +
                                            " " +
                                            tr.fecha_inicio_turno_extra
                                    }}
                                    <br />
                                    {{
                                        "Hora Inicio Turno Extra :" +
                                            " " +
                                            tr.hora_inicio_turno_extra
                                    }}
                                    <br />
                                    {{
                                        "Fecha Termino Turno Extra:" +
                                            " " +
                                            tr.fecha_termino_reemplazo
                                    }}
                                    <br />
                                    {{
                                        "Hora Termino Turno Extra:" +
                                            " " +
                                            tr.hora_termino_turno_extra
                                    }}
                                    <br />
                                    {{
                                        "Estado Turno Extra:" +
                                            " " +
                                            tr.estado_turno_extra
                                    }}
                                </vx-card>
                                <br />
                            </div>
                        </vs-list>
                    </vs-popup>
                </vs-popup>
            </div>
        </vs-popup>
    </div>
</template>

<script>
import { CalendarView, CalendarViewHeader } from "vue-simple-calendar";
import moduleCalendar from "@/store/calendar/moduleCalendar.js";
require("vue-simple-calendar/static/css/default.css");
import moment from "moment";
import Datepicker from "vuejs-datepicker";
import { es } from "vuejs-datepicker/src/locale";
require("moment/locale/es");
import vSelect from "vue-select";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import axios from "axios";
import { InfoIcon } from "vue-feather-icons";

export default {
    components: {
        CalendarView,
        CalendarViewHeader,
        Datepicker,
        "v-select": vSelect,
        flatPickr,
        InfoIcon
    },
    colors: {
        primary: "#5b3cc4",
        success: "rgb(23, 201, 100)",
        danger: "rgb(242, 19, 93)",
        warning: "rgb(255, 130, 0)",
        dark: "rgb(66, 27, 150)"
    },
    data() {
        return {
            listadoInf: [],

            listadoDet: [],

            infoAdicionalesAct: false,
            popInfoDet: false,

            localVal: "http://10.66.248.51:8000",

            configFromdateTimePicker: {
                minDate: null,
                maxDate: null,
                locale: {
                    firstDayOfWeek: 1,
                    weekdays: {
                        shorthand: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                        longhand: [
                            "Domingo",
                            "Lunes",
                            "Martes",
                            "Miércoles",
                            "Jueves",
                            "Viernes",
                            "Sábado"
                        ]
                    },
                    months: {
                        shorthand: [
                            "Ene",
                            "Feb",
                            "Mar",
                            "Abr",
                            "May",
                            "Jun",
                            "Jul",
                            "Ago",
                            "Sep",
                            "Оct",
                            "Nov",
                            "Dic"
                        ],
                        longhand: [
                            "Enero",
                            "Febrero",
                            "Мarzo",
                            "Abril",
                            "Mayo",
                            "Junio",
                            "Julio",
                            "Agosto",
                            "Septiembre",
                            "Octubre",
                            "Noviembre",
                            "Diciembre"
                        ]
                    }
                }
            },

            configTodateTimePicker: {
                minDate: null,
                locale: {
                    firstDayOfWeek: 1,
                    weekdays: {
                        shorthand: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                        longhand: [
                            "Domingo",
                            "Lunes",
                            "Martes",
                            "Miércoles",
                            "Jueves",
                            "Viernes",
                            "Sábado"
                        ]
                    },
                    months: {
                        shorthand: [
                            "Ene",
                            "Feb",
                            "Mar",
                            "Abr",
                            "May",
                            "Jun",
                            "Jul",
                            "Ago",
                            "Sep",
                            "Оct",
                            "Nov",
                            "Dic"
                        ],
                        longhand: [
                            "Enero",
                            "Febrero",
                            "Мarzo",
                            "Abril",
                            "Mayo",
                            "Junio",
                            "Julio",
                            "Agosto",
                            "Septiembre",
                            "Octubre",
                            "Noviembre",
                            "Diciembre"
                        ]
                    }
                }
            },

            configdateTimePicker: {
                enableTime: true,
                enableSeconds: true,
                noCalendar: true
            },

            listValidaciones: {
                idDAdm: 0,
                idVac: 0,
                idRem: 0,
                idTExt: 0
            },

            listadoTrabajadores: [],
            labelLocal: "none",

            rDAdmin: "2",
            rVacaciones: "2",
            rReemplazo: "2",
            rTurnoExtra: "2",

            title: "",
            startDate: null,
            endDate: null,
            label: "none",
            descripcion_ascensores: "",
            id_trabajador: 0,
            id_turno: 0,
            id_edificio: 0,
            id_val_dia_administrativo: 2,
            id_val_vacaciones: 2,
            id_val_reemplazo: 2,
            id_val_turno_extra: 2,
            id_tipo_dia_administrativo: 0,
            fecha_dia_administrativo: null,
            fecha_inicio_vacaciones: null,
            fecha_termino_vacaciones: null,
            dias_vacaciones: 0,
            id_trabajador_reemplazo: 0,
            fecha_inicio_reemplazo: null,
            fecha_termino_reemplazo: null,
            dias_reemplazo: 0,
            fecha_inicio_turno_extra: null,
            fecha_termino_turno_extra: null,
            dias_ejecucion_turno_extra: null,
            horas_ejecucion_turno_extra: null,
            hora_termino_turno_extra: null,
            hora_inicio_turno_extra: null,
            hora_inicio: null,
            hora_termino: null,
            dias_ejecucion: 0,
            horas_ejecucion: 0,
            id_dia_administrativo: null,
            id_vacaciones: null,
            id_reemplazo: null,
            id_turno_extra: null,
            id_calendario: 0,
            classes: "",
            estado_turno_extra: true,
            estado_reemplazo: true,
            estado_dia_administrativo: true,
            estado_vacaciones: true,

            events: {
                title: "",
                startDate: null,
                endDate: null,
                label: "none",
                descripcion_ascensores: "",
                id_trabajador: 0,
                id_turno: 0,
                id_edificio: 0,
                id_val_dia_administrativo: 2,
                id_val_vacaciones: 2,
                id_val_reemplazo: 2,
                id_val_turno_extra: 2,
                id_tipo_dia_administrativo: 0,
                fecha_dia_administrativo: null,
                fecha_inicio_vacaciones: null,
                fecha_termino_vacaciones: null,
                dias_vacaciones: 0,
                id_trabajador_reemplazo: 0,
                fecha_inicio_reemplazo: null,
                fecha_termino_reemplazo: null,
                dias_reemplazo: 0,
                fecha_inicio_turno_extra: null,
                fecha_termino_turno_extra: null,
                dias_ejecucion_turno_extra: null,
                horas_ejecucion_turno_extra: null,
                hora_termino_turno_extra: null,
                hora_inicio_turno_extra: null,
                hora_inicio: null,
                hora_termino: null,
                dias_ejecucion: 0,
                horas_ejecucion: 0,
                rDAdmin: "2",
                rVacaciones: "2",
                rReemplazo: "2",
                rTurnoExtra: "2",
                id_dia_administrativo: null,
                id_vacaciones: null,
                id_reemplazo: null,
                id_turno_extra: null,
                id_calendario: null,
                classes: "",
                estado_turno_extra: true,
                estado_reemplazo: true,
                estado_dia_administrativo: true,
                estado_vacaciones: true
            },
            listadoTurnoExtra: [
                {
                    idTurnoExtra: 1,
                    descripcionTurnoExtra: "Si"
                },
                { idTurnoExtra: 2, descripcionTurnoExtra: "No" }
            ],

            listadoReemplazo: [
                {
                    idReemplazo: 1,
                    descripcionReemplazo: "Si"
                },
                { idReemplazo: 2, descripcionReemplazo: "No" }
            ],

            listadoVacaciones: [
                {
                    idVacaciones: 1,
                    descripcionVacaciones: "Si"
                },
                { idVacaciones: 2, descripcionVacaciones: "No" }
            ],

            listadoValDAdministrativo: [
                {
                    idValDAdministrativo: 1,
                    descripcionValDAdministrativo: "Si"
                },
                { idValDAdministrativo: 2, descripcionValDAdministrativo: "No" }
            ],

            listadoDAdministrativo: [
                {
                    idDAdministrativo: 1,
                    descripcionDAdministrativo: "Mañana"
                },
                { idDAdministrativo: 2, descripcionDAdministrativo: "Tarde" },
                {
                    idDAdministrativo: 3,
                    descripcionDAdministrativo: "Dia Completo"
                }
            ],

            seleccionDAdministrativo: {
                idDAdministrativo: 1,
                descripcionDAdministrativo: "Mañana"
            },

            seleccionValDAdministrativo: {
                idValDAdministrativo: 2,
                descripcionValDAdministrativo: "No"
            },

            seleccionReemplazo: {
                idReemplazo: 2,
                descripcionReemplazo: "No"
            },

            seleccionVacaciones: {
                idVacaciones: 2,
                descripcionVacaciones: "No"
            },

            seleccionTurnoExtra: {
                idTurnoExtra: 2,
                descripcionTurnoExtra: "No"
            },

            //Para Hacer Array

            seleccionValDAdministrativoData: [
                {
                    idValDAdministrativo: 2,
                    descripcionValDAdministrativo: "No"
                }
            ],

            seleccionReemplazoData: [
                {
                    idReemplazo: 2,
                    descripcionReemplazo: "No"
                }
            ],

            seleccionVacacionesData: [
                {
                    idVacaciones: 2,
                    descripcionVacaciones: "No"
                }
            ],

            seleccionTurnoExtraData: [
                {
                    idTurnoExtra: 2,
                    descripcionTurnoExtra: "No"
                }
            ],
            // Aca termina

            listadoTurno: [],
            seleccionTurno: {
                id: 0,
                descripcionTurno: "Seleccione Turno"
            },
            listadoEdificios: [],
            seleccionEdificio: {
                id: 0,
                descripcionEdificio: "Seleccione Edificio"
            },

            seleccionTrabajador: {
                id: 0,
                tra_nombre_apellido: "Seleccione al Trabajador"
            },

            seleccionTrabajadorReemplazo: {
                id: 0,
                tra_nombre_apellido: "Seleccione al Trabajador"
            },

            listadoCalendarioAsc: [],

            listadoDataDAdministrativo: [],
            listadoDataVacaciones: [],
            listadoDataReemplazo: [],
            listadoDataTurnoExtra: [],

            meses: new Array(
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre"
            ),

            showDate: new Date(moment()),

            calendarView: "month",

            activePromptAddEvent: false,
            activePromptEditEvent: false,

            calendarViewTypes: [
                {
                    label: "Mes",
                    val: "month"
                },
                {
                    label: "Semana",
                    val: "week"
                },
                {
                    label: "Año",
                    val: "year"
                }
            ]
        };
    },
    computed: {
        /* simpleCalendarEvents() {
            let list = this.$store.state.calendar.events;

            return list;
        }, */
        validForm() {
            return (
                this.title !== "" &&
                this.startDate !== "" &&
                this.endDate !== "" &&
                Date.parse(this.endDate) - Date.parse(this.startDate) >= 0 &&
                !this.errors.has("event-url")
            );
        },
        disabledDatesTo() {
            return { to: new Date(this.startDate) };
        },
        disabledDatesFrom() {
            return { from: new Date(this.endDate) };
        },
        calendarLabels() {
            return this.$store.state.calendar.eventLabels;
        },
        labelColor() {
            return label => {
                if (label === "vacaciones") return "success";
                else if (label === "dadministrativo") return "warning";
                else if (label === "reemplazo") return "dark";
                else if (label === "turnoextra") return "danger";
                else if (label === "none") return "primary";
            };
        },
        windowWidth() {
            return this.$store.state.windowWidth;
        }
    },
    methods: {
        //Informacion Detallada Disponible Solo si tiene activo alguno de los id
        verInfo(idDAdm, idVac, idRem, idTExt) {
            if (idDAdm == 1 || idVac == 1 || idRem == 1 || idTExt == 1) {
                let data = {
                    id: this.listadoInf[0].id
                };

                const dat = data;
                axios
                    .post(this.localVal + "/api/Agente/GetDataCalenAsc", dat)
                    .then(res => {
                        this.listadoDet = res.data;
                    });
                this.listValidaciones.idDAdm = idDAdm;
                this.listValidaciones.idVac = idVac;
                this.listValidaciones.idRem = idRem;
                this.listValidaciones.idTExt = idTExt;
                this.popInfoDet = true;
            } else {
                this.$vs.notify({
                    title: "No tiene Informacion disponible ",
                    text:
                        "El Trabajador del turno, debe tener asignado alguno de los campos para su visualizacion",
                    color: "danger",
                    position: "top-right"
                });
            }
        },
        infoDetallada() {
            let listadoInfo = this.listadoCalendarioAsc;
            let a = [];
            listadoInfo.forEach((value, index) => {
                if (value.id == this.id_calendario) {
                    a.push(value);
                }
            });
            this.listadoInf = a;
            this.infoAdicionalesAct = true;
        },
        volver() {
            this.activePromptEditEvent = false;
        },
        //Seleccion como Array
        arrayDiaAdm() {
            let a = this.listadoValDAdministrativo;
            let b = [];
            a.forEach((value, index) => {
                if (
                    value.idValDAdministrativo ==
                    this.seleccionValDAdministrativo.idValDAdministrativo
                ) {
                    b.push(value);
                }
            });

            this.seleccionValDAdministrativoData = b;
        },
        arrayVacaciones() {
            let a = this.listadoVacaciones;
            let b = [];
            a.forEach((value, index) => {
                if (
                    value.idVacaciones == this.seleccionVacaciones.idVacaciones
                ) {
                    b.push(value);
                }
            });

            this.seleccionVacacionesData = b;
        },
        arrayReemplazo() {
            let a = this.listadoReemplazo;
            let b = [];
            a.forEach((value, index) => {
                if (value.idReemplazo == this.seleccionReemplazo.idReemplazo) {
                    b.push(value);
                }
            });

            this.seleccionReemplazoData = b;
        },
        arrayTurnoExtra() {
            let a = this.listadoTurnoExtra;
            let b = [];
            a.forEach((value, index) => {
                if (
                    value.idTurnoExtra == this.seleccionTurnoExtra.idTurnoExtra
                ) {
                    b.push(value);
                }
            });

            this.seleccionTurnoExtraData = b;
        },
        //Carga Calendario
        simpleCalendarEvents() {
            console.log(this.showDate);
            axios
                .get(this.localVal + "/api/Agente/GetCalendarioAsc")
                .then(res => {
                    this.listadoCalendarioAsc = res.data;
                });
        },
        //Carga de los edificios
        cargarEdificios() {
            axios.get(this.localVal + "/api/Usuario/GetEdificios").then(res => {
                this.listadoEdificios = res.data;
            });
        },
        //Carga de turnos
        cargarTurnos() {
            axios.get(this.localVal + "/api/Agente/GetTurnos").then(res => {
                this.listadoTurno = res.data;
            });
        },
        //Carga de trabajadores
        cargarTrabajadores() {
            axios
                .get(this.localVal + "/api/Agente/GetTrabajadores")
                .then(res => {
                    this.cargarApoyosArray(res.data);
                });
        },
        //Carga de los dias Administrativos
        cargaDAdminAsc() {
            axios.get(this.localVal + "/api/Agente/DAdminAsc").then(res => {
                this.listadoDataDAdministrativo = res.data;
            });
        },
        //Carga de las Vacaciones
        cargaVacAsc() {
            axios
                .get(this.localVal + "/api/Agente/VAscensoristas")
                .then(res => {
                    this.listadoDataVacaciones = res.data;
                });
        },
        //Carga de Reemplazos
        cargaRemAsc() {
            axios
                .get(this.localVal + "/api/Agente/RAscensoristas")
                .then(res => {
                    this.listadoDataReemplazo = res.data;
                });
        },
        //Carga de los Turnos Extras
        cargaTurExtAsc() {
            axios
                .get(this.localVal + "/api/Agente/TurExtAscensoristas")
                .then(res => {
                    this.listadoDataTurnoExtra = res.data;
                });
        },
        cargarApoyosArray(listadoApoyo) {
            this.listadoTrabajadoresData = listadoApoyo;
            let c = listadoApoyo;

            let b = [];
            var a = 0;

            c.forEach((value, index) => {
                if (1 != value.id) {
                    b.push(value);
                }
            });

            this.listadoTrabajadores = b;
        },
        onFromChange(selectedDates, dateStr, instance) {
            this.$set(this.configTodateTimePicker, "minDate", dateStr);
        },
        //Seleccion de fechas
        onToChange(selectedDates, dateStr, instance) {
            this.$set(this.configFromdateTimePicker, "maxDate", dateStr);
        },
        addEvent() {
            this.events.title = this.title;
            this.events.descripcion_ascensores = this.descripcion_ascensores;
            this.events.startDate = this.startDate;
            this.events.endDate = this.endDate;
            this.events.id_turno = this.seleccionTurno.id;
            this.events.id_trabajador = this.seleccionTrabajador.id;
            this.events.id_edificio = this.seleccionEdificio.id;
            this.events.hora_inicio = this.hora_inicio;
            this.events.hora_termino = this.hora_termino;
            this.events.label = this.labelLocal;
            this.events.classes = `event-${this.labelColor(this.labelLocal)}`;

            const newevent = this.events;
            axios
                .post(this.localVal + "/api/Agente/PostCalendarioAsc", newevent)
                .then(res => {
                    if (res.data) {
                        console.log("Ok");
                        this.simpleCalendarEvents();
                    } else {
                        console.log("Error");
                    }
                });

            //obj.classes = `event-${this.labelColor(this.labelLocal)}`;
            //this.$store.dispatch("calendar/addEvent", newevent);
            this.activePromptAddEvent = false;
        },
        updateMonth(val) {
            this.showDate = this.$refs.calendar.getIncrementedPeriod(val);
        },
        clearFields() {
            this.title = this.endDate = this.url = "";
            this.id_calendario = 0;
            this.labelLocal = "none";
        },
        promptAddNewEvent(date) {
            this.disabledFrom = false;
            this.addNewEventDialog(date);
        },
        addNewEventDialog(date) {
            this.clearFields();
            this.startDate = date;
            this.endDate = date;
            this.activePromptAddEvent = true;
        },
        openAddNewEvent(date) {
            this.disabledFrom = true;
            this.addNewEventDialog(date);
        },
        openEditEvent(event) {
            let calen = this.listadoCalendarioAsc;
            let b = [];
            let a = 0;

            calen.forEach((value, index) => {
                a = value.id;
                if (a == event.id) {
                    b.push(value);
                }
            });

            const e = b;
            this.id_calendario = e[0].id;
            this.title = e[0].title;
            this.startDate = e[0].startDate;
            this.endDate = e[0].endDate;
            this.descripcion_ascensores = e[0].descripcion_ascensores;
            this.labelLocal = e[0].label;
            this.hora_inicio = e[0].hora_inicio;
            this.hora_termino = e[0].hora_termino;
            let turno = this.listadoTurno;
            let d = [];
            let f = 0;

            turno.forEach((value, index) => {
                f = value.id;
                if (f == e[0].id_turno) {
                    d.push(value);
                }
            });

            this.seleccionTurno = d;

            let trabajador = this.listadoTrabajadores;
            let g = [];
            let h = 0;

            trabajador.forEach((value, index) => {
                h = value.id;
                if (h == e[0].id_trabajador) {
                    g.push(value);
                }
            });

            this.seleccionTrabajador = g;

            let edificio = this.listadoEdificios;
            let i = [];
            let j = 0;

            edificio.forEach((value, index) => {
                j = value.id;
                if (j == e[0].id_edificio) {
                    i.push(value);
                }
            });

            this.seleccionEdificio = i;

            let valDAdministrativo = this.listadoValDAdministrativo;
            let k = [];
            let l = 0;

            valDAdministrativo.forEach((value, index) => {
                l = value.idValDAdministrativo;
                if (l == e[0].id_val_dia_administrativo) {
                    k.push(value);
                }
            });

            this.seleccionValDAdministrativo = k;

            let reemplazo = this.listadoReemplazo;
            let m = [];
            let n = 0;

            reemplazo.forEach((value, index) => {
                n = value.idReemplazo;
                if (n == e[0].id_val_reemplazo) {
                    m.push(value);
                }
            });

            this.seleccionReemplazo = m;

            let vacaciones = this.listadoVacaciones;
            let o = [];
            let p = 0;

            vacaciones.forEach((value, index) => {
                p = value.idVacaciones;
                if (p == e[0].id_val_vacaciones) {
                    o.push(value);
                }
            });

            this.seleccionVacaciones = o;

            let turnoExtra = this.listadoTurnoExtra;
            let q = [];
            let r = 0;

            turnoExtra.forEach((value, index) => {
                r = value.idTurnoExtra;
                if (r == e[0].id_val_turno_extra) {
                    q.push(value);
                }
            });

            this.seleccionTurnoExtra = q;

            if (e[0].id_val_dia_administrativo == 1) {
                let dataDiaAdm = this.listadoDataDAdministrativo;
                let aa = [];
                let bb = 0;

                dataDiaAdm.forEach((value, index) => {
                    bb = value.id_calendario_ascensores;
                    if (bb == e[0].id) {
                        aa.push(value);
                    }
                });

                this.id_tipo_dia_administrativo =
                    aa[0].id_tipo_dia_administrativo;
                this.fecha_dia_administrativo = aa[0].fecha_dia_administrativo;
                this.id_dia_administrativo = aa[0].id;

                let listSDAdministrativo = this.listadoDAdministrativo;
                let cc = [];
                let dd = 0;

                listSDAdministrativo.forEach((value, index) => {
                    dd = value.idDAdministrativo;
                    if (dd == aa[0].id_tipo_dia_administrativo) {
                        cc.push(value);
                    }
                });

                this.seleccionDAdministrativo = cc;
            }

            if (e[0].id_val_vacaciones == 1) {
                let dataVacaciones = this.listadoDataVacaciones;
                let a = [];
                let b = 0;
                dataVacaciones.forEach((value, index) => {
                    b = value.id_calendario_ascensores;
                    if (b == e[0].id) {
                        a.push(value);
                    }
                });

                this.fecha_inicio_vacaciones = a[0].fecha_inicio_vacaciones;
                this.fecha_termino_vacaciones = a[0].fecha_termino_vacaciones;
                this.id_vacaciones = a[0].id_vacaciones;
            }

            if (e[0].id_val_reemplazo == 1) {
                let dataReemplazo = this.listadoDataReemplazo;
                let a = [];
                let b = 0;
                dataReemplazo.forEach((value, index) => {
                    b = value.id_calendario_ascensores;
                    if (b == e[0].id) {
                        a.push(value);
                    }
                });

                this.fecha_inicio_reemplazo = a[0].fecha_inicio_reemplazo;
                this.fecha_termino_reemplazo = a[0].fecha_termino_reemplazo;
                this.id_reemplazo = a[0].id;

                let dataTrabajador = this.listadoTrabajadores;
                let c = [];
                let d = 0;
                dataTrabajador.forEach((value, index) => {
                    d = value.id;
                    if (d == a[0].id_trabajador_reemplazo) {
                        c.push(value);
                    }
                });

                this.seleccionTrabajadorReemplazo = c;
            }

            if (e[0].id_val_turno_extra == 1) {
                let dataTurnoExtra = this.listadoDataTurnoExtra;
                let a = [];
                let b = 0;
                dataTurnoExtra.forEach((value, index) => {
                    b = value.id_calendario_ascensores;
                    if (b == e[0].id) {
                        a.push(value);
                    }
                });
                this.fecha_inicio_turno_extra = a[0].fecha_inicio_turno_extra;
                this.fecha_termino_turno_extra = a[0].fecha_termino_turno_extra;
                this.id_turno_extra = a[0].id;
            }

            this.activePromptEditEvent = true;
        },
        editEvent() {
            const events = {
                title: this.title,
                startDate: this.startDate,
                endDate: this.endDate,
                label: this.labelLocal,
                descripcion_ascensores: this.descripcion_ascensores,
                id_trabajador: this.seleccionTrabajador[0].id,
                id_turno: this.seleccionTurno[0].id,
                id_edificio: this.seleccionEdificio[0].id,
                id_val_dia_administrativo: this
                    .seleccionValDAdministrativoData[0].idValDAdministrativo,
                id_val_vacaciones: this.seleccionVacacionesData[0].idVacaciones,
                id_val_reemplazo: this.seleccionReemplazoData[0].idReemplazo,
                id_val_turno_extra: this.seleccionTurnoExtraData[0]
                    .idTurnoExtra,
                id_tipo_dia_administrativo: this.seleccionDAdministrativo
                    .idDAdministrativo,
                fecha_dia_administrativo: this.fecha_dia_administrativo,
                fecha_inicio_vacaciones: this.fecha_inicio_vacaciones,
                fecha_termino_vacaciones: this.fecha_termino_vacaciones,
                dias_vacaciones: 0,
                id_trabajador_reemplazo: this.seleccionTrabajadorReemplazo.id,
                fecha_inicio_reemplazo: this.fecha_inicio_reemplazo,
                fecha_termino_reemplazo: this.fecha_termino_reemplazo,
                dias_reemplazo: 0,
                fecha_inicio_turno_extra: this.fecha_inicio_turno_extra,
                fecha_termino_turno_extra: this.fecha_termino_turno_extra,
                dias_ejecucion_turno_extra: 0,
                horas_ejecucion_turno_extra: 0,
                hora_termino_turno_extra: this.hora_termino_turno_extra,
                hora_inicio_turno_extra: this.hora_inicio_turno_extra,
                hora_inicio: this.hora_inicio,
                hora_termino: this.hora_termino,
                dias_ejecucion: 0,
                horas_ejecucion: 0,
                rDAdmin: this.rDAdmin,
                rVacaciones: this.rVacaciones,
                rReemplazo: this.rReemplazo,
                rTurnoExtra: this.rTurnoExtra,
                id_dia_administrativo: this.id_dia_administrativo,
                id_vacaciones: this.id_vacaciones,
                id_reemplazo: this.id_reemplazo,
                id_turno_extra: this.id_turno_extra,
                id_calendario_ascensores: this.id_calendario,
                classes: `event-${this.labelColor(this.labelLocal)}`,
                estado_turno_extra: true,
                estado_reemplazo: true,
                estado_dia_administrativo: true,
                estado_vacaciones: true
            };

            this.events = {
                title: "",
                startDate: null,
                endDate: null,
                label: "none",
                descripcion_ascensores: "",
                id_trabajador: 0,
                id_turno: 0,
                id_edificio: 0,
                id_val_dia_administrativo: 2,
                id_val_vacaciones: 2,
                id_val_reemplazo: 2,
                id_val_turno_extra: 2,
                id_tipo_dia_administrativo: 0,
                fecha_dia_administrativo: null,
                fecha_inicio_vacaciones: null,
                fecha_termino_vacaciones: null,
                dias_vacaciones: 0,
                id_trabajador_reemplazo: 0,
                fecha_inicio_reemplazo: null,
                fecha_termino_reemplazo: null,
                dias_reemplazo: 0,
                fecha_inicio_turno_extra: null,
                fecha_termino_turno_extra: null,
                dias_ejecucion_turno_extra: null,
                horas_ejecucion_turno_extra: null,
                hora_termino_turno_extra: null,
                hora_inicio_turno_extra: null,
                hora_inicio: null,
                hora_termino: null,
                dias_ejecucion: 0,
                horas_ejecucion: 0,
                rDAdmin: "2",
                rVacaciones: "2",
                rReemplazo: "2",
                rTurnoExtra: "2",
                id_dia_administrativo: null,
                id_vacaciones: null,
                id_reemplazo: null,
                id_turno_extra: null,
                id_calendario: null,
                classes: "",
                estado_turno_extra: true,
                estado_reemplazo: true,
                estado_dia_administrativo: true,
                estado_vacaciones: true
            };

            //console.log(events);
            if (events.id_val_dia_administrativo == 1) {
                this.cargaDAdminAsc();
            } else if (events.id_val_vacaciones == 1) {
                this.cargaVacAsc();
            } else if (events.id_val_reemplazo == 1) {
                c;
                this.cargaRemAsc();
            } else if (events.id_val_turno_extra == 1) {
                this.cargaTurExtAsc();
            }

            axios
                .post(this.localVal + "/api/Agente/PutCalendarioAsc", events)
                .then(res => {
                    if (res.data == true) {
                        console.log("Ok");
                        this.simpleCalendarEvents();
                    } else {
                        console.log("Error");
                    }
                });

            // this.$store.dispatch("calendar/editEvent", events);
            this.activePromptEditEvent = false;
        },
        removeEvent() {
            this.$store.dispatch("calendar/removeEvent", this.id);
            this.activePromptEditEvent = false;
        },
        eventDragged(event, date) {
            this.$store.dispatch("calendar/eventDragged", { event, date });
        }
    },
    created() {
        this.$vs.theme({
            dark: "rgb(37, 172, 249)" // my new color
        });
        this.$store.registerModule("calendar", moduleCalendar);
        this.$store.dispatch("calendar/fetchEvents");
        this.$store.dispatch("calendar/fetchEventLabels");
        this.cargarTrabajadores();
        this.cargarTurnos();
        this.cargarEdificios();
        this.simpleCalendarEvents();
        this.cargaDAdminAsc();
        this.cargaRemAsc();
        this.cargaVacAsc();
        this.cargaTurExtAsc();
    },
    beforeDestroy() {
        this.$store.unregisterModule("calendar");
    }
};
</script>

<style lang="scss">
@import "@sass/vuexy/apps/simple-calendar.scss";
</style>

<style>
.con-vs-popup .vs-popup {
    width: auto !important;
}
</style>
