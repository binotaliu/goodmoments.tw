<template>
  <button
    :class="[
      'border rounded',
      'font-bold',
      'outline-none focus:outline-none',
      'transition-colors duration-50',
      ...sizeClasses[size],
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
  size: { type: String, default: 'DEFAULT' },
  theme: { type: String, default: 'DEFAULT' }
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

const sizeClasses = {
  sm: [
    'px-2 py-1',
    'text-sm'
  ],
  DEFAULT: [
    'px-6 py-2',
    'text-base'
  ],
  lg: [
    'px-10 py-3',
    'text-base'
  ]
}
</script>
