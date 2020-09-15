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
      if ('userIp' in userProfile) state.userProfile.userIp = userProfile.userIp;
      if ('userName' in userProfile) state.userProfile.userName = userProfile.userName;
      if ('accessOpfr' in userProfile) state.userProfile.accessOpfr = userProfile.accessOpfr;
    },
    // setUnknownUserProfile(state) {
    //   axios
    //     .post(pathBackEnd + 'php/index.php', null, {params: {function: 'getUserIp'}})
    //     .then(response => {
    //       let arrUserIp = response.data.split('.');
    //       if (arrUserIp[2] == '0' || arrUserIp[2] == '100') {
    //         state.userProfile.accessOpfr = true;
    //       }
    //     })
    // }
  },
  actions: {
  },
  modules: {
  }
})
