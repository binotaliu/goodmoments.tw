<template>
  <InertiaHead title="橫幅列表" />

  <div class="mb-4 flex w-full items-center justify-between">
    <h1 class="text-2xl font-semibold text-wood-600">
      橫幅列表
    </h1>

    <GMLinkButton
      :href="$route('admin.banners.create')"
      class="flex items-center justify-between gap-2"
    >
      <PlusIcon class="h-4 w-4" /> 建立橫幅
    </GMLinkButton>
  </div>

  <GMCard class="w-full">
    <table class="gm-table w-full">
      <thead>
        <tr>
          <th class="w-12">
            #
          </th>
          <th class="w-40">
            圖片
          </th>
          <th>標題</th>
          <th class="w-40">
            狀態/期限
          </th>
          <th class="w-52">
            動作
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="banner in banners.data"
          :key="banner.id"
        >
          <td>{{ banner.id }}</td>
          <td>
            <img
              :src="banner.image?.url"
              :alt="banner.image_description.zh_Hant_TW"
            >
          </td>
          <td>{{ banner.title.zh_Hant_TW }}</td>
          <td>
            <div class="inline-flex w-full flex-col items-center">
              <Popover>
                <PopoverButton
                  v-if="banner.ended_at !== null && $dayjs(banner.ended_at).isSameOrBefore(now)"
                  class="rounded-full bg-gray-100 px-3 py-1 text-sm text-gray-800 outline-none"
                >
                  已截止
                </PopoverButton>

                <PopoverButton
                  v-else-if="$dayjs(banner.started_at).isAfter(now)"
                  class="rounded-full bg-sun-100 px-3 py-1 text-sm text-sun-800 outline-none"
                >
                  尚未開始
                </PopoverButton>

                <PopoverButton
                  v-else
                  class="rounded-full bg-green-100 px-3 py-1 text-sm text-green-800 outline-none"
                >
                  播放中
                </PopoverButton>

                <PopoverPanel class="absolute z-10">
                  <div class="inline-flex flex-col items-center rounded bg-white px-4 py-1 shadow-lg">
                    <span class="text-sm">
                      {{ $dayjs(banner.started_at).local().format('YYYY-MM-DD HH:mm') }}
                    </span>
                    <span class="text-xs">至</span>
                    <span
                      v-if="banner.ended_at === null"
                      class="text-sm"
                    >無期限</span>
                    <span
                      v-else
                      class="text-sm"
                    >
                      {{ $dayjs(banner.ended_at).local().format('YYYY-MM-DD HH:mm') }}
                    </span>
                  </div>
                </PopoverPanel>
              </Popover>
            </div>
          </td>
          <td>
            <div class="flex justify-center gap-2">
              <GMLinkButton
                :href="$route('admin.banners.edit', [banner.id])"
                size="sm"
                class="flex items-center gap-2"
              >
                <EyeIcon class="h-4 w-4" /> 檢視
              </GMLinkButton>
              <GMButton
                size="sm"
                class="flex items-center gap-2"
                @click="showRemoveModal(banner)"
              >
                <TrashIcon class="h-4 w-4" /> 刪除
              </GMButton>
            </div>
          </td>
        </tr>
      </tbody>
    </table>

    <GMPaginator :paginator="banners" />
  </GMCard>

  <Teleport to="body">
    <GMModal
      :open="removeModalOpen"
      title="確定要刪除？"
    >
      確定要刪除這個橫幅嗎？ <br>
      {{ removingBanner?.name?.zh_Hant_TW }} <br>

      <template #footer>
        <div class="flex items-stretch justify-end gap-2">
          <GMButton @click="removeModalOpen = false">
            取消
          </GMButton>
          <GMButton
            theme="danger"
            @click="remove(removingBanner)"
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
import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue'
import { PlusIcon, EyeIcon, TrashIcon } from '@heroicons/vue/solid'
import { useForm } from '@inertiajs/inertia-vue3'
import { onBeforeUnmount, ref } from 'vue'
import dayjs from '@/js/dayjs'

defineProps({
  banners: { type: Object, required: true }
})

const now = ref(dayjs())

const removeModalOpen = ref(false)
const removingBanner = ref(null)

const removeForm = useForm({})

const showRemoveModal = (banner) => {
  removeModalOpen.value = true
  removingBanner.value = banner
}

const remove = (banner) => {
  removeForm.delete(
    route('admin.banners.destroy', [banner.id]),
    {
      onFinish () {
        removeModalOpen.value = false
        removingBanner.value = null
      }
    }
  )
}

const counter = setInterval(() => {
  now.value = new Date()
}, 1000)

onBeforeUnmount(() => {
  clearInterval(counter)
})
</script>
