import axios from "axios";
import { createStore } from "vuex";
export default createStore({
    state: {
        users: [],
        aplikasi: [],
    },
    getters: {
        getUsers: (state) => state.users,
        getAplikasi: (state) => state.aplikasi,
    },
    actions: {
        async fetchUsers({ commit }) {
            try {
                let email = JSON.parse(localStorage.getItem('email'));
                let token = JSON.parse(localStorage.getItem('token'));
                // console.log(email);
                const data = await axios.post(
                    'http://127.0.0.1:8000/api/getUsers', { 'email': email }, {

                    headers: {
                        Accept: "application/json",
                        Authorization: "Bearer " + token

                    }
                }
                );
                // console.log(data.data);
                commit("SET_USERS", data.data);
            } catch (error) {
                alert(error);
                console.log(error);
            }
        },
        async fetchAplikasi({ commit }) {
            try {
                let token = JSON.parse(localStorage.getItem('token'));
                // console.log(email);
                const data = await axios.get(
                    'http://127.0.0.1:8000/api/getAplikasi', {

                    headers: {
                        Accept: "application/json",
                        Authorization: "Bearer " + token

                    }
                }
                );
                // console.log(data.data);
                commit("SET_APLIKASI", data.data);
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
        SET_APLIKASI(state, aplikasi) {
            state.aplikasi = aplikasi;
        },
    },
});
