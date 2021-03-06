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
      accessOzi: false,
      accessLevel: 0,
      accessResource: {
        ocenka: {
          access: false,
          administrator: false,
          guest: false
        }
      }
    }
    // userProfile: {
    //   userId: '',
    //   userIp: '',
    //   userName: 'Гость',
    //   accessOpfr: true,
    //   accessResource: {
    //     ocenka: {
    //       access: true,
    //       administrator: true
    //     }
    //   }
    // }
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
          if ('guest' in ocenka) state.userProfile.accessResource.ocenka.guest = ocenka.guest;
        }
      }
    },
    setUserProfileOzi(state, userProfile) {
      if ('userId' in userProfile) state.userProfile.userId = userProfile.userId;
      if ('userIp' in userProfile) state.userProfile.userIp = userProfile.userIp;
      if ('userName' in userProfile) state.userProfile.userName = userProfile.userName;
      if ('accessOzi' in userProfile) state.userProfile.accessOzi = userProfile.accessOzi;
      if ('accessLevel' in userProfile) state.userProfile.accessLevel = userProfile.accessLevel;
    }
  },
  actions: {
  },
  modules: {
  }
})
