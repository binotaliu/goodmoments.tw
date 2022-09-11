<template>
  <div class="relative flex w-full flex-wrap items-stretch">
    <span
      v-if="hasIcon"
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
    >
      <slot name="icon" />
    </span>
    <input
      v-model="inputValue"
      :type="type"
      :placeholder="placeholder || fieldName"
      :id="id || fieldId"
      :name="name || id || fieldId"
      :class="[
        ...styles.base(hasIcon)
      ]"
      v-bind="$attrs"
    >
  </div>
</template>

<script setup>
import { computed, inject, useSlots } from 'vue'
import * as styles from './styles/input'

defineOptions({
  inheritAttrs: false
})

const props = defineProps({
  type: { type: String, default: 'text' },
  placeholder: { type: String, default: '' },
  modelValue: { type: [String, Number, null], required: true },
  id: { type: String, default: null },
  name: { type: String, default: null }
})

const slots = useSlots()

const emits = defineEmits(['update:modelValue'])

const hasIcon = computed(() => !!slots.icon)

const fieldId = inject('field-id', null)
const fieldName = inject('field-name', null)

const inputValue = computed({
  get () {
    return props.modelValue
  },
  set (value) {
    emits('update:modelValue', value)
  }
})
</script>
