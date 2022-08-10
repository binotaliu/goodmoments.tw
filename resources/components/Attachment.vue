<template>
  <div class="flex flex-col items-stretch gap-y-2">
    <div class="w-full px-4 py-2 border border-2 border-wood-400 border-dashed rounded">
      <div class="w-full h-28 flex center-center text-wood-400" v-if="previews.length <= 0">尚未選擇</div>

      <div class="w-full flex flex-wrap gap-2" v-else>
        <div
          class="group w-1/3 relative"
          v-for="(preview, i) in previews"
        >
          <div class="border border-gray-100 rounded shadow group-hover:shadow-lg touch:group-hover:shadow transition-shadow relative">
            <div class="rounded overflow-hidden">
              <img :src="preview.url" :alt="preview.filename" />
            </div>

            <div class="absolute w-full h-full left-0 top-0 flex center-center bg-gray-800/30 text-white" v-if="preview.progress < 1">
              <GMLoadingIcon class="w-6 h-6 fill-white/60 animate-spin" />
            </div>
          </div>

          <p class="text-xs text-center">{{ preview.filename }}</p>
          <p class="hidden touch:block text-center mt-2" v-if="preview.processing >= 1">
            <GMButton
              type="button"
              size="sm"
              theme="danger"
              class="inline-flex center-center gap-2"
              @click="remove(i)"
            >
              <TrashIcon class="w-4 h-4" /> 刪除
            </GMButton>
          </p>
          <button
            type="button"
            :class="[
              'absolute',
              'touch:hidden',
              'flex',
              'top-0 right-0',
              '-mr-3 -mt-3',
              'p-1',
              'rounded-full border shadow',
              'bg-white',
              'opacity-0 group-hover:opacity-100',
              'transition-opacity'
            ]"
            @click="remove(i)"
            v-if="preview.processing >= 1"
          >
            <XIcon class="w-4 h-4" />
          </button>
        </div>
      </div>
    </div>

    <div>
      <label
        :for="id"
        :class="[
          'inline-flex center-center gap-2',
          ...buttonStyles.base,
          ...buttonStyles.size.sm,
          ...buttonStyles.theme.DEFAULT,
        ]"
      >
        <FolderIcon class="w-4 h-4" /> 選擇檔案
      </label>
      <input
        :id="id"
        type="file"
        rel="fileInputEl"
        class="hidden"
        @change="handleFileChange"
        :multiple="multiple"
      />
    </div>
  </div>

</template>

<script setup>
/**
 * @see docs/attachments.md
 */

import axios from 'axios'
import { computed, reactive, ref, watch } from 'vue'
import { FolderIcon, TrashIcon, XIcon } from '@heroicons/vue/solid'

import { mapObjectIntoFormData } from '@/js/utils'

import * as buttonStyles from './styles/button'

const props = defineProps({
  id: { type: String, required: true },
  modelValue: { type: [Array, String, null], required: true },
  attachments: { type: Array, required: true },
  processing: { type: Boolean, required: true },
  multiple: { type: Boolean, default: false },
  meta: { type: Object, default: () => ({}) }
})

const emits = defineEmits(['update:modelValue', 'update:attachments', 'update:processing'])

const readFile = (file) => new Promise((accepts, rejects) => {
  const reader = new FileReader()

  reader.onload = (e) => {
    const data = e.target.result
    accepts(data)
  }

  reader.onerror = (e) => {
    const error = e.target.error
    rejects(error)
  }

  reader.readAsDataURL(file)
})

const uploadFile = (file, progressCallback) => {
  const formData = new FormData()
  formData.append('file', file)
  mapObjectIntoFormData(props.meta, 'meta', formData)

  return axios.post(route('admin.attachments.store'), formData, {
    onUploadProgress (event) {
      if (event.lengthComputable) {
        // * 0.9 to indicate that last 10% is for downloading
        progressCallback(event.loaded / event.total * 0.9)
      }
    },
    onDownloadProgress (event) {
      if (event.lengthComputable) {
        // last 10% for downloading
        progressCallback(event.loaded / event.total / 10 + 0.9)
      }
    }
  })
}

const pendingAttachments = ref([])
const previews = ref([])

watch(() => pendingAttachments.value, (attachments) => {
  if (attachments === null || typeof attachments === 'undefined' || attachments?.length <= 0) {
    previews.value = []
    return
  }

  previews.value = attachments.map((attachment) => ({
    filename: attachment.name,
    url: attachment.url,
    uploaded: true,
    progress: 1
  }))
}, { deep: true, immediate: true })

watch(() => props.attachments, (attachments) => {
  pendingAttachments.value = attachments
}, { immediate: true })

const handleFileChange = async (event) => {
  const files = (event.target.files || [])

  if (!files || files.length <= 0) {
    previews.value = []
    return
  }

  if (!props.multiple) {
    previews.value = []

    if (files.length > 1) {
      console.warn(`Component only support 1 file, ${files.length} files given. Only the first file will be uploaded.`)
    }
  }

  const promises = []
  const uploadedAttachments = []

  for (const file of files) {
    const preview = reactive({
      uuid: null,
      filename: file.name,
      url: null,
      uploaded: false,
      progress: 0,
    })

    preview.url = await readFile(file)
    promises.push(uploadFile(file, (progress) => preview.progress = progress)
      .then(({ data }) => {
        preview.uuid = data.uuid
        preview.url = data.url
        preview.uploaded = true
        preview.progress = 1
        uploadedAttachments.push(data)
      }))

    previews.value.push(preview)

    if (!props.multiple) {
      break
    }
  }

  await Promise.allSettled(promises)
  if (props.multiple) {
    pendingAttachments.value.push(...uploadedAttachments)
  } else {
    pendingAttachments.value = uploadedAttachments
  }

  emits('update:attachments', pendingAttachments)

  if (props.multiple) {
    emits('update:modelValue', pendingAttachments.value.map((attachment) => attachment.uuid))
  } else {
    emits('update:modelValue', pendingAttachments.value[0]?.uuid || null)
  }
}

const remove = (uuid) => {
  const previewRemoveIndex = previews.value.findIndex((preview) => preview.uuid === uuid)
  if (previewRemoveIndex !== -1) {
    previews.value.splice(previewRemoveIndex, 1)
  }

  const attachmentsRemoveIndex = pendingAttachments.value.findIndex((attachment) => attachment.uuid === uuid)
  if (attachmentsRemoveIndex !== -1) {
    pendingAttachments.value.splice(attachmentsRemoveIndex, 1)
  }
}
</script>
