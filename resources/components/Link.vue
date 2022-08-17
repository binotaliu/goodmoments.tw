<template>
  <Link
    v-bind="$attrs"
    class="text-blue-500 hover:underline"
  >
    <slot />
  </Link>
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3'
</script>
