<script setup lang="ts">
import TodoList from '../components/todo/Todo.vue'

import { useStore } from '../store/useStore';

const { state } = useStore()
</script>

<template>
  <div class="flex min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md">
      <h2 class="mt-3 text-center text-3xl font-bold tracking-tight text-gray-900">
        Hello {{ state.user?.username }}
      </h2>

      <TodoList :token="state.user?.token" />
    </div>
  </div>  
</template>
