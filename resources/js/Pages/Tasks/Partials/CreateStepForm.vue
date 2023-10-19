<script setup>
  import { reactive, toRefs } from 'vue';
  import { router } from '@inertiajs/vue3';
  
  import TextInput from '@/Components/TextInput.vue';
  import InputLabel from '@/Components/InputLabel.vue';
  import PrimaryButton from '@/Components/PrimaryButton.vue';
  import Modal from '@/Components/Modal.vue';

  const props = defineProps({
    show: {
      type: Boolean,
      default: false,
    },
    close: {
      type: Function,
      default: null      
    },
    taskInfo: {
      type: Object,
      required: true,     
    },
  })

  const {
    close,
    taskInfo
  } = toRefs(props)

  // const stepForm = useForm({
  //   name: '',
  //   description: '',
  //   taskId: null
  // });
  
  const stepForm = reactive({
    name: '',
    description: '',
    taskId: null
  })

  const stepSubmit = async () => {
    // stepForm.post(route('steps.store'), {
    //   onSuccess: () => form.reset(),
    // });
    stepForm.taskId = taskInfo?.value?.id
    await router.post(route('steps.store'), stepForm);
    close.value.call();
  };
  

</script>

<template>
  <!-- STEP FORM MODAL -->
  <Modal :show="show" @close="close">
    <div>
      <h4 class="mb-5 font-semibold text-md text-gray-800 leading-tight">New Step</h4>
      <form
        @submit.prevent="stepSubmit"
      >
        <input
          name="taskId"
          :value="taskInfo?.value?.id"
          type="hidden"
        />
        <div>
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
            <!--
              <InputError class="mt-2" :message="stepForm.errors.name" />
            -->
        </div>
  
        <div class="mt-4">
            <InputLabel for="description" value="Description" />
            <TextInput
                id="description"
                type="text"
                class="mt-1 block w-full"
                v-model="stepForm.description"
                required
            />
            <!--
              <InputError class="mt-2" :message="stepForm.errors.description" />
            -->
        </div>
        
        <div class="col-auto flex items-center justify-end mt-4">
            <PrimaryButton class="ml-4" :class="{ 'opacity-25': stepForm.processing }" :disabled="stepForm.processing">
                Create
            </PrimaryButton>
        </div>
      </form>
    </div>
  </Modal>
</template>