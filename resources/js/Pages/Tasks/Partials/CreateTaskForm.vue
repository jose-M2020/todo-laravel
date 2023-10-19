<script setup>
  import { useForm } from "@inertiajs/vue3";
  import { toRefs } from "vue";

  import TextInput from '@/Components/TextInput.vue';
  import InputLabel from '@/Components/InputLabel.vue';
  import InputError from '@/Components/InputError.vue';
  import PrimaryButton from '@/Components/PrimaryButton.vue';

  const props = defineProps({
    todoId: {
      type: Number,
      required: true,
    }
  })
  const { todoId } = toRefs(props);

  const taskForm = useForm({
    name: '',
    description: '',
    todoId: todoId.value
  });

  const taskSubmit = () => {
    taskForm.post(route('tasks.store'), {
      onSuccess: () => taskForm.reset(),
    });
  };
</script>

<template>
  <div>
    <h3 class="mb-5 font-semibold text-lg text-gray-800 leading-tight">New task</h3>
    <form @submit.prevent="taskSubmit">
      <div>
          <InputLabel for="name" value="Name" />
          <TextInput
              id="name"
              type="text"
              class="mt-1 block w-full"
              v-model="taskForm.name"
              required
              autofocus
              autocomplete="name"
          />
          <InputError class="mt-2" :message="taskForm.errors.name" />
      </div>
      <div class="mt-4">
          <InputLabel for="description" value="Descriptiom" />
          <TextInput
              id="description"
              input-type="textArea"
              class="mt-1 block w-full"
              v-model="taskForm.description"
              required
              autocomplete="description"
          />
      </div>
  
      <div class="flex items-center justify-end mt-4">
          <PrimaryButton class="ml-4" :class="{ 'opacity-25': taskForm.processing }" :disabled="taskForm.processing">
              Create
          </PrimaryButton>
      </div>
    </form>
  </div>
</template>