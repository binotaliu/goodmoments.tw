<template>
  <div class="w-full flex items-center justify-between mb-4">
    <h1 class="text-2xl font-semibold text-wood-600">產品列表 - {{ category.name.zh_Hant_TW }}</h1>

    <GMLinkButton
      :href="$route('admin.categories.products.create', [category.id])"
      class="flex items-center justify-between gap-2"
    >
      <PlusIcon class="w-4 h-4" /> 建立產品
    </GMLinkButton>
  </div>

  <GMCard class="w-full">
    <table class="gm-table w-full">
      <thead><tr>
        <th class="w-40">Slug</th>
        <th class="w-40">分類</th>
        <th>名稱</th>
        <th class="w-60">動作</th>
      </tr></thead>
      <tbody>
        <tr v-for="product in products.data">
          <td>{{ product.slug }}</td>
          <td>{{ product.category.name.zh_Hant_TW }}</td>
          <td>{{ product.name.zh_Hant_TW}}</td>
          <td>
            <div class="flex justify-center gap-2">
              <GMLinkButton :href="$route('admin.categories.products.show', [product.category_id, product.id])" size="sm" class="flex items-center gap-2"><EyeIcon class="w-4 h-4" /> 檢視</GMLinkButton>
              <GMButton size="sm" class="flex items-center gap-2"><TrashIcon class="w-4 h-4" /> 刪除</GMButton>
            </div>
          </td>
        </tr>
      </tbody>
    </table>

    <GMPaginator :paginator="products" />
  </GMCard>
</template>
<script setup>
import { PlusIcon, EyeIcon, TrashIcon } from '@heroicons/vue/solid'

defineProps({
  category: { type: [Object, null], required: true },
  products: { type: Object, required: true }
})
</script>
