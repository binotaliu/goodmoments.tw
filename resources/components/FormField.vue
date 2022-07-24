<template>
  <div class="group flex flex-col items-start justify-center gap-1">
    <label :for="id" class="flex justify-start items-center gap-1 text-gray-400 group-focus-within:text-gray-800 text-sm transition-colors">
      <span class="inline-flex center-center" v-if="$slots.icon">
        <slot name="icon" />
      </span>
      {{ name }}
    </label>
    <slot class="peer" />
  </div>
</template>

<script setup>
defineProps({
  id: { type: String, required: true },
  name: { type: String, required: true },
  errors: { type: [Array, String, Object, null], default: () => null },
})
</script>
