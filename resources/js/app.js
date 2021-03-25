require('./bootstrap');

import Vue from "vue";
import App from "./App.vue";
import router from "./router";

import Spoiler from "./components/Spoiler";
import Spinner from "./components/Spinner";
import CopyOnClick from "./components/CopyOnClick";

Vue.component('spoiler', Spoiler);
Vue.component("spinner", Spinner);
Vue.component("copy-on-click", CopyOnClick);

window.vm = new Vue({
    router,
    render: h => h(App)
}).$mount("#app");
