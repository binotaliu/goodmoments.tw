<template>
  <div class="relative flex w-full flex-wrap items-stretch mb-3">
    <span
      :class="[
        'w-8 h-full pl-3 py-3',
        'z-10',
        'absolute',
        'flex center-center',
        'leading-snug font-normal',
        'bg-transparent',
        'text-base text-gray-300',
        'rounded',
      ]"
      v-if="hasIcon"
    >
      <slot name="icon" />
    </span>
    <input
      :type="type"
      :placeholder="placeholder"
      :class="[
        'relative',
        hasIcon ? 'pl-10' : 'pl-2',
        'w-full pl-10 pr-2 py-1',
        'border border-gray-100',
        'outline-none focus:outline-none focus:ring',
        'rounded',
        'bg-white',
        'text-sm',
        'placeholder-gray-300 text-gray-600',
        'shadow',
        'motion-safe:focus:md:scale-[1.02]',
        'transition-all'
      ]"
      v-model="inputValue"
      v-bind="$attrs"
    />
  </div>
</template>

<script setup>
import { computed, useSlots } from 'vue'

const props = defineProps({
  type: { type: String, default: 'text' },
  placeholder: { type: String, default: '' },
  modelValue: { type: [String, Number], required: true }
})

const slots = useSlots()

const emits = defineEmits(['update:modelValue'])

const hasIcon = computed(() => !!slots.icon)

const inputValue = computed({
  get () {
    return props.modelValue
  },
  set (value) {
    emits('update:modelValue', value)
  },
})
</script>
