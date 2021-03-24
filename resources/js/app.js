require('./bootstrap');

import Vue from "vue";
import App from "./App.vue";
import router from "./router";

import Spinner from "./components/Spinner";

Vue.component("spinner", Spinner);

window.vm = new Vue({
    router,
    render: h => h(App)
}).$mount("#app");
