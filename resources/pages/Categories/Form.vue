<template>
  <InertiaHead :title="isCreating ? '建立分類' : `${category.name.zh_Hant_TW} – 編輯分類`" />

  <div class="mb-4 flex w-full items-center justify-between">
    <h1
      v-if="isCreating"
      class="text-2xl font-semibold text-wood-600"
    >
      建立分類
    </h1>
    <h1
      v-else
      class="text-2xl font-semibold text-wood-600"
    >
      編輯分類 - {{ category.name.zh_Hant_TW }}
    </h1>
  </div>

  <form
    :action="isCreating ? $route('admin.categories.store') : $route('admin.categories.update', [category.id])"
    method="post"
    class="flex w-full flex-col gap-4"
    @submit.prevent="submit"
  >
    <GMCard class="flex w-full flex-col gap-2">
      <GMFormField
        id="slug"
        name="Slug"
      >
        <GMInput
          id="slug"
          v-model="form.slug"
        />
      </GMFormField>
      <GMFormField
        id="name"
        error-key="name.zh_Hant_TW"
        name="名稱"
      >
        <GMInput
          id="username"
          v-model="form.name.zh_Hant_TW"
        />
      </GMFormField>
    </GMCard>

    <div class="flex w-full justify-end">
      <GMButton type="submit">
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
import { computed, watch } from 'vue'

const props = defineProps({
  category: { type: [Object, null], default: () => null }
})

const isCreating = computed(() => props.category === null)

const form = useForm({
  slug: '',
  name: {
    en: null,
    zh_Hant_TW: null,
    zh_Oan: null
  }
})

watch(() => props.category, (category, old) => {
  if (category === null) {
    return
  }

  if (category?.id === old?.id) {
    return
  }

  Object.assign(form, category)
}, { immediate: true })

const submit = () => {
  if (isCreating.value) {
    form.post(route('admin.categories.store'))
  } else {
    form.put(route('admin.categories.update', [props.category.id]))
  }
}
</script>
