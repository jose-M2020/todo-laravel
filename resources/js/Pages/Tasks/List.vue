<script setup>
  import { ref, toRefs } from 'vue';
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import { Head, useForm } from '@inertiajs/vue3';

  import TextInput from '@/Components/TextInput.vue';
  import InputLabel from '@/Components/InputLabel.vue';
  import PrimaryButton from '@/Components/PrimaryButton.vue';
  import Accordion from '@/Components/Accordion.vue';

  import { getStatus } from '@/Helpers/getStatus';

  const props = defineProps({
    todoId: {
      type: Number,
      required: true,
    },
    tasks: {
      type: Array,
      required: true,
    }
  })
  const { todoId } = toRefs(props);
  const shareFormField = ref({
    taskId: null,
    userId: 1
  });

  const taskForm = useForm({
    name: '',
    description: '',
    todoId: todoId.value
  });
  
  const shareTaskForm = useForm({
    task: null,
    userId: 1,
  });
  
  const stepForm = useForm({
    name: '',
    description: '',
    taskId: null
  });

  const taskSubmit = () => {
    taskForm.post(route('tasks.store'), {
      onSuccess: () => taskForm.reset(),
    });
  };
  

  const shareTaskSubmit = () => {
    shareTaskForm.post(route('tasks.share'), {
      onSuccess: () => shareTaskForm.reset(),
    });
  };
  
  const stepSubmit = () => {
    stepForm.post(route('steps.store'), {
      onSuccess: () => form.reset(),
    });
  };
</script>

<template>
  <Head title="Todo" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tasks</h2>
    </template>
    <div class="p-4 md:p-6 lg:p-8">
      <div class="grid grid-cols-3 gap-6">
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
      
                <InputError class="mt-2" :message="taskForm.errors.description" />
            </div>
      
            
            <div class="flex items-center justify-end mt-4">
                <PrimaryButton class="ml-4" :class="{ 'opacity-25': taskForm.processing }" :disabled="taskForm.processing">
                    Create
                </PrimaryButton>
            </div>
          </form>
        </div>
        <div class="col-span-2">
          <!-- <button @click="shareTaskSubmit()">post</button> -->
          <h3 class="mb-5 font-semibold text-lg text-gray-800 leading-tight">Added tasks</h3>
          <div
            v-if="tasks.length"
            class="grid grid-cols-1 gap-4"
          >
            <!-- TASKS -->
            <div
              v-for="{id, name, description, status, steps} in tasks" :key="id"
            >
              <div class="p-5 bg-white shadow-lg rounded-lg">
                <div class="pb-4 mb-4 border-b-2 border-gray-300 flex flex-col gap-2">
                  <div class="flex justify-between items-center">
                    <p>{{ name }}</p>
                    <div class="flex justify-center items-center gap-3">
                      <span @click="() => { shareTaskForm.data.task = id; }">Share</span>
                      <span>{{ getStatus(status).name }}</span>
                    </div>
                  </div>
                  <p>{{ description }}</p>
                </div>
                <!-- STEPS -->
                <div>
                  <div>
                    <h4 class="mb-5 font-semibold text-md text-gray-800 leading-tight">New Step</h4>
                    <form
                      @submit.prevent="stepSubmit"
                      class="grid grid-cols-6 gap-2 items-center justify-between"
                    >
                      <input
                        id="taskId"
                        class="mt-1 block w-full"
                        v-value="id"
                        v-model="stepForm.taskId"
                        required
                        type="hidden"
                      />
                      <div class="col-span-2">
                          <InputLabel for="name" value="Name" />
                
                          <TextInput
                              id="name"
                              type="text"
                              class="mt-1 block w-full"
                              v-model="stepForm.name"
                              required
                              autofocus
                              autocomplete="name"
                          />
                
                          <InputError class="mt-2" :message="stepForm.errors.name" />
                      </div>
                
                      <div class="mt-4 col-span-3">
                          <InputLabel for="description" value="Descriptiom" />
                
                          <TextInput
                              id="description"
                              type="text"
                              class="mt-1 block w-full"
                              v-model="stepForm.description"
                              required
                              autocomplete="description"
                          />
                
                          <InputError class="mt-2" :message="stepForm.errors.description" />
                      </div>
                
                      
                      <div class="col-auto flex items-center justify-end mt-4">
                          <PrimaryButton class="ml-4" :class="{ 'opacity-25': stepForm.processing }" :disabled="stepForm.processing">
                              Create
                          </PrimaryButton>
                      </div>
                    </form>
                  </div>
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
  </AuthenticatedLayout>
</template>

<style>

</style>