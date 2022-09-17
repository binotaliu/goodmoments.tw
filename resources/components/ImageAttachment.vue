<template>
  <div class="flex flex-col items-stretch gap-y-2">
    <div class="w-full rounded border-2 border-dashed border-wood-400 px-4 py-2">
      <div
        v-if="!hasImages"
        class="center-center flex h-28 w-full text-wood-400"
      >
        尚未選擇
      </div>
      <div
        v-else
        class="flex w-full flex-wrap gap-2"
      >
        <div
          v-for="attachment in previews"
          :key="attachment.uuid"
          class="group relative w-1/2 md:w-1/3"
        >
          <div
            class="
              relative
              rounded
              border border-gray-100
              shadow transition-all
              group-hover:shadow-lg
              touch:group-hover:shadow
              motion-safe:group-hover:scale-[1.01]
            "
          >
            <div class="overflow-hidden rounded">
              <img
                :src="attachment.url"
                :alt="attachment.name"
                @click="handleImageClick(attachment)"
              >

              <div
                v-if="attachment.processing"
                class="
                  center-center
                  absolute
                  left-0 top-0
                  flex h-full w-full
                  bg-gray-800/30
                  text-white
                "
              >
                <GMLoadingIcon class="h-6 w-6 animate-spin fill-white/60" />
              </div>
            </div>
          </div>

          <p class="text-center text-xs">
            {{ attachment.name }}
          </p>
          <p class="mt-2 hidden text-center touch:block">
            <GMButton
              type="button"
              size="sm"
              theme="danger"
              class="center-center inline-flex gap-2"
              @click="remove(attachment)"
            >
              <TrashIcon class="h-4 w-4" /> 刪除
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
            @click="remove(attachment)"
          >
            <XMarkIcon class="h-4 w-4" />
          </button>
        </div> <!-- /attachment -->
      </div>
    </div>

    <div>
      <GMButton
        class="center-center inline-flex gap-2"
        size="sm"
        @click="$refs.fileSelector.select()"
      >
        <FolderIcon class="h-4 w-4" />
        <span v-if="multiple && hasImages">
          新增檔案
        </span>
        <span v-else>
          選擇檔案
        </span>
      </GMButton>
    </div>

    <teleport to="body">
      <ImageCropper
        ref="imageCropper"
        :aspect-ratio="aspectRatio"
        :max-height="maxHeight"
        :max-width="maxWidth"
        @cropped="addImage"
      />

      <FileSelector
        ref="fileSelector"
        @selected="cropFile"
      />
    </teleport>
  </div>
</template>

<script setup>
/**
 * @see docs/attachments.md
 */

import { uuid4 } from '@/js/utils'
import { FolderIcon, TrashIcon, XMarkIcon } from '@heroicons/vue/20/solid'
import axios from 'axios'
import { serialize as serializeToFormData } from 'object-to-formdata'
import { computed, ref } from 'vue'

import FileSelector from './internals/FileSelector.vue'
import ImageCropper from './internals/ImageCropper.vue'

const props = defineProps({
  id: { type: String, required: true },
  modelValue: { type: [Array, Object, null], required: true },
  multiple: { type: Boolean, default: false },
  meta: { type: Object, default: () => ({}) },
  aspectRatio: { type: [Number, null], default: null },
  maxHeight: { type: [Number, null], default: null },
  maxWidth: { type: [Number, null], default: null }
})

const emits = defineEmits(['update:modelValue', 'image-click'])

const processingFiles = ref([])
const isProcessing = computed(() => processingFiles.value.length > 0)
const imageCropper = ref(null)

const previews = computed(() => {
  return [
    ...(props.multiple ? props.modelValue : [props.modelValue])
      .filter((a) => a)
      .map((attachment) => ({ ...attachment, processing: false })),
    ...(
      processingFiles
        .value
        .map(({ uuid, file }) => ({
          uuid,
          url: getFileUrl(file),
          name: file.name,
          processing: true
        }))
    )
  ]
})

const hasImages = computed(() => {
  return previews.value.length > 0
})

const cropFile = (dataUrl) => {
  imageCropper.value.open(dataUrl)
}

const addImage = async (croppedFile) => {
  const form = new FormData()
  form.append('file', croppedFile)

  const attachment = await uploadImage(croppedFile)
  if (attachment === null) {
    return
  }

  append(attachment)
}

const uploadImage = async (file) => {
  const uuid = uuid4()
  try {
    processingFiles.value.push({ uuid, file })

    const { data: attachment } = await axios.post(
      route('admin.attachments.store'),
      serializeToFormData({
        file,
        meta: props.meta
      }),
      {
        headers: {
          'Content-Type': 'multipart/form-encoded'
        }
      }
    )

    return attachment
  } catch (e) {
    console.error(e)

    return null
  } finally {
    processingFiles.value = processingFiles.value.filter(
      (processingFile) => processingFile.uuid !== uuid
    )
  }
}

const append = (attachment) => {
  if (props.multiple) {
    emits('update:modelValue', [...(props.modelValue || []), attachment])
    return
  }

  emits('update:modelValue', attachment)
}

const remove = (attachment) => {
  if (props.multiple) {
    emits('update:modelValue', [...(props.modelValue || []).filter(({ uuid }) => uuid !== attachment.uuid)])
    return
  }

  emits('update:modelValue', null)
}

const getFileUrl = (file) => {
  return URL.createObjectURL(file)
}

const handleImageClick = (attachment) => {
  if (attachment.processing) {
    return
  }

  emits('image-click', attachment)
}

defineExpose({
  remove,
  append,
  hasImages,
  processing: isProcessing
})
</script>
