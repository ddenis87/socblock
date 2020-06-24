<template>
  <div class="side-bar">
    <div >
      <img class="logo" src="img/logo-pfr.jpg">
    </div>
    {{ dT }}
    <div class="profil">
      <img src="/img/user-profile-bar.png" />
      <span>Denis Dontsov</span>
      <img src="/img/drop-down.png" />
      <div class="slide">
        <ul>
          <li><img src="/img/user-profile.png" />Профиль</li>
          <router-link to="/" tag="li"><img src="/img/user-exit.png" />Выход</router-link>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'sideTop',
  data: function() {
    return {
      dT: '',
    }
  },
  mounted: function() {
    setInterval(() => {this.dT = Date()}, 1000);
  }
}
</script>

<style scoped>
.side-bar {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

img {
  width: 25px;
  height: 25px;
  margin-left: 5px;
  margin-right: 5px;
}

.logo {
  width: auto;
  height: 48px;
}

.profil {
  display: inline-flex;
  position: relative;
  width: auto;
  min-width: 150px;
  height: 40px;
  border: 1px solid white;
  justify-content: space-between;
  align-items: center;
}

.slide {
  position: absolute;
  display: block;
  width: 150px;
  height: 0px;
  top: 41px;
  left: -1px;
  background-color: white;
  border: 1px solid grey;
  border-radius: 0px 0px 5px 5px;
  box-shadow: 1px 1px 2px grey;
  z-index: 200;
  opacity: 0;
  transition: .5s opacity, .5s height;
  overflow: hidden;
}

.profil:hover > .slide {
  opacity: 1;
  height: 90px;
}
</style>