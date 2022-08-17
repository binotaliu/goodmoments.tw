<template>
  <div class="mb-4 flex w-full items-center justify-between">
    <h1
      v-if="isCreating"
      class="text-2xl font-semibold text-wood-600"
    >
      建立使用者
    </h1>
    <h1
      v-else
      class="text-2xl font-semibold text-wood-600"
    >
      編輯使用者 - {{ user.name }}
    </h1>
  </div>

  <form
    :action="isCreating ? $route('admin.users.store') : $route('admin.users.update', [user.id])"
    method="post"
    class="flex w-full flex-col gap-4"
    @submit.prevent="submit"
  >
    <GMCard class="flex w-full flex-col gap-2">
      <GMFormField
        id="name"
        name="顯示名稱"
      >
        <GMInput
          id="name"
          v-model="form.name"
        />
      </GMFormField>
      <GMFormField
        id="username"
        name="帳號"
      >
        <GMInput
          id="username"
          v-model="form.username"
        />
      </GMFormField>
      <GMFormField
        id="email"
        name="E-Mail"
      >
        <GMInput
          id="email"
          v-model="form.email"
          type="email"
        />
      </GMFormField>
      <GMFormField
        id="is_active"
        name="啟用"
      >
        <GMCheckbox
          id="is_active"
          v-model="form.is_active"
          label="啟用"
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
  user: { type: [Object, null], default: () => null }
})

const isCreating = computed(() => props.user === null)

const form = useForm({
  username: '',
  name: '',
  email: '',
  is_active: true
})

watch(() => props.user, (user, old) => {
  if (user === null) {
    return
  }

  if (user?.id === old?.id) {
    return
  }

  Object.assign(form, user)
}, { immediate: true })

const submit = () => {
  if (isCreating.value) {
    form.post(route('admin.users.store'))
  } else {
    form.put(route('admin.users.update', [props.user.id]))
  }
}
</script>
