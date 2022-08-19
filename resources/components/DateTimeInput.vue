<template>
  <GMInput
    v-model="proxiedValue"
    type="datetime-local"
  />
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  modelValue: { type: [Object, String, null], default: () => null }
})

const emits = defineEmits(['update:modelValue'])

const proxiedValue = computed({
  get () {
    if (props.modelValue === null) {
      return null
    }

    const parsed = dayjs(props.modelValue)

    return parsed.isValid() ? parsed.format('YYYY-MM-DDTHH:mm') : null
  },
  set (value) {
    if (value === null) {
      emits('update:modelValue', null)
    }

    const parsed = dayjs(value, 'YYYY-MM-DDTHH:mm')
    emits(
      'update:modelValue',
      parsed.isValid()
        ? parsed.utc().format('YYYY-MM-DDTHH:mm:ss')
        : null
    )
  }
})
</script>
