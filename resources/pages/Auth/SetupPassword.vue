<template>
  <InertiaHead title="設定密碼" />

  <div class="center-center flex w-full flex-col gap-2">
    <h1 class="text-2xl font-semibold">
      設定密碼
    </h1>
    <GMCard
      class="w-full md:w-64 lg:w-80"
      expanded-on-mobile
    >
      <form
        class="flex flex-col items-stretch justify-center gap-4"
        @submit.prevent="send"
      >
        <GMAlert v-if="status">
          {{ status }}
        </GMAlert>

        <GMFormField
          id="email"
          name="電子郵件"
        >
          <template #icon>
            <EnvelopeIcon class="h-4 w-4" />
          </template>
          <GMInput
            v-model="form.email"
            type="email"
            autofocus
          />
        </GMFormField>

        <GMFormField
          id="password"
          name="新密碼"
        >
          <template #icon>
            <LockClosedIcon class="h-4 w-4" />
          </template>
          <GMInput
            v-model="form.password"
            type="password"
            autocomplete="new-password"
            autofocus
          />
        </GMFormField>

        <GMFormField
          id="password_confirmation"
          name="確認密碼"
        >
          <template #icon>
            <LockClosedIcon class="h-4 w-4" />
          </template>
          <GMInput
            v-model="form.password_confirmation"
            type="password"
            autocomplete="new-password"
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
import { LockClosedIcon, EnvelopeIcon } from '@heroicons/vue/20/solid'
import { watch } from 'vue'

const props = defineProps({
  status: { type: String, default: '' },
  email: { type: String, default: '' },
  url: { type: String, default: '' }
})

defineOptions({
  layout: Auth
})

const form = useForm({
  email: '',
  password: '',
  password_confirmation: ''
})

watch(() => props.email, (email) => {
  form.email = email
}, { immediate: true })

const send = async () => {
  await form.post(props.url)
}
</script>
