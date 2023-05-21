
import Swal from "sweetalert2";
let actions = {
    async loadStatistics(context){
        context.commit('SET_LOADER_SPINNER',true)

        await axios.get('api/statistics',context.getters.getConfig).then((res)=>{
            console.log(res.data.data);
            context.commit('SET_CHART_OPTIONS',res.data.data);
        }).catch((err) => {
        context.commit('SET_LOADER_SPINNER',false)

            console.error(err.message);
        });
        context.commit('SET_LOADER_SPINNER',false)

    },
    // action to be performed
    setToken(context, payload) {
        localStorage.setItem("token", payload);
        context.commit("UPDATE_TOKEN", payload);
    },
    loadProfile(context) {
        axios.get("api/me", context.getters.getConfig).then((res) => {
            console.log(res.data.data.account);
            context.commit("SET_PROFILE", res.data.data);
        });
    },
    removeToken(context) {
        localStorage.removeItem("token");
        context.state.token = 0
        context.state.configAuth.headers.Authorization = '';
        context.commit("UPDATE_TOKEN", 0);
    },
    async loadCategories(context) {
        context.commit('SET_LOADER_SPINNER',true)

        await axios
            .get("api/categories", context.getters.getConfig)
            .then((res) => {
                context.commit("SET_CATEGORIES", res.data.data.categories);

                console.log(context.state.categories);
            })
            .catch((err) => {
        context.commit('SET_LOADER_SPINNER',false)

                console.error(err.message);
            });
        context.commit('SET_LOADER_SPINNER',false)

    },
    async loadOperations(context) {
        context.commit('SET_LOADER_SPINNER',true)
        await axios
            .get("/api/dashboard", context.getters.getConfig)
            .then((res) => {
                context.commit("SET_OPERATIONS", res.data.data.opertaionsLast60Days);
                context.commit("SET_EXPENSES", res.data.data.expensesLastMonth);
                context.commit("SET_INCOME", res.data.data.incomeLastMonth);
                console.log(res.data.data)
            })
            .catch((err) => {
        context.commit('SET_LOADER_SPINNER',false)
                console.error(err.message);
            });
        context.commit('SET_LOADER_SPINNER',false)

    },
    loadOperationsSearch(context, search) {
        axios
            .post("api/operations/search", search, context.getters.getConfig)
            .then((res) => {
                context.commit(
                    "SET_OPERATIONS_SEARCH",
                    res.data.data.operations
                );
                console.log(context.state.operationsSearch);
            })
            .catch((err) => {
                console.error(err.message);
            });
    },
    popUp(context,data){
        Swal.fire({
            title: data.msg,
            icon: data.iconMsg,
            showClass: {
                popup: "animate__animated animate__fadeInDown",
            },
            hideClass: {
                popup: "animate__animated animate__fadeOutUp",
            },
        });
    },
    clearData(context){
        context.commit('CLEAR_DATA');
    }

};
export default actions;
