<template>
  <div
    v-if="status === 'created'"
    class="center-center text-xs rounded-full px-2 py-px border border-red-400 inline-flex gap-1 text-red-700"
  >
    <div class="inline-block rounded-full w-3 h-3 bg-red-500" />
    待處理
  </div>
  <div
    v-else-if="status === 'processing'"
    class="center-center text-xs rounded-full px-2 py-px border border-yellow-600 inline-flex gap-1 text-yellow-700"
  >
    <div class="inline-block rounded-full w-3 h-3 bg-yellow-500" />
    待處理
  </div>
  <div
    v-else-if="status === 'resolved'"
    class="center-center text-xs rounded-full px-2 py-px border border-gray-600 inline-flex gap-1 text-gray-700"
  >
    <div class="inline-block rounded-full w-3 h-3 bg-gray-500" />
    完成
  </div>
</template>

<script setup>
defineProps({
  status: { type: [String, null], required: true }
})
</script>
