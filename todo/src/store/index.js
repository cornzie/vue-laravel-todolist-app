import { createStore } from 'vuex';
import { auth } from './auth.module';
import { notification } from './notification.module';
import { todoList } from './todolist.module';

const store = createStore({
  modules: {
    auth,
    notification,
    todoList,
  },
});

export default store;
