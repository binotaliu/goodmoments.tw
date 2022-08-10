<template>
  <div class="w-full flex flex-col center-center gap-2">
    <h1 class="text-2xl font-semibold">設定密碼</h1>
    <GMCard class="w-full md:w-64 lg:w-80">
      <form
        class="flex flex-col items-stretch justify-center gap-4"
        @submit.prevent="send"
      >
        <GMAlert v-if="status">
          {{ status }}
        </GMAlert>

        <GMFormField id="email" name="電子郵件">
          <template #icon>
            <MailIcon class="w-4 h-4" />
          </template>
          <GMInput
            id="email"
            name="email"
            placeholder="電子郵件"
            v-model="form.email"
            autofocus
          />
        </GMFormField>

        <GMFormField id="password" name="新密碼">
          <template #icon>
            <LockClosedIcon class="w-4 h-4" />
          </template>
          <GMInput
            type="password"
            id="password"
            name="password"
            autocomplete="new-password"
            placeholder="新密碼"
            v-model="form.password"
            autofocus
          />
        </GMFormField>

        <GMFormField id="password_confirmation" name="確認密碼">
          <template #icon>
            <LockClosedIcon class="w-4 h-4" />
          </template>
          <GMInput
            type="password"
            id="password_confirmation"
            name="password_confirmation"
            autocomplete="new-password"
            placeholder="確認密碼"
            v-model="form.password_confirmation"
            autofocus
          />
        </GMFormField>

        <GMButton type="submit">
          <GMLoadingText :loading="form.processing">
            設定密碼
          </GMLoadingText>
        </GMButton>
      </form>
    </GMCard>
  </div>
</template>

<script setup>
import Auth from '@/layouts/Auth.vue'
import { useForm } from '@inertiajs/inertia-vue3'
import { LockClosedIcon, MailIcon } from '@heroicons/vue/solid'
import { watch } from 'vue'

const props = defineProps({
  status: { type: String, default: '' },
  email: { type: String, default: '' },
  url: { type: String, default: '' },
})

defineOptions({
  layout: Auth
})

const form = useForm({
  email: '',
  password: '',
  password_confirmation: '',
})

watch(() => props.email, (email) => {
  form.email = email
}, { immediate: true })

const send = async () => {
  await form.post(props.url)
}
</script>
