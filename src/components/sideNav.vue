<template>
  <ul>
    <router-link
      v-for="rowNav in arrNav"
      v-bind:key="rowNav.url"
      tag="li"
      :to="rowNav.url"
    >
      <div><img v-bind:src="rowNav.urlImg" ></div>{{ rowNav.title }}
    </router-link>
  </ul>
</template>

<script>
export default {
  data: () => ({
    arrNav: [
      {url: "/", urlImg: "img/home.png", title: "На главную"},
      {url: "/opeka", urlImg: "img/opeka.png", title: "Отдел опеки"},
      {url: "/ocenka", urlImg: "img/fss.png", title: "Оценка ПП ЗЛ"},
      // {url: "/foms", urlImg: "img/foms.png", title: "ФОМС"},
      // {url: "/fssp", urlImg: "img/fssp.png", title: "ФССП"},
      // {url: "/czn", urlImg: "img/czn.png", title: "Центр занятости"}
    ]
  })
}
</script>

<style scoped>
img {
  width: auto;
  max-width: 50px;
  height: 50px;
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
  margin-right: 10px;
}
</style>