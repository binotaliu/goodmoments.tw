<template>
  <div class="w-full flex items-center justify-between mb-4">
    <h1 class="text-2xl font-semibold text-wood-600" v-if="isCreating">建立使用者</h1>
    <h1 class="text-2xl font-semibold text-wood-600" v-else>編輯使用者 - {{ user.name }}</h1>
  </div>

  <form
    :action="isCreating ? $route('admin.users.store') : $route('admin.users.update', [user.id])"
    method="post"
    @submit.prevent="submit"
    class="w-full flex flex-col gap-4"
  >
    <GMCard class="w-full flex flex-col gap-2">
      <GMFormField id="name" name="顯示名稱">
        <GMInput id="name" v-model="form.name" />
      </GMFormField>
      <GMFormField id="username" name="帳號">
        <GMInput id="username" v-model="form.username" />
      </GMFormField>
      <GMFormField id="email" name="E-Mail">
        <GMInput id="email" v-model="form.email" type="email" />
      </GMFormField>
      <GMFormField id="is_active" name="啟用">
        <GMCheckbox v-model="form.is_active" label="啟用" id="is_active" />
      </GMFormField>
    </GMCard>

    <div class="w-full flex justify-end">
      <GMButton type="submit">
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

watch(() => props.user, (user) => {
  if (user === null) {
    return
  }

  Object.assign(form, user)
}, { immediate: true })

const submit = () => {
  form.post(isCreating ? route('admin.users.store') : route('admin.users.update'))
}
</script>
