<template>
  <InertiaHead title="登入" />

  <div class="center-center flex w-full flex-col gap-2">
    <h1 class="text-2xl font-semibold">
      登入
    </h1>
    <GMCard
      class="w-full md:w-64 lg:w-80"
      expanded-on-mobile
    >
      <form
        class="flex flex-col items-stretch justify-center gap-4"
        @submit.prevent="login"
      >
        <GMAlert v-if="$page.props.flash.message">
          {{ $page.props.flash.message }}
        </GMAlert>

        <GMFormField
          id="username"
          name="帳號"
        >
          <template #icon>
            <UserIcon class="h-4 w-4" />
          </template>
          <GMInput
            v-model="form.username"
            autofocus
          />
        </GMFormField>

        <GMFormField
          id="password"
          name="密碼"
        >
          <template #icon>
            <LockClosedIcon class="h-4 w-4" />
          </template>
          <GMInput
            v-model="form.password"
            type="password"
          />
        </GMFormField>

        <GMButton type="submit">
          <GMLoadingText :loading="form.processing">
            登入
          </GMLoadingText>
        </GMButton>

        <div class="flex justify-end">
          <GMLink
            :href="$route('password.request')"
            class="text-sm"
          >
            忘記密碼？
          </GMLink>
        </div>
      </form>
    </GMCard>
  </div>
</template>

<script setup>
import Auth from '@/layouts/Auth.vue'
import { useForm } from '@inertiajs/inertia-vue3'
import { UserIcon, LockClosedIcon } from '@heroicons/vue/20/solid'

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
