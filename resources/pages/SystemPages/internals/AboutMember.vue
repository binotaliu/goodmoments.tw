<template>
  <div class="rounded border p-2 flex flex-col gap-2 center-center">
    <div class="h-16 w-16 group relative rounded-full shadow">
      <img
        :src="value.image.url"
        class="h-16 w-16 rounded-full"
        :alt="`${value.name} 的顯示圖片`"
        v-if="value.image"
      />
      <div
        class="h-16 w-16 rounded-full flex center-center bg-pearl-200"
        v-else
      >
        <UserIcon class="w-6 h-6 text-pearl-700" />
      </div>

      <button
        type="button"
        class="opacity-0 group-hover:opacity-100 transition-opacity left-0 top-0 absolute w-full h-full flex center-center rounded-full bg-black/70 text-white text-xs"
        @click="$refs.fileSelector.select()"
      >
        選擇圖片
      </button>
    </div>
    <GMInput class="text-center" v-model="value.name" placeholder="姓名" />
    <GMInput class="text-center" v-model="value.title" placeholder="職稱" />

    <GMButton theme="danger-alt" size="sm" @click="remove">
      <span class="flex center-center gap-1">
        <TrashIcon class="w-4 h-4" />
        刪除此成員
      </span>
    </GMButton>

    <FileSelector ref="fileSelector" @selected="(file) => $refs.imageCropper.open(file)" />
    <ImageCropper ref="imageCropper" :max-height="1024" :max-width="1024" :aspect-ratio="1" @cropped="uploadImage" />
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
