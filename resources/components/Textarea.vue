<template>
  <textarea
    v-model="value"
    :class="[
      ...styles.base(false)
    ]"
  />
</template>

<script setup>
import { computed } from 'vue'
import * as styles from './styles/input'

const props = defineProps({
  modelValue: { type: [String, null], default: '' }
})

const emits = defineEmits(['update:modelValue'])

const value = computed({
  get () {
    return props.modelValue
  },
  set (value) {
    emits('update:modelValue', value)
  },
})
</script>
