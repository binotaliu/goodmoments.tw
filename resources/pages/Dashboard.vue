<template>
  <InertiaHead title="首頁" />

  <div class="mb-4 flex w-full items-center justify-between">
    <h1 class="text-2xl font-semibold text-wood-600">
      首頁
    </h1>
  </div>

  <div class="mb-8 grid w-full grid-cols-1 gap-4 md:grid-cols-2 md:gap-8">
    <GMCard class="flex items-center gap-4">
      <div>
        <UserIcon class="h-6 w-6" />
      </div>

      <div>
        您好，<br>
        <span class="text-2xl text-wood-700">{{ $page.props.app.user.name }}</span>
      </div>
    </GMCard>
    <GMCard class="flex items-center gap-4">
      <div>
        <QuestionMarkCircleIcon class="h-6 w-6" />
      </div>

      <div class="grow text-center">
        <GMLinkButton
          href="https://manual.goodmoments.tw/docs/account/"
          target="_blank"
        >
          打開操作手冊
        </GMLinkButton>
      </div>
    </GMCard>
  </div>

  <div class="w-full">
    <h3 class="mb-4 flex items-center gap-1 text-xl font-medium">
      <ChartBarIcon class="h-5 w-5" /> 統計
    </h3>

    <dl class="grid grid-cols-1 gap-6 md:grid-cols-3">
      <GMCard class="flex gap-2">
        <div class="center-center flex w-1/4">
          <NewspaperIcon class="h-8 w-8 text-ground-600" />
        </div>
        <div class="flex grow flex-col justify-between">
          <dt class="text-sm">
            未發表文章數 / 總文章數
          </dt>
          <dt class="text-3xl">
            {{ pendingArticlesCount }} <small class="text-lg">/ {{ articlesCount }}</small>
          </dt>
        </div>
      </GMCard>

      <GMCard class="flex gap-2">
        <div class="center-center flex w-1/4">
          <RectangleStackIcon class="h-8 w-8 text-ground-600" />
        </div>
        <div class="flex grow flex-col justify-between">
          <dt class="text-sm">
            投放中輪播圖片 / 總輪播圖片數
          </dt>
          <dt class="text-3xl">
            {{ activeBannersCount }} <small class="text-lg">/ {{ bannersCount }}</small>
          </dt>
        </div>
      </GMCard>

      <GMCard class="flex gap-2">
        <div class="center-center flex w-1/4">
          <ShoppingBagIcon class="h-8 w-8 text-ground-600" />
        </div>
        <div class="flex grow flex-col justify-between">
          <dt class="text-sm">
            總商品數
          </dt>
          <dt class="text-3xl">
            {{ productsCount }}
          </dt>
        </div>
      </GMCard>
    </dl>
  </div>

  <div
    v-if="support !== null"
    class="w-full"
  >
    <div class="my-16 w-full border-t border-wood-200" />
    <GMCard class="flex items-stretch gap-4">
      <div class="flex flex-col justify-center">
        <InformationCircleIcon class="h-8 w-8" />
      </div>

      <div class="flex grow flex-col items-stretch gap-4 md:flex-row">
        <div class="flex grow flex-col justify-center">
          <h4 class="text-lg font-medium">
            技術支援
          </h4>
          <p
            v-if="isSupported"
            class="text-sm text-wood-600"
          >
            如有任何技術問題，請聯絡我們。
          </p>
          <p
            v-else-if="receivesSecurityPatch"
            class="text-sm text-wood-600"
          >
            目前不再提供技術支援，<br>僅會就網站已知的安全性漏洞進行修補，<br>以避免遭受惡意攻擊。
          </p>
          <p
            v-else
            class="text-sm text-wood-600"
          >
            本網站已停止維護<br>當發現新的安全性漏洞時將不再接收修補程式，<br>可能會有受到惡意軟體攻擊的可能。
          </p>
        </div>

        <div
          class="flex flex-col rounded px-4 py-2 text-center"
          :class="[supportDateBackground]"
        >
          <span>支援有效期限</span>
          <template v-if="isSupported">
            <p class="center-center flex grow text-xl">
              {{ supportedUntil.format('YYYY 年 M 月 D 日') }}
            </p>
            <span class="text-xs">（安全性維護至 {{ $dayjs(securityPatchUntil).format('YYYY 年 M 月 D 日') }}）</span>
          </template>
          <template v-else-if="receivesSecurityPatch">
            <p class="center-center flex grow text-xl">
              僅安全性維護
            </p>
            <span class="text-xs">安全性維護至 {{ $dayjs(securityPatchUntil).format('YYYY 年 M 月 D 日') }}</span>
          </template>
          <template v-else>
            <p class="center-center flex grow text-xl">
              不安全
            </p>
          </template>
        </div>

        <div class="flex flex-col items-center rounded bg-wood-100 px-4 py-2 md:items-start">
          <span class="text-lg">{{ support.name }}</span>
          <p class="mb-1 flex grow items-center gap-1">
            <EnvelopeIcon class="h-4 w-4" /> <a :href="`mailto:?to=${support.email}&subject=${encodeURIComponent(`公舘網站支援 - ${$page.props.app.user.name}`)}&body=${encodeURIComponent(emailTemplate)}`">{{ support.email }}</a>
          </p>
          <p
            v-if="isSupported"
            class="text-xs"
          >
            歡迎來信詢問操作問題或回報 Bug
          </p>
        </div>
      </div>
    </GMCard>
  </div>
</template>

<script setup>
import { RectangleStackIcon, ChartBarIcon, InformationCircleIcon, UserIcon, EnvelopeIcon, NewspaperIcon, QuestionMarkCircleIcon, ShoppingBagIcon } from '@heroicons/vue/24/outline'
import { usePage } from '@inertiajs/inertia-vue3'
import { computed } from 'vue'

const props = defineProps({
  pendingArticlesCount: { type: Number, required: true },
  articlesCount: { type: Number, required: true },
  activeBannersCount: { type: Number, required: true },
  bannersCount: { type: Number, required: true },
  categoriesCount: { type: Number, required: true },
  productsCount: { type: Number, required: true },
  support: { type: Object, required: true }
})

const page = usePage()

const supportedUntil = computed(() => props.support.supportedUntil ? dayjs(props.support.supportedUntil) : null)
const securityPatchUntil = computed(() => props.support.securityPatchUntil ? dayjs(props.support.securityPatchUntil) : null)

const isSupported = computed(() => supportedUntil.value !== null && supportedUntil.value.isAfter(dayjs()))
const receivesSecurityPatch = computed(() => securityPatchUntil.value !== null && securityPatchUntil.value.isAfter(dayjs()))

const supportDateBackground = computed(() => {
  if (supportedUntil.value === null) {
    return 'bg-wood-100'
  }

  if (isSupported.value) {
    return 'bg-wood-100'
  }

  if (receivesSecurityPatch.value || supportedUntil.value.isBefore(dayjs().add(1, 'month'))) {
    return 'bg-orange-100'
  }

  return 'bg-red-100 text-red-900'
})

const emailTemplate = computed(() => `
請詳細描述您遇到的問題。若為 Bug 回報，請說明您的操作步驟，並提供有問題網頁之網址。

來信請保留下列資訊
----
UID: ${page.props.value.app?.user.id}
Browser: ${navigator.userAgent}
Screen Resolution: ${screen.width} x ${screen.height}
Window Resolution: ${window.innerWidth} x ${window.innerHeight}
`)
</script>
