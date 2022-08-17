<template>
  <div
    :class="[
      'px-4 py-2',
      'border',
      'rounded',
      ...themeClasses[theme]
    ]"
  >
    <slot />
  </div>
</template>

<script setup>
defineProps({
  theme: { type: String, default: 'DEFAULT' }
})

const themeClasses = {
  DEFAULT: [
    'border-wood-500',
    'bg-wood-100',
    'text-wood-900'
  ]
}
</script>
