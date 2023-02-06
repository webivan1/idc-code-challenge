import { createRouter, createWebHistory } from 'vue-router'
import Login from '../views/Login.vue'
import Todo from '../views/Todo.vue'
import NotFound from '../views/NotFound.vue'

const routes = [
  { path: '/', component: Todo },
  { path: '/login', component: Login },
  { path: '/:pathMatch(.*)*', component: NotFound }
]

export const router = createRouter({
  history: createWebHistory(),
  routes,
})
