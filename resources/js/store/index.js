import { createStore } from 'vuex';
import createPersistedState from 'vuex-persistedstate';
import auth from '../store/auth';


const store = createStore({
    state: {
        users: [],
    },
    getters: {
        getUsers: (state) => state.users,
    },
    actions: {
        async fetchUsers({ commit }) {
            try {
                let email = JSON.parse(localStorage.getItem('email'));
                console.log(email);
                const data = await axios.get(
                    'http://127.0.0.1:8000/api/users', email
                );
                commit("SET_USERS", data.data);
            } catch (error) {
                alert(error);
                console.log(error);
            }
        },
    },
    mutations: {
        SET_USERS(state, users) {
            state.users = users;
        },
    },
    plugins: [
        createPersistedState()
    ],
    modules: {
        auth,

    }
})

export default store
