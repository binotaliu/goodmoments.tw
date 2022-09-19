<template>
  <InertiaLink
    v-if="as === 'link'"
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
  <a
    v-else
    :class="[
      ...classes.base,
      ...classes.size[size],
      ...classes.theme[theme],
    ]"
    :type="type"
    tabindex="0"
  >
    <slot />
  </a>
</template>

<script setup>
import { Link as InertiaLink } from '@inertiajs/inertia-vue3'

import * as classes from './styles/button'

defineProps({
  as: { type: String, default: 'link' },
  type: { type: String, default: 'button' },
  size: { type: String, default: 'DEFAULT' },
  theme: { type: String, default: 'DEFAULT' }
})
</script>
