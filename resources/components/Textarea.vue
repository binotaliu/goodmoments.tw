<template>
  <textarea
    v-model="value"
    :class="[
      ...styles.base(false)
    ]"
    :id="id || fieldId"
    :name="name || id || fieldId"
    :placeholder="placeholder || fieldName"
  />
</template>

<script setup>
import { computed, inject } from 'vue'
import * as styles from './styles/input'

const props = defineProps({
  modelValue: { type: [String, null], default: '' },
  id: { type: String, default: null },
  name: { type: String, default: null },
  placeholder: { type: String, default: null }
})

const emits = defineEmits(['update:modelValue'])

const fieldId = inject('field-id', null)
const fieldName = inject('field-name', null)

const value = computed({
  get () {
    return props.modelValue
  },
  set (value) {
    emits('update:modelValue', value)
  }
})
</script>
