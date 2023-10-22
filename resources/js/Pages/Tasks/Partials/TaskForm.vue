<script setup>
import { useForm } from "@inertiajs/vue3";

import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useTodoStore } from "@/Stores/TodoStore";

const props = defineProps({
  id: {
    type: Number,
    default: null
  },
  name: {
    type: String,
    default: ''
  },
  description: {
    type: String,
    default: ''
  },
  status: {
    type: Boolean,
    default: ''
  },
  action: {
    type: String,
    default: 'store'
  },
});

const { currentTodo } = useTodoStore()
const emit = defineEmits(['updated']);

const form = useForm({
  name: props.name,
  description: props.description,
  todoId: currentTodo.id,
  ...props.action === 'edit'&& {
    status: props.status
  }
});

const taskSubmit = () => {
  if(props.action === 'store'){
    form.post(route('tasks.store'), {
      onSuccess: () => form.reset(),
  });
  } else {
    form.patch(route('tasks.update', props.id), {
      onSuccess: () => {
        emit('updated');
      }
    });
  }
};

</script>

<template>
  <form @submit.prevent="taskSubmit">
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
            input-type="textArea"
            class="mt-1 block w-full"
            v-model="form.description"
            autocomplete="description"
        />
        <InputError class="mt-2" :message="form.errors.description" />
    </div>

    <div class="flex items-center justify-end mt-4">
        <PrimaryButton class="ml-4" :loading="form.processing">
            Create
        </PrimaryButton>
    </div>
  </form>
</template>