<template>
  <div class="relative">
    <span :class="{ 'opacity-0': loading }">
      <slot />
    </span>

    <div
      class="absolute top-0 left-0 w-full h-full flex center-center"
      :class="{ 'opacity-0': !loading }"
    >
      <div class="animate-spin">
        <GMLoadingIcon class="w-4 h-4" />
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  loading: { type: Boolean, default: false },
})
</script>
