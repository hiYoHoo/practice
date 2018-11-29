<template>
  <menu id="menu" :class="{'is-spread': menu_spread}">
    <span class="link" @click="spread">{{selected.name}}</span>
    <router-link class="link" :to="{name:'home', params:{page:'home', type:link.type}}" :key="index" v-for="(link, index) in menu_links" @click.native="spread(link.type)">{{link.name}}</router-link>
  </menu>
</template>

<script>
export default {
  data() {
    return {
      menu_spread: false,
      menu_links: [
        { name: "最新", type: "Lastest" },
        { name: "Javascript", type: "Javascript" },
        { name: "PHP", type: "PHP" },
        { name: "Linux", type: "Linux" }
      ],
      selected_type: this.$route.params.type || this.G.defaultMenuType
    };
  },
  computed: {
    selected() {
      const _selected_type = this.menu_links.find(
        link => link.type === this.selected_type
      );
      if (!_selected_type) {
        this.$router.replace({ name: "notfound" });
        return false;
      }
      return _selected_type;
    }
  },
  watch: {
    $route() {
      this.menu_spread = false;
    },
    selected_type: {
      handler(type) {
        console.log(type);
      },
      immediate: true
    }
  },
  methods: {
    spread(type) {
      const media_query = `(max-width: ${this.G.breakpoints.sm - 1}px)`;
      if (window.matchMedia(media_query).matches) {
        this.menu_spread = !this.menu_spread;
        if (typeof type === "string") this.selected_type = type;
      }
    }
  }
};
</script>

<style lang="scss" scoped>
@import "@/assets/style/menu.scss";
</style>
