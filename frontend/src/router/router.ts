import { createRouter, createWebHistory } from 'vue-router'
import Login from '../views/Login.vue'
import Category from '../views/Category.vue'
import CategoryList from '../views/CategoryList.vue'
import NotFound from '../views/NotFound.vue'

const routes = [
  { path: '/', component: CategoryList }, // @todo user must be authorised
  { path: '/category/:category', component: Category }, // @todo user must be authorised
  { path: '/login', component: Login },
  { path: '/:pathMatch(.*)*', component: NotFound }
]

export const router = createRouter({
  history: createWebHistory(),
  routes,
})
