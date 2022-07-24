<template>
  <div class="w-full flex flex-col center-center gap-2">
    <h1 class="text-2xl font-semibold">登入</h1>
    <GMCard class="w-full md:w-64 lg:w-80">
      <form
        class="flex flex-col items-stretch justify-center gap-4"
        @submit.prevent="login"
      >
        <GMFormField id="username" name="帳號">
          <template #icon>
            <UserIcon class="w-4 h-4" />
          </template>
          <GMInput
            id="username"
            name="username"
            placeholder="帳號"
            v-model="form.username"
            autofocus
          />
        </GMFormField>

        <GMFormField id="password" name="密碼">
          <template #icon>
            <LockClosedIcon class="w-4 h-4" />
          </template>
          <GMInput
            id="password"
            name="password"
            placeholder="密碼"
            type="password"
            v-model="form.password"
          />
        </GMFormField>

        <GMButton type="submit">
          <GMLoadingText :loading="form.processing">
            登入
          </GMLoadingText>
        </GMButton>

        <div class="flex justify-end">
          <GMLink class="text-sm">忘記密碼？</GMLink>
        </div>
      </form>
    </GMCard>
  </div>
</template>

<script setup>
import Auth from '@/layouts/Auth.vue'
import { useForm } from '@inertiajs/inertia-vue3'
import { UserIcon, LockClosedIcon } from '@heroicons/vue/solid'

defineOptions({
  layout: Auth
})

const form = useForm({
  username: '',
  password: ''
})

const login = async () => {
  await form.post(route('login'))
}
</script>
