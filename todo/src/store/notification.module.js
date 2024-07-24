const state = {
  messages: [],
}

const getters = {
  messages: (state) => state.messages,
}

const actions = {
    addMessage({ commit }, message) {
      commit('addMessage', message)
    },
    removeMessage({ commit }, messageId) {
      commit('removeMessage', messageId)
    },
  }

const mutations = {
    addMessage(state, message) {
      state.messages.push(message)
    },
    removeMessage(state, messageId) {
      state.messages = state.messages.filter((msg) => msg.id !== messageId)
    },
  }

  export const notification = {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
  }