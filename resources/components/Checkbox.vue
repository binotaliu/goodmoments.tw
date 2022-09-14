<template>
  <div>
    <div class="flex items-center gap-2 touch:hidden">
      <input
        :id="id || fieldId"
        v-model="value"
        :name="name || id || fieldId"
        type="checkbox"
        class="rounded border-wood-600 p-2 transition-colors checked:bg-wood-600 checked:hover:bg-wood-500"
      >
      <label
        :for="id || fieldId"
        class="select-none"
      >{{ label || fieldName }}</label>
    </div>

    <div class="hidden select-none items-center touch:flex">
      <label
        :for="id || fieldId"
        class="mr-2"
      >{{ label || fieldName }}</label>
      <input
        :id="id || fieldId"
        :name="name || id || fieldId"
        type="checkbox"
        class="sr-only"
      >
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
        aria-hidden="true"
        @click="value = !value"
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
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, inject } from 'vue'

const props = defineProps({
  id: { type: String, default: null },
  name: { type: String, default: null },
  label: { type: String, default: null },
  modelValue: { type: Boolean, required: true }
})

const emits = defineEmits(['update:modelValue', 'change'])

const fieldId = inject('field-id', null)
const fieldName = inject('field-name', null)

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
