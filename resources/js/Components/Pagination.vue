<template>
  <div
    class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6"
  >
    <div class="flex flex-1 justify-between sm:hidden">
      <button
        @click="changePage(data.meta.current_page - 1)"
        :disabled="data.meta.current_page === 1"
        class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50"
      >
        Previous
      </button>
      <button
        @click="changePage(data.meta.current_page + 1)"
        :disabled="data.meta.current_page === data.meta.last_page"
        class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50"
      >
        Next
      </button>
    </div>
    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
      <div>
        <p class="text-sm text-gray-700">
          Showing
          <span class="font-medium">{{ data.meta.from }}</span>
          to
          <span class="font-medium">{{ data.meta.to }}</span>
          of
          <span class="font-medium">{{ data.meta.total }}</span>
          results
        </p>
      </div>
      <div>
        <nav
          class="isolate inline-flex -space-x-px rounded-md shadow-sm"
          aria-label="Pagination"
        >
          <!-- Dynamic Pagination Links -->
          <span v-for="(page, index) in data.meta.links" :key="index">
            <button
              @click.prevent="updatePageNumber(page)"
              :disabled="page.active || !page.url"
              :class="{
                'z-10 bg-indigo-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600':
                  page.active,
                'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20':
                  !page.active,
              }"
              class="relative inline-flex items-center px-4 py-2 text-sm font-semibold"
              v-html="page.label"
            ></button>
          </span>
        </nav>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ChevronLeftIcon, ChevronRightIcon } from "@heroicons/vue/20/solid";
import { computed } from "vue";
import { router } from "@inertiajs/vue3";

defineProps({
  data: {
    type: Object,
    required: true,
  },
  updatePageNumber: {
    type: Function,
    required: true,
  },
});
</script>
