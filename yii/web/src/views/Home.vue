<template>
  <div id="home">
    <Contents></Contents>
    <Message></Message>
  </div>
</template>

<script>
import Contents from "@/components/Contents.vue";
import Message from "@/components/Message.vue";

export default {
  components: {
    Contents,
    Message
  }
};
</script>

<style lang="scss" scoped>
@import "@/assets/style/home.scss";
</style>
