<template>
  <div class="mb-4 flex w-full items-center justify-between">
    <h1 class="text-2xl font-semibold text-wood-600">
      文章列表
    </h1>

    <GMLinkButton
      :href="$route('admin.articles.create')"
      class="flex items-center justify-between gap-2"
    >
      <PlusIcon class="h-4 w-4" /> 建立文章
    </GMLinkButton>
  </div>

  <GMCard class="w-full">
    <table class="gm-table w-full">
      <thead>
        <tr>
          <th class="w-40">
            Slug
          </th>
          <th>標題</th>
          <th class="w-40">
            發佈時間
          </th>
          <th class="w-64">
            動作
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="article in articles.data"
          :key="article.id"
        >
          <td>{{ article.slug }}</td>
          <td>{{ article.title.zh_Hant_TW }}</td>
          <td :title="$dayjs(article.published_at).local().format('YYYY-MM-DD HH:mm:ss')">
            {{ $dayjs(article.published_at).local().format('YYYY-MM-DD HH:mm') }}
          </td>
          <td>
            <div class="flex justify-center gap-2">
              <!--              <GMLinkButton-->
              <!--                :href="$route('articles.show', [article.slug])"-->
              <!--                size="sm"-->
              <!--                class="flex items-center gap-2"-->
              <!--              >-->
              <!--                <ExternalLinkIcon class="h-4 w-4" /> 開啟-->
              <!--              </GMLinkButton>-->
              <GMLinkButton
                :href="$route('admin.articles.edit', [article.id])"
                size="sm"
                class="flex items-center gap-2"
              >
                <EyeIcon class="h-4 w-4" /> 檢視
              </GMLinkButton>
              <GMButton
                size="sm"
                class="flex items-center gap-2"
                @click="showRemoveModal(article)"
              >
                <TrashIcon class="h-4 w-4" /> 刪除
              </GMButton>
            </div>
          </td>
        </tr>
      </tbody>
    </table>

    <GMPaginator :paginator="articles" />
  </GMCard>

  <Teleport to="body">
    <GMModal
      :open="removeModalOpen"
      title="確定要刪除？"
    >
      確定要刪除這篇文章嗎？ <br>
      {{ removingArticle?.name?.zh_Hant_TW }}

      <template #footer>
        <div class="flex items-stretch justify-end gap-2">
          <GMButton @click="removeModalOpen = false">
            取消
          </GMButton>
          <GMButton
            theme="danger"
            @click="remove(removingArticle)"
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
import { PlusIcon, EyeIcon, TrashIcon } from '@heroicons/vue/solid'
import { useForm } from '@inertiajs/inertia-vue3'
import { ref } from 'vue'

defineProps({
  articles: { type: Object, required: true }
})

const removeModalOpen = ref(false)
const removingArticle = ref(null)

const removeForm = useForm({})

const showRemoveModal = (article) => {
  removingArticle.value = article
  removeModalOpen.value = true
}

const remove = (article) => {
  removeForm.delete(
    route('admin.articles.destroy', [article.id]),
    {
      onFinish () {
        removeModalOpen.value = false
        removingArticle.value = null
      }
    }
  )
}
</script>
