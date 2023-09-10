import axios from 'axios';

export default {
    namespaced: true,
    state: {
        authenticated: false,
        user: {}
    },
    getters: {
        authenticated(state) {
            return state.authenticated
        },
        user(state) {
            return state.user
        }
    },
    mutations: {
        SET_AUTHENTICATED(state, value) {
            state.authenticated = value
        },
        SET_USER(state, value) {
            state.user = value
        }
    },
    actions: {
        login({ commit }) {
            return axios.get('http://127.0.0.1:8000/api/users').then(({ data }) => {
                commit('SET_USER', data)
                commit('SET_AUTHENTICATED', true)
            }).catch(({ res }) => {
                commit('SET_USER', {})
                commit('SET_AUTHENTICATED', false)
            })
        },
        getUser({ commit }) {
            let email = JSON.parse(localStorage.getItem('email'));
            console.log(email);
            return axios.post('http://127.0.0.1:8000/api/users', email).then(({ data }) => {
                if (data.success) {
                    commit('SET_USER', data.data)
                    commit('SET_AUTHENTICATED', true)
                    // router.push({name: 'dashboard'})
                }
                // else {
                //     commit('SET_USER', {})
                //     commit('SET_AUTHENTICATED', false)
                // }
            }).catch(({ res }) => {
                commit('SET_USER', {})
                commit('SET_AUTHENTICATED', false)
            })
        },
        logout({ commit }) {
            commit('SET_USER', {})
            commit('SET_AUTHENTICATED', false)
        }
    }
}
