<script setup>
import { ref } from 'vue';

import { useTodoStore } from '@/Stores/TodoStore'

import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import DeleteModal from '@/Components/DeleteModal.vue';
import { getStatus } from '@/Helpers/getStatus';
import Modal from '@/Components/Modal.vue';
import StepForm from './StepForm.vue';

const { currentTodo } = useTodoStore()

const props = defineProps({
  steps: {
    type: Array,
    default: []
  },
})
const clickedStep = ref({});

// Delete Task Modal

const isOpenDeleteModal = ref(false);
const toggleDeleteModal = (step = {}) => {
  clickedStep.value = step;
  isOpenDeleteModal.value = !isOpenDeleteModal.value
};

// Edit Task Modal

const isOpenEditModal = ref(false);
const toggleEditModal = (step = {}) => {
  clickedStep.value = step;
  isOpenEditModal.value = !isOpenEditModal.value
};

</script>

<template>
  <template v-if="steps.length">
    <div
      v-for="{id, name, description, status, task_id} in steps"
      :key="id"
    >
      <div class="p-5 shadow-lg rounded-lg flex flex-col gap-2">
        <!--HEADER -->
        <div class="flex justify-between items-center">
          <div class="flex items-center gap-2">
            <p>{{ name }}</p>
            <span
              class="p-[7px] rounded-lg text-sm bg-emerald-100 text-emerald-700"
              :class="getStatus(status).tailwindClass"
            >
              {{ getStatus(status).name }}
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
                    <DropdownLink @click="toggleDeleteModal({ id, name })">
                      <i class="fa-solid fa-trash me-2"></i>Delete
                    </DropdownLink>
                    <DropdownLink @click="toggleEditModal({ id, name, description, status, task_id })" >
                      <i class="fa-solid fa-edit me-2"></i>Edit
                    </DropdownLink>
                </template>
            </Dropdown>
          </div>
        </div>
        <p>{{ description }}</p>
      </div>
    </div>

    <Modal :show="isOpenEditModal" @close="toggleEditModal">
      <h4 class="mb-5 font-semibold text-md text-gray-800 leading-tight">Edit Step</h4>
      <StepForm
        action="edit"
        :id="clickedStep.id"
        :name="clickedStep.name"
        :description="clickedStep.description"
        :status="clickedStep.status"
        :task-id="clickedStep?.task_id"
        @updated="toggleEditModal"
      />
    </Modal>
    <DeleteModal
      title="Are you sure you want to delete the step?"
      description="Once the step is deleted, all of its resources and data will be permanently deleted."
      :deleteRoute="['steps.destroy', { 
        step: clickedStep?.id,
        todolist: currentTodo.id
      }]"
      :show="isOpenDeleteModal"
      @close="toggleDeleteModal"
    />
  </template>
</template>
