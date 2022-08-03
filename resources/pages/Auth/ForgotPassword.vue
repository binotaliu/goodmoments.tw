<template>
  <div class="w-full flex flex-col center-center gap-2">
    <h1 class="text-2xl font-semibold">忘記密碼</h1>
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

        <GMButton type="submit">
          <GMLoadingText :loading="form.processing">
            重設密碼
          </GMLoadingText>
        </GMButton>
      </form>
    </GMCard>
  </div>
</template>

<script setup>
import Auth from '@/layouts/Auth.vue'
import { useForm } from '@inertiajs/inertia-vue3'
import { MailIcon } from '@heroicons/vue/solid'

defineProps({
  status: { type: String, default: '' },
})

defineOptions({
  layout: Auth
})

const form = useForm({
  email: '',
})

const send = async () => {
  await form.post(route('password.email'))
}
</script>
