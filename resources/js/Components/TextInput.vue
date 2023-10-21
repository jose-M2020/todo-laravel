<script setup>
import { onMounted, ref, toRefs } from 'vue';

const props = defineProps({
    modelValue: {
        type: String,
        required: true,
    },
    inputType: {
        type: String,
        required: false,
        default: 'text'
    },
});
const { inputType } = toRefs(props);

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (inputType === 'text' && input?.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        v-if="inputType === 'text'"
        class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        ref="input"
    />
    <textarea
      v-else
      class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      ref="input"
      rows="4">
    </textarea>
</template>