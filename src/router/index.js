import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/home.vue'

Vue.use(VueRouter)

  const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/fss',
    name: 'fss',
    component: () => import('../views/fss.vue')
  },
  {
    path: '/foms',
    name: 'foms',
    component: () => import('../views/foms.vue')
  },
  {
    path: '/fssp',
    name: 'fssp',
    component: () => import('../views/fssp.vue')
  },
  {
    path: '/czn',
    name: 'czn',
    component: () => import('../views/czn.vue')
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
