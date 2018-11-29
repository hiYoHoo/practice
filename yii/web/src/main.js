import Vue from "vue";
import "@/assets/style/common.scss";
import App from "./App.vue";
import router from "./router";
import global from "./global";
import { library } from "@fortawesome/fontawesome-svg-core";
import { faCoffee, faChild } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

library.add(faCoffee, faChild);
Vue.component("font-awesome-icon", FontAwesomeIcon);

Vue.use(global);
Vue.config.productionTip = false;

new Vue({
  router,
  render: h => h(App)
}).$mount("#app");
