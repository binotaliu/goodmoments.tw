<template>
  <button
    :class="[
      'px-6 py-2',
      'border rounded',
      'font-bold',
      'text-base',
      'outline-none focus:outline-none',
      'transition-colors duration-50',
      ...themeClasses[theme],
    ]"
    :type="type"
    tabindex="0"
  >
    <slot />
  </button>
</template>

<script setup>
defineProps({
  type: { type: String, default: 'button' },
  theme: { type: String, default: 'DEFAULT' },
})

const themeClasses = {
  DEFAULT: [
    'text-pearl-800',
    'border-pearl-600',
    'bg-pearl-500 hover:bg-pearl-400 active:bg-pearl-600',
  ],
  primary: [
    'border-sun-600',
    'bg-sun-500 hover:bg-sun-400 active:bg-sun-600',
  ]
}
</script>
