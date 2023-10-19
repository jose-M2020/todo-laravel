<script setup>
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import { Head, Link, useForm } from '@inertiajs/vue3';
  
  import TextInput from '@/Components/TextInput.vue';
  import InputLabel from '@/Components/InputLabel.vue';
  import PrimaryButton from '@/Components/PrimaryButton.vue';
  import Dropdown from '@/Components/Dropdown.vue';
  
  import { getStatus } from '@/Helpers/getStatus';

  defineProps({
    todoList: {
      type: Array,
      required: true,
    }
  })

  const form = useForm({
    name: '',
    description: '',
  });
  
  const submit = () => {
      form.post(route('todo.store'), {
        onSuccess: () => form.reset(),
      });
  };

  const redirectTasks = () => {
    $inertia.visit(route('todo.tasks'), { method: 'get' });
  }

</script>

<template>
  <Head title="Todo" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Todo List</h2>
    </template>  
    <div class="p-4 md:p-6 lg:p-8">
      <div
        v-if="todoList.length"
        class=""
      >
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4">
          <Link
            v-for="{id, name, description, status} in todoList" :key="id"
            :href="route('todo.tasks', {todolist: id})"
          >
            <div class="p-5 bg-white shadow-lg rounded-lg hover:bg-slate-100 duration-200">
              <div class="flex justify-between items-center pb-4">
                <p>{{ name }}</p>
                <p :class="getStatus(status).tailwindClass">{{ getStatus(status).name }}</p>
              </div>
              <p>{{ description }}</p>
            </div>
            <!--
              <Dropdown align="right" width="48">
                <template #trigger>
                  list
                </template>
              </Dropdown>
              -->
          </Link>
        </div>
      </div>
      <div v-else>
        <h3>There's no todo lists</h3>
        <form @submit.prevent="submit">
              <div>
                  <InputLabel for="name" value="Name" />
  
                  <TextInput
                      id="name"
                      type="text"
                      class="mt-1 block w-full"
                      v-model="form.name"
                      required
                      autofocus
                      autocomplete="name"
                  />
  
                  <InputError class="mt-2" :message="form.errors.name" />
              </div>
  
              <div class="mt-4">
                  <InputLabel for="description" value="Descriptiom" />
  
                  <TextInput
                      id="description"
                      type="description"
                      class="mt-1 block w-full"
                      v-model="form.description"
                      required
                      autocomplete="description"
                  />
  
                  <InputError class="mt-2" :message="form.errors.description" />
              </div>
  
              
              <div class="flex items-center justify-end mt-4">
                  <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                      Create
                  </PrimaryButton>
              </div>
          </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style>

</style>