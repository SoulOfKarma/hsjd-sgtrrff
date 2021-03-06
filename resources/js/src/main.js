/*=========================================================================================
  File Name: main.js
  Description: main vue(js) file
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

import Vue from "vue";
import App from "./App.vue";

// Vuesax Component Framework
import Vuesax from "vuesax";

Vue.use(Vuesax);

import moment from "moment";

// axios
import axios from "./axios.js";
Vue.prototype.$http = axios;

// mock
import "./fake-db/index.js";

// API Calls
import "./http/requests";

// Theme Configurations
import "../themeConfig.js";

// Globally Registered Components
import "./globalComponents.js";

// Vue Router
import router from "./router";

// Vuex Store
import store from "./store/store";

// Vuexy Admin Filters
import "./filters/filters";

// VeeValidate
import VeeValidate, { Validator } from "vee-validate";
import es from "vee-validate/dist/locale/es";
Vue.use(VeeValidate);
Validator.localize("es", es);

// Vuejs - Vue wrapper for hammerjs
import { VueHammer } from "vue2-hammer";
Vue.use(VueHammer);

// PrismJS
import "prismjs";
import "prismjs/themes/prism-tomorrow.css";

Vue.config.productionTip = false;

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount("#app");
