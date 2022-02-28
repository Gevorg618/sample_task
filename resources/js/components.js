import Vue from "vue"

Vue.component('App', () => import("./layouts/App"));
Vue.component('Item', () => import("./components/Item"));
Vue.component('Column', () => import("./components/column"));
