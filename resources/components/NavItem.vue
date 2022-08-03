<template>
  <li>
    <template
      v-if="$slots.contents"
    >
      <a
        href="javascript:void(0)"
        :class="linkClasses"
        @click="showChildren = !showChildren"
      >
        <slot />

        <ChevronUpIcon class="w-4 h-4" v-if="showChildren" />
        <ChevronDownIcon class="w-4 h-4" v-else />
      </a>

      <ul class="pl-4 flex flex-col items-stretch gap-2" v-show="showChildren">
        <slot name="contents" />
      </ul>
    </template>
    <InertiaLink
      v-bind="$attrs"
      :class="linkClasses"
      v-else
    >
      <slot />
    </InertiaLink>
  </li>
</template>

<script setup>
import { Link as InertiaLink } from '@inertiajs/inertia-vue3'
import { computed, ref } from 'vue'
import { ChevronDownIcon, ChevronUpIcon } from '@heroicons/vue/solid'

const props = defineProps({
  active: { type: Boolean, default: false }
})

const linkClasses = computed(() => [
  'w-full',
  'inline-flex justify-between items-center',
  'px-4 py-2',
  'rounded',
  props.active ? 'bg-wood-500 hover:bg-wood-400' : 'hover:bg-ground-100',
  props.active ? 'text-white' : 'text-wood-600',
  'transition-colors'
])

const showChildren = ref(false)
</script>
