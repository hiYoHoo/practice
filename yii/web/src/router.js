import Vue from "vue";
import Router from "vue-router";
import Page from "./views/Page.vue";
import Home from "./views/Home.vue";
import Article from "./views/Article.vue";
import NotFound from "./views/NotFound.vue";

Vue.use(Router);

export default new Router({
  mode: "history",
  routes: [
    {
      path: "/",
      name: "root",
      alias: "/home",
      redirect: { name: "home" }
    },
    {
      path: "/:page",
      name: "page",
      component: Page,
      children: [
        {
          path: "/home/:type",
          name: "home",
          component: Home
        },
        {
          path: "/article",
          name: "article",
          component: Article
        },
        {
          path: "/*",
          redirect: { name: "notfound" }
        }
      ]
    },
    {
      path: "*",
      name: "notfound",
      component: NotFound
    }
  ]
});
