<template>
  <nav
    role="navigation"
    aria-label="分頁選單"
  >
    <div class="flex flex-1 justify-between sm:hidden">
      <span
        v-if="isOnFirstPage"
        class="relative inline-flex cursor-default items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-500"
      >
        上一頁
      </span>
      <InertiaLink
        v-else
        :href="paginator.prev_page_url"
        class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-700 ring-gray-300 transition duration-150 ease-in-out hover:text-gray-500 focus:border-blue-300 focus:outline-none focus:ring active:bg-gray-100 active:text-gray-700"
      >
        上一頁
      </InertiaLink>

      <InertiaLink
        v-if="hasMorePage"
        :href="paginator.next_page_url"
        class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-700 ring-gray-300 transition duration-150 ease-in-out hover:text-gray-500 focus:border-blue-300 focus:outline-none focus:ring active:bg-gray-100 active:text-gray-700"
      >
        下一頁
      </InertiaLink>
      <span
        v-else
        class="relative ml-3 inline-flex cursor-default items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-500"
      >
        下一頁
      </span>
    </div>

    <div class="hidden gap-2 sm:flex sm:flex-1 sm:flex-col sm:items-center sm:justify-between">
      <div>
        <p class="text-sm leading-5 text-gray-700 dark:text-gray-200">
          正在顯示
          <template v-if="firstItem">
            <span
              class="font-medium"
              v-text="firstItem"
            />
            至
            <span
              class="font-medium"
              v-text="paginator.data.length > 0 ? firstItem + paginator.data.length - 1 : null"
            />
          </template>
          <template v-else>
            {{ paginator.total }}
          </template>
          項，共
          <span
            class="font-medium"
            v-text="paginator.total"
          />
          項
        </p>
      </div>

      <div>
        <span class="relative z-0 inline-flex rounded-md shadow-sm">
          <span
            v-if="isOnFirstPage"
            aria-disabled="true"
            aria-label="上一頁"
            class="relative inline-flex cursor-default items-center rounded-l-md border border-gray-300 bg-white p-2 text-sm font-medium leading-5 text-gray-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300"
          >
            <ChevronLeftIcon
              aria-hidden="true"
              class="h-4 w-4"
            />
          </span>
          <InertiaLink
            v-else
            :href="paginator.prev_page_url"
            rel="prev"
            class="relative inline-flex items-center rounded-l-md border border-gray-300 bg-white p-2 text-sm font-medium leading-5 text-gray-500 ring-gray-300 transition duration-150 ease-in-out hover:text-gray-400 focus:z-10 focus:border-blue-300 focus:outline-none focus:ring active:bg-gray-100 active:text-gray-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:active:bg-gray-800 dark:active:text-gray-600"
            aria-label="上一頁"
          >
            <ChevronLeftIcon
              aria-hidden="tre"
              class="h-4 w-4"
            />
          </InertiaLink>

          <template v-for="element in paginator.links">
            <span
              v-if="element.url === null"
              :key="element.label"
              aria-disabled="true"
              class="relative -ml-px inline-flex cursor-default items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-700 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-500"
              v-text="element.label"
            />

            <span
              v-else-if="element.active"
              :key="element.label"
              class="relative -ml-px inline-flex cursor-default items-center border border-gray-300 bg-wood-500 px-4 py-2 text-sm font-medium leading-5 text-white dark:border-gray-600 dark:bg-gray-600 dark:text-white"
              aria-current="page"
              v-text="element.label"
            />

            <InertiaLink
              v-else
              :key="element.label"
              :href="element.url"
              class="relative -ml-px inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-700 ring-gray-300 transition duration-150 ease-in-out hover:text-gray-200 focus:z-10 focus:border-blue-300 focus:outline-none focus:ring active:bg-gray-100 active:text-gray-700 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:active:bg-gray-800 dark:active:text-gray-400"
              :aria-label="`前往第 ${element.label} 頁`"
            >{{ element.label }}</InertiaLink>
          </template>

          <span
            v-if="!hasMorePage"
            aria-disabled="true"
            aria-label="下一頁"
            class="relative inline-flex cursor-default items-center rounded-r-md border border-l-0 border-gray-300 bg-white p-2 text-sm font-medium leading-5 text-gray-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300"
          >
            <ChevronRightIcon
              aria-hidden="true"
              class="h-4 w-4"
            />
          </span>
          <InertiaLink
            v-else
            :href="paginator.next_page_url"
            rel="next"
            class="relative inline-flex items-center rounded-r-md border border-l-0 border-gray-300 bg-white p-2 text-sm font-medium leading-5 text-gray-500 ring-gray-300 transition duration-150 ease-in-out hover:text-gray-400 focus:z-10 focus:border-blue-300 focus:outline-none focus:ring active:bg-gray-100 active:text-gray-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:active:bg-gray-800 dark:active:text-gray-600"
            aria-label="下一頁"
          >
            <ChevronRightIcon
              aria-hidden="true"
              class="h-4 w-4"
            />
          </InertiaLink>
        </span>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { computed } from 'vue'
import { Link as InertiaLink } from '@inertiajs/inertia-vue3'

import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/solid'

const props = defineProps({
  paginator: { type: Object, required: true }
})

const isOnFirstPage = computed(() => props.paginator.current_page <= 1)
const hasMorePage = computed(() => props.paginator.current_page < props.paginator.last_page)

const firstItem = computed(() => props.paginator.data.length > 0 ? (props.paginator.current_page - 1) * props.paginator.per_page + 1 : null)
</script>
