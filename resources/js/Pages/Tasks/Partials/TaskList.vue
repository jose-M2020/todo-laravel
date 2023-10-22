<script setup>
import { ref, watch } from 'vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import Dropdown from '@/Components/Dropdown.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Modal from '@/Components/Modal.vue';
import DeleteModal from '@/Components/DeleteModal.vue';

import StepList from './StepList.vue';
import ShareTask from './ShareTask.vue';
import StepForm from './StepForm.vue';
import TaskForm from './TaskForm.vue';
import { getStatus } from '@/Helpers/getStatus';

const props = defineProps({
  tasks: {
    type: Array
  },
  currentType: {
    type: String,
    required: true
  },
  todoId: {
    type: Number,
    required: true
  },
});

const selectedTask = ref({});
const currentSteps = ref([]);
const clickedTask = ref({});

const setSteps = () => {
  currentSteps.value = props.tasks.find(task => (
    task.id === selectedTask.value.id
  ))?.steps;
}

watch(
  () => [props.tasks, selectedTask.value],
  () => {
    if(Object.keys( selectedTask.value ).length) {
      setSteps();
    }
  }
);

const selectTask = task => selectedTask.value = task;

// Step Form Modal

const isOpenStepModal = ref(false);

const openStepModal = (task) => {
  clickedTask.value = task;
  isOpenStepModal.value = true;
}

const closeStepModal = () => {
  isOpenStepModal.value = false;
  // stepForm.reset();
}

// Share Form Modal

const isOpenShareModal = ref(false);

const openShareModal = (task) => {
  clickedTask.value = task;
  isOpenShareModal.value = true;
}

const closeShareModal = () => {
  isOpenShareModal.value = false;
  // stepForm.reset();
}

// Delete Task Modal
const isOpenTaskDeleteModal = ref(false);
const toggleTaskDeleteModal = (task = {}) => {
  clickedTask.value = task;
  isOpenTaskDeleteModal.value = !isOpenTaskDeleteModal.value
};

// Edit Task Modal

const isOpenEditModal = ref(false);
const toggleEditModal = (task = {}) => {
  clickedTask.value = task;
  isOpenEditModal.value = !isOpenEditModal.value
};

</script>

<template>
  <template v-if="tasks?.length">
    <div
      class="grid grid-cols-2 gap-4"
    >
      <!-- TASKS -->
      <div class="flex flex-col gap-4">
        <div
          v-for="{id, name, description, status, shared_users} in tasks"
          :key="id"
          class="flex items-center"
        >
          <div
            class="flex-grow p-5 bg-white shadow-lg rounded-lg"
            :class="{ 'bg-cyan-800/10': selectedTask.id === id }"  
          >
            <div class="pb-4 mb-4 border-b-2 border-gray-200 flex flex-col gap-2">
              <!-- HEADER -->
              <div class="flex justify-between items-center">
                <div class="flex items-center gap-2">
                  <p>{{ name }}</p>
                  <span
                    class="p-[7px] rounded-lg text-sm bg-indigo-100 text-indigo-700"
                  >
                    {{ getStatus(status).name }}
                  </span>
                </div>
  
                <div
                  v-if="currentType === 'personal'"
                  class="flex justify-center items-center gap-2"
                >
                  <div class="flex items-center">
                    <span>{{ shared_users?.length }}</span>
                    <span
                      class="rounded-full p-1 shadow-lg flex justify-center items-center"
                    >
                      <i class="fa-solid fa-user"></i>
                    </span>
                  </div>
                  
                  <!-- Dropdown OPTIONS -->
                  <div class="relative">
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button
                                  type="button"
                                  class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-full text-gray-500 bg-white hover:text-gray-700 hover:bg-gray-200 focus:outline-none transition ease-in-out duration-150"
                                >
                                  <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                            </span>
                        </template>
  
                        <template #content>
                            <DropdownLink @click="openStepModal({id, name})" >
                              <i class="fa-solid fa-plus me-2"></i>Add step
                            </DropdownLink>
                            <DropdownLink 
                              @click="toggleEditModal({
                                id, name, description, status,
                              })"
                            >
                              <i class="fa-solid fa-edit me-2"></i>Edit
                            </DropdownLink>
                            <DropdownLink @click="openShareModal({id, name})" >
                              <i class="fa-solid fa-share-nodes me-2"></i>Share
                            </DropdownLink>
                            <DropdownLink @click="toggleTaskDeleteModal({id, name})" >
                              <i class="fa-solid fa-trash me-2"></i>Delete
                            </DropdownLink>
                        </template>
                    </Dropdown>
                  </div>
                </div>
              </div>
              <p>{{ description }}</p>
            </div>
            <div class="flex justify-end">
              <PrimaryButton
                @click="selectTask({id, name})"
              >
                Show steps
              </PrimaryButton>
            </div>
          </div>
          <!-- <i class="fa-solid fa-play text-white text-3xl"></i>             -->
        </div>
      </div>
      <div>
        <StepList :steps="currentSteps" />
      </div>
    </div>

    <Modal :show="isOpenEditModal" @close="toggleEditModal">
      <TaskForm
        action="edit"
        :id="clickedTask.id"
        :name="clickedTask.name"
        :description="clickedTask.description"
        :status="clickedTask.status"
        @updated="toggleEditModal"
      />
    </Modal>
    
    <Modal :show="isOpenStepModal" @close="closeStepModal">
      <h4 class="mb-5 font-semibold text-md text-gray-800 leading-tight">New Step</h4>
      <StepForm
        :task-id="clickedTask?.id"
        :todo-id="todoId"
        action="store"
        @created="closeStepModal"
      />
    </Modal>
    
    <DeleteModal
      title="Are you sure you want to delete the task?"
      description="Once your task is deleted, all of its resources and data will be permanently deleted."
      :deleteRoute="['tasks.destroy', clickedTask.id]"
      :show="isOpenTaskDeleteModal"
      @close="toggleTaskDeleteModal"
    />
    
    <ShareTask
      :show="isOpenShareModal"
      :close="closeShareModal"
      :taskInfo="clickedTask"/>
  </template>

</template>
