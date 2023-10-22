<script setup>
import { useForm } from '@inertiajs/vue3';
  
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useTodoStore } from '@/Stores/TodoStore';

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
  taskId: {
    type: Number,
    required: true,     
  },
  action: {
    type: String,
    default: 'store'
  },
})

const { currentTodo } = useTodoStore()
const emit = defineEmits(['updated', 'created']);

const form = useForm({
  name: props.name,
  description: props.description,
  taskId: props.taskId,
  todoId: currentTodo?.id,
  ...props.action === 'edit'&& {
    status: props.status
  }
});

const stepSubmit = async () => {
  if(props.action === 'store'){
    form.post(route('steps.store'), {
      onSuccess: () => {
        form.reset();
        emit('created');
      }
  });
  } else {
    form.patch(route('steps.update', props.id), {
      onSuccess: () => {
        emit('updated');
      }
    });
  }
};
  

</script>

<template>
  <form @submit.prevent="stepSubmit" >
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
        <InputLabel for="description" value="Description" />
        <TextInput
            id="description"
            inputType="textarea"
            class="mt-1 block w-full"
            v-model="form.description"
            required
        />
          <InputError class="mt-2" :message="form.errors.description" />
    </div>
    
    <div class="col-auto flex items-center justify-end mt-4">
        <PrimaryButton class="ml-4" :loading="form.processing">
            Update
        </PrimaryButton>
    </div>
  </form>
</template>