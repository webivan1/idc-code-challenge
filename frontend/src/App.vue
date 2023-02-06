<script setup lang="ts">
  import { useRouter } from 'vue-router';
import { useStore } from './store/useStore'

  const { state, actions } = useStore();
  const router = useRouter()

  const logout = () => {
    actions.logout()
    router.push('/login');
  }
</script>

<template>
  <h1 v-if="state.user" class="text-3xl pt-2 font-bold text-center">
    <a class="text-red-500 cursor-pointer hover:underline" @click="logout">Logout</a>
  </h1>


  <router-view />
</template>
