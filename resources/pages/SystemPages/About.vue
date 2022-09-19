<template>
  <InertiaHead title="關於我們 – 系統頁面" />

  <div class="mb-4 flex w-full items-center justify-between">
    <h1
      class="text-2xl font-semibold text-wood-600"
    >
      關於我們
    </h1>
  </div>

  <form
    :action="$route('admin.pages.about.update')"
    method="post"
    class="flex w-full flex-col gap-4"
    @submit.prevent="submit"
  >
    <GMCard class="flex w-full flex-col gap-2">
      <GMFormField
        id="description"
        name="說明"
      >
        <GMRichEditor v-model="form.description.zh_Hant_TW" />
      </GMFormField>
      <GMFormField
        id="members"
        name="人員"
        class="w-full"
      >
        <div class="flex w-full flex-col gap-4">
          <div
            v-for="(row, rowIndex) in form.members"
            :key="rowIndex"
          >
            <div class="text-wood-700">
              第 {{ rowIndex + 1 }} 行
            </div>
            <div class="mb-2 flex flex-wrap gap-2">
              <template v-if="row.length">
                <div class="grid grid-cols-4 gap-4">
                  <AboutMember
                    v-for="(member, memberIndex) in row"
                    :key="member.id"
                    v-model="proxiedMembers[rowIndex][memberIndex]"
                    @remove="removeMember(rowIndex, memberIndex)"
                  />
                </div>
              </template>
              <div
                v-else
                class="center-center flex h-32 w-full rounded border-2 border-dotted border-wood-500 text-wood-400"
              >
                此行暫無成員，點擊下方「新增一人」以開始編輯。
              </div>
            </div>
            <div class="flex justify-end gap-2">
              <GMButton
                size="sm"
                theme="danger-alt"
                @click="removeRow(rowIndex)"
              >
                <span class="center-center flex gap-1"><MinusIcon class="h-4 w-4" />刪除此行</span>
              </GMButton>
              <GMButton
                size="sm"
                @click="pushMember(rowIndex)"
              >
                <span class="center-center flex gap-1"><UserPlusIcon class="h-4 w-4" />新增一人</span>
              </GMButton>
            </div>
          </div>
        </div>

        <div class="flex justify-end">
          <GMButton @click="addRow">
            <span class="center-center flex gap-1"><PlusIcon class="h-4 w-4" />新增一行</span>
          </GMButton>
        </div>
      </GMFormField>
    </GMCard>

    <div class="flex justify-end">
      <GMButton type="submit">
        <span class="center-center flex gap-1">
          <CheckIcon class="h-4 w-4" />
          送出
        </span>
      </GMButton>
    </div>
  </form>
</template>

<script setup>
import { clone } from '@/js/utils'

import { UserPlusIcon, PlusIcon, MinusIcon, CheckIcon } from '@heroicons/vue/24/outline'
import { useForm } from '@inertiajs/inertia-vue3'
import { computed, onMounted } from 'vue'

import AboutMember from './internals/AboutMember.vue'

const props = defineProps({
  description: { type: String, required: true },
  members: { type: Array, required: true }
})

const form = useForm({
  description: {
    en: '',
    zh_Hant_TW: '',
    zh_Oan: ''
  },
  members: []
})

const pushMember = (rowIndex) => {
  const rowMembers = form.members[rowIndex]
  const maxPriority = Math.max(-1, ...rowMembers.map(({ priority }) => priority))

  form.members[rowIndex].push({
    id: null,
    name: '',
    title: '',
    image: null,
    row: rowIndex,
    priority: maxPriority + 1
  })
}

const removeMember = (rowIndex, memberIndex) => {
  form.members[rowIndex].splice(memberIndex, 1)
}

const addRow = () => {
  form.members.push([])
}

const removeRow = (rowIndex) => {
  form.members.splice(rowIndex, 1)
}

const submit = () => {
  form.put(route('admin.pages.about.update'))
}

const proxiedMembers = computed({
  get: () => clone(form.members),
  set: (value) => {
    const newMembers = clone(value)

    for (const rowIndex in newMembers) {
      const row = newMembers[rowIndex]

      for (const memberIndex in row) {
        const member = row[memberIndex]

        newMembers[rowIndex][memberIndex] = {
          ...member,
          row: Number(rowIndex),
          priority: Number(member.priority)
        }
      }
    }

    form.members = newMembers
  }
})

onMounted(() => {
  form.description.en = clone(props.description.en)
  form.description.zh_Hant_TW = clone(props.description.zh_Hant_TW)
  form.description.zh_Oan = clone(props.description.zh_Oan)
  proxiedMembers.value = clone(props.members)
})
</script>
