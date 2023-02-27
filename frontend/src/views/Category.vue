<script setup lang="ts">
import TodoList from '../components/todo/Todo.vue'
import { useRoute } from 'vue-router'
import { useStore } from '../store/useStore';
import { watch, ref, onMounted } from 'vue'
import Heading from '../components/shared/ui/Heading.vue'

const { state } = useStore()
const { params } = useRoute()
const loading = ref<boolean>(false)
const category = ref<any>(null)

const fetchCategory = async (slug: string): Promise<void> => {
  loading.value = true
  const response  = await fetch('http://127.0.0.1:8086/api/category/' + slug)
  category.value = await response.json()
  loading.value = false
}

watch(() => params?.category, async (slug) => {
  category.value = null

  if (typeof slug !== 'string') {
    return
  }

  await fetchCategory(slug)
})

onMounted(async () => {
  await fetchCategory(params?.category as string)
})
</script>

<template>
  <Heading>
    Category | {{ category?.title }}
    <template #subheading>
      <div class="text-blue-500 underline mt-3">
        <router-link to="/">
          Go to category list
        </router-link>
      </div>
    </template>
  </Heading>

  <TodoList v-if="category" :category="category" :token="state.user?.token" />
</template>
