<template>
  <div id="page">
    <Menu></Menu>
    <router-view/>
  </div>
</template>

<script>
import Menu from "@/components/Menu.vue";

export default {
  components: {
    Menu
  }
};
</script>

<style lang="scss" scoped>
@import "@/assets/style/page.scss";
</style>
