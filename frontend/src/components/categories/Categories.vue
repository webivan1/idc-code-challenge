<script setup lang="ts">
  import { ref, onMounted } from 'vue'
  import { CategorySummaryType } from '../../types/CategorySummaryType'
  import { http } from '../../api/http'

  const loading = ref<boolean>(false)
  const categories = ref<CategorySummaryType[]>([])

  const fetchSummary = async () => {
    loading.value = true
    const { data } = await http.get<CategorySummaryType[]>('http://localhost:8086/api/category/summary')
    categories.value = data
    loading.value = false
  }

  onMounted(async () => {
    await fetchSummary()
  })
</script>

<template>
  <div v-if="loading">
    Wait a moment...
  </div>

  <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
    <tr>
      <th class="px-6 py-3">Category</th>
      <th class="px-6 py-3">Todo count</th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="item of categories" :key="item.category.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
      <td class="px-6 py-4">
        <router-link :to="`/category/${item.category.slug}`" class="text-blue-500 underline">
          {{ item.category.title }}
        </router-link>
      </td>
      <td class="px-6 py-4 font-bold">
        {{ item.todoCount }}
      </td>
    </tr>
    </tbody>
  </table>
</template>