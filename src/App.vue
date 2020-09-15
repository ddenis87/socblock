<template>
  <div id="app">
    <component :is="content">
      <router-view />
    </component>
  </div>
</template>

<script>
import axios from 'axios';
import substrateMain from "@/substrate/substrate__main"

export default {
  computed: {
    content() {return substrateMain;}
  },
  components: {
    substrateMain
  },
  created: function() {
    let userInfo = {
      userName: ''
    }
    axios
      .post(pathBackEnd + 'php/index.php', null, {params: {function: 'getUserInfo'}})
      .then(response => {
        if (response.data.length != 0) {
          userInfo.userId = response.data[0].ID;
          userInfo.userIp = response.data[0].CIP;
          userInfo.userName = response.data[0].CNAME;
          this.$store.commit('setUserProfile', userInfo);
        } else {
          this.$store.commit('setUnknownUserProfile');
        }
      })
  }
}
// console.log(substrateMain);
</script>

<style lang="scss">
@import 'variables.scss';
@import 'fonts.scss';

html {
  overflow-y: scroll;
}
body {
  margin: 0;
}

#app {
  width: 100%;
  max-width: $pageWidthDefault;
  margin-left: auto;
  margin-right: auto;
}

h1, h2, h3 {
  font-family: 'Open sans';
  color: grey;
}

a {text-decoration: none;}

</style>