<script setup>
import { computed } from 'vue';

const props = defineProps({
  options: {
    type: [Array, Object],
    default: () => []
  },
  defaultValue: {
    type: String,
    default: ''
  }
})

const selectedValue = props.defaultValue;

const normalizedOptions = computed( () => {
  // Check if options is an Array
  if (Array.isArray(props.options)) {
    // If it's a plain array of strings
    if (typeof props.options[0] === 'string') {
      return props.options.map(item => ({ value: item }));
    }
    // If it's an array of objects
    return props.options;
  }
  // Convert object to an array of its values
  return Object.values(props.options);
})

const getOptionValue = (option) => {
  return option.value || option.id || option.name;
}

</script>

<template>
  <select
    class="py-3 px-4 pr-9 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500"
    v-model="selectedValue"
  >
    <option selected disabled>Select an option</option>
    <option
      v-for="(option, index) in normalizedOptions"
      :key="index"
      :value="getOptionValue(option)"
      :selected="getOptionValue(option) === defaultValue"
    >
      {{ option.name || option.value || option.id }}
    </option>
  </select>
</template>

