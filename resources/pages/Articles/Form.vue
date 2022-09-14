<template>
  <InertiaHead :title="isCreating ? '建立文章' : `${article.title.zh_Hant_TW} - 編輯文章`" />

  <div class="mb-4 flex w-full items-center justify-between">
    <h1
      v-if="isCreating"
      class="text-2xl font-semibold text-wood-600"
    >
      建立文章
    </h1>
    <h1
      v-else
      class="text-2xl font-semibold text-wood-600"
    >
      編輯文章 - {{ article.title.zh_Hant_TW }}
    </h1>
  </div>

  <form
    :action="
      isCreating
        ? $route('admin.articles.store')
        : $route('admin.articles.update', [article.id])
    "
    method="post"
    class="flex w-full flex-col gap-4"
    @submit.prevent="submit"
  >
    <GMCard class="flex w-full flex-col gap-2">
      <GMFormField
        id="slug"
        name="Slug"
      >
        <GMInput v-model="form.slug" />
      </GMFormField>
      <GMFormField
        id="title"
        error-key="title.zh_Hant_TW"
        name="標題"
      >
        <GMInput v-model="form.title.zh_Hant_TW" />
      </GMFormField>
      <GMFormField
        id="description"
        error-key="description.zh_Hant_TW"
        name="簡介"
      >
        <GMTextarea v-model="form.description.zh_Hant_TW" />
      </GMFormField>
      <GMFormField
        id="published_at"
        error-key="published_at"
        name="發佈時間"
      >
        <GMDateTimeInput v-model="form.published_at" />
      </GMFormField>
      <GMFormField
        id="cover_image"
        name="封面圖片"
      >
        <GMImageAttachment
          id="cover_image"
          v-model="form.cover_image"
          :aspect-ratio="2"
          :max-width="2880"
          class="w-full"
          :meta="{ type: 'articleCoverImage' }"
        />
      </GMFormField>
      <GMFormField
        id="social_image"
        name="社群圖片"
      >
        <GMImageAttachment
          id="social_image"
          v-model="form.social_image"
          :aspect-ratio="2"
          :max-width="1280"
          class="w-full"
          :meta="{ type: 'articleSocialImage' }"
        />
      </GMFormField>
      <GMFormField
        id="content"
        name="文章內容"
        error-key="content.zh_Hant_TW"
      >
        <GMRichEditor v-model="form.content.zh_Hant_TW" />
      </GMFormField>
    </GMCard>

    <div class="flex w-full justify-end">
      <GMButton
        type="submit"
        :disabled="!imageProcessed"
      >
        <GMLoadingText :loading="form.processing">
          <div
            v-if="isCreating"
            class="center-center flex gap-2"
          >
            <PlusIcon class="h-4 w-4" /> 新增
          </div>
          <div
            v-else
            class="center-center flex gap-2"
          >
            <SaveIcon class="h-4 w-4" /> 保存
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
  article: { type: [Object, null], default: () => null }
})

const isCreating = computed(() => props.article === null)

const imageProcessStatus = reactive({
  coverImage: true,
  socialImage: true
})

const imageProcessed = computed(() => {
  return imageProcessStatus.coverImage && imageProcessStatus.socialImage
})

const form = useForm({
  slug: '',
  title: {
    en: null,
    zh_Hant_TW: null,
    zh_Oan: null
  },
  description: {
    en: null,
    zh_Hant_TW: null,
    zh_Oan: null
  },
  published_at: null,
  cover_image: null,
  cover_image_uuid: null,
  social_image: null,
  social_image_uuid: null,
  content: {
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

const socialImageAttachments = computed({
  get () {
    return form.cover_image ? [form.cover_image] : []
  },
  set (socialImageAttachments) {
    form.cover_image = socialImageAttachments[0] ?? null
  }
})

watch(() => props.article, (article, old) => {
  if (article === null) {
    return
  }

  if (article?.id === old?.id) {
    return
  }

  Object.assign(form, clone(article))
}, { immediate: true })

const submit = () => {
  if (isCreating.value) {
    form.post(route('admin.articles.store'))
  } else {
    form.put(route('admin.articles.update', [props.article.id]))
  }
}
</script>
