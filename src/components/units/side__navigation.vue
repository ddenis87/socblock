<template>
<div class="side-navigation">
  <ul class="navigation">
    <li class="navigation__item" 
        v-for="(rowNav, index) in arrNav"
        :key="index" 
        @click.prevent="goAdmin($event, rowNav.url)">
      <img class="item__img" v-bind:src="rowNav.urlImg" />
      <span class="item__title">{{ rowNav.title }}</span>
    </li>
  </ul>
</div>
</template>

<script>
export default {
  data: () => ({
    arrNav: [
      {url: "/", urlImg: "img/menu_home.png", title: "На главную"},
      {url: "/office-work", urlImg: "img/menu_documents.png", title: "Делопроизводство"},
      {url: "/ocenka", urlImg: "img/menu_ocenka.png", title: "Оценка ПП ЗЛ"},
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

<style lang="scss" scoped>
@import '@/variables.scss';

.side-navigation {
  padding-right: 20px;

  
  .navigation {
    padding-left: 10px;
    &__item {
      display: flex;
      padding: 10px 5px;
      align-items: center;
      list-style: none;

      border-top: 1px solid white;
      border-bottom: 1px solid white;
      text-transform: uppercase;
      cursor: pointer;
      &:hover {
        color: lightgray;
        border-top: 1px solid grey;
        border-bottom: 1px solid grey;
        background-image: linear-gradient(90deg, lightgray, white );
      }
      .item__img { width: 30px; margin-right: 10px; }
      .item__title {
        font-family: 'Open sans';
        font-weight: bold;
        color: darkslateblue;
      }
    }
  }
}
</style>

<style scoped>
/* img {
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
} */
</style>