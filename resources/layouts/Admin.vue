<template>
  <div class="mx-auto flex h-full min-h-screen w-screen max-w-6xl flex-col items-start justify-between gap-8 overflow-x-hidden md:flex-row md:px-6 md:py-8 md:pt-16">
    <header
      class="flex w-full flex-col items-stretch gap-4 bg-white md:w-1/5 md:gap-8 md:bg-transparent md:pb-0"
      :class="{ 'pb-8': showMenu }"
    >
      <div class="flex items-center justify-between px-4 md:flex-col md:justify-center md:gap-8 md:px-0">
        <div class="center-center flex gap-4 py-4 md:flex-col md:gap-1 md:py-0">
          <GMLogo class="h-12 w-12 md:h-16 md:w-16" />
          <GMTextLogo class="hidden md:inline md:h-8" />
          <h3 class="text-base font-semibold text-wood-600 md:text-2xl">
            管理面板
          </h3>
        </div>

        <div class="md:hidden">
          <button
            type="button"
            class="rounded border border-pearl-800 px-3 py-2 text-pearl-800 transition-colors hover:bg-pearl-100"
            aria-label="展開選單"
            @click="showMenu = !showMenu"
          >
            <Bars3Icon class="h-6 w-6" />
          </button>
        </div>
      </div>

      <div
        class="mx-4 items-center justify-between gap-x-2 rounded border border-pearl-600 px-6 py-2 md:mx-0 md:flex"
        :class="[ showMenu ? 'flex' : 'hidden' ]"
      >
        <img
          :src="$page.props.app.user.avatar_url"
          class="h-8 w-8 rounded-full"
          :alt="`${$page.props.app.user.name} 的顯示圖片`"
        >
        <div class="flex grow items-center justify-between md:flex-col md:items-start md:justify-center">
          <span class="text-lg font-medium">{{ $page.props.app.user.name }}</span>
          <div class="flex w-full justify-between">
            <a
              :href="$route('index')"
              class="-m-2 p-2 text-base text-pearl-800 underline transition-colors hover:text-pearl-700 hover:no-underline md:text-xs"
              target="_blank"
            >
              打開前台
            </a>
            <button
              type="button"
              class="-m-2 p-2 text-base text-pearl-800 underline transition-colors hover:text-pearl-700 hover:no-underline md:text-xs"
              @click="logout"
            >
              登出
            </button>
          </div>
        </div>
      </div>

      <nav
        class="px-4 md:block"
        :class="[ showMenu ? 'block' : 'hidden' ]"
      >
        <ul class="flex w-full flex-col items-stretch gap-2">
          <GMNavItem :href="$route('admin.dashboard')">
            <div class="inline-flex items-center gap-2">
              <HomeIcon class="h-4 w-4" />
              首頁
            </div>
          </GMNavItem>
          <GMNavItem>
            <div class="inline-flex items-center gap-2">
              <UsersIcon class="h-4 w-4" />
              使用者
            </div>
            <template #contents>
              <GMNavItem :href="$route('admin.users.index')">
                <div class="inline-flex items-center gap-2">
                  <Bars4Icon class="h-4 w-4" />
                  使用者列表
                </div>
              </GMNavItem>
            </template>
          </GMNavItem>
        </ul>
        <ul class="flex w-full flex-col items-stretch gap-2">
          <GMNavItem>
            <div class="inline-flex items-center gap-2">
              <ShoppingBagIcon class="h-4 w-4" />
              商品
            </div>
            <template #contents>
              <GMNavItem :href="$route('admin.categories.index')">
                <div class="inline-flex items-center gap-2">
                  <TagIcon class="h-4 w-4" />
                  分類列表
                </div>
              </GMNavItem>
            </template>
          </GMNavItem>
        </ul>
        <ul class="flex w-full flex-col items-stretch gap-2">
          <GMNavItem>
            <div class="inline-flex items-center gap-2">
              <PhotoIcon class="h-4 w-4" />
              宣傳
            </div>
            <template #contents>
              <GMNavItem :href="$route('admin.banners.index')">
                <div class="inline-flex items-center gap-2">
                  <RectangleStackIcon class="h-4 w-4" />
                  輪播圖片
                </div>
              </GMNavItem>
              <GMNavItem :href="$route('admin.articles.index')">
                <div class="inline-flex items-center gap-2">
                  <PencilIcon class="h-4 w-4" />
                  文章
                </div>
              </GMNavItem>
            </template>
          </GMNavItem>
        </ul>
        <ul class="flex w-full flex-col items-stretch gap-2">
          <GMNavItem>
            <div class="inline-flex items-center gap-2">
              <DocumentDuplicateIcon class="h-4 w-4" />
              系統頁面
            </div>
            <template #contents>
              <GMNavItem :href="$route('admin.pages.about.edit')">
                <div class="inline-flex items-center gap-2">
                  <UsersIcon class="h-4 w-4" />
                  關於我們
                </div>
              </GMNavItem>
              <GMNavItem :href="$route('admin.pages.life.edit')">
                <div class="inline-flex items-center gap-2">
                  <HeartIcon class="h-4 w-4 shrink-0" />
                  食衣住行育樂
                </div>
              </GMNavItem>
              <GMNavItem :href="$route('admin.pages.maps.edit')">
                <div class="inline-flex items-center gap-2">
                  <MapIcon class="h-4 w-4" />
                  交通資訊
                </div>
              </GMNavItem>
            </template>
          </GMNavItem>
        </ul>
      </nav>
    </header>

    <section class="flex w-full flex-col items-start justify-center px-6 md:w-4/5 md:px-0">
      <slot />

      <footer class="my-8 w-full text-center text-xs text-gray-400 md:mb-0 md:mt-16 md:text-left">
        左鎮公舘社區發展協會 &copy; {{ year }}, All Rights Reserved.
      </footer>
    </section>
  </div>
</template>

<script setup>
import { DocumentDuplicateIcon, RectangleStackIcon, HomeIcon, Bars3Icon, PencilIcon, PhotoIcon, ShoppingBagIcon, TagIcon, UsersIcon, Bars4Icon, MapIcon, HeartIcon } from '@heroicons/vue/24/outline'
import { Inertia } from '@inertiajs/inertia'
import { ref } from 'vue'

const year = (new Date()).getFullYear()

const showMenu = ref(false)

const logout = () => {
  Inertia.post(route('logout'))
}
</script>
