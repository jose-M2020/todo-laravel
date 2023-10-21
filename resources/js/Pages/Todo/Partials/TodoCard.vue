<script setup>
  import { Link } from '@inertiajs/vue3';
  import { getStatus } from '@/Helpers/getStatus';
  import { toRefs } from 'vue';
  import Dropdown from '@/Components/Dropdown.vue';
  import DropdownLink from '@/Components/DropdownLink.vue';

  const props = defineProps({
    id: {
      type: Number,
      required: true,
    },
    name: {
      type: String,
      required: true,
    },
    description: {
      type: String,
      default: ''
    },
    status: {
      type: String,
      required: true,
    },
  })

  const { status } = toRefs(props);

  const {
    name: nameStatus,
    tailwindClass,
  } = getStatus(status.value);

</script>

<template>
  <div>
    <div class="flex flex-col gap-3 p-5 bg-white shadow-lg rounded-lg">
      <div class="flex justify-between items-center">
        <div class="flex items-center gap-2">
          <p>{{ name }}</p>
          <span
            class="p-[7px] rounded-lg text-sm bg-indigo-100 text-indigo-700"
            :class="`bg-${status}`"
          >
            {{ nameStatus }}
          </span>
        </div>
        <div>
          <!-- Settings Dropdown -->
          <div class="ml-3 relative">
            <Dropdown align="right" width="48">
                <template #trigger>
                    <span class="inline-flex rounded-md">
                        <button
                          type="button"
                          class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                        >
                          <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                    </span>
                </template>

                <template #content>
                    <DropdownLink
                      :href="route('todo.destroy', { todo: id })"
                      method="delete"
                      as="button"
                    >
                      Delete
                    </DropdownLink>
                </template>
            </Dropdown>
          </div>
        </div>
      </div>
      <p>{{ description }}</p>
      <Link
        :href="route('todo.tasks', {todolist: id})"
        class="flex justify-end items-center gap-1"
      >
        <span class="text-teal-500 font-semibold hover:cursor-pointer hover:text-teal-600 duration-200">
          View
          <i class="fa-solid fa-arrow-right"></i>
        </span>
      </Link>
    </div>
  </div>
</template>
