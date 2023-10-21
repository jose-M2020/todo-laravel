<script setup>
  import { Head } from '@inertiajs/vue3';

  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

  import TodoCard from './Partials/TodoCard.vue';
  import CreateTodoForm from './Partials/CreateTodoForm.vue';

  const props = defineProps({
    todoList: {
      type: Array,
      required: true,
    },
    message: {
      type: String,
      required: false,
    }
  })
</script>

<template>
  <Head title="Todo" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Todo List</h2>
    </template>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
      <div
        v-if="todoList.length"
        class=""
      >
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
          <div
            v-for="{id, name, description, status} in todoList"
            :key="id"
          >
            <TodoCard
              :id="id"
              :name="name"
              :description="description"
              :status="status"
            />
          </div>
        </div>
      </div>
      <div v-else class="flex justify-center items-center gap-7">
          <div>
              <img
                class="max-w-sm"
                src="../../../images/ui-list.svg"
                alt="Todo list" />
          </div>
          <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <h3 class="text-xl font-bold text-center mb-6">Create your first todo list</h3>
            <CreateTodoForm />
          </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style>

</style>
