<template>
  <div>
    <div class="touch:hidden flex items-center gap-2">
      <input :id="id" type="checkbox" class="p-2 rounded border-wood-600 checked:bg-wood-600 checked:hover:bg-wood-500 transition-colors" v-model="value" />
      <label :for="id" class="select-none">{{ label }}</label>
    </div>

    <div class="hidden touch:flex items-center select-none">
      <label :for="id" class="mr-2">{{ label }}</label>
      <input :id="id" type="checkbox" class="sr-only" />
      <div
        :class="[
          'inline-block relative',
          'h-6 w-16',
          'border',
          'rounded-full',
          { 'border-wood-500 bg-wood-500': value },
          { 'border-gray-100 bg-gray-100': !value },
          'box-content',
          'overflow-hidden',
          'transition-colors',
        ]"
        @click="value = !value"
        aria-hidden="true"
      >
        <div
          :class="[
            'h-6 w-6',
            { 'left-[calc(100%_-_1.5rem)]': value },
            { 'left-0': !value },
            'absolute',
            'rounded-full',
            'bg-white',
            'shadow-lg',
            'transition-all',
          ]"
        ></div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  id: { type: String, required: true },
  label: { type: String, required: true },
  modelValue: { type: Boolean, required: true }
})

const emits = defineEmits(['update:modelValue', 'change'])

const value = computed({
  get: () => props.modelValue,
  set: (value) => {
    if (value !== props.modelValue) {
      emits('change', value)
    }
    emits('update:modelValue', value)
  }
})
</script>
