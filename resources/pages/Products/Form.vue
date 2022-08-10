<template>
  <div class="w-full flex items-center justify-between mb-4">
    <h1 class="text-2xl font-semibold text-wood-600" v-if="isCreating">建立產品 - {{ category.name.zh_Hant_TW }}</h1>
    <h1 class="text-2xl font-semibold text-wood-600" v-else>編輯產品 - {{ product.name.zh_Hant_TW }} - {{ category.name.zh_Hant_TW }}</h1>
  </div>

  <form
    :action="
      isCreating
      ? $route('admin.categories.products.store', [category.id])
      : $route('admin.categories.products.update', [category.id, product.id])
    "
    method="post"
    @submit.prevent="submit"
    class="w-full flex flex-col gap-4"
  >
    <GMCard class="w-full flex flex-col gap-2">
      <GMFormField id="slug" name="Slug">
        <GMInput id="slug" v-model="form.slug" />
      </GMFormField>
      <GMFormField id="name" error-key="name.zh_Hant_TW" name="名稱">
        <GMInput id="username" v-model="form.name.zh_Hant_TW" />
      </GMFormField>
      <GMFormField id="cover_image" name="封面圖片">
        <GMAttachment
          class="w-full"
          id="cover_image_uuid"
          v-model="form.cover_image_uuid"
          v-model:processing="imageProcessStatus.coverImage"
          v-model:attachments="coverImageAttachments"
          :meta="{ type: 'productCoverImage' }"
        />
      </GMFormField>
      <GMFormField id="images" name="其他圖片">
        <GMAttachment
          class="w-full"
          id="image_uuids"
          v-model="form.image_uuids"
          v-model:processing="imageProcessStatus.images"
          v-model:attachments="form.images"
          :meta="{ type: 'productImages' }"
          multiple
        />
      </GMFormField>
      <GMFormField id="price" name="價格">
        <GMInput id="price" type="number" v-model="form.price" />
      </GMFormField>
      <GMFormField id="unit" error-key="unit.zh_Hant_TW" name="單位">
        <GMInput id="unit" v-model="form.unit.zh_Hant_TW" />
      </GMFormField>
      <GMFormField id="store_url" name="賣場網址">
        <GMInput id="store_url" type="url" v-model="form.store_url" />
      </GMFormField>
      <GMFormField id="store_url_text" error-key="store_url_text.zh_Hant_TW" name="賣場網址連結文字">
        <GMInput id="store_url_text" v-model="form.store_url_text.zh_Hant_TW" />
      </GMFormField>
      <GMFormField id="description" error-key="description.zh_Hant_TW" name="說明">
        <GMTextarea id="description" v-model="form.description.zh_Hant_TW" rows="10" />
      </GMFormField>
    </GMCard>

    <div class="w-full flex justify-end">
      <GMButton type="submit" :disabled="!imageProcessed">
        <GMLoadingText :loading="form.processing">
          <div class="flex center-center gap-2" v-if="isCreating">
            <PlusIcon class="w-4 h-4" /> 新增
          </div>
          <div class="flex center-center gap-2" v-else>
            <SaveIcon class="w-4 h-4" /> 保存
          </div>
        </GMLoadingText>
      </GMButton>
    </div>
  </form>
</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3'

import { PlusIcon, SaveIcon } from '@heroicons/vue/solid'
import { computed, reactive, watch } from 'vue'
import { clone } from '../../js/utils'

const props = defineProps({
  category: { type: [Object, null], default: () => null },
  product: { type: [Object, null], default: () => null }
})

const isCreating = computed(() => props.product === null)

const imageProcessStatus = reactive({
  coverImage: true,
  images: true
})

const imageProcessed = computed(() => {
  return imageProcessStatus.coverImage && imageProcessStatus.images
})

const form = useForm({
  slug: '',
  name: {
    en: null,
    zh_Hant_TW: null,
    zh_Oan: null
  },
  cover_image: null,
  cover_image_uuid: null,
  images: [],
  image_uuids: [],
  price: null,
  unit: {
    en: null,
    zh_Hant_TW: null,
    zh_Oan: null
  },
  store_url: null,
  store_url_text: {
    en: null,
    zh_Hant_TW: null,
    zh_Oan: null
  },
  description: {
    en: null,
    zh_Hant_TW: null,
    zh_Oan: null
  }
})

const coverImageAttachments = computed({
  get () {
    return form.cover_image ? [form.cover_image] : []
  },
  set (coverImageAttachments) {
    form.cover_image = coverImageAttachments[0] ?? null
  }
})

watch(() => props.product, (product, old) => {
  if (product === null) {
    return
  }

  if (product?.id === old?.id) {
    return
  }

  Object.assign(form, clone(product))
}, { immediate: true })

const submit = () => {
  if (isCreating.value) {
    form.post(route('admin.categories.products.store', [props.category.id]))
  } else {
    form.put(route('admin.categories.products.update', [props.category.id, props.product.id]))
  }
}
</script>
