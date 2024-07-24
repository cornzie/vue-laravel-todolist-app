
import ApiService from './api.services'
import { TokenService } from './storage.services'


class AuthenticationError extends Error {
    constructor(errorCode, message) {
        super(message)
        this.name = this.constructor.name
        this.message = message
        this.errorCode = errorCode
    }
}

const UserService = {
    /**
     * Login the user and store the access token to TokenService. 
     * 
     * @returns access_token
     * @throws AuthenticationError 
    **/
    login: async function(email, password) {
        const requestData = {
            method: 'post',
            url: "/login",
            data: {
                email: email,
                password: password
            },
        }

        try {
            const response = await ApiService.customRequest(requestData)

            const { api_token, user } = response.data.data

            TokenService.saveToken(api_token)
            ApiService.setHeader()
            
            ApiService.mount401Interceptor();

            return { api_token, user }
        } catch (error) {
            throw new AuthenticationError(error.response.data.status, error.response.data.error_message)
        }
    },

    register: async function (name, email, password) {
        const requestData = {
            method: 'post',
            url: "/users",
            data: {
                name,
                email,
                password,
                password_confirmation: password
            },
        }

        try {

            const response = await ApiService.customRequest(requestData)

        } catch (error) {
          throw new AuthenticationError(error.response.status, error.response.data.error_message);
        }
      },

    logout() {
        TokenService.removeToken()
        ApiService.removeHeader()
        
        ApiService.unmount401Interceptor()
    }
}

export default UserService

export { UserService, AuthenticationError }