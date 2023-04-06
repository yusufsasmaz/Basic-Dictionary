<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add an Italian Word or Phrase</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="mx-auto max-w-screen-xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-lg text-center">
              <h1 class="text-2xl font-bold sm:text-3xl">Continuare a imparare</h1>

            </div>

            <form @submit.prevent="submit" class="mx-auto mt-8 mb-0 max-w-md space-y-4">
              <div>
                <label for="italian" class="sr-only">Italian</label>

                <div class="relative">
                  <input v-model="form.italian" id="italian" type="text" class="w-full rounded-lg border-gray-200 p-4 pr-12 text-sm shadow-sm" placeholder="Italian" />
                  <div v-if="form.errors.italian" v-text="form.errors.italian" class="block mb-2 text-sm font-medium text-red-700 dark:text-red-500"></div>

                </div>
              </div>

              <div>
                <label for="english" class="sr-only">english</label>

                <div class="relative">
                  <input v-model="form.english" id="english" type="text" class="w-full rounded-lg border-gray-200 p-4 pr-12 text-sm shadow-sm" placeholder="English" />
                  <div v-if="form.errors.english" v-text="form.errors.english" class="block mb-2 text-sm font-medium text-red-700 dark:text-red-500"></div>
                </div>
              </div>
              <div>
                <label for="description" class="sr-only">description</label>

                <div class="relative">
                  <textarea v-model="form.description" id="description" class="w-full rounded-lg border-gray-200 p-4 pr-12 text-sm shadow-sm" rows="5" cols="50" 
                  placeholder="Description" />
                </div>
              </div>

              <div class="flex items-center justify-between">

                <button type="submit" :disabled="form.prossesing" class="inline-block rounded-lg bg-blue-500 px-5 py-3 text-sm font-medium text-white"> + Add</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/vue3";
import Swal from "sweetalert2";

const Toast = Swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener("mouseenter", Swal.stopTimer);
    toast.addEventListener("mouseleave", Swal.resumeTimer);
  },
});

let form = useForm({
  italian: null,
  english: null,
  description: null,
});

function submit() {
  form.post('/dictionary/store', {
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
      Toast.fire({
        icon: "success",
        title: "Created successfully",
      });
    },
  });
}


</script>