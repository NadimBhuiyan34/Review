<!-- File: src/components/TableComponent.vue -->
<template>
  <div class="overflow-x-auto rounded-lg shadow bg-white">
    <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
      <thead class="bg-blue-100">
        <tr>
          <th
            v-for="header in headers"
            :key="header.key"
            class="px-4 py-3 font-semibold text-gray-600"
          >
            {{ header.label }}
          </th>
          <th class="px-4 py-3 font-semibold text-right text-gray-600">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        <tr v-for="row in rows" :key="row.id" class="hover:bg-gray-50 transition">
          <td v-for="header in headers" :key="header.key" class="px-4 py-3">
            <slot :name="header.key" :row="row">
              {{ row[header.key] }}
            </slot>
          </td>
          <td class="px-4 py-3 text-right flex justify-end gap-2">
            <slot name="actions" :row="row" />
          </td>
        </tr>

        <tr v-if="rows.length === 0">
          <td :colspan="headers.length + 1" class="text-center py-6 text-gray-500">
            No data found.
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Pagination -->
    <div v-if="meta" class="flex justify-between items-center px-4 py-3 border-t text-sm text-gray-600 flex-wrap gap-2">
      <div>
        Showing {{ meta.from }} - {{ meta.to }} of {{ meta.total }}
      </div>
      <div class="flex items-center space-x-1">
        <button
          v-if="meta.current_page > 1"
          @click="$emit('paginate', meta.current_page - 1)"
          class="px-3 py-1 border rounded hover:bg-gray-200"
        >
          Prev
        </button>
        <button
          v-for="page in pages"
          :key="page"
          @click="$emit('paginate', page)"
          :class="[
            'px-3 py-1 border rounded',
            page === meta.current_page ? 'bg-blue-600 text-white' : 'hover:bg-gray-200'
          ]"
        >
          {{ page }}
        </button>
        <button
          v-if="meta.current_page < meta.last_page"
          @click="$emit('paginate', meta.current_page + 1)"
          class="px-3 py-1 border rounded hover:bg-gray-200"
        >
          Next
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
interface Header {
  key: string;
  label: string;
}

defineProps<{
  headers: Header[];
  rows: any[];
  meta?: {
    current_page: number;
    last_page: number;
    total: number;
    from: number;
    to: number;
  };
}>();

const emit = defineEmits(['paginate']);

const pages = computed(() => {
  const pageArray = [];
  if (!meta) return [];
  for (let i = 1; i <= meta.last_page; i++) {
    pageArray.push(i);
  }
  return pageArray;
});
</script>
