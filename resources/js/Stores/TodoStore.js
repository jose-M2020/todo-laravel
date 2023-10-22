import { defineStore } from 'pinia'

export const useTodoStore = defineStore('TodoStore', {
  state: () => ({
    currentTodo: {},
    
  }),
  getters: {
    id: (state) => state.currentTodo?.id,
  },
  actions: {
    setCurrentTodo(currentTodo) {
      this.currentTodo = currentTodo
    },
  },
  persist: true,
})