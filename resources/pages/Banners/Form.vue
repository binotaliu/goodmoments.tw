<template>
  <div class="w-full flex items-center justify-between mb-4">
    <h1 class="text-2xl font-semibold text-wood-600" v-if="isCreating">建立橫幅</h1>
    <h1 class="text-2xl font-semibold text-wood-600" v-else>編輯橫幅 - {{ banner.title.zh_Hant_TW }}</h1>
  </div>

  <form
    :action="
      isCreating
      ? $route('admin.banners.store')
      : $route('admin.banners.update', [banner.id])
    "
    method="post"
    @submit.prevent="submit"
    class="w-full flex flex-col gap-4"
  >
    <GMCard class="w-full flex flex-col gap-2">
      <GMFormField id="title" error-key="title.zh_Hant_TW" name="標題">
        <GMInput id="title" v-model="form.title.zh_Hant_TW" />
      </GMFormField>
      <GMFormField id="description" error-key="description.zh_Hant_TW" name="說明">
        <GMTextarea id="description" v-model="form.description.zh_Hant_TW" />
      </GMFormField>
      <GMFormField id="image" name="圖片">
        <GMAttachment
          class="w-full"
          id="image"
          v-model="form.image_uuid"
          v-model:processing="imageProcessing"
          v-model:attachments="attachments"
        />
      </GMFormField>
      <GMFormField id="image_description" error-key="image_description.zh_Hant_TW" name="圖片替代文字">
        <GMInput id="image_description" v-model="form.image_description.zh_Hant_TW" />
      </GMFormField>
      <GMFormField id="url" name="連結網址">
        <GMInput id="url" v-model="form.url" />
      </GMFormField>
      <GMFormField id="started_at" name="開始時間">
        <GMInput
          id="started_at"
          type="datetime-local"
          :model-value="$dayjs(form.started_at).format('YYYY-MM-DDTHH:mm')"
          @update:model-value="(value) => form.started_at = $dayjs(value, 'YYYY-MM-DDTHH:mm').format()"
        />
      </GMFormField>
      <GMFormField id="ended_at" name="結束時間">
        <GMCheckbox
          id="unlimited"
          label="無期限"
          :model-value="form.ended_at === null"
          @update:model-value="(unlimited) => form.ended_at = unlimited ? null : $dayjs(form.started_at).add(1, 'month').format('YYYY-MM-DDTHH:mm')"
        />
        <GMInput
          id="ended_at"
          type="datetime-local"
          :model-value="$dayjs(form.ended_at).format('YYYY-MM-DDTHH:mm')"
          :min="$dayjs(form.started_at).format('YYYY-MM-DDTHH:mm')"
          :disabled="form.ended_at === null"
          @update:model-value="(value) => form.ended_at = $dayjs(value, 'YYYY-MM-DDTHH:mm').format()"
        />
      </GMFormField>
    </GMCard>

    <div class="w-full flex justify-end">
      <GMButton type="submit" :disabled="imageProcessing">
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
import { computed, ref, watch } from 'vue'
import { clone } from '../../js/utils'

const props = defineProps({
  banner: { type: [Object, null], default: () => null }
})

const isCreating = computed(() => props.banner === null)

const imageProcessing = ref(false)

const form = useForm({
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
  image: null,
  image_uuid: null,
  image_description: {
    en: null,
    zh_Hant_TW: null,
    zh_Oan: null
  },
  url: null,
  started_at: null,
  ended_at: null,
})

const attachments = computed({
  get () {
    return form.image ? [form.image] : []
  },
  set (imageAttachments) {
    form.image = imageAttachments[0] ?? null
  }
})

watch(() => props.banner, (banner, old) => {
  if (banner === null) {
    return
  }

  if (banner?.id === old?.id) {
    return
  }

  Object.assign(form, clone(banner))
}, { immediate: true })

const submit = () => {
  if (isCreating.value) {
    form.post(route('admin.banners.store'))
  } else {
    form.put(route('admin.banners.update', [props.banner.id]))
  }
}
</script>
