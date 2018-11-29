<template>
  <div id="article">
    <article>
      <h2>{{message}}</h2>
    </article>
  </div>
</template>

<script>
export default {
  data() {
    return {
      message: "This is an article page"
    };
  },
  mounted() {
    this.getArticle(this.$route.query.id);
  },
  methods: {
    getArticle(id) {
      this.message = this.message + id;
    }
  }
};
</script>

<style lang="scss" scoped>
@import "@/assets/style/article.scss";
</style>
