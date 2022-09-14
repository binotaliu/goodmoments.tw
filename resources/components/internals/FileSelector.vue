<template>
  <input
    ref="inputEl"
    type="file"
    class="hidden"
    @change="handleFileChange"
  >
</template>

<script setup>
import { ref } from 'vue'

const inputEl = ref(null)

const emits = defineEmits(['selected'])

const handleFileChange = async () => {
  const { files } = inputEl.value

  if (files.length <= 0) {
    return
  }

  emits('selected', files[0])
  inputEl.value.value = null
}

defineExpose({
  select () {
    inputEl.value?.click()
  }
})
</script>
