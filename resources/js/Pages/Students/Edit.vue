<template>
  <Head title="Edit Create" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Edit Student
      </h2>
    </template>

    <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md mt-6">
      <h2 class="text-2xl font-bold mb-6">Edit Student</h2>
      <form @submit.prevent="updateForm">
        <div class="mb-4">
          <label for="name" class="block text-gray-700">Name</label>
          <input
            type="text"
            id="name"
            v-model="form.name"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"
            :class="{
              'border-red-500 focus:ring-red-500 focus:border-red-500 border-red-300':
                form.errors.name,
            }"
          />
          <InputError :message="form.errors.name" class="mt-2" />
        </div>
        <div class="mb-4">
          <label for="email" class="block text-gray-700">Email</label>
          <input
            type="email"
            id="email"
            v-model="form.email"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"
            :class="{
              'border-red-500 focus:ring-red-500 focus:border-red-500 border-red-300':
                form.errors.email,
            }"
          />
          <InputError :message="form.errors.email" class="mt-2" />
        </div>
        <div class="mb-4">
          <label for="class" class="block text-gray-700">Class</label>
          <select
            id="class"
            v-model="form.class_id"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"
            :class="{
              'border-red-500 focus:ring-red-500 focus:border-red-500 border-red-300':
                form.errors.class_id,
            }"
          >
            <option value="" disabled>Select a class</option>
            <option
              v-for="classOption in classes.data"
              :key="classOption.id"
              :value="classOption.id"
            >
              {{ classOption.name }}
            </option>
          </select>
          <InputError :message="form.errors.class" class="mt-2" />
        </div>
        <div class="mb-4">
          <label for="section" class="block text-gray-700">Section</label>
          <select
            id="section"
            v-model="form.section_id"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"
            :class="{
              'border-red-500 focus:ring-red-500 focus:border-red-500 border-red-300':
                form.errors.section_id,
            }"
          >
            <option value="" disabled>Select a section</option>
            <option
              v-for="sectionOption in sections.data"
              :key="sectionOption.id"
              :value="sectionOption.id"
            >
              {{ sectionOption.name }}
            </option>
          </select>
          <InputError :message="form.errors.section_id" class="mt-2" />
        </div>
        <div class="flex justify-end">
          <button
            type="submit"
            class="bg-blue-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-600"
          >
            Update
          </button>
        </div>
      </form>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, usePage } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import axios from "axios";
import { onMounted, ref, watch } from "vue";

defineProps({
  classes: {
    type: Object,
    requried: true,
  },
});

const student = usePage().props.student.data;
const form = useForm({
  name: student.name,
  email: student.email,
  class_id: student.class.id,
  section_id: student.section.id,
});

const sections = ref({});
watch(
  () => form.class_id,
  (value) => {
    if (value) {
      getSections(value);
    }
  }
);

const getSections = (classId) => {
  axios.get("/api/sections?class_id=" + classId).then((response) => {
    sections.value = response.data;
  });
};
const updateForm = () => {
  form.put(route("students.update", student.id));
};
onMounted(() => {
  getSections(form.class_id);
});
</script>

