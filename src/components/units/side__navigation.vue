<template>
<div class="side-navigation">
  <ul class="navigation">
    <router-link tag="li" class="navigation__item" to="/">
      <img class="item__img" src="@/assets/images/menu/menu_home.png" />
      <span class="item__title">На главную</span>
    </router-link>
    <router-link tag="li" class="navigation__item" to="/office-work">
      <img class="item__img" src="@/assets/images/menu/menu_documents.png" />
      <span class="item__title">Делопроизводство</span>
    </router-link>
    <li class="navigation__item" @click.prevent="goOcenkaAdmin($event, '/ocenka')">
      <img class="item__img" src="@/assets/images/menu/menu_ocenka.png" />
      <span class="item__title">Оценка ПП ЗЛ</span>
    </li>

  </ul>
</div>
</template>

<script>
export default {
  data: () => ({
  }),
  methods: {
    goOcenkaAdmin: function(event, url) {
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
  font-size: 14px;
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
      .item__img { 
        width: 30px; 
        margin-right: 10px; 
      }
      .item__title {
        font-family: 'Open sans';
        font-weight: bold;
        color: darkslateblue;
      }
    }
  }
}
</style>