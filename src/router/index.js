import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/home.vue'

Vue.use(VueRouter)

  const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  }
  ,
  {
    path: '/opeka',
    name: 'opeka',
    component: () => import('../views/opeka.vue')
  },
  {
    path: '/ocenka',
    name: 'ocenka',
    component: () => import('../views/ocenka/ocenka.vue')
  },
  {
    path: '/ocenka-card',
    name: 'ocenka-card',
    component: () => import('../views/ocenka/ocenka-card.vue')
  },
  
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
