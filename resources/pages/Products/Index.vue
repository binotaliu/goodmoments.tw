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

  <div class="mb-8 w-full overflow-x-auto">
    <div class="min-w-[1024px]">
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
                    as="a"
                    :href="$route('categories.products.show', [product.category.slug, product.slug])"
                    target="_blank"
                    size="sm"
                    class="flex items-center gap-2"
                  >
                    <ArrowTopRightOnSquareIcon class="h-4 w-4" /> 開啟
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
      </GMCard>
    </div>
  </div>

  <GMPaginator :paginator="products" />

  <Teleport to="body">
    <GMModal
      ref="removeModal"
      title="確定要刪除？"
    >
      確定要刪除這個產品嗎？ <br>
      <span class="font-medium">{{ removingProduct?.name?.zh_Hant_TW }}</span>

      <template #footer>
        <div class="flex items-stretch justify-end gap-2">
          <GMButton @click="removeModal.close()">
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
import { PencilIcon, PlusIcon, ArrowTopRightOnSquareIcon, TrashIcon } from '@heroicons/vue/20/solid'
import { useForm } from '@inertiajs/inertia-vue3'
import { ref } from 'vue'

defineProps({
  category: { type: [Object, null], required: true },
  products: { type: Object, required: true }
})

const removeModal = ref(null)
const removingProduct = ref(null)

const removeForm = useForm({})

const showRemoveModal = (product) => {
  removingProduct.value = product
  removeModal.value.open()
}

const remove = (product) => {
  removeForm.delete(
    route('admin.categories.products.destroy', [product.category_id, product.id]),
    {
      onFinish () {
        removeModal.value.close()
        removingProduct.value = null
      }
    }
  )
}
</script>
