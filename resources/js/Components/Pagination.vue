<template>
  <div>
    <Component
      :is="link.url ? 'Link' : 'span'"
      v-for="link in links"
      :key="link"
      :href="link.url"
      v-html="link.label"
      class="px-2 py-1  hover:bg-slate-600 hover:text-white hover:rounded-lg"
      :class="{ 
        'cursor-not-allowed': !link.url, ' font-semibold bg-slate-600 text-white  rounded-lg': link.active }"
    />
  </div>
</template>

<script setup>

let props = defineProps({
  links: Array,
});
</script>
