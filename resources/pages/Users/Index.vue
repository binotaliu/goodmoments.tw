<template>
  <div class="mb-4 flex w-full items-center justify-between">
    <h1 class="text-2xl font-semibold text-wood-600">
      使用者列表
    </h1>

    <GMLinkButton
      :href="$route('admin.users.create')"
      class="flex items-center justify-between gap-2"
    >
      <PlusIcon class="h-4 w-4" /> 建立使用者
    </GMLinkButton>
  </div>

  <GMCard class="w-full">
    <table class="gm-table w-full">
      <thead>
        <tr>
          <th class="w-40">
            名稱
          </th>
          <th class="w-40">
            帳號
          </th>
          <th>電子郵件</th>
          <th class="w-16 text-center">
            啟用
          </th>
          <th class="w-60">
            動作
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="user in users.data"
          :key="user.id"
        >
          <td>{{ user.name }}</td>
          <td>{{ user.username }}</td>
          <td>{{ user.email }}</td>
          <td v-if="user.is_active">
            <p class="center-center flex">
              <CheckIcon class="h-4 w-4" />
            </p>
          </td>
          <td v-else />
          <td>
            <div class="flex justify-center gap-2">
              <GMLinkButton
                :href="$route('admin.users.show', [user.id])"
                size="sm"
                class="flex items-center gap-2"
              >
                <EyeIcon class="h-4 w-4" /> 檢視
              </GMLinkButton>
              <GMButton
                size="sm"
                class="flex items-center gap-2"
              >
                <TrashIcon class="h-4 w-4" /> 刪除
              </GMButton>
            </div>
          </td>
        </tr>
      </tbody>
    </table>

    <GMPaginator :paginator="users" />
  </GMCard>
</template>
<script setup>
import { CheckIcon, PlusIcon, EyeIcon, TrashIcon } from '@heroicons/vue/solid'

defineProps({
  users: { type: Object, required: true }
})
</script>
