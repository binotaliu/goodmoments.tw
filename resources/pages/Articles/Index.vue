<template>
  <InertiaHead title="文章列表" />

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

  <div class="mb-8 w-full overflow-x-auto">
    <div class="min-w-[1024px]">
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
                  <!--                <ArrowTopRightOnSquareIcon class="h-4 w-4" /> 開啟-->
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
      </GMCard>
    </div>
  </div>

  <GMPaginator :paginator="articles" />

  <GMRemoveModal
    ref="removeModal"
    :loading="removeForm.processing"
    @remove="remove(removingArticle)"
  >
    確定要刪除這篇文章嗎？ <br>
    <span class="font-medium">{{ removingArticle?.title?.zh_Hant_TW }}</span> <br>
  </GMRemoveModal>
</template>
<script setup>
import { PlusIcon, EyeIcon, TrashIcon } from '@heroicons/vue/20/solid'
import { useForm } from '@inertiajs/inertia-vue3'
import { ref } from 'vue'

defineProps({
  articles: { type: Object, required: true }
})

const removeModal = ref(null)
const removingArticle = ref(null)

const removeForm = useForm({})

const showRemoveModal = (article) => {
  removingArticle.value = article
  removeModal.value.open()
}

const remove = (article) => {
  removeForm.delete(
    route('admin.articles.destroy', [article.id]),
    {
      onFinish () {
        removeModal.value.close()
        removingArticle.value = null
      }
    }
  )
}
</script>
