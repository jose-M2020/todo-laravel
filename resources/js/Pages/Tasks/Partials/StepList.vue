<script setup>
import { getStatus } from '@/Helpers/getStatus';


const props = defineProps({
  steps: {
    type: Array,
    default: []
  },
})

</script>

<template>
  <template v-if="steps.length">
    <div
      v-for="{id, name, description, status} in steps"
      :key="id"
    >
      <div class="p-5 shadow-lg rounded-lg flex flex-col gap-2">
        <!--HEADER -->
        <div class="flex justify-between items-center">
          <div class="flex items-center gap-2">
            <p>{{ name }}</p>
            <span
              class="p-[7px] rounded-lg text-sm bg-emerald-100 text-emerald-700"
              :class="getStatus(status).tailwindClass"
            >
              {{ getStatus(status).name }}
            </span>
          </div>

        </div>
        <p>{{ description }}</p>
      </div>
    </div>
  </template>
</template>
