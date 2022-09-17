<template>
  <teleport to="body">
    <GMModal
      ref="modal"
      title="剪裁圖片"
      :closable="false"
    >
      <div class="mb-4">
        <img
          ref="imageEl"
          class="max-h-[50vh] w-auto"
          :src="imageDataUrl"
        >
      </div>

      <div class="flex justify-between">
        <GMButton
          size="sm"
          @click="cropper.rotate(90)"
        >
          <span class="center-center inline-flex gap-1">
            <ArrowUturnLeftIcon class="h-4 w-4" />
            逆時針旋轉
          </span>
        </GMButton>
        <GMButton
          size="sm"
          @click="cropper.rotate(-90)"
        >
          <span class="center-center inline-flex gap-1">
            <ArrowUturnRightIcon class="h-4 w-4" />
            順時針旋轉
          </span>
        </GMButton>
      </div>

      <template #footer>
        <div class="flex items-center justify-end gap-2">
          <GMButton @click="modal.close()">
            取消
          </GMButton>
          <GMButton
            theme="primary"
            @click="save"
          >
            完成
          </GMButton>
        </div>
      </template>
    </GMModal>
  </teleport>
</template>

<script setup>
import { ArrowUturnLeftIcon, ArrowUturnRightIcon } from '@heroicons/vue/24/outline'

import Cropper from 'cropperjs'
import { onBeforeUnmount, ref, watch } from 'vue'

import 'cropperjs/dist/cropper.css'

const props = defineProps({
  aspectRatio: { type: [Number, null], default: null },
  maxHeight: { type: Number, default: null },
  maxWidth: { type: Number, default: null }
})

const emits = defineEmits(['cropped'])

const modal = ref(null)

const file = ref(null)
const imageDataUrl = ref(null)

const imageEl = ref(null)
const cropper = ref(null)

const readFileAsDataUrl = (file) => new Promise((resolve, reject) => {
  const reader = new FileReader()

  reader.onload = (e) => {
    const data = e.target.result
    resolve(data)
  }

  reader.onerror = (e) => {
    const error = e.target.error
    reject(error)
  }

  reader.readAsDataURL(file)
})

const getCanvasBlob = async (canvasElement) => new Promise((resolve) => {
  canvasElement.toBlob((blob) => {
    resolve(blob)
  })
})

const save = async () => {
  const blob = await getCanvasBlob(cropper.value.getCroppedCanvas({
    maxHeight: props.maxHeight,
    maxWidth: props.maxWidth
  }))
  const croppedFile = new File([blob], file.value.name)
  emits('cropped', croppedFile)
  modal.value.close()
}

defineExpose({
  async open (openingFile) {
    file.value = openingFile
    imageDataUrl.value = await readFileAsDataUrl(openingFile)
    modal.value.open()
  }
})

watch(() => [imageEl.value, imageDataUrl.value], ([imageEl, imageDataUrl]) => {
  if (!imageEl || !imageDataUrl) {
    return
  }

  if (cropper.value !== null) {
    cropper.value.destroy()
    cropper.value = null
  }

  cropper.value = new Cropper(imageEl, {
    aspectRatio: props.aspectRatio,
    viewMode: 1
  })
}, { immediate: true })

onBeforeUnmount(() => {
  if (cropper.value !== null) {
    cropper.value.destroy()
    cropper.value = null
  }
})
</script>
