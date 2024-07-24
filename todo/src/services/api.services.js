
import axios from 'axios'
import { TokenService } from './storage.services';
import router from '../router';

const ApiService = {

    init(baseURL) {
        axios.defaults.baseURL = baseURL;
    },

    setHeader() {
        axios.defaults.headers.common["Authorization"] = `Bearer ${TokenService.getToken()}`
    },

    removeHeader() {
        axios.defaults.headers.common = {}
    },

    get(resource) {
        return axios.get(resource)
    },

    post(resource, data) {
        return axios.post(resource, data)
    },

    put(resource, data) {
        return axios.put(resource, data)
    },

    delete(resource) {
        return axios.delete(resource)
    },

    /**
     * Perform a custom Axios request.
     *
     * data is an object containing the following properties:
     *  - method
     *  - url
     *  - data ... request payload
     *  - auth (optional)
     *    - username
     *    - password
    **/
    customRequest(data) {
        return axios(data)
    },

    mount401Interceptor() {
        axios.interceptors.response.use(
          (response) => {
            return response;
          },
          async (error) => {
            if (error.response.status === 401) {
              TokenService.removeToken();
              router.push('/login');
            }
    
            return Promise.reject(error);
          }
        );
    },

    unmount401Interceptor() {
      axios.interceptors.response.eject(this._401interceptor);
  }
}

export default ApiService