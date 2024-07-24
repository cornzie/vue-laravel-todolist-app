import ApiService from "../services/api.services";

const state = () => ({
  todoList: [],
  createTodoErrorMsg: "",
  updateTodoErrorMsg: "",
});

const getters = {
  todoList: (state) => state.todoList,
  getTodoById: (state) => (todoId) =>
    state.todoList.find((todo) => todo.id === todoId),
  createTodoErrorMsg: (state) => state.createTodoErrorMsg,
  updateTodoErrorMsg: (state) => state.updateTodoErrorMsg,
};

const actions = {
  async fetchTodos({ commit }) {
    try {
      const response = await ApiService.customRequest({
        method: "get",
        url: "/todos",
      });
      commit("setTodos", response.data.data.todo_list);
    } catch (error) {
      console.error("Failed to fetch todos:", error);
    }
  },

  async createTodo({ commit }, todo) {
    try {
      const response = await ApiService.customRequest({
        method: "post",
        url: "todos",
        data: {
          title: todo.title,
          description: todo.description,
        },
      });
      commit("createTodo", response.data);
      return true;
    } catch (error) {
      commit("createTodoErrorMsg", error.response.data.message);
      console.error("Failed to create todo", error);
    }
  },

  async updateTodo({ commit }, { todoId, data }) {
    console.log(data);
    try {
      const response = await ApiService.customRequest({
        method: "put",
        url: `todos/${todoId}`,
        data,
      });
      commit("updateTodo", { todoId, data });
      dispatch('fetchTodos')
      return true;
    } catch (error) {
      commit("updateTodoErrorMsg", error.response.data?.error_message || error.response.data?.message);
      return false
    }
  },

  deleteTodo({ commit }, todoId) {
    commit("deleteTodo", todoId);
  },
};

const mutations = {
  setTodos(state, todos) {
    state.todoList = todos;
  },

  createTodo(state, todo) {
    state.todoList.unshift(todo);
  },

  updateTodo(state, { todoId, data }) {
    const index = state.todoList.findIndex((todo) => todo.id === todoId);
    if (index !== -1) {
      state.todoList[index] = { ...state.todoList[index], ...data };
    }
  },

  deleteTodo(state, todoId) {
    state.todoList = state.todoList.filter((todo) => todo.id !== todoId);
  },

  createTodoErrorMsg(state, message) {
    state.createTodoErrorMsg = message;
  },

  updateTodoErrorMsg(state, message) {
    state.updateTodoErrorMsg = message;
  },
};

export const todoList = {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};
