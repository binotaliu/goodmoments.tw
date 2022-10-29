<template>
  <InertiaHead title="待處理聯絡" />

  <GMPageHeader>
    待處理聯絡
  </GMPageHeader>

  <GMMain class="mb-8">
    <GMCard>
      <table class="gm-table w-full">
        <thead>
          <tr>
            <th class="font-semibold w-40">
              大名
            </th>
            <th class="font-semibold">
              主旨
            </th>
            <th class="font-semibold w-40">
              時間
            </th>
            <th class="relative w-24" />
          </tr>
        </thead>

        <tbody>
          <tr
            v-for="entry in contacts.data"
            :key="entry.xid"
          >
            <td>{{ entry.name }}</td>
            <td class="font-medium">
              <span class="line-clamp-1">
                {{ entry.subject }}
              </span>
            </td>
            <td>{{ $dayjs(entry.created_at).format('YYYY-MM-DD HH:mm') }}</td>
            <td class="text-right">
              <div>
                <GMLinkButton
                  :href="$route('admin.contacts.show', entry)"
                  size="sm"
                  class="center-center flex gap-1"
                >
                  <EyeIcon class="h-4 w-4" />
                  檢視
                </GMLinkButton>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </GMCard>
  </GMMain>

  <GMPaginator :paginator="contacts" />
</template>

<script setup>
import { EyeIcon } from '@heroicons/vue/24/outline'

defineProps({
  contacts: { type: Object, required: true }
})
</script>
