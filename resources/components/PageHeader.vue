<template>
  <div class="mb-4 flex w-full items-center justify-between">
    <h1 class="grow text-2xl font-semibold text-wood-600">
      <slot />
    </h1>

    <div class="flex items-center gap-2">
      <slot name="actions" />
    </div>
  </div>
</template>

<script setup>

</script>
