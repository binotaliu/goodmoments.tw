<template>
  <button
    :class="[
      ...classes.base,
      ...classes.size[size],
      ...classes.theme[theme],
    ]"
    :type="type"
    tabindex="0"
    :disabled="disabled"
  >
    <slot />
  </button>
</template>

<script setup>
import * as classes from './styles/button'

defineProps({
  type: { type: String, default: 'button' },
  size: { type: String, default: 'DEFAULT' },
  theme: { type: String, default: 'DEFAULT' },
  disabled: { type: Boolean, default: false }
})
</script>
