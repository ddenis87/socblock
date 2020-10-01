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
  data: function() {
    return {
      userIp: '',
    }
  },
  created: function() {
    let userInfo = {
      userName: ''
    }
    axios
        .post(pathBackEnd + 'php/index.php', null, {params: {function: 'getUserIp'}})
        .then(response => {
          this.userIp = response.data;
          let arrUserIp = response.data.split('.');
          userInfo.userIp = response.data;
          if (arrUserIp[2] == '0' || arrUserIp[2] == '100' || arrUserIp[2] == '99') {
            userInfo.userName = "Пользователь ОПФР";
            userInfo.accessOpfr = true;
          } else {
            userInfo.userName = "Пользователь УПФР";
          }
          this.$store.commit('setUserProfile', userInfo);
          this.getAccessOzi();
        })
        .catch(() => console.log("Failed to connect server"))
  },
  methods: {
    getAccessOzi: function() {
      let userInfo = {};
      axios
        .post(pathBackEnd + 'php/index.php', null, {params: {function: 'getUserOzi'}})
        .then(response => {
          if (response.data.length != 0) {
            userInfo.userId = response.data[0].ID;
            userInfo.userIp = response.data[0].CIP;
            userInfo.userName = response.data[0].CNAME;
            userInfo.accessOzi = true;
            userInfo.accessLevel = response.data[0].CACCESSLEVEL;

            this.$store.commit('setUserProfileOzi', userInfo);
          }
        })
    }
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