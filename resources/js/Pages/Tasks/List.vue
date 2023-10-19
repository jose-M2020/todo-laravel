<script setup>
  import { onMounted, ref, toRefs, watch } from 'vue';
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import { Head } from '@inertiajs/vue3';

  import CreateTaskForm from './Partials/CreateTaskForm.vue';
  import CreateStepForm from './Partials/CreateStepForm.vue';
  import ShareTask from './Partials/ShareTask.vue';

  import { getStatus } from '@/Helpers/getStatus';

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
  const currentTask = ref(null);
  const currentType = ref('personal');
  
  const types = {
    personal: tasks,
    shared: sharedTasks
  }

  currentTasks.value = types[currentType.value].value;
  
  watch(
    () => currentType.value,
    () => {
      currentTasks.value = types[currentType.value].value;
      console.log('change')
    }
  )

  // Step Form Modal

  const isOpenStepModal = ref(false);
  
  const openStepModal = (task) => {
    currentTask.value = task;
    isOpenStepModal.value = true;
  }

  const closeStepModal = () => {
    isOpenStepModal.value = false;
    // stepForm.reset();
  }

  // Share Form Modal

  const isOpenShareModal = ref(false);
  
  const openShareModal = (task) => {
    currentTask.value = task;
    isOpenShareModal.value = true;
  }

  const closeShareModal = () => {
    isOpenShareModal.value = false;
    // stepForm.reset();
  }
  
</script>

<template>
  <Head title="Todo" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tasks</h2>
    </template>
    <div class="p-4 md:p-6 lg:p-8">
      <div class="grid grid-cols-3 gap-6">
        <CreateTaskForm :todo-id="todoId" />
        <div class="col-span-2">
          <div class="flex justify-between items-center gap-3">
            <h3 class="mb-5 font-semibold text-lg text-gray-800 leading-tight">Task List</h3>
            <div class="bg-white">
              <nav class="flex flex-col sm:flex-row">
                <button
                  @click="currentType = 'personal'"
                  class="text-gray-600 py-4 px-6 block hover:text-blue-500 focus:outline-none"
                  :class="currentType === 'personal' && 'text-blue-500 border-b-2 font-medium border-blue-500'"
                >
                    Personal
                </button>
                <button
                  @click="currentType = 'shared'"
                  class="text-gray-600 py-4 px-6 block hover:text-blue-500 focus:outline-none"
                  :class="currentType === 'shared' && 'text-blue-500 border-b-2 font-medium border-blue-500'"
                >
                    Shared
                </button>
              </nav>
            </div>
          </div>
          <div
            v-if="currentTasks.length"
            class="grid grid-cols-1 gap-4"
          >
            <!-- TASKS -->
            <div
              v-for="{id, name, description, status, steps} in currentTasks" :key="id"
            >
              <div class="p-5 bg-white shadow-lg rounded-lg">
                <div class="pb-4 mb-4 border-b-2 border-gray-300 flex flex-col gap-2">
                  <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                      <p>{{ name }}</p>
                      <span class="shadow-md p-1" :class="getStatus(status).tailwindClass">{{ getStatus(status).name }}</span>
                    </div>
                    <div
                      v-if="currentType === 'personal'"
                      class="flex justify-center items-center gap-2"
                    >
                      <span
                        @click="() => { openShareModal({id, name}) }"
                        class="rounded-full w-8 h-8 p-1 shadow-lg flex justify-center items-center hover:cursor-pointer hover:bg-gray-200 duration-200"
                      >
                        <i class="fa-solid fa-share-nodes"></i>
                      </span>
                      <span
                        @click="openStepModal({id, name})"
                        class="rounded-full w-8 h-8 p-1 shadow-lg flex justify-center items-center hover:cursor-pointer hover:bg-gray-200 duration-200"
                      >
                        <i class="fa-solid fa-plus"></i>
                      </span>
                    </div>
                  </div>
                  <p>{{ description }}</p>
                </div>
                <!-- STEPS -->
                <div>
                  <!-- LIST -->
                  <template v-if="steps.length">
                    <div v-for="{id, name, description, status} in steps" :key="id">
                      <div class="p-5 shadow-lg rounded-lg flex flex-col gap-2">
                        <div class="flex justify-between items-center">
                          <p>{{ name }}</p>
                          <span :class="getStatus(status).tailwindClass">{{ getStatus(status).name }}</span>
                        </div>
                        <p>{{ description }}</p>
                      </div>
                    </div>
                  </template>
                </div>
              </div>
            </div>
          </div>
          <div v-else>
            <p>There's no tasks</p>
          </div>
        </div>
      </div>
    </div>

    <CreateStepForm
      :show="isOpenStepModal"
      :close="closeStepModal"
      :taskInfo="currentTask"/>
    <ShareTask
      :show="isOpenShareModal"
      :close="closeShareModal"
      :taskInfo="currentTask"/>
  </AuthenticatedLayout>
</template>

<style>

</style>