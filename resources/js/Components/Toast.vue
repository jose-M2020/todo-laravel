<script setup>
  import { onMounted, ref, toRefs } from "vue"

  const props = defineProps({
    text: {
      type: String,
      required: true,
    },
    type: {
      type: String,
      required: true,
    },
  });

  const prop = toRefs(props);

  const textRef = ref(prop.text);
  
  // onMounted(() => {
  //   // show.value = true;
  //   console.log('mounted')
  // })

  // TODO Close toast on click
  const close = () => {
    textRef.value = '';
  }

</script>

<template>
   <Transition
      enter-active-class="ease-out duration-300"
      enter-from-class="opacity-0 scale-[.6]"
      enter-to-class="opacity-100 scale-[100]"
      leave-active-class="ease-in duration-200"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
  >
    <div class="fixed bottom-[15px] right-[15px]">
        <div id="toast-danger" class="flex items-center w-full max-w-xs min-w-[300px] p-4 text-slate-800 bg-slate-100 shadow-xl rounded-lg" role="alert">
          
          <div v-if="type === 'error'" class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-300 bg-red-700 rounded-lg">
              <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/>
              </svg>
              <span class="sr-only">Error icon</span>
          </div>
          <div v-if="type === 'success'" class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-100 bg-green-600 rounded-lg">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
            </svg>
            <span class="sr-only">Check icon</span>
          </div>

          <div class="ml-3 text-sm font-bold">{{ text }}</div>
          <button
              @click="close"
              type="button"
              class="ml-auto -mx-1.5 -my-1.5 text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8"
          >
              <span class="sr-only">Close</span>
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
              </svg>
          </button>
        </div>
    </div>
  </Transition>

</template>

