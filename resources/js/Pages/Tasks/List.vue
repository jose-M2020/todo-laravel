<script setup>
import { ref, toRefs, watch } from 'vue';
import { Head } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TaskForm from './Partials/TaskForm.vue';
import TaskList from './Partials/TaskList.vue';

const props = defineProps({
  todoId: {
    type: Number,
    required: true,
  },
  tasks: {
    type: Array,
    required: true,
  },
  sharedTasks: {
    type: Array,
    default: []
  }
})

const { tasks, sharedTasks } = toRefs(props);
const currentTasks = ref([]);
const currentTaskType = ref('personal');

const isOpenTaskModal = ref(false);

const types = {
  personal: tasks,
  shared: sharedTasks
}

watch(
  () => props.tasks,
  () => { 
    currentTasks.value = types[currentTaskType.value].value
    isOpenTaskModal.value = false;
  },
  { immediate: true }
);

watch(
  () => currentTaskType.value,
  () => {
    currentTasks.value = types[currentTaskType.value].value;
  }
)

const setTaskType = type => {
  currentTaskType.value = type;
  // currentSteps.value = [];
}

// Task Form Modal

const toggleTaskModal = () => isOpenTaskModal.value = !isOpenTaskModal.value;

</script>

<template>
  <Head title="Tasks" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tasks</h2>
    </template>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center gap-3">
        <PrimaryButton @click="toggleTaskModal" >
          create task
        </PrimaryButton>
        <div class="bg-white">
          <nav class="flex flex-col sm:flex-row">
            <button
              @click="setTaskType('personal')"
              class="text-gray-600 py-4 px-6 block hover:text-blue-500 focus:outline-none"
              :class="currentTaskType === 'personal' && 'text-blue-500 border-b-2 font-medium border-blue-500'"
            >
                Personal
            </button>
            <button
              @click="setTaskType('shared')"
              class="text-gray-600 py-4 px-6 block hover:text-blue-500 focus:outline-none"
              :class="currentTaskType === 'shared' && 'text-blue-500 border-b-2 font-medium border-blue-500'"
            >
                Shared
            </button>
          </nav>
        </div>
      </div>
      
      <TaskList
        :tasks="currentTasks"
        :currentType="currentTaskType"
        :todoId="todoId"
      />

      <!-- TASK FORM -->
      <div
        v-if="currentTasks.length === 0 && currentTaskType === 'personal'"
        class="flex justify-center items-center gap-7"
      >
          <div>
              <img
                class="max-w-sm"
                src="../../../images/ui-task.png"
                alt="Todo list" />
          </div>
          <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <h3 class="text-xl font-bold text-center mb-6">Create new task</h3>
            <TaskForm action="store" />
          </div>
      </div>
      <template v-else>
        <Modal
          :show="isOpenTaskModal"
          @close="toggleTaskModal"
        >
          <h3 class="text-xl font-bold text-center mb-6">Create new task</h3>
          <TaskForm action="store" />
        </Modal>
      </template>
    </div>
  </AuthenticatedLayout>
</template>

<style>

</style>
