<script setup>
import { router } from '@inertiajs/vue3';
import { ref, toRefs, watch } from 'vue';

import { useTodoStore } from '@/Stores/TodoStore';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import DeleteModal from '@/Components/DeleteModal.vue';
import Modal from '@/Components/Modal.vue';
import TodoForm from './TodoForm.vue';
import { getStatus } from '@/Helpers/getStatus';

const props = defineProps({
  id: {
    type: Number,
    required: true,
  },
  name: {
    type: String,
    required: true,
  },
  description: {
    type: String,
    default: ''
  },
  status: {
    type: String,
    required: true,
  },
})

const todoStore = useTodoStore()

const statusProps = ref();
const clickedTodo = ref();

watch(
  () => props.status,
  () => {
    statusProps.value = getStatus(props.status);
  },
  { immediate: true }
)

const redirectTask = todo => {
  todoStore.setCurrentTodo(todo);
  router.get(route('todo.tasks', todo.id));
}

// Delete Modal

const isOpenDeleteModal = ref(false);
const toggleDeleteModal = (todo = {}) => {
  clickedTodo.value = todo;
  isOpenDeleteModal.value = !isOpenDeleteModal.value
};

// Edit Modal

const isOpenEditModal = ref(false);
const toggleEditModal = (todo = {}) => {
  clickedTodo.value = todo;
  isOpenEditModal.value = !isOpenEditModal.value
};

</script>

<template>
  <div>
    <div class="flex flex-col gap-3 p-5 bg-white shadow-lg rounded-lg">
      <div class="flex justify-between items-center">
        <div class="flex items-center gap-2">
          <p>{{ name }}</p>
          <span
            class="p-[7px] rounded-lg text-sm bg-indigo-100 text-indigo-700"
            :class="`bg-${statusProps?.name}`"
          >
            {{ statusProps?.name }}
          </span>
        </div>
        <div>
          <!-- Settings Dropdown -->
          <div class="ml-3 relative">
            <Dropdown align="right" width="48">
                <template #trigger>
                    <span class="inline-flex rounded-md">
                        <button
                          type="button"
                          class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                        >
                          <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                    </span>
                </template>

                <template #content>
                    <DropdownLink @click="toggleDeleteModal({id})" >
                      <i class="fa-solid fa-trash me-2"></i>Delete
                    </DropdownLink>
                    <DropdownLink @click="toggleEditModal({id, name})" >
                      <i class="fa-solid fa-edit me-2"></i>Edit
                    </DropdownLink>
                </template>
            </Dropdown>
          </div>
        </div>
      </div>
      <p>{{ description }}</p>
      <span
        @click="redirectTask({ id, name, status })"
        class="flex justify-end items-center gap-1 text-teal-500 font-semibold hover:cursor-pointer hover:text-teal-600 duration-200"
      >
        View
        <i class="fa-solid fa-arrow-right"></i>
      </span>
    </div>
  </div>

  <Modal :show="isOpenEditModal" @close="toggleEditModal">
    <TodoForm
      action="edit"
      :id="id"
      :name="name"
      :description="description"
      :status="status"
      @updated="toggleEditModal"
    />
  </Modal>

  <DeleteModal
    title="Are you sure you want to delete the todo list?"
    description="Once your todo is deleted, all of its resources and data will be permanently deleted."
    :deleteRoute="['todo.destroy', clickedTodo?.id]"
    :show="isOpenDeleteModal"
    @close="toggleDeleteModal"
  />
</template>
