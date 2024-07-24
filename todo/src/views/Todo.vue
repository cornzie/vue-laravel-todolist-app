<template>
  <div class="container m-auto">
    <div class="my-10 flex items-center justify-center">
      <h1 class="text-center font-bold text-3xl">{{ user }}'s Todo List</h1>
    </div>

    <div class="container flex items-center justify-center flex-col">
      <div class="container p-5">
        <TodoForm @newTodo="handleNewTodo" />
      </div>
      <div class="container">

        <TodoListItem v-for="todo in pendingTodoList" :todo="todo" :key="todo.id" @toggleTodo="handleToggleTodo"
          @toggleEditTodo="handleToggleEditTodo" @updatedTodo="handleUpdatedTodo" @removeTodo="handleRemoveTodo" />

      </div>
    </div>

    <div class="bg-green-100 p-8 rounded-md">
      <h1 class="font-bold text-2xl">Completed Todo: {{ completedTodoList.length }}</h1>
      <TodoListItem v-for="todo in completedTodoList" :todo="todo" :key="todo.id" @toggleTodo="handleToggleTodo"
        @toggleEditTodo="handleToggleEditTodo" @updatedTodo="handleUpdatedTodo" @removeTodo="handleRemoveTodo" />
    </div>

  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useStore } from 'vuex';
import TodoForm from '../components/TodoForm.vue';
import TodoListItem from '../components/TodoListItem.vue';

const store = useStore()

onMounted(() => {
  store.dispatch('todoList/fetchTodos')
})

const user = computed(() => store.getters['auth/user']?.name || 'Guest')

const todoList = computed(() => store.getters['todoList/todoList'])

const pendingTodoList = computed(() => store.getters['todoList/todoList']?.filter(todo => todo.status !== 'completed'))


const completedTodoList = computed(() => todoList.value.filter(todo => todo.status === 'completed'))

const createTodo = async (newTodo) => {
  const addedTodo = await store.dispatch('todoList/createTodo', newTodo)

  if (addedTodo) {
   store.dispatch('notification/addMessage', {
    id: Date.now(),
    type: 'success',
    text: 'Todo item added successfully!',
   })
  } else {
    store.dispatch('notification/addMessage', {
      id: Date.now(),
      type: 'error',
      text: store.getters['todoList/createTodoErrorMsg'],
    })
  }
}
const handleNewTodo = (newTodo) => {
  todoList.value.unshift(newTodo)
  createTodo(newTodo)
}

const handleToggleTodo = ({ value, id }) => {
  const todo = findTodo(id)
  todo.isChecked = value
}

const handleToggleEditTodo = (id) => {
  const todo = findTodo(id)
  todo.editMode = !todo.editMode
}

const findTodo = (id) => todoList.value.find(todo => todo.id === id)

const handleUpdatedTodo = async (updatedTodo) => {

  const updatedTodoItem = await store.dispatch('todoList/updateTodo', {todoId: updatedTodo.id, data: updatedTodo})
  
  if (updatedTodoItem) {
  store.dispatch('notification/addMessage', {
    id: Date.now(),
    type: 'success',
    text: 'Todo item updated successfully!',
  })
  } else {
    store.dispatch('notification/addMessage', {
      id: Date.now(),
      type: 'error',
      text: store.getters['todoList/updateTodoErrorMsg'],
    })
  }
  store.dispatch('todoList/fetchTodos')
}

const handleRemoveTodo = (id) => {
  todoList.value = todoList.value.filter(todo => todo.id !== id)
}



</script>

<style></style>