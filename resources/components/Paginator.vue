<template>
  <nav role="navigation" aria-label="分頁選單">
    <div class="flex justify-between flex-1 sm:hidden">
      <span
        class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md"
        v-if="isOnFirstPage"
      >
        上一頁
      </span>
      <InertiaLink
        :href="paginator.prev_page_url"
        class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
        v-else
      >
        上一頁
      </InertiaLink>

      <InertiaLink
        :href="paginator.next_page_url"
        class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
        v-if="hasMorePage"
      >
        下一頁
      </InertiaLink>
      <span
        class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md"
        v-else
      >
        下一頁
      </span>
    </div>

    <div class="hidden sm:flex-1 sm:flex sm:flex-col sm:items-center sm:justify-between gap-2">
      <div>
        <p class="text-sm text-gray-700 dark:text-gray-200 leading-5">
          正在顯示
          <template v-if="firstItem">
            <span class="font-medium" v-text="firstItem"></span>
            至
            <span
              class="font-medium"
              v-text="paginator.data.length > 0 ? firstItem + paginator.data.length - 1 : null"
            >
            </span>
          </template>
          <template v-else>
            {{ paginator.total }}
          </template>
          項，共
          <span class="font-medium" v-text="paginator.total"></span>
          項
        </p>
      </div>

      <div>
        <span class="relative z-0 inline-flex shadow-sm rounded-md">
          <span
            aria-disabled="true"
            aria-label="上一頁"
            v-if="isOnFirstPage"
            class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 cursor-default rounded-l-md leading-5"
          >
            <ChevronLeftIcon aria-hidden="true" class="w-4 h-4" />
          </span>
          <InertiaLink
            :href="paginator.prev_page_url"
            rel="prev"
            class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-l-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 dark:active:bg-gray-800 active:text-gray-500 dark:active:text-gray-600 transition ease-in-out duration-150"
            aria-label="上一頁"
            v-else
          >
              <ChevronLeftIcon aria-hidden="tre" class="w-4 h-4" />
          </InertiaLink>

          <template v-for="element in paginator.links">
            <span
              aria-disabled="true"
              class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 dark:text-gray-500 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 cursor-default leading-5"
              v-if="element.url === null"
              v-text="element.label"
            >
            </span>

            <span
              class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-white dark:text-white bg-sun-500 dark:bg-gray-600 border border-gray-300 dark:border-gray-600 cursor-default leading-5"
              aria-current="page"
              v-else-if="element.active"
              v-text="element.label"
            >
            </span>

            <InertiaLink
              :href="element.url"
              class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 leading-5 hover:text-gray-500 hover:text-gray-200 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 dark:active:bg-gray-800 active:text-gray-700 dark:active:text-gray-400 transition ease-in-out duration-150"
              :aria-label="`前往第 ${element.label} 頁`"
              v-text="element.label"
              v-else
            >
            </InertiaLink>
          </template>

          <span
            aria-disabled="true"
            aria-label="下一頁"
            class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 dark:text-gray-300 bg-white dark:bg-gray-700 border border-l-0 border-gray-300 dark:border-gray-600 cursor-default rounded-r-md leading-5"
            v-if="!hasMorePage"
          >
            <ChevronRightIcon aria-hidden="true" class="w-4 h-4" />
          </span>
          <InertiaLink
            :href="paginator.next_page_url"
            rel="next"
            class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 dark:text-gray-300 bg-white dark:bg-gray-700 border border-l-0 border-gray-300 dark:border-gray-600 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 dark:active:bg-gray-800 active:text-gray-500 dark:active:text-gray-600 transition ease-in-out duration-150"
            aria-label="下一頁"
            v-else
          >
              <ChevronRightIcon aria-hidden="true" class="w-4 h-4" />
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
