<template>
  <div class="flex min-h-screen w-screen flex-col items-center gap-8 overflow-x-hidden py-8 md:pt-16">
    <header class="center-center flex flex-col gap-1">
      <GMLogo class="h-16 w-16" />
      <GMTextLogo class="h-8" />
    </header>

    <slot />

    <footer class="text-xs text-gray-400 md:mt-16">
      左鎮公舘社區發展協會 &copy; {{ year }}, All Rights Reserved.
    </footer>
  </div>
</template>

<script setup>
const year = (new Date()).getFullYear()
</script>
