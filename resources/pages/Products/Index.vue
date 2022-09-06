<template>
  <InertiaHead :title="`產品列表 – ${category.name.zh_Hant_TW}`" />

  <div class="mb-4 flex w-full items-center justify-between">
    <h1 class="text-2xl font-semibold text-wood-600">
      產品列表 - {{ category.name.zh_Hant_TW }}
    </h1>

    <GMLinkButton
      :href="$route('admin.categories.products.create', [category.id])"
      class="flex items-center justify-between gap-2"
    >
      <PlusIcon class="h-4 w-4" /> 建立產品
    </GMLinkButton>
  </div>

  <GMCard class="w-full">
    <table class="gm-table w-full">
      <thead>
        <tr>
          <th class="w-40">
            Slug
          </th>
          <th class="w-40">
            分類
          </th>
          <th>名稱</th>
          <th class="w-64">
            動作
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="product in products.data"
          :key="product.id"
        >
          <td>{{ product.slug }}</td>
          <td>{{ product.category.name.zh_Hant_TW }}</td>
          <td>{{ product.name.zh_Hant_TW }}</td>
          <td>
            <div class="flex justify-center gap-2">
              <GMLinkButton
                :href="$route('categories.products.show', [product.category.slug, product.slug])"
                size="sm"
                class="flex items-center gap-2"
              >
                <ExternalLinkIcon class="h-4 w-4" /> 開啟
              </GMLinkButton>
              <GMLinkButton
                :href="$route('admin.categories.products.update', [product.category_id, product.id])"
                size="sm"
                class="flex items-center gap-2"
              >
                <PencilIcon class="h-4 w-4" /> 編輯
              </GMLinkButton>
              <GMButton
                size="sm"
                class="flex items-center gap-2"
                @click="showRemoveModal(product)"
              >
                <TrashIcon class="h-4 w-4" /> 刪除
              </GMButton>
            </div>
          </td>
        </tr>
      </tbody>
    </table>

    <GMPaginator :paginator="products" />
  </GMCard>

  <Teleport to="body">
    <GMModal
      :open="removeModalOpen"
      title="確定要刪除？"
    >
      確定要刪除這個產品嗎？ <br>
      {{ removingProduct?.name?.zh_Hant_TW }}

      <template #footer>
        <div class="flex items-stretch justify-end gap-2">
          <GMButton @click="removeModalOpen = false">
            取消
          </GMButton>
          <GMButton
            theme="danger"
            @click="remove(removingProduct)"
          >
            <GMLoadingText :loading="removeForm.processing">
              刪除
            </GMLoadingText>
          </GMButton>
        </div>
      </template>
    </GMModal>
  </Teleport>
</template>
<script setup>
import { PencilIcon, PlusIcon, ExternalLinkIcon, TrashIcon } from '@heroicons/vue/solid'
import { useForm } from '@inertiajs/inertia-vue3'
import { ref } from 'vue'

defineProps({
  category: { type: [Object, null], required: true },
  products: { type: Object, required: true }
})

const removeModalOpen = ref(false)
const removingProduct = ref(null)

const removeForm = useForm({})

const showRemoveModal = (product) => {
  removingProduct.value = product
  removeModalOpen.value = true
}

const remove = (product) => {
  removeForm.delete(
    route('admin.categories.products.destroy', [product.category_id, product.id]),
    {
      onFinish () {
        removeModalOpen.value = false
        removingProduct.value = null
      }
    }
  )
}
</script>
