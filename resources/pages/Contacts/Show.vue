<template>
  <InertiaHead :title="`${contact.subject} by ${contact.name} – 檢視聯絡單#${contact.id}`" />

  <GMPageHeader>
    <span class="mr-2">{{ contact.subject }}</span>
    <small class="text-sm">– 檢視聯絡單#{{ contact.id }}</small>
  </GMPageHeader>

  <GMMain>
    <GMCard>
      <dl class="grid grid-cols-[max-content_auto]">
        <dt class="p-4 py-4 text-right font-semibold border-b">
          大名
        </dt>
        <dd class="p-4 border-b flex items-center">
          {{ contact.name }}
        </dd>

        <dt class="p-4 py-4 text-right font-semibold border-b">
          聯絡方式
        </dt>
        <dd class="p-4 border-b flex items-center">
          {{ contact.contact_method }}
        </dd>

        <dt class="p-4 py-4 text-right font-semibold border-b">
          E-Mail
        </dt>
        <dd class="p-4 border-b flex items-center">
          <GMLink
            :href="`mailto:${contact.email}`"
          >
            {{ contact.email }}
          </GMLink>
        </dd>

        <dt class="p-4 py-4 text-right font-semibold">
          內文
        </dt>
        <dd class="p-4 flex items-center">
          {{ contact.content }}
        </dd>
      </dl>
    </GMCard>
  </GMMain>
</template>

<script setup>
defineProps({
  contact: { type: Object, required: true }
})

</script>
