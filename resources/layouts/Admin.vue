<template>
  <div class="min-h-screen h-full w-screen max-w-6xl px-6 mx-auto flex items-start justify-between gap-8 md:pt-16 py-8 overflow-x-hidden">
    <header class="w-1/4 flex flex-col items-stretch gap-8">
      <div class="flex flex-col center-center gap-1">
        <GMLogo class="w-16 h-16" />
        <GMTextLogo class="h-8" />
        <h3 class="text-2xl font-semibold text-wood-600">管理面板</h3>
      </div>

      <nav class="px-4">
        <ul class="w-full flex flex-col items-stretch gap-2">
          <GMNavItem>
            <div class="inline-flex items-center gap-2">
              <UsersIcon class="w-4 h-4" />
              使用者
            </div>
            <template #contents>
              <GMNavItem :href="$route('admin.users.index')">
                <div class="inline-flex items-center gap-2">
                  <ViewListIcon class="w-4 h-4" />
                  使用者列表
                </div>
              </GMNavItem>
            </template>
          </GMNavItem>
        </ul>
      </nav>
    </header>

    <section class="w-3/4 flex flex-col items-start justify-center gap-1">
      <slot />

      <footer class="md:mt-16 w-full text-gray-400 text-xs">
        左鎮公舘社區發展協會 &copy; {{ year }}, All Rights Reserved.
      </footer>
    </section>
  </div>
</template>

<script setup>
import { UsersIcon, ViewListIcon } from '@heroicons/vue/solid'
const year = (new Date()).getFullYear()
</script>
