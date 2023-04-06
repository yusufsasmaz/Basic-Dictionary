<template>
  <AppLayout title="Dictionary">
    <template #header>
      <h2 class="font-semibold text-lg text-gray-800 leading-tight" v-text="`Welcome ${$page.props.auth.user.name}`"></h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="grid grid-flow-col m-4">
            <div><input v-model="search" class="mb-3 rounded-lg bg-transparent border border-indigo-400" type="search" placeholder="Search" name="" id="" /></div>
            <div class="text-end"><Link href="/dictionary/create" class="inline-block rounded border border-green-600 bg-green-600 px-3 py-2 text-sm font-medium text-white hover:bg-transparent hover:text-indigo-600 focus:outline-none focus:ring active:text-indigo-500"> Create</Link></div>
          </div>

          <div class="overflow-x-auto">
            <table class="min-w-full divide-y-2 divide-gray-200 text-sm">
              <thead>
                <tr>
                  <th class="whitespace-nowrap px-4 py-2 text-left font-medium text-gray-900">Italian</th>
                  <th class="whitespace-nowrap px-4 py-2 text-left font-medium text-gray-900">English</th>
                  <th class="whitespace-nowrap px-4 py-2 text-left font-medium text-gray-900">Description</th>
                  <th class="px-4 py-2"></th>
                </tr>
              </thead>

              <tbody class="divide-y divide-gray-200">
                <tr v-for="word in words.data" :key="word.id" class="hover:bg-sky-50">
                  <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{ word.italian }}</td>
                  <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ word.english }}</td>
                  <td class="w-1/2 px-4 py-2 text-gray-700">{{ word.description }}</td>
                  <td class="whitespace-nowrap px-4 py-2 text-end">
                    <span class="inline-flex divide-x overflow-hidden rounded-md border bg-white shadow-sm">
                      <Link :href="`/dictionary/${word.id}/edit`" class="inline-block p-3 text-gray-700 hover:bg-indigo-400 focus:relative">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                      </Link>
                      <button @click="destroy(word.id)" class="inline-block p-3 text-gray-700 hover:bg-red-400 focus:relative">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                      </button>
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <Pagination class="mt-6" :links="words.links" />
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";
import Pagination from "../Components/Pagination.vue";
import Swal from "sweetalert2";

let props = defineProps({
  words: Object,
  filters: String,
});

let search = ref(props.filters);

watch(search, (value) => {
  router.get(
    "/dictionary",
    { search: value },
    {
      preserveState: true,
      replace: true,
    }
  );
});

const Toast = Swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 2000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener("mouseenter", Swal.stopTimer);
    toast.addEventListener("mouseleave", Swal.resumeTimer);
  },
});

function destroy(id) {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    title: 'Are you Sure!',
    imageUrl: '/storage/meow/delete-cat.png',
    imageWidth: 128,
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      router.delete(route("destroy", id));
      Toast.fire({
        icon: "success",
        title: "Deleted successfully",
      });
    }
  });
}

</script>
