<template>
  <div id="app">
    <header class="header" @click="toIndex">
      <h1>白昼行将</h1>
    </header>
    <router-view/>
    <footer class="footer">copyright</footer>
  </div>
</template>

<script>
export default {
  methods: {
    toIndex() {
      this.$router.push({ name: "root" });
    }
  }
};
</script>

<style lang="scss" scoped>
@import "@/assets/style/app.scss";
</style>
