<template>
    <form @submit.prevent="submit">
        <div class="my-3">
            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Title</label>
            <input type="text" id="title"
                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                placeholder="What's on your mind?" v-model="title" required>
        </div>
        <div class="my-3">
            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Short
                description</label>
            <textarea type="text" id="description"
                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                placeholder="Optional: describe the task briefly..." v-model="description"></textarea>
        </div>
        <div v-if="isEditMode">
            <div class="my-3">
                <label for="priority" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Set
                    priority</label>
                <select id="priority"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    v-model="priority">
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                    <option value="urgent">Urgent!</option>
                </select>
            </div>
            <div class="my-3">
                <label for="labels"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Labels</label>
                <input type="text" id="labels"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                    v-model="labels" required>
            </div>
        </div>
        <div class="my-3">
            <button
                class="py-3 px-5 text-sm font-medium text-center text-white rounded-lg bg-blue-700 sm:w-fit hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                type="submit">{{ isEditMode ? 'Save' : 'Add Todo' }}</button>
        </div>
    </form>
</template>

<script setup>
import { ref, defineEmits, onMounted, watch } from 'vue'

const emit = defineEmits(['newTodo', 'updatedTodo'])

const props = defineProps({
    todo: {
        type: Object,
        default: () => ({})
    },
    isEditMode: {
        type: Boolean,
        default: false
    }
})

// Reactive properties
const title = ref("")
const description = ref("")
const priority = ref("")  // Reactive priority
const labels = ref("")    // Reactive labels

// Watch for prop changes and initialize
onMounted(() => {
    if (props.isEditMode) {
        title.value = props.todo.title
        description.value = props.todo.description
        priority.value = props.todo.priority || ""  // Set priority
        labels.value = props.todo.labels.map(label => label.name).join(',') || ""  // Set labels
    }
})

// Watch for priority and labels changes and update props.todo
watch(() => props.todo, (newTodo) => {
    if (props.isEditMode) {
        title.value = newTodo.title
        description.value = newTodo.description
        priority.value = newTodo.priority || ""  // Update priority
        labels.value = newTodo.labels.map(label => label.name).join(',') || ""  // Update labels
    }
}, { deep: true })

const submit = () => {
    if (props.isEditMode) {
        emitUpdatedTodo()
        return
    }
    emitNewTodo()
}

const emitNewTodo = () => {
    emit('newTodo', {
        id: Date.now(),
        title: title.value,
        description: description.value,
        priority: priority.value,
        labels: labels.value.split(',').map(item => item.trim()),
        isChecked: false,
        editMode: false
    })

    title.value = ""
    description.value = ""
    priority.value = ""
    labels.value = ""
}

const emitUpdatedTodo = () => {
    emit('updatedTodo', {
        id: props.todo.id,
        title: title.value,
        description: description.value,
        priority: priority.value,
        labels: labels.value.split(',').map(item => item.trim()),
        isChecked: props.todo.isChecked,
        editMode: false
    })
}
</script>

<style scoped></style>