import { createRouter, createWebHistory } from 'vue-router'
import Todo from '../views/Todo.vue'
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
import { TokenService } from '../services/storage.services'

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Todo
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
        meta: {
          public: true,  // Allow access to even if not logged in
          onlyWhenLoggedOut: true
        }
    },
    {
        path: '/register',
        name: 'Register',
        component: Register,
        meta: {
          public: true,  // Allow access to even if not logged in
          onlyWhenLoggedOut: true
        }
    },

]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next) => {
   const user = JSON.parse(localStorage.getItem('user'));
   const isPublic = to.matched.some(record => record.meta.public)
   const onlyWhenLoggedOut = to.matched.some(record => record.meta.onlyWhenLoggedOut)
   const loggedIn = !!TokenService.getToken();

   if (!isPublic && !loggedIn) {
    return next({
      path:'/login',
      // query: {redirect: to.fullPath}  // Store the full path to redirect the user to after login
    });
  }

  next();
});


export default router