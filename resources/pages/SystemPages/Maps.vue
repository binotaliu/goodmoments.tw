<template>
  <InertiaHead title="交通資訊 – 系統頁面" />

  <div class="mb-4 flex w-full items-center justify-between">
    <h1
      class="text-2xl font-semibold text-wood-600"
    >
      交通資訊
    </h1>
  </div>

  <form
    :action="$route('admin.pages.maps.update')"
    method="post"
    class="flex w-full flex-col gap-4"
    @submit.prevent="submit"
  >
    <GMCard class="flex w-full flex-col gap-2">
      <GMFormField
        id="description"
        name="交通資訊說明"
        error-key="description.zh_Hant_TW"
      >
        <GMRichEditor v-model="form.description.zh_Hant_TW" />
      </GMFormField>
    </GMCard>

    <div class="flex justify-end">
      <GMButton type="submit">
        <span class="center-center flex gap-1">
          <CheckIcon class="h-4 w-4" />
          送出
        </span>
      </GMButton>
    </div>
  </form>
</template>
<script setup>
import { clone } from '@/js/utils'

import { CheckIcon } from '@heroicons/vue/24/outline'
import { useForm } from '@inertiajs/inertia-vue3'
import { onMounted } from 'vue'

const props = defineProps({
  description: { type: Object, required: true }
})

const form = useForm({
  description: {
    en: '',
    zh_Hant_TW: '',
    zh_Oan: ''
  }
})

const submit = () => {
  form.put(route('admin.pages.maps.update'))
}

onMounted(() => {
  form.description.en = clone(props.description.en)
  form.description.zh_Hant_TW = clone(props.description.zh_Hant_TW)
  form.description.zh_Oan = clone(props.description.zh_Oan)
})
</script>
