import { getLocalUser } from "./helpers/auth";

const user = getLocalUser();

export default {
    state: {
        currentUser: user,
    },
    getters: {        
        currentUser(state) {
            return state.currentUser;
        },
    },
    mutations: {        
        loginSuccess(state, payload) {
            state.currentUser = Object.assign({}, payload.user, {token: payload.access_token});

            localStorage.setItem("user", JSON.stringify(state.currentUser));
        },
        logout(state) {
            localStorage.removeItem("user");
            state.currentUser = null;
        },
    },
    actions: {
        login(context) {
            context.commit("login");
        },
        getCustomers(context) {
            axios.put('/api/' + credentials.id + '/update')
            .then((response) => {
                // context.commit('updateCustomers', response.data.customers);
            })
        }
    }
};