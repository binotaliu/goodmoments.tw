<template>
  <InertiaHead title="公舘的食衣住行育樂 – 系統頁面" />

  <div class="mb-4 flex w-full items-center justify-between">
    <h1
      class="text-2xl font-semibold text-wood-600"
    >
      公舘的食衣住行育樂
    </h1>
  </div>

  <form
    :action="$route('admin.pages.life.update')"
    method="post"
    class="flex w-full flex-col gap-4"
    @submit.prevent="submit"
  >
    <GMCard class="flex w-full flex-col gap-8">
      <LifeBlock
        v-for="(block, blockIndex) in form.blocks"
        :key="blockIndex"
        v-model="form.blocks[blockIndex]"
        :index="blockIndex"
        @remove="removeBlock(blockIndex)"
      />

      <div class="flex w-full justify-end">
        <GMButton @click="addBlock">
          <span class="center-center flex">
            <PlusIcon class="h-4 w-4" />
            新增區塊
          </span>
        </GMButton>
      </div>
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

import { CheckIcon, PlusIcon } from '@heroicons/vue/24/outline'
import { useForm } from '@inertiajs/inertia-vue3'
import { onMounted } from 'vue'

import LifeBlock from './internals/LifeBlock.vue'

const props = defineProps({
  blocks: { type: Array, required: true }
})

const form = useForm({
  blocks: []
})

const addBlock = () => {
  form.blocks.push({
    image: null,
    image_description: {
      zh_Hant_TW: ''
    },
    title: {
      zh_Hant_TW: ''
    },
    text: {
      zh_Hant_TW: ''
    },
    text_position: 'left'
  })
}

const removeBlock = (index) => {
  form.blocks.splice(index, 1)
}

const submit = () => {
  form.put(route('admin.pages.life.update'))
}

onMounted(() => {
  form.blocks = clone(props.blocks)
})
</script>
