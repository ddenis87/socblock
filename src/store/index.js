import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios';

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    userProfile: {
      userId: '',
      userIp: '',
      userName: 'Гость',
      accessOpfr: false,
    }
  },
  mutations: {
    setUserProfile(state, userProfile) {
      if ('userId' in userProfile) state.userProfile.userId = userProfile.userId;
      if ('userIp' in userProfile) state.userProfile.userIp = userProfile.userIp;
      if ('userName' in userProfile) state.userProfile.userName = userProfile.userName;
      let arrUserIp = userProfile.userIp.split('.');
        if (arrUserIp[2] == '0' || arrUserIp[2] == '100') {
          state.userProfile.accessOpfr = true;
        }
    },
    setUnknownUserProfile(state) {
      axios
        .post(pathBackEnd + 'php/index.php', null, {params: {function: 'getUserIp'}})
        .then(response => {
          let arrUserIp = response.data.split('.');
          if (arrUserIp[2] == '0' || arrUserIp[2] == '100') {
            state.userProfile.accessOpfr = true;
          }
        })
    }
  },
  actions: {
  },
  modules: {
  }
})
