<template>
  <InertiaHead :title="`${contact.subject} by ${contact.name} – 檢視聯絡單#${contact.id}`" />

  <GMPageHeader>
    <StatusBadge :status="contact.status" /> <br>
    <span class="mr-2">{{ contact.subject }}</span>
    <small class="text-sm">– 檢視聯絡單#{{ contact.id }}</small>
  </GMPageHeader>

  <GMMain>
    <GMCard class="mb-8">
      <dl class="grid grid-cols-[max-content_auto]">
        <dt class="p-4 py-4 text-right font-semibold border-b">
          大名
        </dt>
        <dd class="p-4 border-b flex items-center">
          {{ contact.name }}
        </dd>

        <dt class="p-4 py-4 text-right font-semibold border-b">
          聯絡方式
        </dt>
        <dd class="p-4 border-b flex items-center">
          {{ contact.contact_method }}
        </dd>

        <dt class="p-4 py-4 text-right font-semibold border-b">
          E-Mail
        </dt>
        <dd class="p-4 border-b flex items-center">
          <GMLink
            :href="`mailto:${contact.email}`"
          >
            {{ contact.email }}
          </GMLink>
        </dd>

        <dt class="p-4 py-4 text-right font-semibold">
          內文
        </dt>
        <dd class="p-4 flex items-center">
          {{ contact.content }}
        </dd>
      </dl>
    </GMCard>

    <h3 class="font-semibold text-wood-600 text-lg mb-2">
      留言
      <small class="text-sm">（留言僅後台可見）</small>
    </h3>

    <GMCard
      v-if="contact.comments.length > 0"
      class="mb-4"
    >
      <div class="grid grid-cols-[max-content_auto]">
        <template
          v-for="comment in contact.comments"
          :key="comment.id"
        >
          <dl class="text-right p-4">
            <dt class="sr-only">
              留言者
            </dt>
            <dd class="flex justify-end items-center gap-2">
              <div class="rounded-full w-8 h-8 overflow-hidden">
                <img
                  :src="comment.user.avatar_url"
                  class="w-full h-full"
                >
              </div>
              {{ comment.user.name }}
            </dd>

            <dt class="sr-only">
              建立時間
            </dt>
            <dd class="text-xs">
              {{ $dayjs(comment.created_at).format('YYYY-MM-DD HH:mm') }}
            </dd>
          </dl>

          <dl class="py-4">
            <dt class="sr-only">
              留言內容
            </dt>
            <dd>{{ comment.content }}</dd>
          </dl>
        </template>
      </div>
    </GMCard>
    <GMCard v-else>
      <div class="center-center py-36 flex text-wood-400">
        無留言
      </div>
    </GMCard>

    <form
      :action="$route('admin.contacts.comments.store', contact)"
      method="post"
      @submit.prevent="addComment"
    >
      <h3 class="font-semibold text-wood-600 text-lg mb-2">
        新增留言
      </h3>
      <GMCard>
        <GMFormField
          id="contact-comment"
          error-key="content"
          name="留言"
          class="mb-4"
        >
          <GMTextarea
            v-model="commentForm.content"
            name="content"
            rows="12"
          />
        </GMFormField>

        <div
          v-if="contact.status === 'resolved'"
          class="flex justify-end gap-4"
        >
          <GMButton
            type="submit"
            class="center-center flex gap-1"
          >
            <EnvelopeIcon class="h-4 w-4" />
            新增留言並標記為處理中
          </GMButton>
          <GMButton
            class="center-center flex gap-1"
            @click="addComment({ resolved: true })"
          >
            <PlusIcon class="h-4 w-4" />
            新增留言
          </GMButton>
        </div>
        <div
          v-else
          class="flex justify-end gap-4"
        >
          <GMButton
            class="center-center flex gap-1"
            @click="addComment({ resolved: true })"
          >
            <EnvelopeOpenIcon class="w-4 h-4" />
            新增留言並標註為完成
          </GMButton>
          <GMButton
            type="submit"
            class="center-center flex gap-1"
          >
            <PlusIcon class="h-4 w-4" />
            新增留言
          </GMButton>
        </div>
      </GMCard>
    </form>
  </GMMain>
</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3'
import { EnvelopeIcon, EnvelopeOpenIcon, PlusIcon } from '@heroicons/vue/24/solid'

import StatusBadge from './Partials/StatusBadge.vue'

const props = defineProps({
  contact: { type: Object, required: true }
})

const commentForm = useForm({
  content: ''
})

const addComment = ({ resolved = false }) => {
  commentForm
    .transform((data) => ({
      ...data,
      resolved
    }))
    .post(
      route('admin.contacts.comments.store', props.contact),
      {
        onFinish: () => {
          commentForm.reset()
        }
      }
    )
}
</script>
