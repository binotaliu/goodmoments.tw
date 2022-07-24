<template>
  <div class="min-h-screen h-full min-w-screen flex flex-col items-center gap-8 md:pt-16 py-8 overflow-x-hidden">
    <header class="flex flex-col center-center gap-1">
      <GMLogo class="w-16 h-16" />
      <GMTextLogo class="h-8" />
    </header>

    <slot />

    <footer class="md:mt-16 text-gray-400 text-xs">
      左鎮公舘社區發展協會 &copy; {{ year }}, All Rights Reserved.
    </footer>
  </div>
</template>

<script setup>
const year = (new Date()).getFullYear()
</script>
