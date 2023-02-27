<script lang="ts">
import { ref, onMounted, computed, watch } from 'vue'
import { useStore } from '../../store/useStore';
import { http } from '../../api/http';
import { Input, Button } from 'flowbite-vue'

export default {
  props: {
    token: {
      type: String
    },
    category: {
      type: Object,
      default: () => null,
    }
  },
  components: { Input, Button },
  setup({ token, category }: { token: string, category: any|null }) {
    const { state, actions } = useStore()
    const isShowTodoForm = ref<boolean>(false)
    const search = ref<string>('')
    const baseUrl = 'http://localhost:8086/api/todo'

    const headers =  { Authorization: 'Bearer ' + token }

    const canAddTodo = computed(() => search.value.trim().length > 0 && category !== null)

    let fetchTodoList = (search?: string) => {
      const url = `${baseUrl}${category ? `/category/${category.id}` : ''}?search=${search ? search : ''}`

      http.get<any>(url, { headers: headers }).then(response => {
        actions.setTodoList(response.data.todoList)
      })
    }

    // @todo it does not work
    let addTodo = (title: any) => {
      http.put<any>(baseUrl + '/category/' + category?.id, { title: title }, { headers: headers }).then(response => {
        actions.addTodo(response.data.todo)
        search.value = ''
      })
    }

    // @todo it does not work
    let changeTodo = (id: any, isDone: boolean) => {
      http.post<any>(baseUrl + '/' + id, { isDone: isDone }, { headers: headers }).then(response => {
        for (var i = 0; i < state.todoList.length; i++) {
          const item = state.todoList[i]
          if(item.id == id) {
            state.todoList[i] = response.data.todo
          }
        }
        // @ts-ignore
        actions.setTodoList(Array.isArray(state.todoList) ? [...state.todoList] : {...state.todoList})
      })
    }

    let removeTodo = (id: any) => {
      http.delete<any>(baseUrl + '/' + id, { headers: headers }).then(response => {
        for (var i = 0; i < state.todoList.length; i++) {
          const item = state.todoList[i]
          if(item.id == id) {
            state.todoList.splice(i, 1)
          }
        }
        // @ts-ignore
        actions.setTodoList(Array.isArray(state.todoList) ? [...state.todoList] : {...state.todoList})
      })
    }

    let showTodoForm = () => {
      isShowTodoForm.value = isShowTodoForm.value == true ? false : isShowTodoForm.value
    }

    onMounted(function() {
      fetchTodoList()
    })

    // @todo is something wrong?
    watch(search, (search) => {
      if (search.trim().length > 0)
      {
        fetchTodoList(search)
      }
      else
      {
        fetchTodoList()
      }
    })

    return {
      category: category,
      todoList: computed(() => state.todoList),
      search: search,
      addTodo: addTodo,
      canAddTodo: canAddTodo,
      changeTodo: changeTodo,
      removeTodo: removeTodo,
    }
  },
};
</script>

<template>
  <div 
    class="min-h-full py-12 px-4">
    <div class="w-full max-w-md mb-5">
      <form class="mt-2 space-y-1 flex flex-row items-center" action="#" method="POST">
        <Input v-model="search" placeholder="Search..." class="flex-auto mr-1" />
        <Button v-if="category" :disabled="!canAddTodo" class="w-auto m-0" type="button" @click="addTodo(search)">Add</Button>
      </form>
    </div>

    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
      <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
          <th class="px-6 py-3">ID</th>
          <th class="px-6 py-3">Category</th>
          <th class="px-6 py-3">Title</th>
          <th class="px-6 py-3">Status</th>
          <th class="px-6 py-3" colspan="2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item of todoList" :key="item.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
          <td class="px-6 py-4">{{ item.id }}</td>
          <td class="px-6 py-4">{{ item.category.title }}</td>
          <td class="px-6 py-4">{{ item.title }}</td>
          <td class="px-6 py-4">{{ item.isDone ? 'Done' : 'In progress' }}</td>
          <td class="px-6 py-4">
            <Button v-if="!item.isDone" size="sm" color="green" class="mr-2" @click="changeTodo(item.id, true)">
              Done
            </Button>
          </td>
          <td class="px-6 py-4">
            <Button size="sm" color="red" @click="removeTodo(item.id)">
              Remove
            </Button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
