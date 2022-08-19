<template>
  <div class="w-full">
    <ckeditor
      v-model="modelProxy"
      :editor="Editor"
    />
  </div>
</template>

<script setup>
import Editor from '@ckeditor/ckeditor5-build-classic'
import { computed } from 'vue'

const props = defineProps({
  modelValue: { type: [String, null], required: true }
})

const emits = defineEmits(['update:modelValue'])

const modelProxy = computed({
  get () {
    return props.modelValue
  },
  set (value) {
    emits('update:modelValue', value)
  }
})
</script>
