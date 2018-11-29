<template>
  <div id="contents">
    <router-link :to="{name:'article', params:{page:'article'}, query:{id:chap.id}}" v-for="(chap, index) in chapters" :key="index" class="link">
      <section class="chapter">
        <h2 class="title">{{chap.title}}</h2>
        <h3 class="summary">{{chap.summary}}</h3>
      </section>
    </router-link>
  </div>
</template>

<script>
export default {
  data() {
    return {
      chapters: [
        {
          id: 233,
          title: "JavaScript教程",
          summary:
            "这是小白的零基础JavaScript全栈教程，可以在线免费学习！可以在线编写JavaScript代码并直接运行！零基础迈向全栈开发工程师！这是小白的零基础Java"
        },
        {
          id: 234,
          title: "Python教程",
          summary:
            "小白的Python新手教程，具有如下特点：中文，免费，零起点，完整示例，基于最新的Python 3版本。随着AI时代的来临，Python已经是必学语言。"
        },
        {
          id: 235,
          title: "Git教程",
          summary:
            "史上最浅显易懂的Git教程，绝对面向初学者！如果你是一个开发人员，想用上这个世界上目前最先进的分布式版本控制系统，那么，赶快开始学习吧！"
        }
      ]
    };
  }
};
</script>

<style lang="scss" scoped>
@import "@/assets/style/contents.scss";
</style>
