<script setup lang="ts">
import { RouterLink } from 'vue-router';
</script>

<template>
    <footer class="p-4 bg-white md:p-8 lg:p-10 dark:bg-gray-800">
  <div class="mx-auto max-w-screen-xl text-center">
      <RouterLink to="/" class="flex justify-center items-center text-2xl font-semibold text-gray-900 dark:text-white">
          ToNotDo    
      </RouterLink>
      <p class="my-6 text-gray-500 dark:text-gray-400">This app helps you with things you should not be doing :D </p>
      <ul class="flex flex-wrap justify-center items-center mb-6 text-gray-900 dark:text-white">
          <li>
              <a href="#" class="mr-4 hover:underline md:mr-6 ">About</a>
          </li>
          
      </ul>
      <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2021-2022 <a href="#" class="hover:underline">Cornelius</a>. All Rights Reserved.</span>
  </div>
</footer>
</template>