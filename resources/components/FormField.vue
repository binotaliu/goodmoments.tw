<template>
  <div class="form-field flex flex-col items-start justify-center gap-1">
    <label :for="id" class="flex justify-start items-center gap-1 text-gray-400 form-field-focus:text-gray-800 text-sm transition-colors">
      <span class="inline-flex center-center" v-if="$slots.icon">
        <slot name="icon" />
      </span>
      {{ name }}
    </label>
    <slot />
    <transition>
      <ul class="list-disc pl-6 text-red-600 text-sm" v-if="hasErrors">
        <li v-for="error in errors" :key="error">{{ error }}</li>
      </ul>
    </transition>
  </div>
</template>

<script setup>
import { usePage } from '@inertiajs/inertia-vue3'
import { computed } from 'vue'

const props = defineProps({
  id: { type: String, required: true },
  errorKey: { type: [String, null], default: null },
  name: { type: String, required: true },
  errorBag: { type: [String, null], default: null }
})

const errors = computed(() => {
  const pageErrors = usePage().props.value.errors

  const errorBag = props.errorBag === null ? pageErrors : pageErrors[props.errorBag]
  const errors = errorBag[props.errorKey || props.id]

  if ((errors || null) === null) {
    return []
  }

  if (typeof errors === 'string') {
    return [errors]
  }

  return errors
})

const hasErrors = computed(() => errors.value.length > 0)
</script>
