<template>
  <div class="flex flex-col gap-2">
    <div class="mb-2 flex justify-between">
      <h2 class="text-xl font-semibold text-wood-600">
        第 {{ index + 1 }} 區塊
      </h2>
      <GMButton
        theme="danger-alt"
        size="sm"
        @click="$emit('remove')"
      >
        移除第 {{ index + 1 }} 區塊
      </GMButton>
    </div>
    <GMFormField
      :id="`title_${index}`"
      name="標題"
      :error-key="`blocks.${index}.title.zh_Hant_TW`"
    >
      <GMInput v-model="block.title.zh_Hant_TW" />
    </GMFormField>
    <GMFormField
      :id="`text_${index}`"
      name="內容"
      :error-key="`blocks.${index}.text.zh_Hant_TW`"
    >
      <GMTextarea
        v-model="block.text.zh_Hant_TW"
        rows="8"
      />
    </GMFormField>
    <GMFormField
      :id="`image_${index}`"
      name="圖片"
      :error-key="`blocks.${index}.text.zh_Hant_TW`"
    >
      <div class="flex items-end gap-2">
        <div
          v-if="block.image"
          class="w-48"
        >
          <img
            :src="block.image"
            alt="區塊圖片"
          >
        </div>
        <div
          v-else
          class="center-center flex rounded border-2 border-dotted border-pearl-400 px-4 py-6 text-pearl-600"
        >
          尚未選擇圖片
        </div>
        <div>
          <GMButton
            size="sm"
            @click="$refs.fileSelector.select()"
          >
            選擇圖片
          </GMButton>
        </div>
      </div>
    </GMFormField>
    <GMFormField
      :id="`image_alt_${index}`"
      name="圖片替代文字"
      :error-key="`blocks.${index}.image_description.zh_Hant_TW`"
    >
      <GMInput v-model="block.image_description.zh_Hant_TW" />
    </GMFormField>
    <GMFormField
      :id="`image_alt_${index}`"
      name="文字位址"
      :error-key="`blocks.${index}.image_description.zh_Hant_TW`"
    >
      <select
        v-model="block.text_position"
        class="rounded border-gray-100 py-1 px-2 pr-8 text-sm shadow focus:border-wood-300"
      >
        <option value="left">
          文字在左，圖片在右
        </option>
        <option value="right">
          圖片在左，文字在右
        </option>
      </select>
    </GMFormField>

    <FileSelector
      ref="fileSelector"
      @selected="(file) => $refs.imageCropper.open(file)"
    />
    <ImageCropper
      ref="imageCropper"
      :aspect-ratio="1.35"
      :max-width="2048"
      :max-height="2048"
      @cropped="uploadImage"
    />
  </div>
</template>
<script setup>
import FileSelector from '@/components/internals/FileSelector.vue'
import ImageCropper from '@/components/internals/ImageCropper.vue'

import axios from 'axios'
import { computed } from 'vue'

const props = defineProps({
  modelValue: { type: Object, required: true },
  index: { type: [Number, String], required: true }
})

const emits = defineEmits(['update:modelValue', 'remove'])

const block = computed({
  get: () => props.modelValue,
  set: (value) => emits('update:modelValue', value)
})

const uploadImage = async (image) => {
  const formData = new FormData()
  formData.append('image', image)

  const response = await axios.post(route('admin.pages.life.images.store'), formData)

  block.value.image = response.data.url
}
</script>
