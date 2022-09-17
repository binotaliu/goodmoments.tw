<template>
  <div
    class="border border-gray-100 bg-white px-6 py-4 shadow"
    :class="[
      expandedOnMobile
        ? 'border-x-0 md:border-x md:rounded'
        : 'border-x rounded'
    ]"
  >
    <slot />
  </div>
</template>

<script setup>
defineProps({
  expandedOnMobile: { type: Boolean, default: false }
})
</script>
