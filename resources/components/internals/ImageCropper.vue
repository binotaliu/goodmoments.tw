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
            <svg
              class="h-4 w-4"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 24 24"
              fill="currentColor"
            ><path d="M6.758 8.758 5.344 7.344a8.048 8.048 0 0 0-1.841 2.859l1.873.701a6.048 6.048 0 0 1 1.382-2.146zM19 12.999a7.935 7.935 0 0 0-2.344-5.655A7.917 7.917 0 0 0 12 5.069V2L7 6l5 4V7.089a5.944 5.944 0 0 1 3.242 1.669A5.956 5.956 0 0 1 17 13v.002c0 .33-.033.655-.086.977-.007.043-.011.088-.019.131a6.053 6.053 0 0 1-1.138 2.536c-.16.209-.331.412-.516.597a5.954 5.954 0 0 1-.728.613 5.906 5.906 0 0 1-2.277 1.015c-.142.03-.285.05-.43.069-.062.009-.122.021-.184.027a6.104 6.104 0 0 1-1.898-.103L9.3 20.819a8.087 8.087 0 0 0 2.534.136c.069-.007.138-.021.207-.03.205-.026.409-.056.61-.098l.053-.009-.001-.005a7.877 7.877 0 0 0 2.136-.795l.001.001.028-.019a7.906 7.906 0 0 0 1.01-.67c.27-.209.532-.43.777-.675.248-.247.47-.513.681-.785.021-.028.049-.053.07-.081l-.006-.004a7.899 7.899 0 0 0 1.093-1.997l.008.003c.029-.078.05-.158.076-.237.037-.11.075-.221.107-.333.04-.14.073-.281.105-.423.022-.099.048-.195.066-.295.032-.171.056-.344.076-.516.01-.076.023-.15.03-.227.023-.249.037-.5.037-.753.002-.002.002-.004.002-.008zM6.197 16.597l-1.6 1.201a8.045 8.045 0 0 0 2.569 2.225l.961-1.754a6.018 6.018 0 0 1-1.93-1.672zM5 13c0-.145.005-.287.015-.429l-1.994-.143a7.977 7.977 0 0 0 .483 3.372l1.873-.701A5.975 5.975 0 0 1 5 13z" /></svg>
            逆時針旋轉
          </span>
        </GMButton>
        <GMButton
          size="sm"
          @click="cropper.rotate(-90)"
        >
          <span class="center-center inline-flex gap-1">
            <svg
              class="h-4 w-4"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 24 24"
              fill="currentColor"
            ><path d="M16.242 17.242a6.04 6.04 0 0 1-1.37 1.027l.961 1.754a8.068 8.068 0 0 0 2.569-2.225l-1.6-1.201a5.938 5.938 0 0 1-.56.645zm1.743-4.671a5.975 5.975 0 0 1-.362 2.528l1.873.701a7.977 7.977 0 0 0 .483-3.371l-1.994.142zm1.512-2.368a8.048 8.048 0 0 0-1.841-2.859l-1.414 1.414a6.071 6.071 0 0 1 1.382 2.146l1.873-.701zm-8.128 8.763c-.047-.005-.094-.015-.141-.021a6.701 6.701 0 0 1-.468-.075 5.923 5.923 0 0 1-2.421-1.122 5.954 5.954 0 0 1-.583-.506 6.138 6.138 0 0 1-.516-.597 5.91 5.91 0 0 1-.891-1.634 6.086 6.086 0 0 1-.247-.902c-.008-.043-.012-.088-.019-.131A6.332 6.332 0 0 1 6 13.002V13c0-1.603.624-3.109 1.758-4.242A5.944 5.944 0 0 1 11 7.089V10l5-4-5-4v3.069a7.917 7.917 0 0 0-4.656 2.275A7.936 7.936 0 0 0 4 12.999v.009c0 .253.014.504.037.753.007.076.021.15.03.227.021.172.044.345.076.516.019.1.044.196.066.295.032.142.065.283.105.423.032.112.07.223.107.333.026.079.047.159.076.237l.008-.003A7.948 7.948 0 0 0 5.6 17.785l-.007.005c.021.028.049.053.07.081.211.272.433.538.681.785a8.236 8.236 0 0 0 .966.816c.265.192.537.372.821.529l.028.019.001-.001a7.877 7.877 0 0 0 2.136.795l-.001.005.053.009c.201.042.405.071.61.098.069.009.138.023.207.03a8.038 8.038 0 0 0 2.532-.137l-.424-1.955a6.11 6.11 0 0 1-1.904.102z" /></svg>
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
/** !
 * rotate-left, rotate-right from Boxicons.
 * Boxicons.com
 *
 * The MIT License (MIT)
 *
 * Copyright (c) 2015-2021 Aniket Suvarna
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the “Software”),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *   The above copyright notice and this permission notice shall be included
 *   in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

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
