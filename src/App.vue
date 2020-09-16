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
  components: {
    substrateMain
  },  
  computed: {
    content() {return substrateMain;}
  },

  created: function() {
    let userInfo = {
      userName: ''
    }
    axios
        .post(pathBackEnd + 'php/index.php', null, {params: {function: 'getUserIp'}})
        .then(response => {
          let arrUserIp = response.data.split('.');
          userInfo.userIp = response.data;
          if (arrUserIp[2] == '0' || arrUserIp[2] == '100') {
            userInfo.userName = "Пользователь ОПФР";
            userInfo.accessOpfr = true;
          } else {
            userInfo.userName = "Пользователь УПФР";
          }
          this.$store.commit('setUserProfile', userInfo);
        })
  }
}

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