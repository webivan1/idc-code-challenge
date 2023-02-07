<script lang="ts">
import { ref, onMounted, computed } from 'vue'
import { useStore } from '../../store/useStore';
import { http } from '../../api/http';
import { Input, Button } from 'flowbite-vue'

export default {
  props: {
    token: {
      type: String
    }
  },
  components: { Input, Button },
  setup({ token }) {
    const { state, actions } = useStore()
    const isShowTodoForm = ref<boolean>(false)
    const search = ref<string>('')

    const headers =  { Authorization: 'Bearer ' + token }

    const todoList = computed(function () {
      let newList: any[] = []

      if (search.value.trim().length > 0) {
        for (var i = 0; i < state.todoList.length; i++) {
          if (state.todoList[i].title.indexOf(search.value) > -1) {
            newList.push(state.todoList[i])
          }
        }
      } else {
        newList = state.todoList
      }
      
      return newList
    })

    const canAddTodo = computed(() => todoList.value.length === 0)

    onMounted(function() {
      http.get<any>('http://localhost:8086/api/todo', { headers: headers }).then(response => {
        actions.setTodoList(response.data.todoList)
      })
    })

    let addTodo = (title: any) => {
      http.put<any>('http://localhost:8086/api/todo', { title: title }, { headers: headers }).then(response => {
        actions.addTodo(response.data.todo)
        search.value = ''
      })
    }

    let changeTodo = (id: any, isDone: boolean) => {
      http.post<any>('http://localhost:8086/api/todo/' + id, { isDone: isDone }, { headers: headers }).then(response => {
        for (var i = 0; i <= state.todoList.length; i++) {
          const item = state.todoList[i]
          if(item.id == id) {
            state.todoList[i] = response.data.todo
          }
        }
        actions.setTodoList(state.todoList.concat())
      })
    }

    let removeTodo = (id: any) => {
      http.delete<any>('http://localhost:8086/api/todo/' + id, { headers: headers }).then(response => {
        for (var i = 0; i < state.todoList.length; i++) {
          const item = state.todoList[i]
          if(item.id == id) {
            state.todoList.splice(i, 1)
          }
        }
        actions.setTodoList(state.todoList.concat())
      })
    }

    let showTodoForm = () => {
      isShowTodoForm.value = isShowTodoForm.value == true ? false : isShowTodoForm.value
    }

    return {
      todoList: todoList,
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
    class="min-h-full py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md mb-5">
      <form class="mt-2 space-y-1 flex flex-row items-center" action="#" method="POST">
        <Input v-model="search" placeholder="Search..." class="flex-auto mr-1" />
        <Button :disabled="!canAddTodo" class="w-auto m-0" type="button" @click="addTodo(search)">Add</Button>
      </form>
    </div>

    <div v-for="item of todoList" :key="item.id" class="flex flex-row mb-3">
      <div class="flex-auto shadow-md border-gray-600 p-3 mr-2" :class="{ 'line-through': item.isDone }">
        {{ item.title }}
      </div>
      <Button v-if="!item.isDone" size="sm" color="dark" class="mr-2" @click="changeTodo(item.id, true)">
        Done?
      </Button>
      <Button size="sm" color="red" @click="removeTodo(item.id)">
        Remove
      </Button>
    </div>
  </div>
</template>
