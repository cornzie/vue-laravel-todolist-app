import { createApp } from 'vue'
import './style.css'
import './index.css'
import App from './App.vue'
import { initFlowbite } from 'flowbite'
import router from './router'
import store from './store';

import ApiService from './services/api.services'
// import { TokenService } from './services/storage.services'

import { TokenService } from './services/storage.services'

createApp(App)
    .use(router)
    .use(store)
    .mount('#app')

// initialize components based on data attribute selectors
initFlowbite()

// Set the base URL of the API
ApiService.init(import.meta.env.VITE_APP_ROOT_API)

// If token exists set header
if (TokenService.getToken()) {
  ApiService.setHeader()
}

ApiService.mount401Interceptor();
