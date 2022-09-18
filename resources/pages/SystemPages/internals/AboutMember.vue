<template>
  <div class="center-center flex flex-col gap-2 rounded border p-2">
    <div class="group relative h-16 w-16 rounded-full shadow">
      <img
        v-if="value.image"
        :src="value.image.url"
        class="h-16 w-16 rounded-full"
        :alt="`${value.name} 的顯示圖片`"
      >
      <div
        v-else
        class="center-center flex h-16 w-16 rounded-full bg-pearl-200"
      >
        <UserIcon class="h-6 w-6 text-pearl-700" />
      </div>

      <button
        type="button"
        class="center-center absolute left-0 top-0 flex h-full w-full rounded-full bg-black/70 text-xs text-white opacity-0 transition-opacity group-hover:opacity-100"
        @click="$refs.fileSelector.select()"
      >
        選擇圖片
      </button>
    </div>
    <GMInput
      v-model="value.name"
      class="text-center"
      placeholder="姓名"
    />
    <GMInput
      v-model="value.title"
      class="text-center"
      placeholder="職稱"
    />

    <GMButton
      theme="danger-alt"
      size="sm"
      @click="remove"
    >
      <span class="center-center flex gap-1">
        <TrashIcon class="h-4 w-4" />
        刪除此成員
      </span>
    </GMButton>

    <FileSelector
      ref="fileSelector"
      @selected="(file) => $refs.imageCropper.open(file)"
    />
    <ImageCropper
      ref="imageCropper"
      :max-height="1024"
      :max-width="1024"
      :aspect-ratio="1"
      @cropped="uploadImage"
    />
  </div>
</template>

<script setup>
import FileSelector from '@/components/internals/FileSelector.vue'
import ImageCropper from '@/components/internals/ImageCropper.vue'

import { TrashIcon, UserIcon } from '@heroicons/vue/24/outline'
import axios from 'axios'
import { computed } from 'vue'

const props = defineProps({
  modelValue: { type: Object, required: true }
})

const emits = defineEmits(['update:modelValue', 'remove'])

const value = computed({
  get: () => props.modelValue,
  set: (value) => emits('update:modelValue', value)
})

const uploadImage = async (image) => {
  if (!image) {
    return
  }

  const form = new FormData()
  form.append('file', image)
  form.append('meta[type]', 'memberPicture')

  const response = await axios.post(route('admin.attachments.store'), form)

  value.value.image = response.data
}

const remove = () => {
  emits('remove')
}
</script>
