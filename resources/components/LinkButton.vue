<template>
  <InertiaLink
    :class="[
      ...classes.base,
      ...classes.size[size],
      ...classes.theme[theme],
    ]"
    :type="type"
    tabindex="0"
  >
    <slot />
  </InertiaLink>
</template>

<script setup>
import { Link as InertiaLink } from '@inertiajs/inertia-vue3'

import * as classes from './styles/button'

defineProps({
  type: { type: String, default: 'button' },
  size: { type: String, default: 'DEFAULT' },
  theme: { type: String, default: 'DEFAULT' }
})
</script>
