<template>
  <teleport to="body">
    <GMModal
      ref="removeModal"
      :title="title"
    >
      <slot />

      <template #footer>
        <div class="flex items-stretch justify-end gap-2">
          <GMButton @click="removeModal.close()">
            取消
          </GMButton>
          <GMButton
            theme="danger"
            @click="$emit('remove')"
          >
            <GMLoadingText :loading="loading">
              刪除
            </GMLoadingText>
          </GMButton>
        </div>
      </template>
    </GMModal>
  </Teleport>
</template>

<script setup>
import { ref } from 'vue'

defineProps({
  title: { type: String, default: '確定要刪除？' },
  loading: { type: Boolean, default: false }
})

defineEmits(['remove'])

const removeModal = ref(null)

defineExpose({
  open: () => removeModal.value.open(),
  close: () => removeModal.value.close()
})
</script>
