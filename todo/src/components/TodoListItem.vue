<template>
  <div v-if="!editMode" class="flex gap-3 justify-between p-5 border border-blue-500 rounded-md my-3">
    <div class="flex w-3/4">
      <input type="checkbox" v-model="isChecked"
        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 mx-4">

      <div class="w-3/4">
        <span :class="['block', strikeCompleted]"><strong>{{ todo.title }}</strong></span>
        <span class="block">{{ todo.description }}</span>
      </div>
    </div>

    <div class="w-1/4">

      <div class="info">
        <div class="font-bold">Labels: </div><span v-for="label in todo.labels" :key="label.id"
          :class="priorityLabelClass">{{ label.name }}</span>
        <hr class="boder-blue-500 my-3">
        <div class="font-bold">Priority: </div><span :class="priorityLabelClass">{{ todo.priority }}</span>
      </div>

      <div class="flex">
        <button @click="toggleEditTodo"
          class="py-3 px-5 text-sm font-medium text-center text-white rounded-lg bg-green-700 sm:w-fit hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 m-2">Edit</button>
        <button @click="removeTodo"
          class="py-3 px-5 text-sm font-medium text-center text-white rounded-lg bg-red-700 sm:w-fit hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 m-2">Delete</button>


      </div>
    </div>

  </div>

  <div v-else>
    <TodoForm @updatedTodo="handleUpdatedTodo" :todo="todo" :isEditMode="true" />
  </div>
</template>

<script setup>
import { computed } from 'vue';
import TodoForm from './TodoForm.vue';

const props = defineProps({
  todo: {
    type: Object,
    required: true
  },
})

const emit = defineEmits(['toggleTodo', 'toggleEditTodo', 'updatedTodo', 'removeTodo'])

const isChecked = computed({
  get: () => props.todo.isChecked,
  set: (value) => {
    emit('toggleTodo', {
      value: value,
      id: props.todo.id
    })
  }
})

const strikeCompleted = computed(() => {
  return props.todo.status === 'completed' ? 'line-through' : ''
})

const priorityLabelClassesMap = {
  high: [
    'bg-red-100',
    'text-red-800',
    'text-xs',
    'font-medium',
    'me-2',
    'px-2.5',
    'py-0.5',
    'rounded',
    'dark:bg-red-900',
    'dark:text-red-300'
  ],
  medium: [
    'bg-blue-100',
    'text-blue-800',
    'text-xs',
    'font-medium',
    'me-2',
    'px-2.5',
    'py-0.5',
    'rounded',
    'dark:bg-blue-900',
    'dark:text-blue-300'
  ],
  low: [
    'bg-green-100',
    'text-green-800',
    'text-xs',
    'font-medium',
    'me-2',
    'px-2.5',
    'py-0.5',
    'rounded',
    'dark:bg-green-900',
    'dark:text-green-300'
  ],
  default: [
    'bg-purple-100',
    'text-purple-800',
    'text-xs',
    'font-medium',
    'me-2',
    'px-2.5',
    'py-0.5',
    'rounded',
    'dark:bg-purple-900',
    'dark:text-purple-300'
  ]
};

const priorityLabelClass = computed(() => {
  return priorityLabelClassesMap[props.todo.priority] || priorityLabelClassesMap.default;
});

const editMode = computed(() => props.todo.editMode)

const toggleEditTodo = () => {
  emit('toggleEditTodo', props.todo.id)
}

const handleUpdatedTodo = (updatedTodo) => {
  emit('updatedTodo', updatedTodo)
}

const removeTodo = () => {
  emit('removeTodo', props.todo.id)
}
</script>

<style scoped></style>