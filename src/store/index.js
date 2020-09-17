import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios';

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
  //   userProfile: {
  //     userId: '',
  //     userIp: '',
  //     userName: 'Гость',
  //     accessOpfr: false,
  //     accessResource: {
  //       ocenka: {
  //         access: false,
  //         administrator: false
  //       }
  //     }
  //   }
    userProfile: {
      userId: '',
      userIp: '',
      userName: 'Гость',
      accessOpfr: true,
      accessResource: {
        ocenka: {
          access: true,
          administrator: true
        }
      }
    }
  },
  mutations: {
    setUserProfile(state, userProfile) {
      if ('userId' in userProfile) state.userProfile.userId = userProfile.userId;
      if ('userIp' in userProfile) state.userProfile.userIp = userProfile.userIp;
      if ('userName' in userProfile) state.userProfile.userName = userProfile.userName;
      if ('accessOpfr' in userProfile) state.userProfile.accessOpfr = userProfile.accessOpfr;

      // access into Resource
      if ('accessResource' in userProfile) {

        if ('ocenka' in userProfile.accessResource) {
          let ocenka = userProfile.accessResource.ocenka;
          state.userProfile.accessResource.ocenka.access = ocenka.access;
          if ('administrator' in ocenka) state.userProfile.accessResource.ocenka.administrator = ocenka.administrator;
        }
      }
    },
  },
  actions: {
  },
  modules: {
  }
})
