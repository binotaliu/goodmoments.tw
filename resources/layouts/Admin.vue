<template>
  <div class="mx-auto flex h-full min-h-screen w-screen max-w-6xl items-start justify-between gap-8 overflow-x-hidden px-6 py-8 md:pt-16">
    <header class="flex w-1/5 flex-col items-stretch gap-8">
      <div class="center-center flex flex-col gap-1">
        <GMLogo class="h-16 w-16" />
        <GMTextLogo class="h-8" />
        <h3 class="text-2xl font-semibold text-wood-600">
          管理面板
        </h3>
      </div>

      <nav class="px-4">
        <ul class="flex w-full flex-col items-stretch gap-2">
          <GMNavItem>
            <div class="inline-flex items-center gap-2">
              <UsersIcon class="h-4 w-4" />
              使用者
            </div>
            <template #contents>
              <GMNavItem :href="$route('admin.users.index')">
                <div class="inline-flex items-center gap-2">
                  <ViewListIcon class="h-4 w-4" />
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
              <PhotographIcon class="h-4 w-4" />
              宣傳
            </div>
            <template #contents>
              <GMNavItem :href="$route('admin.banners.index')">
                <div class="inline-flex items-center gap-2">
                  <CollectionIcon class="h-4 w-4" />
                  橫幅
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
      </nav>
    </header>

    <section class="flex w-4/5 flex-col items-start justify-center gap-1">
      <slot />

      <footer class="w-full text-xs text-gray-400 md:mt-16">
        左鎮公舘社區發展協會 &copy; {{ year }}, All Rights Reserved.
      </footer>
    </section>
  </div>
</template>

<script setup>
import { CollectionIcon, PencilIcon, PhotographIcon, ShoppingBagIcon, TagIcon, UsersIcon, ViewListIcon } from '@heroicons/vue/solid'
const year = (new Date()).getFullYear()
</script>
