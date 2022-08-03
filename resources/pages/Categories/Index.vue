<template>
  <div class="w-full flex items-center justify-between mb-4">
    <h1 class="text-2xl font-semibold text-wood-600">分類列表</h1>

    <GMLinkButton
      :href="$route('admin.categories.create')"
      class="flex items-center justify-between gap-2"
    >
      <PlusIcon class="w-4 h-4" /> 建立分類
    </GMLinkButton>
  </div>

  <GMCard class="w-full">
    <table class="gm-table w-full">
      <thead><tr>
        <th class="w-40">Slug</th>
        <th>名稱</th>
        <th class="w-60">動作</th>
      </tr></thead>
      <tbody>
        <tr v-for="category in categories.data">
          <td>{{ category.slug }}</td>
          <td>{{ category.name.zh_Hant_TW}}</td>
          <td>
            <div class="flex justify-center gap-2">
              <GMLinkButton :href="$route('admin.categories.show', [category.id])" size="sm" class="flex items-center gap-2"><EyeIcon class="w-4 h-4" /> 檢視</GMLinkButton>
              <GMButton size="sm" class="flex items-center gap-2"><TrashIcon class="w-4 h-4" /> 刪除</GMButton>
            </div>
          </td>
        </tr>
      </tbody>
    </table>

    <GMPaginator :paginator="categories" />
  </GMCard>
</template>
<script setup>
import { PlusIcon, EyeIcon, TrashIcon } from '@heroicons/vue/solid'

defineProps({
  categories: { type: Object, required: true }
})
</script>
