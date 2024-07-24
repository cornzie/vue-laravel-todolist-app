import { UserService, AuthenticationError } from '../services/user.service';
import { TokenService } from '../services/storage.services';
import router from '../router';

const state = {
  authenticating: false,
  accessToken: TokenService.getToken(),
  authenticationErrorCode: 0,
  authenticationError: '',
  registering: false,
  registrationError: '',
  registrationErrorCode: 0,
  user: null
};

const getters = {
  loggedIn: (state) => {
    return state.accessToken ? true : false;
  },
  authenticationErrorCode: (state) => {
    return state.authenticationErrorCode;
  },
  authenticationError: (state) => {
    return state.authenticationError;
  },
  authenticating: (state) => {
    return state.authenticating;
  },
  registering: (state) => {
    return state.registering;
  },
  registrationErrorCode: (state) => {
    return state.registrationErrorCode;
  },
  registrationError: (state) => {
    return state.registrationError;
  },
  user: (state) => {
    return state.user;
  },
};

const actions = {
  async login({ commit }, { email, password }) {
    commit('loginRequest');

    try {
      const { api_token, user} = await UserService.login(email, password);
      commit('loginSuccess', { api_token, user });

      router.push('/');
      return true;
    } catch (e) {

      console.log(e);
      if (e instanceof AuthenticationError) {
        commit('loginError', { errorCode: e.errorCode, errorMessage: e.message });
      }

      return false;
    }
  },

  async register({ commit }, { name, email, password }) {
    commit('registerRequest');

    try {
      await UserService.register(name, email, password);
      commit('registerSuccess');
      
      router.push('/');

      return true;
    } catch (e) {
      if (e instanceof AuthenticationError) {
        commit('registerError', { errorCode: e.errorCode, errorMessage: e.message });
      }

      return false;
    }
  },

  logout({ commit }) {
    UserService.logout();
    commit('logoutSuccess');
    router.push('/login');
  },
};

const mutations = {
  loginRequest(state) {
    state.authenticating = true;
    state.authenticationError = '';
    state.authenticationErrorCode = 0;
  },
  loginSuccess(state, { api_token, user }) {
    state.accessToken = api_token;
    state.authenticating = false;
    state.user = user;
  },
  loginError(state, { errorCode, errorMessage }) {
    state.authenticating = false;
    state.authenticationErrorCode = errorCode;
    state.authenticationError = errorMessage;
  },
  logoutSuccess(state) {
    state.accessToken = '';
    state.user=null
  },
  registerRequest(state) {
    state.registering = true;
    state.registrationError = '';
    state.registrationErrorCode = 0;
  },
  registerSuccess(state) {
    state.registering = false;
  },
  registerError(state, { errorCode, errorMessage }) {
    state.registering = false;
    state.registrationErrorCode = errorCode;
    state.registrationError = errorMessage;
  },
};

export const auth = {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};
