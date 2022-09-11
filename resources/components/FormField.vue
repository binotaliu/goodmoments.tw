<template>
  <div class="form-field flex flex-col items-start justify-center gap-1">
    <label
      :for="id"
      class="flex items-center justify-start gap-1 text-sm text-gray-400 transition-colors form-field-focus:text-gray-800"
    >
      <span
        v-if="$slots.icon"
        class="center-center inline-flex"
      >
        <slot name="icon" />
      </span>
      {{ name }}
    </label>
    <slot />
    <transition>
      <ul
        v-if="hasErrors"
        class="list-disc pl-6 text-sm text-red-600"
      >
        <li
          v-for="error in errors"
          :key="error"
        >
          {{ error }}
        </li>
      </ul>
    </transition>
  </div>
</template>

<script setup>
import { usePage } from '@inertiajs/inertia-vue3'
import { computed, provide } from 'vue'

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

provide('field-id', computed(() => props.id))
provide('field-name', computed(() => props.name))
provide('field-has-errors', hasErrors)
</script>
