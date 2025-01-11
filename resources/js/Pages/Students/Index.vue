<script setup>
import MagnifyingGlass from "@/Components/Icons/MagnifyingGlass.vue";
import Pagination from "@/Components/Pagination.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, Head, useForm, router, usePage } from "@inertiajs/vue3";
import { computed, ref, watch } from "vue";

defineProps({
  students: {
    type: Array,
    required: true,
  },
});
const deleteForm = useForm({});

const confirmDelete = (studentId) => {
  if (confirm("Are you sure you want to delete this student?")) {
    deleteForm.delete(route("students.destroy", studentId));
  }
};

let search = ref(usePage().props.search),
  pageNumber = ref(1);

let studentUrl = computed(() => {
  let url = new URL(route("students.index"));
  url.searchParams.append("page", pageNumber.value);
  if (search.value) {
    url.searchParams.append("search", search.value);
  }
  return url.toString();
});
watch(
  () => studentUrl.value,
  (updatedStudentUrl) => {
    router.visit(updatedStudentUrl, {
      replace: true,
      preserveState: true,
      preserveScroll: true,
    });
  }
);
watch(
  () => search.value,
  (value) => {
    if (value) {
      pageNumber.value = 1;
    }
  }
);
const updatePageNumber = (page) => {
  pageNumber.value = page.url.split("=")[1];
};
</script>

<template>
  <Head title="Student List" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Students List
      </h2>
    </template>
    <div class="bg-gray-100 py-10">
      <div class="mx-auto max-w-7xl">
        <!-- Header Section -->
        <div class="px-4 sm:px-6 lg:px-8">
          <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
              <h1 class="text-xl font-semibold text-gray-900">Students</h1>
              <p class="mt-2 text-sm text-gray-700">
                A list of all the Students
              </p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
              <Link
                href="/students/create"
                class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:2-auto"
              >
                Add Student
              </Link>
            </div>
          </div>
        </div>

        <!-- Search Bar -->
        <div
          class="flex flex-col justify-between sm:flex-row mt-6 px-4 sm:px-6 lg:px-8"
        >
          <div class="relative w-full sm:w-1/3">
            <div
              class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-500"
            >
              <MagnifyingGlass />
            </div>
            <input
              type="text"
              v-model="search"
              placeholder="Search students data"
              id="search"
              class="block w-full rounded-lg border-0 py-2 pl-10 text-gray-900 ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
            />
          </div>
        </div>

        <!-- Students Table -->
        <div class="mt-6 px-4 sm:px-6 lg:px-8">
          <div class="overflow-x-auto">
            <table
              class="min-w-full divide-y divide-gray-200 border border-gray-300"
            >
              <thead class="bg-gray-50">
                <tr>
                  <th
                    scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Id
                  </th>
                  <th
                    scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Name
                  </th>
                  <th
                    scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Email
                  </th>
                  <th
                    scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Class
                  </th>
                  <th
                    scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Section
                  </th>
                  <th
                    scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Date
                  </th>
                  <th
                    scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Actions
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="student in students.data" :key="student.id">
                  <td class="px-6 py-4 text-sm text-gray-900">
                    {{ student.id }}
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-900">
                    {{ student.name }}
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-500">
                    {{ student.email }}
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-500">
                    {{ student.class.name }}
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-500">
                    {{ student.section.name }}
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-500">
                    {{ student.created_at }}
                  </td>
                  <td class="px-6 py-4 text-sm">
                    <Link
                      :href="route('students.edit', student.id)"
                      class="text-indigo-600 hover:text-indigo-900"
                    >
                      Edit
                    </Link>
                    <a
                      href="#"
                      class="text-red-600 hover:text-red-900 ml-4"
                      @click="confirmDelete(student.id)"
                    >
                      Delete
                    </a>
                  </td>
                </tr>
                <tr v-if="students.length === 0">
                  <td
                    colspan="4"
                    class="px-6 py-4 text-center text-sm text-gray-500"
                  >
                    No students found.
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Pagination Placeholder -->
        <div class="mt-4 px-4 sm:px-6 lg:px-8">
          <Pagination :data="students" :updatePageNumber="updatePageNumber" />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
