<template>
  <div class="mb-4 flex w-full items-center justify-between">
    <h1 class="text-2xl font-semibold text-wood-600">
      分類列表
    </h1>

    <GMLinkButton
      :href="$route('admin.categories.create')"
      class="flex items-center justify-between gap-2"
    >
      <PlusIcon class="h-4 w-4" /> 建立分類
    </GMLinkButton>
  </div>

  <GMCard class="w-full">
    <table class="gm-table w-full">
      <thead>
        <tr>
          <th class="w-40">
            Slug
          </th>
          <th>名稱</th>
          <th class="w-80">
            動作
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="category in categories.data"
          :key="category.id"
        >
          <td>{{ category.slug }}</td>
          <td>{{ category.name.zh_Hant_TW }}</td>
          <td>
            <div class="flex justify-center gap-2">
              <GMLinkButton
                :href="$route('admin.categories.products.index', [category.id])"
                size="sm"
                class="flex items-center gap-2"
              >
                <ShoppingBagIcon class="h-4 w-4" /> 產品列表
              </GMLinkButton>
              <GMLinkButton
                :href="$route('admin.categories.show', [category.id])"
                size="sm"
                class="flex items-center gap-2"
              >
                <EyeIcon class="h-4 w-4" /> 檢視
              </GMLinkButton>
              <GMButton
                size="sm"
                class="flex items-center gap-2"
                @click="showRemoveModal(category)"
              >
                <TrashIcon class="h-4 w-4" /> 刪除
              </GMButton>
            </div>
          </td>
        </tr>
      </tbody>
    </table>

    <GMPaginator :paginator="categories" />
  </GMCard>

  <Teleport to="body">
    <GMModal
      :open="removeModalOpen"
      title="確定要刪除？"
    >
      確定要刪除這個分類嗎？ <br>
      {{ removingCategory?.name?.zh_Hant_TW }} <br>

      刪除分類也會一併刪除其中所有產品，確定要刪除嗎？ <br>

      <template #footer>
        <div class="flex items-stretch justify-end gap-2">
          <GMButton @click="removeModalOpen = false">
            取消
          </GMButton>
          <GMButton
            theme="danger"
            @click="remove(removingCategory)"
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
import { PlusIcon, ShoppingBagIcon, EyeIcon, TrashIcon } from '@heroicons/vue/solid'
import { useForm } from '@inertiajs/inertia-vue3'
import { ref } from 'vue'

defineProps({
  categories: { type: Object, required: true }
})

const removeModalOpen = ref(false)
const removingCategory = ref(null)

const removeForm = useForm({})

const showRemoveModal = (category) => {
  removeModalOpen.value = true
  removingCategory.value = category
}

const remove = (category) => {
  removeForm.delete(
    route('admin.categories.destroy', [category.id]),
    {
      onFinish () {
        removeModalOpen.value = false
        removingCategory.value = null
      }
    }
  )
}

</script>
