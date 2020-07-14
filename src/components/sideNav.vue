<template>
<div class="menu">
  <ul>
    <li v-for="(rowNav, index) in arrNav"
        :key="index" @click.prevent="goAdmin($event, rowNav.url)"><div ><img v-bind:src="rowNav.urlImg" ></div>{{ rowNav.title }}</li>
  </ul>
</div>
</template>

<script>
export default {
  data: () => ({
    arrNav: [
      {url: "/", urlImg: "img/home.png", title: "На главную"},
      // {url: "/opeka", urlImg: "img/opeka.png", title: "Отдел опеки"},
      {url: "/ocenka", urlImg: "img/ocenka.png", title: "Оценка ПП ЗЛ"},
    ]
  }),
  methods: {
    goAdmin: function(event, url) {
      if(event.ctrlKey && event.shiftKey && accessUserAdmin) {
        this.$router.push('/ocenka-admin');
      } else {
        this.$router.push(url).catch(() => {}) ;
      }
    }
  }
}
</script>

<style scoped>
img {
  width: auto;
  max-width: 45px;
  height: auto;
  vertical-align: middle;
  border: 0px solid black;
}

li {
  display: inline-block;
  width: 100%;
  border-bottom: 2px solid grey;
  padding: 0px;
  padding-top: 5px;
  padding-bottom: 5px;
  margin: 0px;
  cursor: pointer;
}

li:hover {
  background-image: linear-gradient(to right, white 80%, lightgray);
}

div {
  display: inline-block;
  border: 0px solid black;
  width: 50px;
  margin-right: 0px;
}

.menu {
  width: 95%;
  padding-left: 5px;
  padding-right: 5px;
}
</style>