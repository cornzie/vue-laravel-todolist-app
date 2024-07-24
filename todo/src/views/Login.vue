<template>
  <section class="bg-gray-50 dark:bg-gray-900">
  <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <RouterLink to="/" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
          ToNotDo    
      </RouterLink>
      <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
          <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
              <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                  Sign in to your account
              </h1>
              <form class="space-y-4 md:space-y-6" @submit.prevent="handleSubmit">
                <div class="text-sm font-light text-red-600 dark:text-gray-400" v-if="authenticationError">Error: {{ authenticationError }}</div>
                  <div>
                      <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                      <input v-model="email" type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required="">
                  </div>
                  <div>
                      <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                      <input v-model="password" type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                  </div>
                  <div class="flex items-center justify-between">
                      <div class="flex items-start">
                          <div class="flex items-center h-5">
                            <input id="remember" aria-describedby="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800">
                          </div>
                          <div class="ml-3 text-sm">
                            <label for="remember" class="text-gray-500 dark:text-gray-300">Remember me</label>
                          </div>
                      </div>
                      <a href="#" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">Forgot password?</a>
                  </div>
                  <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Sign in</button>
                  <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                      Don’t have an account yet? <RouterLink to="/register" class="font-medium text-blue-600 hover:underline dark:text-blue-500">Sign up</RouterLink>
                  </p>
              </form>
          </div>
      </div>
  </div>
</section>
</template>

<script setup>
import { ref, computed } from 'vue';
import { RouterLink } from 'vue-router';
import { useStore } from 'vuex';

const email = ref('');
const password = ref('');

const store = useStore();

const authenticating = computed(() => store.getters['auth/authenticating']);
const authenticationError = computed(() => store.getters['auth/authenticationError']);
const authenticationErrorCode = computed(() => store.getters['auth/authenticationErrorCode']);

const login = async (credentials) => {
  const success = await store.dispatch('auth/login', credentials);

  if (success) {
   store.dispatch('notification/addMessage', {
    id: Date.now(),
    type: 'success',
    text: 'Login successful!',
   })
  } else {
    store.dispatch('notification/addMessage', {
      id: Date.now(),
      type: 'error',
      text: store.getters['auth/authenticationError'],
    })
  }
}

const handleSubmit = () => {
  if (email.value !== '' && password.value !== '') {
    login({ email: email.value, password: password.value });
    password.value = '';
  }
};
</script>

<style scoped>

</style>
