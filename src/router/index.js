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
    path: '/office-work',
    name: 'office-work',
    component: () => import('../views/office-work/office-work.vue')
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
  {
    path: '/ocenka-report',
    name: 'ocenka-report',
    component: () => import('../views/ocenka/ocenka-report.vue')
  },
  {
    path: '/ocenka-admin',
    name: 'ocenka-admin',
    component: () => import('../views/ocenka/ocenka-admin.vue')
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
