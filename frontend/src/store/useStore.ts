import { reactive } from 'vue'

type StoreType = {
  user?: {
    username: string
    token: string
  },
  todoList: Array<{
    id: string|number
    title: string
    isDone: boolean
  }>
};

type ActionType<T = unknown> = (store: StoreType, payload?: T) => void

const setUserAction: ActionType<{ username: string; token: string }> = (store: StoreType, user) => {
  store.user = user
}

const logoutAction: ActionType = (store: StoreType) => {
  store.user = undefined
}

const setTodoListAction: ActionType<StoreType['todoList']> = (store: StoreType, todoList?: StoreType['todoList']) => {
  // @ts-ignore
  store.todoList = todoList
}

// @ts-ignore
const addTodoAction: ActionType<{
  id: string|number
  title: string
  isDone: boolean
}> = (store: StoreType, todo: {
  id: string|number
  title: string
  isDone: boolean
}) => {
  store.todoList.push(todo)
}

const store = reactive<StoreType>({
  user: undefined,
  todoList: []
})

export function useStore() {
  return {
    state: store,
    actions: {
      setUser: (user: any) => setUserAction(store, user),
      logout: () => logoutAction(store),
      setTodoList: (todoList: StoreType['todoList']) => setTodoListAction(store, todoList),
      addTodo: (todo: any) => addTodoAction(store, todo)
    }
  }
}
