<template>
  <div class="relative flex w-full flex-wrap items-stretch">
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
        ...styles.base(hasIcon)
      ]"
      v-model="inputValue"
      v-bind="$attrs"
    />
  </div>
</template>

<script setup>
import { computed, useSlots } from 'vue'
import * as styles from './styles/input'

const props = defineProps({
  type: { type: String, default: 'text' },
  placeholder: { type: String, default: '' },
  modelValue: { type: [String, Number, null], required: true }
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
