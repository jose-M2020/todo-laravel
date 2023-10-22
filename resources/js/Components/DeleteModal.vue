<script setup>
import { router } from "@inertiajs/vue3";
import { ref } from "vue";
import Modal from './Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';

const props = defineProps({
  show: {
      type: Boolean,
      default: false,
  },
  maxWidth: {
      type: String,
      default: '2xl',
  },
  closeable: {
      type: Boolean,
      default: true,
  },
  title: {
    type: String,
    required: true,
  },
  description: {
    type: String,
    required: true,
  },
  deleteRoute: {
    type: Array,
    required: true,
  },
  deleteBtnText: {
    type: String,
    default: 'Confirm',
  },
})

const emit = defineEmits(['close']);
const isLoading = ref(false);

const close = () => {
  emit('close');
  console.log('closing...');
};

const deleteItem = () => {
  isLoading.value = true;

  router.delete(route(...props.deleteRoute), {
    onSuccess: () => { 
      isLoading.value = false;
      close();
    },
    onError: (error) => {
      console.log(error);
      isLoading.value = false;
    }
  })
};

</script>

<template>

  <Modal
    :show="show"
    :max-width="maxWidth"
    :closeable="closeable"
    @close="close"
  >
    <div class="p-6">
      <h2 class="text-lg font-medium text-gray-900">
          {{ title }}
      </h2>

      <p class="mt-1 text-sm text-gray-600">
        {{ description }}
      </p>

      <div class="mt-6 flex justify-end">
          <SecondaryButton @click="close"> Cancel </SecondaryButton>
          <DangerButton
            class="ml-3"
            :loading="isLoading"
            @click="deleteItem"
          >
            {{ deleteBtnText }}
          </DangerButton>
      </div>
    </div>
  </Modal>
  
</template>