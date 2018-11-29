import Vue from "vue";

export default () => {
  Vue.prototype.G = {
    breakpoints: {
      sm: 768,
      md: 992,
      lg: 1200
    },
    defaultMenuType: "Lastest"
  };
};
