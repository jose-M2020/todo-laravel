<script setup>
  import { useForm } from "@inertiajs/vue3";

  import TextInput from '@/Components/TextInput.vue';
  import InputLabel from '@/Components/InputLabel.vue';
  import InputError from '@/Components/InputError.vue';
  import PrimaryButton from '@/Components/PrimaryButton.vue';

  const form = useForm({
    name: '',
    description: '',
  });

  const submit = () => {
      form.post(route('todo.store'), {
        onSuccess: () => form.reset(),
      });
  };

</script>

<template>
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
                inputType="textarea"
                class="mt-1 block w-full"
                v-model="form.description"
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
</template>
