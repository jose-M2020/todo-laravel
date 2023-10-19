
<script setup>
  import { router } from "@inertiajs/vue3";
  import { onMounted, reactive, ref, toRefs } from "vue";
  import axios from "axios";
  
  import Modal from '@/Components/Modal.vue';
  import TextInput from '@/Components/TextInput.vue';

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

  const { taskInfo, close } = toRefs(props);
  
  const shareTaskForm = reactive({
    taskId: null,
    userId: null,
  });

  const users = ref([])
  const loading = ref(false)
  const search = ref('')

  const shareTask = async (userId) => {
    const taskId = taskInfo?.value?.id;
    shareTaskForm.taskId = taskId,
    shareTaskForm.userId = userId

    const res = await router.post(route('tasks.share', { task: taskId }), shareTaskForm);
    
    close.value.call();
  };

  const searchUser = async () => {
    loading.value = true;
    const { data } = await axios.get(route('users.index'))
    users.value = data;
    
    loading.value = false;
  }
</script>

<template>
  <Modal :show="show" @close="close">
    <div>
      <h4 class="mb-5 font-semibold text-md text-gray-800 leading-tight">Share</h4>
      <TextInput
        v-model="search"
        @keyup.enter="searchUser()"
        type="text"
        class="mt-1 block w-full"
        autofocus
        autocomplete="search"
        placeholder="Search user"
      />
    </div>
    <div>
      <div
        v-for="{ id, name, email } in users" :key="id"
        @click="shareTask(id)"
        class="p-3 bg-gray-100 hover:cursor-pointer hover:bg-gray-200 duration-200">
        <p>{{ name  }}</p>
        <p>{{ email  }}</p>
      </div>
    </div>
  </Modal>
</template>

