<template>
  <TransitionRoot
    appear
    :show="open"
    as="template"
  >
    <Dialog
      as="div"
      class="relative z-10"
      @close="closeModal"
    >
      <TransitionChild
        as="template"
        enter="duration-300 ease-out"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="duration-200 ease-in"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-black/25" />
      </TransitionChild>

      <div class="fixed inset-0 overflow-y-auto">
        <div
          class="flex min-h-full items-center justify-center p-4 text-center"
        >
          <TransitionChild
            as="template"
            enter="duration-300 ease-out"
            enter-from="opacity-0 scale-95"
            enter-to="opacity-100 scale-100"
            leave="duration-200 ease-in"
            leave-from="opacity-100 scale-100"
            leave-to="opacity-0 scale-95"
          >
            <DialogPanel
              :class="[
                'w-full max-w-md',
                'flex flex-col gap-y-8',
                'p-6 rounded-2xl',
                'overflow-hidden',
                'bg-white',
                'text-left align-middle',
                'shadow-xl',
                'transform transition-all',
              ]"
            >
              <DialogTitle
                as="h3"
                class="text-lg font-medium leading-6 text-gray-900"
              >
                <slot
                  v-if="title === null"
                  name="title"
                />
                <span v-else>{{ title }}</span>
              </DialogTitle>

              <div>
                <slot />
              </div>

              <div class="-mx-6 -mb-6 bg-pearl-100 px-6 py-4 text-right">
                <slot name="footer" />
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle } from '@headlessui/vue'

defineProps({
  open: { type: Boolean, default: false },
  title: { type: [String, null], default: () => null }
})

const emits = defineEmits(['close'])

function closeModal () {
  emits('close')
}
</script>
