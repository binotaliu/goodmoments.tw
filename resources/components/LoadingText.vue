<template>
  <div class="relative">
    <span :class="{ 'opacity-0': loading }">
      <slot />
    </span>

    <div
      class="center-center absolute top-0 left-0 flex h-full w-full"
      :class="{ 'opacity-0': !loading }"
    >
      <div class="animate-spin">
        <GMLoadingIcon class="h-4 w-4" />
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  loading: { type: Boolean, default: false }
})
</script>
