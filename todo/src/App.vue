<template>
  <div>
    <AppHeader/>
    <Notification />
    <RouterView/>
    <AppFooter/>
  </div>
</template>

<script setup>
import AppHeader from './components/AppHeader.vue';
import AppFooter from './components/AppFooter.vue';
import Notification from './components/Notification.vue';
</script>

<style scoped>
/* Your styles here */
</style>
