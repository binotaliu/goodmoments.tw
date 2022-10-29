<template>
  <nav
    class="px-4 md:block"
    :class="[ show ? 'block' : 'hidden' ]"
  >
    <slot />
  </nav>
</template>

<script setup>
defineProps({
  show: { type: Boolean, default: false }
})
</script>
